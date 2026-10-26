<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * User Model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $avatar
 * @property string|null $bio
 * @property string|null $location
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Model
{
    protected static string $table = 'users';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'bio',
        'location',
    ];

    protected static array $hidden = [
        'password',
    ];

    /**
     * Get posts created by this user.
     *
     * @return Post[]
     */
    public function posts(): array
    {
        return Post::hydrateAll(
            Post::query()->where('user_id', $this->id)->latest()->get()
        );
    }

    /**
     * Get businesses created by this user.
     *
     * @return Business[]
     */
    public function businesses(): array
    {
        return Business::hydrateAll(
            Business::query()->where('user_id', $this->id)->latest()->get()
        );
    }
}
