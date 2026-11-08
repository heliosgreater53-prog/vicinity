<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * CommunityMessage – a single chat message within a group.
 *
 * @property int    $id
 * @property int    $community_id
 * @property int    $user_id
 * @property string $message
 * @property string $created_at
 */
class CommunityMessage extends Model
{
    protected static string $table      = 'community_messages';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'community_id',
        'user_id',
        'message',
        'created_at',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }
}
