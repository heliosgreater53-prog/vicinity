<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * SavedItem Model (Bookmarked posts, businesses, events)
 *
 * @property int $id
 * @property int $user_id
 * @property string $item_type
 * @property int $item_id
 * @property string $created_at
 */
class SavedItem extends Model
{
    protected static string $table = 'saved_items';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'item_type',
        'item_id',
    ];

    public function item(): mixed
    {
        return match ($this->item_type) {
            'post'     => Post::find($this->item_id),
            'business' => Business::find($this->item_id),
            'event'    => Event::find($this->item_id),
            default    => null,
        };
    }
}
