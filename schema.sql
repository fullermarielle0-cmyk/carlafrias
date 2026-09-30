-- ============================================
-- Create Database
-- ============================================
CREATE DATABASE IF NOT EXISTS exam_db;
USE exam_db;

-- ============================================
-- Create Users Table
-- ============================================
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user', 'admin') DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Insert Default Admin Account
-- ============================================
INSERT INTO users (username, password, role)
VALUES ('admin', '123', 'admin')
ON DUPLICATE KEY UPDATE
  password = VALUES(password),
  role = VALUES(role);

-- ============================================
-- Verify the data
-- ============================================
SELECT * FROM users;
