<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Database;
use Core\Request;
use Core\Response;

/**
 * GroupController – JSON API for group membership, chat, and presence.
 *
 * All endpoints require authentication; unauthenticated requests receive 401.
 *
 * Route parameters (:id) are injected by the router as the second argument
 * after $request, matching the framework's dispatch pattern.
 */
class GroupController extends Controller
{
    // ── Auth guard ────────────────────────────────────────────────────────────

    private function guard(): bool
    {
        return auth()->check();
    }

    // ── GET /api/groups/mine ──────────────────────────────────────────────────
    /**
     * Return communities the current user belongs to.
     * Falls back to all communities if the user has no memberships.
     */
    public function mine(Request $request): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $userId = (int) auth()->id();

        try {
            $db = Database::getInstance();

            // communities the user is a member of
            $rows = $db->getPdo()->prepare(
                "SELECT c.id, c.name, c.category, c.description, c.members_count,
                        cm.role
                   FROM communities c
                   JOIN community_members cm ON cm.community_id = c.id
                  WHERE cm.user_id = :uid
                  ORDER BY c.created_at DESC"
            );
            $rows->execute([':uid' => $userId]);
            $result = $rows->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($result)) {
                // Fallback: return all communities so the UI isn't empty
                $result = $db->table('communities')->latest()->limit(10)->get();
                foreach ($result as &$r) {
                    $r['role'] = 'member';
                }
                unset($r);
            }

            return $this->json($result);
        } catch (\Throwable $e) {
            return $this->json(['error' => 'Server error'], 500);
        }
    }

    // ── POST /api/groups/heartbeat ────────────────────────────────────────────
    /**
     * Update the authenticated user's last_seen_at to now (online presence).
     */
    public function heartbeat(Request $request): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        try {
            Database::getInstance()
                ->table('users')
                ->where('id', (int) auth()->id())
                ->update(['last_seen_at' => now()]);

            return $this->json(['ok' => true]);
        } catch (\Throwable) {
            return $this->json(['ok' => false]);
        }
    }

    // ── GET /api/groups/:id ───────────────────────────────────────────────────
    /**
     * Return basic group/community info.
     */
    public function show(Request $request, string|int $id): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $row = Database::getInstance()
                ->table('communities')
                ->find((int) $id);

            if (!$row) {
                return $this->json(['error' => 'Group not found'], 404);
            }

            return $this->json($row);
        } catch (\Throwable) {
            return $this->json(['error' => 'Server error'], 500);
        }
    }

    // ── GET /api/groups/:id/members ───────────────────────────────────────────
    /**
     * Return all members of a group with their role and online status.
     */
    public function members(Request $request, string|int $id): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $stmt = Database::getInstance()->getPdo()->prepare(
                "SELECT u.id, u.name, cm.role,
                        CASE
                          WHEN u.last_seen_at IS NOT NULL
                           AND u.last_seen_at >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
                          THEN 1 ELSE 0
                        END AS is_online
                   FROM community_members cm
                   JOIN users u ON u.id = cm.user_id
                  WHERE cm.community_id = :cid
                  ORDER BY
                        FIELD(cm.role, 'admin','moderator','member'),
                        is_online DESC,
                        u.name ASC"
            );
            $stmt->execute([':cid' => (int) $id]);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $result = array_map(function (array $row): array {
                return [
                    'id'        => (int)  $row['id'],
                    'name'      =>        $row['name'],
                    'initials'  => strtoupper(substr($row['name'], 0, 2)),
                    'role'      =>        $row['role'],
                    'is_online' => (bool) $row['is_online'],
                ];
            }, $rows);

            return $this->json($result);
        } catch (\Throwable) {
            return $this->json(['error' => 'Server error'], 500);
        }
    }

    // ── GET /api/groups/:id/messages ─────────────────────────────────────────
    /**
     * Return group chat messages (optionally only messages with id > ?since).
     */
    public function messages(Request $request, string|int $id): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $since = (int) ($request->get('since') ?? 0);

        try {
            $sql = "SELECT cm.id, cm.user_id, cm.message, cm.created_at,
                           u.name
                      FROM community_messages cm
                      JOIN users u ON u.id = cm.user_id
                     WHERE cm.community_id = :cid"
                 . ($since > 0 ? " AND cm.id > :since" : "")
                 . " ORDER BY cm.id ASC
                     LIMIT 50";

            $params = [':cid' => (int) $id];
            if ($since > 0) {
                $params[':since'] = $since;
            }

            $stmt = Database::getInstance()->getPdo()->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $result = array_map(function (array $row): array {
                return [
                    'id'         => (int) $row['id'],
                    'user_id'    => (int) $row['user_id'],
                    'name'       =>       $row['name'],
                    'initials'   => strtoupper(substr($row['name'], 0, 2)),
                    'message'    =>       $row['message'],
                    'created_at' =>       $row['created_at'],
                    'time_ago'   => $this->timeAgo($row['created_at']),
                ];
            }, $rows);

            return $this->json($result);
        } catch (\Throwable) {
            return $this->json(['error' => 'Server error'], 500);
        }
    }

    // ── POST /api/groups/:id/messages ─────────────────────────────────────────
    /**
     * Send a new message to a group chatroom.
     */
    public function sendMessage(Request $request, string|int $id): Response
    {
        if (!$this->guard()) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $text = trim($request->post('message') ?? '');
        if ($text === '') {
            return $this->json(['error' => 'Message cannot be empty'], 422);
        }
        if (mb_strlen($text) > 1000) {
            return $this->json(['error' => 'Message too long (max 1000 chars)'], 422);
        }

        $communityId = (int) $id;
        $userId      = (int) auth()->id();
        $createdAt   = now();

        try {
            $db = Database::getInstance();

            // Verify community exists
            if (!$db->table('communities')->find($communityId)) {
                return $this->json(['error' => 'Group not found'], 404);
            }

            $newId = $db->table('community_messages')->insert([
                'community_id' => $communityId,
                'user_id'      => $userId,
                'message'      => $text,
                'created_at'   => $createdAt,
            ]);

            // Fetch author name
            $user = $db->table('users')->select('name')->find($userId);
            $name = $user['name'] ?? 'Unknown';

            return $this->json([
                'id'         => (int) $newId,
                'user_id'    => $userId,
                'name'       => $name,
                'initials'   => strtoupper(substr($name, 0, 2)),
                'message'    => $text,
                'created_at' => $createdAt,
                'time_ago'   => 'Just now',
            ], 201);
        } catch (\Throwable) {
            return $this->json(['error' => 'Server error'], 500);
        }
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function timeAgo(string $datetime): string
    {
        $diff = time() - strtotime($datetime);

        if ($diff < 60)   return 'Just now';
        if ($diff < 3600) return floor($diff / 60) . 'm ago';
        if ($diff < 86400) return floor($diff / 3600) . 'h ago';

        return date('M j', strtotime($datetime));
    }
}
