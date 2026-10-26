<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Event Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string $location
 * @property string $event_date
 * @property string $event_time
 * @property string|null $banner
 * @property int $attendees_count
 * @property string $created_at
 * @property string $updated_at
 */
class Event extends Model
{
    protected static string $table = 'events';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'event_time',
        'banner',
        'attendees_count',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }
}
