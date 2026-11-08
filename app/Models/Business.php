<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Business Model
 *
 * @property int         $id
 * @property int         $user_id
 * @property string      $name
 * @property string      $category
 * @property string      $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $description
 * @property string|null $image          Legacy cover image (URL)
 * @property string|null $logo           Business logo URL
 * @property string|null $cover_image    Cover / hero image URL
 * @property float       $rating
 * @property int         $reviews_count
 * @property string|null $price_range
 * @property string|null $status
 * @property string|null $opening_hours
 * @property string|null $menu           Legacy JSON products (kept for backward compat)
 * @property string|null $services       Legacy JSON services (kept for backward compat)
 * @property string|null $hours_schedule Legacy JSON hours
 * @property string      $created_at
 * @property string      $updated_at
 */
class Business extends Model
{
    protected static string $table = 'businesses';
    protected static string $primaryKey = 'id';

    protected static array $fillable = [
        'user_id',
        'name',
        'category',
        'address',
        'phone',
        'email',
        'website',
        'description',
        'image',
        'logo',
        'cover_image',
        'rating',
        'reviews_count',
        'price_range',
        'status',
        'opening_hours',
        'menu',
        'services',
        'hours_schedule',
    ];

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function user(): ?User
    {
        return User::find($this->user_id);
    }

    /**
     * Get all products linked to this business from the database.
     *
     * @return BusinessProduct[]
     */
    public function products(): array
    {
        try {
            $rows = BusinessProduct::query()
                ->where('business_id', $this->id)
                ->get();
            return BusinessProduct::hydrateAll($rows);
        } catch (\Throwable) {
            return [];
        }
    }

    /**
     * Get all services linked to this business from the database.
     *
     * @return BusinessService[]
     */
    public function businessServices(): array
    {
        try {
            $rows = BusinessService::query()
                ->where('business_id', $this->id)
                ->get();
            return BusinessService::hydrateAll($rows);
        } catch (\Throwable) {
            return [];
        }
    }

    // -------------------------------------------------------------------------
    // Legacy helpers (kept for backward compatibility with old seeded data)
    // These are only used when the new relational tables have no data for
    // this business. They will not emit defaults for new businesses.
    // -------------------------------------------------------------------------

    /**
     * Get products from the relational table.
     * Falls back to the legacy JSON `menu` column if present.
     * Returns an empty array for new businesses with no products.
     *
     * @return array<array{name: string, price: string, description?: string}>
     */
    public function getMenuItems(): array
    {
        // Prefer new relational data
        $products = $this->products();
        if (!empty($products)) {
            return array_map(fn(BusinessProduct $p) => [
                'name'        => $p->name,
                'price'       => $p->price ?? '',
                'description' => $p->description ?? '',
            ], $products);
        }

        // Fall back to legacy JSON column
        if (!empty($this->menu)) {
            $decoded = json_decode($this->menu, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // No products at all — return empty (do NOT return category defaults)
        return [];
    }

    /**
     * Get services from the relational table.
     * Falls back to the legacy JSON `services` column if present.
     * Returns an empty array for new businesses with no services.
     *
     * @return array<array{name: string, icon: string, description?: string}>
     */
    public function getServicesList(): array
    {
        // Prefer new relational data
        $services = $this->businessServices();
        if (!empty($services)) {
            return array_map(fn(BusinessService $s) => [
                'name'        => $s->name,
                'icon'        => $s->icon ?? 'fa-circle-check',
                'description' => $s->description ?? '',
            ], $services);
        }

        // Fall back to legacy JSON column
        if (!empty($this->services)) {
            $decoded = json_decode($this->services, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // No services at all — return empty
        return [];
    }

    /**
     * Get hours schedule list.
     *
     * @return array<array{days: string, hours: string}>
     */
    public function getHoursSchedule(): array
    {
        if (!empty($this->hours_schedule)) {
            $decoded = json_decode($this->hours_schedule, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        $standardHours = $this->opening_hours ?: '8AM - 8PM';
        return [
            ['days' => 'Monday - Friday', 'hours' => $standardHours],
            ['days' => 'Saturday',        'hours' => '9AM - 6PM'],
            ['days' => 'Sunday',          'hours' => '10AM - 4PM'],
        ];
    }

    /**
     * Best available display image: cover_image → image → null
     */
    public function displayImage(): ?string
    {
        return $this->cover_image ?: $this->image ?: null;
    }
}
