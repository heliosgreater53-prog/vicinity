<?php

declare(strict_types=1);

namespace Core;

/**
 * Database – PDO wrapper with a fluent query builder.
 *
 * Usage:
 *   $db = Database::getInstance();
 *
 *   // Raw
 *   $rows = $db->query("SELECT * FROM users WHERE id = ?", [1])->all();
 *
 *   // Builder
 *   $user = $db->table('users')->where('email', 'john@example.com')->first();
 *   $id   = $db->table('users')->insert(['name' => 'Jane', 'email' => 'jane@test.com']);
 */
class Database
{
    private static ?Database $instance = null;
    private \PDO $pdo;

    // Query builder state
    private string $table      = '';
    private array  $wheres     = [];
    private array  $bindings   = [];
    private ?int   $limitVal   = null;
    private ?int   $offsetVal  = null;
    private array  $orderBys   = [];
    private array  $columns    = ['*'];
    private array  $joins      = [];

    public function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    // -------------------------------------------------------------------------
    // Connection
    // -------------------------------------------------------------------------

    private function connect(): void
    {
        $host   = env('DB_HOST', '127.0.0.1');
        $port   = env('DB_PORT', '3306');
        $dbname = env('DB_DATABASE', 'vicinity');
        $user   = env('DB_USERNAME', 'root');
        $pass   = env('DB_PASSWORD', '');

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

        $this->pdo = new \PDO($dsn, $user, $pass, [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    // -------------------------------------------------------------------------
    // Raw query API
    // -------------------------------------------------------------------------

    /**
     * Execute a raw SQL statement and return a result set wrapper.
     *
     * @param array<mixed> $bindings
     */
    public function query(string $sql, array $bindings = []): static
    {
        $clone = clone $this;
        $clone->rawSql      = $sql;
        $clone->rawBindings = $bindings;
        $clone->rawStmt     = null;
        return $clone;
    }

    /** @var string|null */
    private ?string $rawSql = null;
    /** @var array<mixed> */
    private array $rawBindings = [];
    /** @var \PDOStatement|null */
    private ?\PDOStatement $rawStmt = null;

    private function executeRaw(): \PDOStatement
    {
        if ($this->rawStmt !== null) {
            return $this->rawStmt;
        }

        $stmt = $this->pdo->prepare($this->rawSql);
        $stmt->execute($this->rawBindings);
        $this->rawStmt = $stmt;
        return $stmt;
    }

    public function fetchAll(): array
    {
        return $this->executeRaw()->fetchAll();
    }

    public function fetchOne(): array|null
    {
        $row = $this->executeRaw()->fetch();
        return $row === false ? null : $row;
    }

    public function all(): array
    {
        return $this->fetchAll();
    }

    public function scalar(): mixed
    {
        return $this->executeRaw()->fetchColumn();
    }

    public function rowCount(): int
    {
        return $this->executeRaw()->rowCount();
    }

    // -------------------------------------------------------------------------
    // Transaction helpers
    // -------------------------------------------------------------------------

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }

    public function transaction(\Closure $callback): mixed
    {
        $this->beginTransaction();
        try {
            $result = $callback($this);
            $this->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->rollBack();
            throw $e;
        }
    }

    // -------------------------------------------------------------------------
    // Fluent Query Builder
    // -------------------------------------------------------------------------

    public function table(string $table): static
    {
        $clone          = clone $this;
        $clone->table   = $table;
        $clone->wheres  = [];
        $clone->bindings = [];
        $clone->limitVal  = null;
        $clone->offsetVal = null;
        $clone->orderBys  = [];
        $clone->columns   = ['*'];
        $clone->joins     = [];
        $clone->rawSql    = null;
        return $clone;
    }

    public function select(string ...$columns): static
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, mixed $valueOrOperator, mixed $value = null): static
    {
        if ($value === null) {
            $this->wheres[]   = "`{$column}` = ?";
            $this->bindings[] = $valueOrOperator;
        } else {
            $this->wheres[]   = "`{$column}` {$valueOrOperator} ?";
            $this->bindings[] = $value;
        }
        return $this;
    }

    public function whereNull(string $column): static
    {
        $this->wheres[] = "`{$column}` IS NULL";
        return $this;
    }

    public function whereNotNull(string $column): static
    {
        $this->wheres[] = "`{$column}` IS NOT NULL";
        return $this;
    }

    public function whereIn(string $column, array $values): static
    {
        $placeholders   = implode(', ', array_fill(0, count($values), '?'));
        $this->wheres[] = "`{$column}` IN ({$placeholders})";
        $this->bindings = array_merge($this->bindings, $values);
        return $this;
    }

    public function join(string $table, string $first, string $operator, string $second, string $type = 'INNER'): static
    {
        $this->joins[] = "{$type} JOIN `{$table}` ON {$first} {$operator} {$second}";
        return $this;
    }

    public function leftJoin(string $table, string $first, string $operator, string $second): static
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function orderBy(string $column, string $direction = 'ASC'): static
    {
        $direction      = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBys[] = "`{$column}` {$direction}";
        return $this;
    }

    public function latest(string $column = 'created_at'): static
    {
        return $this->orderBy($column, 'DESC');
    }

    public function oldest(string $column = 'created_at'): static
    {
        return $this->orderBy($column, 'ASC');
    }

    public function limit(int $limit): static
    {
        $this->limitVal = $limit;
        return $this;
    }

    public function offset(int $offset): static
    {
        $this->offsetVal = $offset;
        return $this;
    }

    public function paginate(int $page, int $perPage = 15): array
    {
        $total = $this->count();
        $rows  = $this->offset(($page - 1) * $perPage)->limit($perPage)->get();

        return [
            'data'         => $rows,
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $page,
            'last_page'    => (int) ceil($total / $perPage),
        ];
    }

    // -------------------------------------------------------------------------
    // Terminal builder methods
    // -------------------------------------------------------------------------

    public function get(): array
    {
        $sql  = $this->buildSelect();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->fetchAll();
    }

    public function first(): array|null
    {
        $row = $this->limit(1)->get();
        return $row[0] ?? null;
    }

    public function find(int|string $id, string $primaryKey = 'id'): array|null
    {
        return $this->where($primaryKey, $id)->first();
    }

    public function count(): int
    {
        $sql  = "SELECT COUNT(*) FROM `{$this->table}`" . $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return (int) $stmt->fetchColumn();
    }

    public function exists(): bool
    {
        return $this->count() > 0;
    }

    /**
     * Insert a row and return the last insert ID.
     *
     * @param array<string, mixed> $data
     */
    public function insert(array $data): int|string
    {
        $columns      = implode(', ', array_map(fn($c) => "`{$c}`", array_keys($data)));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql  = "INSERT INTO `{$this->table}` ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    /**
     * Update matched rows and return affected row count.
     *
     * @param array<string, mixed> $data
     */
    public function update(array $data): int
    {
        $sets     = implode(', ', array_map(fn($c) => "`{$c}` = ?", array_keys($data)));
        $sql      = "UPDATE `{$this->table}` SET {$sets}" . $this->buildWhere();
        $bindings = array_merge(array_values($data), $this->bindings);

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bindings);
        return $stmt->rowCount();
    }

    /**
     * Delete matched rows and return affected count.
     */
    public function delete(): int
    {
        $sql  = "DELETE FROM `{$this->table}`" . $this->buildWhere();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->bindings);
        return $stmt->rowCount();
    }

    // -------------------------------------------------------------------------
    // SQL Builders
    // -------------------------------------------------------------------------

    private function buildSelect(): string
    {
        $cols  = implode(', ', $this->columns);
        $sql   = "SELECT {$cols} FROM `{$this->table}`";

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        $sql .= $this->buildWhere();

        if (!empty($this->orderBys)) {
            $sql .= ' ORDER BY ' . implode(', ', $this->orderBys);
        }

        if ($this->limitVal !== null) {
            $sql .= " LIMIT {$this->limitVal}";
        }

        if ($this->offsetVal !== null) {
            $sql .= " OFFSET {$this->offsetVal}";
        }

        return $sql;
    }

    private function buildWhere(): string
    {
        if (empty($this->wheres)) {
            return '';
        }

        return ' WHERE ' . implode(' AND ', $this->wheres);
    }
}
