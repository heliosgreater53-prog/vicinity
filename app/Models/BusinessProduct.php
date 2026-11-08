<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * BusinessProduct Model
 *
 * Represents a single product offered by a business.
 *
 * @property int         $id
 * @property int         $business_id
 * @property string      $name
 * @property string|null $description
 * @property string|null $price
 * @property string      $created_at
 */
class BusinessProduct extends Model
{
    protected static string $table = 'business_products';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'business_id',
        'name',
        'description',
        'price',
    ];

    public function business(): ?Business
    {
        return Business::find($this->business_id);
    }
}

