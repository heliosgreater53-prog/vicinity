<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * BusinessService Model
 *
 * Represents a single service offered by a business.
 *
 * @property int         $id
 * @property int         $business_id
 * @property string      $name
 * @property string|null $description
 * @property string|null $icon        FontAwesome class, e.g. "fa-wifi"
 * @property string      $created_at
 */
class BusinessService extends Model
{
    protected static string $table = 'business_services';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'business_id',
        'name',
        'description',
        'icon',
    ];

    public function business(): ?Business
    {
        return Business::find($this->business_id);
    }
}

