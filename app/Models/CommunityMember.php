<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * CommunityMember – membership row linking a user to a community.
 *
 * @property int    $id
 * @property int    $community_id
 * @property int    $user_id
 * @property string $role        'admin' | 'moderator' | 'member'
 * @property string $joined_at
 */
class CommunityMember extends Model
{
    protected static string $table      = 'community_members';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'community_id',
        'user_id',
        'role',
        'joined_at',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }

    public function community(): ?Community
    {
        return Community::find($this->community_id);
    }

    /**
     * True if the linked user's last_seen_at is within the past 5 minutes.
     */
    public function isOnline(): bool
    {
        try {
            $row = static::db()
                ->table('users')
                ->select('last_seen_at')
                ->where('id', $this->user_id)
                ->first();

            if (!$row || empty($row['last_seen_at'])) {
                return false;
            }

            return strtotime($row['last_seen_at']) >= (time() - 300);
        } catch (\Throwable) {
            return false;
        }
    }
}
