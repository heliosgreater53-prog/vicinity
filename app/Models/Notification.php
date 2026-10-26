<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Notification Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $type
 * @property string|null $link
 * @property int $is_read
 * @property string $created_at
 */
class Notification extends Model
{
    protected static string $table = 'notifications';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'is_read',
    ];

    public function markAsRead(): void
    {
        $this->update(['is_read' => 1]);
    }
}
