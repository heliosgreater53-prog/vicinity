<?php

declare(strict_types=1);

namespace App\Models;

use Core\Model;

/**
 * Business Model
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $category
 * @property string $address
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $description
 * @property string|null $image
 * @property float $rating
 * @property int $reviews_count
 * @property string|null $price_range
 * @property string|null $status
 * @property string|null $opening_hours
 * @property string|null $menu
 * @property string|null $services
 * @property string|null $hours_schedule
 * @property string $created_at
 * @property string $updated_at
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
        'rating',
        'reviews_count',
        'price_range',
        'status',
        'opening_hours',
        'menu',
        'services',
        'hours_schedule',
    ];

    public function user(): ?User
    {
        return User::find($this->user_id);
    }

    /**
     * Get menu / product / service items array
     *
     * @return array<array{name: string, price: string}>
     */
    public function getMenuItems(): array
    {
        if (!empty($this->menu)) {
            $decoded = json_decode($this->menu, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // Context-aware defaults based on category
        return match ($this->category) {
            'Cafes & Dining', 'Food Delivery' => [
                ['name' => 'Signature Specialty Dish', 'price' => '₦2,500'],
                ['name' => 'Artisanal Beverage', 'price' => '₦1,200'],
                ['name' => 'Fresh Daily Pastry', 'price' => '₦850'],
                ['name' => 'Chef Combo Special', 'price' => '₦3,800'],
            ],
            'Tech & Repairs', 'Electronics & Tech' => [
                ['name' => 'Device Diagnostics', 'price' => '₦3,000'],
                ['name' => 'Screen Replacement Service', 'price' => '₦15,000'],
                ['name' => 'Hardware Repair & Tune-up', 'price' => '₦8,500'],
                ['name' => 'Premium Accessories Pack', 'price' => '₦4,000'],
            ],
            'Beauty & Wellness' => [
                ['name' => 'Signature Grooming / Styling', 'price' => '₦5,000'],
                ['name' => 'Therapeutic Spa Treatment', 'price' => '₦18,000'],
                ['name' => 'Deep Facial Care', 'price' => '₦12,000'],
                ['name' => 'Deluxe Manicure & Pedicure', 'price' => '₦8,000'],
            ],
            'Fashion & Tailoring', 'Clothing & Fashion' => [
                ['name' => 'Custom Tailored Native Set', 'price' => '₦32,000'],
                ['name' => 'Bespoke 2-Piece Suit', 'price' => '₦60,000'],
                ['name' => 'Express Alterations', 'price' => '₦3,000'],
                ['name' => 'Fabric & Measurement Service', 'price' => '₦5,000'],
            ],
            'Sports & Fitness' => [
                ['name' => 'Day Pass & Studio Workout', 'price' => '₦3,000'],
                ['name' => 'Monthly Unlimited Membership', 'price' => '₦25,000'],
                ['name' => 'Personal Coaching Session', 'price' => '₦10,000'],
                ['name' => 'Nutrition & Protein Shake', 'price' => '₦2,000'],
            ],
            default => [
                ['name' => 'Standard Service Consultation', 'price' => '₦5,000'],
                ['name' => 'Primary Product / Package', 'price' => '₦12,000'],
                ['name' => 'Express Delivery / Setup', 'price' => '₦3,500'],
                ['name' => 'Support & Follow-up Plan', 'price' => '₦7,500'],
            ],
        };
    }

    /**
     * Get services / amenities array with FontAwesome icon classes
     *
     * @return array<array{name: string, icon: string}>
     */
    public function getServicesList(): array
    {
        if (!empty($this->services)) {
            $decoded = json_decode($this->services, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded;
            }
        }

        // Context-aware defaults based on category
        return match ($this->category) {
            'Cafes & Dining', 'Food Delivery' => [
                ['name' => 'Free Wi-Fi', 'icon' => 'fa-wifi'],
                ['name' => 'Power Outlets', 'icon' => 'fa-tablet-button'],
                ['name' => 'Outdoor Seating', 'icon' => 'fa-chair'],
                ['name' => 'Takeaway & Delivery', 'icon' => 'fa-bag-shopping'],
            ],
            'Tech & Repairs', 'Electronics & Tech' => [
                ['name' => 'Warranty Guarantee', 'icon' => 'fa-shield-halved'],
                ['name' => 'Express 1-Hour Fix', 'icon' => 'fa-bolt'],
                ['name' => 'Certified Technicians', 'icon' => 'fa-certificate'],
                ['name' => 'Doorstep Pick-up', 'icon' => 'fa-truck-fast'],
            ],
            'Beauty & Wellness' => [
                ['name' => 'Private Suites', 'icon' => 'fa-door-closed'],
                ['name' => 'Aromatherapy', 'icon' => 'fa-spray-can-sparkles'],
                ['name' => 'Refreshment Lounge', 'icon' => 'fa-mug-hot'],
                ['name' => 'Online Booking', 'icon' => 'fa-calendar-check'],
            ],
            'Groceries & Retail', 'Markets & Grocery' => [
                ['name' => 'Air Conditioned', 'icon' => 'fa-snowflake'],
                ['name' => 'Ample Parking', 'icon' => 'fa-square-parking'],
                ['name' => 'POS & Transfer', 'icon' => 'fa-credit-card'],
                ['name' => 'Swift Home Delivery', 'icon' => 'fa-truck-fast'],
            ],
            default => [
                ['name' => 'Verified Business', 'icon' => 'fa-circle-check'],
                ['name' => 'Customer Support', 'icon' => 'fa-headset'],
                ['name' => 'Flexible Payment', 'icon' => 'fa-credit-card'],
                ['name' => 'Local Delivery', 'icon' => 'fa-truck'],
            ],
        };
    }

    /**
     * Get hours schedule list
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
            ['days' => 'Saturday', 'hours' => '9AM - 6PM'],
            ['days' => 'Sunday', 'hours' => '10AM - 4PM'],
        ];
    }
}
