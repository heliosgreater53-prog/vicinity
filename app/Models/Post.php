<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Post Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $content
 * @property string|null $media_url
 * @property int $likes_count
 * @property int $comments_count
 * @property string $created_at
 * @property string $updated_at
 */
class Post extends Model
{
    protected static string $table = 'posts';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'content',
        'media_url',
        'likes_count',
        'comments_count',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }
}
