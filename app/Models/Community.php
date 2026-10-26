<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Community Model (Neighborhood groups)
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $category
 * @property string|null $description
 * @property string $privacy
 * @property string|null $banner
 * @property int $members_count
 * @property string $created_at
 * @property string $updated_at
 */
class Community extends Model
{
    protected static string $table = 'communities';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'privacy',
        'banner',
        'members_count',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }
}
