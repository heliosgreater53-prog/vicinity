<?php

declare(strict_types=1);

namespace Core;

/**
 * Model – base Active-Record-like model.
 *
 * Each model maps to a database table. Subclasses set:
 *   protected static string $table      = 'users';
 *   protected static string $primaryKey = 'id';
 *   protected static array  $fillable   = ['name', 'email', ...];
 *   protected static array  $hidden     = ['password'];   // excluded from toArray()
 *   protected static array  $casts      = ['is_active' => 'bool'];
 *
 * Usage:
 *   $user = User::find(1);
 *   $users = User::where('active', 1)->get();
 *   User::create(['name' => 'Jane', 'email' => 'jane@example.com']);
 *   $user->update(['name' => 'Jane Doe']);
 *   $user->delete();
 */
abstract class Model
{
    protected static string $table      = '';
    protected static string $primaryKey = 'id';
    protected static array  $fillable   = [];
    protected static array  $hidden     = [];
    protected static array  $casts      = [];

    /** @var array<string, mixed> Row data */
    protected array $attributes = [];

    /** @var bool Whether this instance exists in the DB */
    protected bool $exists = false;

    protected static function db(): Database
    {
        return Database::getInstance();
    }

    // -------------------------------------------------------------------------
    // Constructor & hydration
    // -------------------------------------------------------------------------

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    public function fill(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            if (empty(static::$fillable) || in_array($key, static::$fillable, true)) {
                $this->attributes[$key] = $this->castAttribute($key, $value);
            }
        }
        return $this;
    }

    /**
     * Hydrate a model with raw DB row (skips fillable guard).
     */
    public static function hydrate(array $row): static
    {
        $instance = new static();
        $instance->attributes = $row;
        $instance->exists     = true;
        return $instance;
    }

    /**
     * Hydrate an array of rows.
     *
     * @return static[]
     */
    public static function hydrateAll(array $rows): array
    {
        return array_map(fn($row) => static::hydrate($row), $rows);
    }

    // -------------------------------------------------------------------------
    // Attribute access
    // -------------------------------------------------------------------------

    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return isset($this->attributes[$key]);
    }

    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function toArray(): array
    {
        return array_diff_key($this->attributes, array_flip(static::$hidden));
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    // -------------------------------------------------------------------------
    // Static query API (builder proxies)
    // -------------------------------------------------------------------------

    public static function query(): Database
    {
        return static::db()->table(static::$table);
    }

    /**
     * @return static[]
     */
    public static function all(): array
    {
        return static::hydrateAll(static::query()->get());
    }

    public static function find(int|string $id): ?static
    {
        $row = static::query()->find($id, static::$primaryKey);
        return $row ? static::hydrate($row) : null;
    }

    public static function findOrFail(int|string $id): static
    {
        $model = static::find($id);
        if ($model === null) {
            throw new \RuntimeException(
                static::class . " with primary key [{$id}] not found."
            );
        }
        return $model;
    }

    public static function where(string $column, mixed $valueOrOperator, mixed $value = null): Database
    {
        return $value !== null
            ? static::query()->where($column, $valueOrOperator, $value)
            : static::query()->where($column, $valueOrOperator);
    }

    public static function first(): ?static
    {
        $row = static::query()->first();
        return $row ? static::hydrate($row) : null;
    }

    public static function count(): int
    {
        return static::query()->count();
    }

    // -------------------------------------------------------------------------
    // Persistence
    // -------------------------------------------------------------------------

    /**
     * Create a new record in the DB and return a hydrated model.
     *
     * @param array<string, mixed> $attributes
     */
    public static function create(array $attributes): static
    {
        // Add timestamps if supported
        if (in_array('created_at', static::$fillable) || method_exists(static::class, 'timestamps')) {
            $attributes['created_at'] = $attributes['created_at'] ?? now();
            $attributes['updated_at'] = $attributes['updated_at'] ?? now();
        }

        $filtered = empty(static::$fillable)
            ? $attributes
            : array_intersect_key($attributes, array_flip(static::$fillable));

        $id = static::query()->insert($filtered);

        $row = static::query()->find($id, static::$primaryKey);
        return $row ? static::hydrate($row) : static::hydrate(array_merge($filtered, [static::$primaryKey => $id]));
    }

    /**
     * Update this model's row.
     *
     * @param array<string, mixed> $attributes
     */
    public function update(array $attributes): bool
    {
        if (!$this->exists) {
            return false;
        }

        $attributes['updated_at'] = now();

        $filtered = empty(static::$fillable)
            ? $attributes
            : array_intersect_key($attributes, array_flip(static::$fillable));

        $affected = static::query()
            ->where(static::$primaryKey, $this->attributes[static::$primaryKey])
            ->update($filtered);

        if ($affected > 0) {
            $this->fill($attributes);
        }

        return $affected > 0;
    }

    /**
     * Delete this model's row.
     */
    public function delete(): bool
    {
        if (!$this->exists) {
            return false;
        }

        $affected = static::query()
            ->where(static::$primaryKey, $this->attributes[static::$primaryKey])
            ->delete();

        $this->exists = false;
        return $affected > 0;
    }

    /**
     * Save: insert if new, update if existing.
     */
    public function save(): bool
    {
        if ($this->exists) {
            return $this->update($this->attributes);
        }

        $created = static::create($this->attributes);
        $this->attributes = $created->attributes;
        $this->exists     = true;
        return true;
    }

    // -------------------------------------------------------------------------
    // Casts
    // -------------------------------------------------------------------------

    private function castAttribute(string $key, mixed $value): mixed
    {
        if (!array_key_exists($key, static::$casts)) {
            return $value;
        }

        return match(static::$casts[$key]) {
            'int', 'integer' => (int) $value,
            'float', 'double' => (float) $value,
            'bool', 'boolean' => (bool) $value,
            'string'          => (string) $value,
            'array'           => is_array($value) ? $value : json_decode($value ?? '[]', true),
            'json'            => is_array($value) ? $value : json_decode($value ?? '{}', true),
            default           => $value,
        };
    }
}
