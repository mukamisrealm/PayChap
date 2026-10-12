-- ChapChapPay Relational Database Schema (3NF)
CREATE DATABASE IF NOT EXISTS chapchappay_db;
USE chapchappay_db;

-- 1. Users Table
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL UNIQUE,
    role VARCHAR(15) NOT NULL DEFAULT 'Member',
    language_preference ENUM('eng', 'swa') DEFAULT 'eng',
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Requests Table
CREATE TABLE IF NOT EXISTS requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    request_type ENUM('skip_round', 'loan', 'other') NOT NULL,
    reason TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Fines Table
CREATE TABLE IF NOT EXISTS fines (
    fine_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    reason VARCHAR(255) NOT NULL,
    status ENUM('unpaid', 'paid') DEFAULT 'unpaid',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 4. Contributions Table
CREATE TABLE IF NOT EXISTS contributions (
    contribution_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    mpesa_receipt_no VARCHAR(50),
    phone_number VARCHAR(15) NOT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 5. Rotational Queue Table
CREATE TABLE IF NOT EXISTS rotational_queue (
    queue_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    round_number INT NOT NULL,
    position_order INT NOT NULL,
    received_payout BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 6. Payouts Table
CREATE TABLE IF NOT EXISTS payouts (
    payout_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    round_number INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    mpesa_receipt_no VARCHAR(50),
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;