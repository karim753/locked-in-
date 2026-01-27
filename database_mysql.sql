-- KEUZDEEL DATABASE SCHEMA AND DATA
-- MySQL Database for Keuzedeel Management System
-- Database Name: keuzedeel_db
-- Generated: 2026-01-27

-- Create database
CREATE DATABASE IF NOT EXISTS keuzedeel_db;
USE keuzedeel_db;

-- ========================================
-- TABLE STRUCTURES
-- ========================================

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    microsoft_id VARCHAR(255) UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    role ENUM('student', 'admin', 'slber') DEFAULT 'student',
    study_program VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Periods table
CREATE TABLE periods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    enrollment_opens_at TIMESTAMP NULL,
    enrollment_closes_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Keuzedelen table
CREATE TABLE keuzedelen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    period_id INT NOT NULL,
    min_participants INT DEFAULT 15,
    max_participants INT DEFAULT 30,
    is_repeatable BOOLEAN DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    teacher_name VARCHAR(255),
    schedule_info TEXT,
    credits INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (period_id) REFERENCES periods(id) ON DELETE CASCADE
);

-- Inscriptions table
CREATE TABLE inscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    keuzdeel_id INT NOT NULL,
    status ENUM('confirmed', 'pending', 'waitlisted', 'cancelled') DEFAULT 'pending',
    priority INT DEFAULT 1,
    inscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_keuzedeel (user_id, keuzdeel_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (keuzdeel_id) REFERENCES keuzedelen(id) ON DELETE CASCADE
);

-- Completed Keuzedelen table
CREATE TABLE completed_keuzedelen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    keuzdeel_id INT NOT NULL,
    completion_date DATE,
    grade VARCHAR(10),
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_keuzedeel_completed (user_id, keuzdeel_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (keuzdeel_id) REFERENCES keuzedelen(id) ON DELETE CASCADE
);

-- ========================================
-- INDEXES
-- ========================================

CREATE INDEX keuzedelen_period_id_index ON keuzedelen(period_id);
CREATE INDEX keuzedelen_is_active_index ON keuzedelen(is_active);
CREATE INDEX keuzedelen_is_repeatable_index ON keuzedelen(is_repeatable);
CREATE INDEX keuzedelen_min_max_participants_index ON keuzedelen(min_participants, max_participants);

CREATE INDEX inscriptions_user_id_index ON inscriptions(user_id);
CREATE INDEX inscriptions_keuzdeel_id_index ON inscriptions(keuzdeel_id);
CREATE INDEX inscriptions_status_index ON inscriptions(status);

CREATE INDEX completed_keuzedelen_user_id_index ON completed_keuzedelen(user_id);
CREATE INDEX completed_keuzedelen_keuzdeel_id_index ON completed_keuzedelen(keuzdeel_id);

CREATE INDEX users_email_index ON users(email);
CREATE INDEX users_microsoft_id_index ON users(microsoft_id);
CREATE INDEX users_role_index ON users(role);

CREATE INDEX periods_is_active_index ON periods(is_active);
CREATE INDEX periods_start_end_date_index ON periods(start_date, end_date);

-- ========================================
-- SAMPLE DATA
-- ========================================

-- Test Users
INSERT INTO users (name, email, password, role, study_program) VALUES
('Student User', 'student@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'Software Development'),
('Admin User', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL),
('SLB User', 'slb@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'slber', NULL);

-- Periods
INSERT INTO periods (name, start_date, end_date, enrollment_opens_at, enrollment_closes_at, is_active) VALUES
('Periode 1 - 2025', '2025-02-01', '2025-04-30', '2025-01-15 00:00:00', '2025-01-31 23:59:59', 1),
('Periode 2 - 2025', '2025-05-01', '2025-07-31', '2025-04-15 00:00:00', '2025-04-30 23:59:59', 1),
('Periode 3 - 2025', '2025-08-01', '2025-10-31', '2025-07-15 00:00:00', '2025-07-31 23:59:59', 1);

-- Sample Keuzedelen
INSERT INTO keuzedelen (title, description, period_id, min_participants, max_participants, is_repeatable, is_active, teacher_name, schedule_info, credits) VALUES
('Web Development Advanced', 'Verdiep je kennis in moderne web development technieken. Leer werken met frameworks zoals React, Vue.js en Angular. Focus op performance, security en best practices. Inclusief projecten waarbij je een complete webapplicatie bouwt van concept tot deployment.', 1, 12, 25, 0, 1, 'Dr. Jansen', 'Maandag en woensdag 13:30-16:30, plus projecturen', 3),
('Data Science Fundamentals', 'Ontdek de wereld van data science. Leer werken met Python, pandas, en machine learning libraries. Analyseer datasets, visualiseer data en bouw voorspellende modellen. Perfect voor studenten die willen werken met big data en AI.', 1, 15, 30, 0, 1, 'Prof. Smith', 'Dinsdag en donderdag 09:00-12:00, lab uren', 3),
('Mobile App Development', 'Leer native en cross-platform mobile apps ontwikkelen. Werk met Swift/iOS, Kotlin/Android of React Native. Bouw echte apps die je kunt publiceren in de app stores. Inclusief UX/UI design principes.', 2, 10, 20, 0, 1, 'Ing. Johnson', 'Woensdag en vrijdag 09:00-12:00', 3),
('Cybersecurity Essentials', 'Duik in de wereld van cybersecurity. Leer over netwerkbeveiliging, ethisch hacken, cryptografie en security best practices. Bereid je voor op een carrière als security specialist.', 2, 12, 25, 1, 1, 'Dr. Williams', 'Maandag en donderdag 13:30-16:30', 3);

-- ========================================
-- DATABASE SUMMARY
-- ========================================

/*
DATABASE OVERVIEW:
- Type: MySQL/MariaDB
- Total Tables: 5 (main application tables)
- Main Application Tables: 5

TABLES SUMMARY:
- users: 3 records (test accounts)
- periods: 3 records (academic periods)
- keuzedelen: 4 records (available courses)
- inscriptions: 0 records (student enrollments)
- completed_keuzedelen: 0 records (completed courses)

RELATIONSHIPS:
- Users can have multiple inscriptions
- Users can have multiple completed keuzedelen
- Periods contain multiple keuzedelen
- Keuzedelen can have multiple inscriptions
- Keuzedelen can have multiple completions

CONSTRAINTS:
- Unique constraint on user_id + keuzdeel_id in inscriptions
- Unique constraint on user_id + keuzdeel_id in completed_keuzedelen
- Foreign key constraints with cascade delete
- ENUM constraints for role and status fields

TEST ACCOUNTS:
- Student: student@example.com / password
- Admin: admin@example.com / password
- SLBer: slb@example.com / password

READY FOR PRODUCTION USE
*/
