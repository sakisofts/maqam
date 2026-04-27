-- User table to store customer information
CREATE TABLE `user` (
                        `id` INT PRIMARY KEY AUTO_INCREMENT,
                        `username` VARCHAR(255) NOT NULL UNIQUE,
                        `auth_key` VARCHAR(32) NOT NULL,
                        `password_hash` VARCHAR(255) NOT NULL,
                        `password_reset_token` VARCHAR(255) UNIQUE,
                        `email` VARCHAR(255) NOT NULL UNIQUE,
                        `status` SMALLINT NOT NULL DEFAULT 10,
                        `created_at` INT NOT NULL,
                        `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pilgrim table to store detailed pilgrim information
CREATE TABLE `pilgrim` (
                           `id` INT PRIMARY KEY AUTO_INCREMENT,
                           `user_id` INT NOT NULL,
                           `first_name` VARCHAR(100) NOT NULL,
                           `last_name` VARCHAR(100) NOT NULL,
                           `passport_number` VARCHAR(50) NOT NULL,
                           `passport_issue_date` DATE NOT NULL,
                           `passport_expiry_date` DATE NOT NULL,
                           `date_of_birth` DATE NOT NULL,
                           `gender` ENUM('Male', 'Female') NOT NULL,
                           `nationality` VARCHAR(100) NOT NULL,
                           `address` TEXT NOT NULL,
                           `phone` VARCHAR(30) NOT NULL,
                           `emergency_contact_name` VARCHAR(200),
                           `emergency_contact_phone` VARCHAR(30),
                           `medical_conditions` TEXT,
                           `created_at` INT NOT NULL,
                           `updated_at` INT NOT NULL
                       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mahram relationship table for female pilgrims
CREATE TABLE `mahram_relationship` (
                                       `id` INT PRIMARY KEY AUTO_INCREMENT,
                                       `pilgrim_id` INT NOT NULL,
                                       `mahram_pilgrim_id` INT NOT NULL,
                                       `relationship` VARCHAR(50) NOT NULL,
                                       `created_at` INT NOT NULL,
                                       `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event type table
CREATE TABLE `event_type` (
                              `id` INT PRIMARY KEY AUTO_INCREMENT,
                              `name` ENUM('Hajj', 'Umrah') NOT NULL,
                              `description` TEXT,
                              `created_at` INT NOT NULL,
                              `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event table for specific hajj/umrah events
CREATE TABLE `event` (
                         `id` INT PRIMARY KEY AUTO_INCREMENT,
                         `event_type_id` INT NOT NULL,
                         `title` VARCHAR(255) NOT NULL,
                         `description` TEXT,
                         `start_date` DATE NOT NULL,
                         `end_date` DATE NOT NULL,
                         `registration_deadline` DATE NOT NULL,
                         `visa_deadline` DATE NOT NULL,
                         `max_capacity` INT NOT NULL,
                         `status` ENUM('Upcoming', 'Active', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Upcoming',
                         `created_at` INT NOT NULL,
                         `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Package category table
CREATE TABLE `package_category` (
                                    `id` INT PRIMARY KEY AUTO_INCREMENT,
                                    `name` VARCHAR(100) NOT NULL,
                                    `description` TEXT,
                                    `created_at` INT NOT NULL,
                                    `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Package table
CREATE TABLE `package` (
                           `id` INT PRIMARY KEY AUTO_INCREMENT,
                           `event_id` INT NOT NULL,
                           `package_category_id` INT NOT NULL,
                           `name` VARCHAR(255) NOT NULL,
                           `description` TEXT NOT NULL,
                           `price` DECIMAL(10,2) NOT NULL,
                           `currency` VARCHAR(3) NOT NULL DEFAULT 'USD',
                           `accommodation_type` VARCHAR(100) NOT NULL,
                           `transportation_details` TEXT NOT NULL,
                           `duration_days` INT NOT NULL,
                           `meals_included` TINYINT(1) NOT NULL DEFAULT 1,
                           `max_slots` INT NOT NULL,
                           `available_slots` INT NOT NULL,
                           `created_at` INT NOT NULL,
                           `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reservation table
CREATE TABLE `reservation` (
                               `id` INT PRIMARY KEY AUTO_INCREMENT,
                               `reservation_number` VARCHAR(50) NOT NULL UNIQUE,
                               `user_id` INT NOT NULL,
                               `package_id` INT NOT NULL,
                               `reservation_date` DATETIME NOT NULL,
                               `number_of_pilgrims` INT NOT NULL DEFAULT 1,
                               `status` ENUM('Pending', 'Confirmed', 'Cancelled', 'Completed') NOT NULL DEFAULT 'Pending',
                               `total_amount` DECIMAL(10,2) NOT NULL,
                               `amount_paid` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
                               `balance_due` DECIMAL(10,2) NOT NULL,
                               `payment_deadline` DATE NOT NULL,
                               `special_requests` TEXT,
                               `created_at` INT NOT NULL,
                               `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reservation pilgrims association table
CREATE TABLE `reservation_pilgrim` (
                                       `id` INT PRIMARY KEY AUTO_INCREMENT,
                                       `reservation_id` INT NOT NULL,
                                       `pilgrim_id` INT NOT NULL,
                                       `created_at` INT NOT NULL,
                                       `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment table
CREATE TABLE `payment` (
                           `id` INT PRIMARY KEY AUTO_INCREMENT,
                           `payment_number` VARCHAR(50) NOT NULL UNIQUE,
                           `reservation_id` INT NOT NULL,
                           `amount` DECIMAL(10,2) NOT NULL,
                           `payment_date` DATETIME NOT NULL,
                           `payment_method` ENUM('Cash', 'Credit Card', 'Bank Transfer', 'PayPal', 'Other') NOT NULL,
                           `transaction_id` VARCHAR(255),
                           `payment_status` ENUM('Pending', 'Completed', 'Failed', 'Refunded') NOT NULL DEFAULT 'Pending',
                           `payment_type` ENUM('Deposit', 'Installment', 'Full Payment', 'Additional Service') NOT NULL,
                           `notes` TEXT,
                           `receipt_number` VARCHAR(50),
                           `created_at` INT NOT NULL,
                           `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment plan table
CREATE TABLE `payment_plan` (
                                `id` INT PRIMARY KEY AUTO_INCREMENT,
                                `reservation_id` INT NOT NULL,
                                `total_installments` INT NOT NULL,
                                `created_at` INT NOT NULL,
                                `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Payment plan installment table
CREATE TABLE `payment_plan_installment` (
                                            `id` INT PRIMARY KEY AUTO_INCREMENT,
                                            `payment_plan_id` INT NOT NULL,
                                            `installment_number` INT NOT NULL,
                                            `due_date` DATE NOT NULL,
                                            `amount` DECIMAL(10,2) NOT NULL,
                                            `status` ENUM('Pending', 'Paid', 'Overdue') NOT NULL DEFAULT 'Pending',
                                            `payment_id` INT NULL,
                                            `created_at` INT NOT NULL,
                                            `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Document table for storing visa, passport copies, etc.
CREATE TABLE `document` (
                            `id` INT PRIMARY KEY AUTO_INCREMENT,
                            `pilgrim_id` INT NOT NULL,
                            `document_type` VARCHAR(100) NOT NULL,
                            `file_name` VARCHAR(255) NOT NULL,
                            `file_path` VARCHAR(255) NOT NULL,
                            `mime_type` VARCHAR(100) NOT NULL,
                            `size` INT NOT NULL,
                            `status` ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
                            `upload_date` DATETIME NOT NULL,
                            `notes` TEXT,
                            `created_at` INT NOT NULL,
                            `updated_at` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default event types
INSERT INTO `event_type` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
                                                                                       (1, 'Hajj', 'Annual Islamic pilgrimage to Mecca', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
                                                                                       (2, 'Umrah', 'Lesser pilgrimage performed by Muslims to Mecca', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- Insert sample package categories
INSERT INTO `package_category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
                                                                                             (1, 'Economy', 'Basic package with standard accommodations', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
                                                                                             (2, 'Standard', 'Medium-tier package with better accommodations', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
                                                                                             (3, 'Premium', 'High-end package with luxury accommodations', UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
                                                                                             (4, 'VIP', 'Executive package with premium services and special attention', UNIX_TIMESTAMP(), UNIX_TIMESTAMP());


alter table packages add column amenity json;
create table amenities (
                           id bigint primary key auto_increment,
                           amenity varchar(255),
                           created_by bigint,
                           created_at timestamp
);

alter table packages add column status varchar(255);

ALTER TABLE maqaidrx_maqam_admin.reservation MODIFY COLUMN created_at DATETIME NOT NULL;
ALTER TABLE maqaidrx_maqam_admin.reservation MODIFY COLUMN updated_at DATETIME NOT NULL;

