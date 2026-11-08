-- Migration: Add business_products and business_services tables
-- Also adds logo and cover_image columns to businesses

-- -------------------------------------------------------------------------
-- Step 1: Extend the businesses table with logo + cover_image columns
-- -------------------------------------------------------------------------
ALTER TABLE `businesses`
  ADD COLUMN IF NOT EXISTS `logo`        VARCHAR(500) NULL AFTER `image`,
  ADD COLUMN IF NOT EXISTS `cover_image` VARCHAR(500) NULL AFTER `logo`;

-- -------------------------------------------------------------------------
-- Step 2: Products table (one-to-many: business → products)
-- -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `business_products` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `business_id` INT UNSIGNED NOT NULL,
    `name`        VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `price`       VARCHAR(100) NULL,
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bp_business` FOREIGN KEY (`business_id`)
        REFERENCES `businesses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------------------
-- Step 3: Services table (one-to-many: business → services)
-- -------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `business_services` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `business_id` INT UNSIGNED NOT NULL,
    `name`        VARCHAR(200) NOT NULL,
    `description` TEXT NULL,
    `icon`        VARCHAR(100) NULL DEFAULT 'fa-circle-check',
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_bs_business` FOREIGN KEY (`business_id`)
        REFERENCES `businesses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

