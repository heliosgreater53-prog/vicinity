<?php

declare(strict_types=1);

require_once __DIR__ . '/../core/helpers.php';
require_once __DIR__ . '/../core/Database.php';

// Load .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v);
    }
}

try {
    $pdo = \Core\Database::getInstance()->getPdo();

    // 1. Ensure columns exist on businesses table
    $columnsToAdd = [
        'price_range'    => "VARCHAR(50) NULL DEFAULT '₦₦ • Moderate'",
        'status'         => "VARCHAR(50) NOT NULL DEFAULT 'Open Now'",
        'opening_hours'  => "VARCHAR(100) NULL DEFAULT '8AM - 8PM'",
        'menu'           => "TEXT NULL",
        'services'       => "TEXT NULL",
        'hours_schedule' => "TEXT NULL",
    ];

    $existingCols = $pdo->query("DESCRIBE businesses")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($columnsToAdd as $col => $definition) {
        if (!in_array($col, $existingCols, true)) {
            $pdo->exec("ALTER TABLE `businesses` ADD COLUMN `{$col}` {$definition}");
            echo "Added column: {$col}\n";
        }
    }

    // 2. Ensure default user exists
    $userStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $userStmt->execute(['john.doe@example.com']);
    $userId = $userStmt->fetchColumn();

    if (!$userId) {
        $insertUser = $pdo->prepare("
            INSERT INTO users (name, email, password, avatar, bio, location, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");
        $insertUser->execute([
            'John Doe',
            'john.doe@example.com',
            password_hash('password123', PASSWORD_BCRYPT),
            'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=200&q=80',
            'Surulere resident, tech enthusiast and community advocate.',
            'Surulere, Lagos',
        ]);
        $userId = (int) $pdo->lastInsertId();
        echo "Created default user ID: {$userId}\n";
    } else {
        $userId = (int) $userId;
    }

    // 3. Seed canonical businesses
    $businesses = [
        [
            'id'            => 1,
            'name'          => 'GreenBite Cafe & Bakery',
            'category'      => 'Cafes & Dining',
            'address'       => '14 Adeniran Ogunsanya, Surulere',
            'phone'         => '+234 803 123 4567',
            'email'         => 'info@greenbite.ng',
            'website'       => 'https://www.greenbite.ng',
            'description'   => 'Artisanal coffees, fresh sourdough bread, healthy pastries, and a peaceful co-working vibe with fast Wi-Fi. We source our beans directly from Nigerian farmers and bake daily on-site. Open from 8AM to 8PM, seven days a week. Perfect for remote work, study sessions, or casual catch-ups with friends.',
            'image'         => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.9,
            'reviews_count' => 64,
            'price_range'   => '₦₦ • Moderate',
            'status'        => 'Open Now',
            'opening_hours' => '8AM - 8PM',
            'menu'          => json_encode([
                ['name' => 'Cold Brew Coffee', 'price' => '₦800'],
                ['name' => 'Fresh Sourdough', 'price' => '₦500'],
                ['name' => 'Avocado Toast', 'price' => '₦700'],
                ['name' => 'Carrot Cake', 'price' => '₦650'],
                ['name' => 'Breakfast Croissant', 'price' => '₦1,200'],
                ['name' => 'Iced Matcha Latte', 'price' => '₦1,500'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => 'Free Wi-Fi', 'icon' => 'fa-wifi'],
                ['name' => 'Power Outlets', 'icon' => 'fa-tablet-button'],
                ['name' => 'Bike Parking', 'icon' => 'fa-bicycle'],
                ['name' => 'Pet-Friendly', 'icon' => 'fa-dog'],
                ['name' => 'Outdoor Seating', 'icon' => 'fa-chair'],
                ['name' => 'Takeaway & Delivery', 'icon' => 'fa-bag-shopping'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Monday - Friday', 'hours' => '8AM - 8PM'],
                ['days' => 'Saturday', 'hours' => '9AM - 6PM'],
                ['days' => 'Sunday', 'hours' => '10AM - 4PM'],
            ], JSON_UNESCAPED_UNICODE),
        ],
        [
            'id'            => 2,
            'name'          => 'Surulere TechFix & Gadgets',
            'category'      => 'Tech & Repairs',
            'address'       => '52 Bode Thomas Street, Surulere',
            'phone'         => '+234 812 345 6789',
            'email'         => 'support@suruleretechfix.ng',
            'website'       => 'https://www.suruleretechfix.ng',
            'description'   => 'Trusted device doctor for MacBooks, Windows laptops, iPhones, and Androids. Quick turnaround, authentic spare parts, and transparent diagnostics by certified technicians with over 8 years experience.',
            'image'         => 'https://images.unsplash.com/photo-1588508065123-287b28e013da?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.8,
            'reviews_count' => 92,
            'price_range'   => '₦₦ • Affordable',
            'status'        => 'Open Now',
            'opening_hours' => '9AM - 7PM',
            'menu'          => json_encode([
                ['name' => 'Screen Replacement (iPhone / Android)', 'price' => '₦15,000'],
                ['name' => 'Laptop Battery Replacement', 'price' => '₦18,000'],
                ['name' => 'Diagnostic & OS Reinstall', 'price' => '₦5,000'],
                ['name' => 'Charging Port / Micro-soldering', 'price' => '₦6,500'],
                ['name' => 'Water Damage Liquid Cleaning', 'price' => '₦12,000'],
                ['name' => 'Tempered Glass & Premium Case', 'price' => '₦2,500'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => '90-Day Warranty', 'icon' => 'fa-shield-halved'],
                ['name' => 'Express 1-Hour Fix', 'icon' => 'fa-bolt'],
                ['name' => 'Certified Technicians', 'icon' => 'fa-certificate'],
                ['name' => 'Pick-up & Delivery', 'icon' => 'fa-truck-fast'],
                ['name' => 'Free System Diagnostic', 'icon' => 'fa-magnifying-glass'],
                ['name' => 'Board Micro-soldering', 'icon' => 'fa-screwdriver-wrench'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Monday - Friday', 'hours' => '9AM - 7PM'],
                ['days' => 'Saturday', 'hours' => '10AM - 5PM'],
                ['days' => 'Sunday', 'hours' => 'Closed'],
            ], JSON_UNESCAPED_UNICODE),
        ],
        [
            'id'            => 3,
            'name'          => 'Apex Fresh Supermarket',
            'category'      => 'Groceries & Retail',
            'address'       => '88 Ogunlana Drive, Surulere',
            'phone'         => '+234 809 876 5432',
            'email'         => 'orders@apexfresh.ng',
            'website'       => 'https://www.apexfresh.ng',
            'description'   => 'Your one-stop community mart with farm-fresh organic produce, household groceries, premium imported wines, and daily essentials with swift doorstep delivery across Surulere.',
            'image'         => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.7,
            'reviews_count' => 110,
            'price_range'   => '₦ • Budget-Friendly',
            'status'        => 'Open Now',
            'opening_hours' => '8AM - 9PM',
            'menu'          => json_encode([
                ['name' => 'Organic Farm Produce Basket', 'price' => '₦4,500'],
                ['name' => 'Premium Basmati Rice (5kg)', 'price' => '₦8,200'],
                ['name' => 'Household Essentials Pack', 'price' => '₦6,000'],
                ['name' => 'Fresh Dairy & Juice Bundle', 'price' => '₦3,500'],
                ['name' => 'Imported Wine & Sparkling Pack', 'price' => '₦14,000'],
                ['name' => 'Pure Cooking Sunflower Oil (3L)', 'price' => '₦5,800'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => 'Air Conditioned', 'icon' => 'fa-snowflake'],
                ['name' => 'Ample Customer Parking', 'icon' => 'fa-square-parking'],
                ['name' => 'POS / Transfer Accepted', 'icon' => 'fa-credit-card'],
                ['name' => 'Home Delivery (30 mins)', 'icon' => 'fa-truck-fast'],
                ['name' => 'Wheelchair Accessible', 'icon' => 'fa-wheelchair'],
                ['name' => 'Loyalty Discounts', 'icon' => 'fa-tags'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Monday - Saturday', 'hours' => '8AM - 9PM'],
                ['days' => 'Sunday', 'hours' => '9AM - 6PM'],
            ], JSON_UNESCAPED_UNICODE),
        ],
        [
            'id'            => 4,
            'name'          => 'Royal Touch Spa & Salon',
            'category'      => 'Beauty & Wellness',
            'address'       => '22 Akerele Street, Surulere',
            'phone'         => '+234 802 987 6543',
            'email'         => 'appointments@royaltouchspa.ng',
            'website'       => 'https://www.royaltouchspa.ng',
            'description'   => 'Modern relaxation sanctuary providing luxury facials, deep-tissue therapeutic massages, bridal grooming, and premium unisex hairstyling in an ultra-clean, serene ambiance.',
            'image'         => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.9,
            'reviews_count' => 45,
            'price_range'   => '₦₦₦ • Premium',
            'status'        => 'Open Now',
            'opening_hours' => '9AM - 8PM',
            'menu'          => json_encode([
                ['name' => 'Executive Haircut & Beard Sculpting', 'price' => '₦5,000'],
                ['name' => 'Revitalizing Hydrafacial Treatment', 'price' => '₦15,000'],
                ['name' => 'Deep Tissue Swedish Massage (60m)', 'price' => '₦20,000'],
                ['name' => 'Manicure & Pedicure Deluxe Spa', 'price' => '₦8,500'],
                ['name' => 'Aromatherapy Body Scrub', 'price' => '₦18,000'],
                ['name' => 'Bridal Glam Hair & Makeup', 'price' => '₦45,000'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => 'Private Treatment Rooms', 'icon' => 'fa-door-closed'],
                ['name' => 'Aromatherapy Ambiance', 'icon' => 'fa-spray-can-sparkles'],
                ['name' => 'Refreshment Lounge', 'icon' => 'fa-mug-hot'],
                ['name' => 'Certified Therapists', 'icon' => 'fa-award'],
                ['name' => 'Online Booking Available', 'icon' => 'fa-calendar-check'],
                ['name' => 'POS & Transfer Accepted', 'icon' => 'fa-credit-card'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Tuesday - Saturday', 'hours' => '9AM - 8PM'],
                ['days' => 'Sunday', 'hours' => '11AM - 6PM'],
                ['days' => 'Monday', 'hours' => 'Closed'],
            ], JSON_UNESCAPED_UNICODE),
        ],
        [
            'id'            => 5,
            'name'          => 'Urban Thread Bespoke',
            'category'      => 'Fashion & Tailoring',
            'address'       => '19 Shitta Road, Surulere',
            'phone'         => '+234 817 654 3210',
            'email'         => 'hello@urbanthread.ng',
            'website'       => 'https://www.urbanthread.ng',
            'description'   => 'Contemporary tailoring house specializing in crisp native Senator suits, bespoke Agbadas, corporate apparel, and precision alteration services with timely delivery.',
            'image'         => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.8,
            'reviews_count' => 38,
            'price_range'   => '₦₦ • Moderate',
            'status'        => 'Open Now',
            'opening_hours' => '9AM - 6PM',
            'menu'          => json_encode([
                ['name' => 'Custom Senator Native Set', 'price' => '₦35,000'],
                ['name' => 'Handcrafted 3-Piece Agbada', 'price' => '₦80,000'],
                ['name' => '2-Piece Formal Tailored Suit', 'price' => '₦65,000'],
                ['name' => 'Linen Kaftan Set', 'price' => '₦28,000'],
                ['name' => 'Express Pant / Shirt Alterations', 'price' => '₦3,500'],
                ['name' => 'Traditional Embroidery Works', 'price' => '₦15,000'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => 'VIP Fitting Room', 'icon' => 'fa-person-booth'],
                ['name' => 'Fabric Sourcing & Catalog', 'icon' => 'fa-shirt'],
                ['name' => 'Measurement Archive', 'icon' => 'fa-ruler'],
                ['name' => 'Express Stitching', 'icon' => 'fa-stopwatch'],
                ['name' => 'Doorstep Delivery', 'icon' => 'fa-box'],
                ['name' => 'Custom Monogramming', 'icon' => 'fa-pen-fancy'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Monday - Saturday', 'hours' => '9AM - 6PM'],
                ['days' => 'Sunday', 'hours' => 'Closed'],
            ], JSON_UNESCAPED_UNICODE),
        ],
        [
            'id'            => 6,
            'name'          => 'Zenith Fitness Hub',
            'category'      => 'Sports & Fitness',
            'address'       => 'Near National Stadium, Surulere',
            'phone'         => '+234 805 112 2334',
            'email'         => 'join@zenithfitness.ng',
            'website'       => 'https://www.zenithfitness.ng',
            'description'   => 'State-of-the-art gym equipped with heavy free weights, Olympic racks, cardio cinema, certified personal trainers, HIIT studio, and an organic smoothie health bar.',
            'image'         => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=800&q=80',
            'rating'        => 4.6,
            'reviews_count' => 53,
            'price_range'   => '₦₦ • Subscription',
            'status'        => 'Open Now',
            'opening_hours' => '6AM - 9PM',
            'menu'          => json_encode([
                ['name' => 'Day Pass & Group Spin Session', 'price' => '₦3,000'],
                ['name' => 'Monthly All-Access Gym Pass', 'price' => '₦25,000'],
                ['name' => '1-on-1 Personal Trainer Session', 'price' => '₦10,000'],
                ['name' => 'Organic Whey Protein Smoothie', 'price' => '₦2,200'],
                ['name' => '10-Session HIIT Bootcamp Pack', 'price' => '₦22,000'],
                ['name' => 'Quarterly VIP Full Access', 'price' => '₦65,000'],
            ], JSON_UNESCAPED_UNICODE),
            'services'      => json_encode([
                ['name' => 'Cardio & Heavy Weights', 'icon' => 'fa-dumbbell'],
                ['name' => 'Shower & Locker Rooms', 'icon' => 'fa-shower'],
                ['name' => 'Certified Trainers', 'icon' => 'fa-user-ninja'],
                ['name' => 'Organic Smoothie Bar', 'icon' => 'fa-blender'],
                ['name' => 'Steam & Sauna Room', 'icon' => 'fa-hot-tub-person'],
                ['name' => 'Filtered Water Stations', 'icon' => 'fa-bottle-water'],
            ], JSON_UNESCAPED_UNICODE),
            'hours_schedule' => json_encode([
                ['days' => 'Monday - Friday', 'hours' => '6AM - 9PM'],
                ['days' => 'Saturday', 'hours' => '7AM - 7PM'],
                ['days' => 'Sunday', 'hours' => '8AM - 2PM'],
            ], JSON_UNESCAPED_UNICODE),
        ],
    ];

    $checkStmt = $pdo->prepare("SELECT id FROM businesses WHERE id = ?");
    $insertStmt = $pdo->prepare("
        INSERT INTO businesses (
            id, user_id, name, category, address, phone, email, website,
            description, image, rating, reviews_count, price_range, status,
            opening_hours, menu, services, hours_schedule, created_at, updated_at
        ) VALUES (
            :id, :user_id, :name, :category, :address, :phone, :email, :website,
            :description, :image, :rating, :reviews_count, :price_range, :status,
            :opening_hours, :menu, :services, :hours_schedule, NOW(), NOW()
        )
    ");
    $updateStmt = $pdo->prepare("
        UPDATE businesses SET
            name = :name,
            category = :category,
            address = :address,
            phone = :phone,
            email = :email,
            website = :website,
            description = :description,
            image = :image,
            rating = :rating,
            reviews_count = :reviews_count,
            price_range = :price_range,
            status = :status,
            opening_hours = :opening_hours,
            menu = :menu,
            services = :services,
            hours_schedule = :hours_schedule,
            updated_at = NOW()
        WHERE id = :id
    ");

    foreach ($businesses as $b) {
        $checkStmt->execute([$b['id']]);
        $exists = $checkStmt->fetchColumn();

        $params = [
            ':id'             => $b['id'],
            ':name'           => $b['name'],
            ':category'       => $b['category'],
            ':address'        => $b['address'],
            ':phone'          => $b['phone'],
            ':email'          => $b['email'],
            ':website'        => $b['website'],
            ':description'    => $b['description'],
            ':image'          => $b['image'],
            ':rating'         => $b['rating'],
            ':reviews_count'  => $b['reviews_count'],
            ':price_range'    => $b['price_range'],
            ':status'         => $b['status'],
            ':opening_hours'  => $b['opening_hours'],
            ':menu'           => $b['menu'],
            ':services'       => $b['services'],
            ':hours_schedule' => $b['hours_schedule'],
        ];

        if ($exists) {
            $updateStmt->execute($params);
            echo "Updated business #{$b['id']}: {$b['name']}\n";
        } else {
            $params[':user_id'] = $userId;
            $insertStmt->execute($params);
            echo "Inserted business #{$b['id']}: {$b['name']}\n";
        }
    }

    echo "Seeding completed successfully!\n";
} catch (\Throwable $e) {
    echo "Seed Error: " . $e->getMessage() . "\n";
    exit(1);
}
