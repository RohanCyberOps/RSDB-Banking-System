-- Create the database
CREATE DATABASE IF NOT EXISTS bank;
USE bank;

-- Table: accounts
CREATE TABLE IF NOT EXISTS accounts (
                                        account_no VARCHAR(20) NOT NULL PRIMARY KEY,
                                        customer_name VARCHAR(100) NOT NULL,
                                        customer_id BIGINT NOT NULL UNIQUE,
                                        email VARCHAR(100) UNIQUE,
                                        phone_number VARCHAR(15) UNIQUE,
                                        account_type ENUM('SAVINGS', 'CURRENT', 'FIXED DEPOSIT') NOT NULL,
                                        balance DECIMAL(15, 2) NOT NULL DEFAULT 0.00,
                                        branch_name VARCHAR(100) NOT NULL,
                                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                        status ENUM('ACTIVE', 'INACTIVE', 'CLOSED') DEFAULT 'ACTIVE',
                                        user_id VARCHAR(20) NOT NULL UNIQUE
);

-- Table: admins
CREATE TABLE IF NOT EXISTS admins (
                                      id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                      username VARCHAR(50) NOT NULL UNIQUE,
                                      email VARCHAR(100) NOT NULL UNIQUE,
                                      password VARCHAR(255) NOT NULL,
                                      role ENUM('SUPER_ADMIN', 'ADMIN') DEFAULT 'ADMIN',
                                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: loginattempts
CREATE TABLE IF NOT EXISTS loginattempts (
                                             id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                             user BIGINT UNSIGNED,
                                             ip VARCHAR(255),
                                             timestamp INT UNSIGNED
);

-- Table: logs
CREATE TABLE IF NOT EXISTS logs (
                                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                    user_id INT NOT NULL,
                                    action TEXT NOT NULL,
                                    log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table: requests
CREATE TABLE IF NOT EXISTS requests (
                                        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                        user BIGINT UNSIGNED,
                                        hash VARCHAR(255),
                                        timestamp INT UNSIGNED,
                                        type INT
);

-- Table: transactions
CREATE TABLE IF NOT EXISTS transactions (
                                            user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                            account_no VARCHAR(20),
                                            sender_user_id INT NOT NULL,
                                            sender_name VARCHAR(255) NOT NULL,
                                            receiver_user_id INT,
                                            receiver_name VARCHAR(255),
                                            transaction_amount DECIMAL(10, 2) NOT NULL,
                                            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                            transaction_id VARCHAR(36) NOT NULL UNIQUE,
                                            sender_account_no VARCHAR(20) NOT NULL,
                                            receiver_account_no VARCHAR(20),
                                            role ENUM('sender', 'receiver') NOT NULL,
                                            type ENUM('Deposit', 'Withdrawal', 'Transfer') NOT NULL,
                                            FOREIGN KEY (account_no) REFERENCES accounts(account_no),
                                            FOREIGN KEY (sender_user_id) REFERENCES users(id),
                                            FOREIGN KEY (receiver_user_id) REFERENCES users(id)
);

-- Table: transfer_form
CREATE TABLE IF NOT EXISTS transfer_form (
                                             id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                             sender_user_id INT NOT NULL,
                                             sender_name VARCHAR(255) NOT NULL,
                                             sender_account_no VARCHAR(255) NOT NULL,
                                             receiver_user_id INT NOT NULL,
                                             receiver_name VARCHAR(255) NOT NULL,
                                             receiver_account_no VARCHAR(255) NOT NULL,
                                             transaction_amount DECIMAL(10, 2) NOT NULL,
                                             transaction_id VARCHAR(255) NOT NULL UNIQUE,
                                             created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                             status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
                                             notes TEXT,
                                             FOREIGN KEY (sender_user_id) REFERENCES users(id),
                                             FOREIGN KEY (receiver_user_id) REFERENCES users(id)
);

-- Table: userlogin
CREATE TABLE IF NOT EXISTS userlogin (
                                         user_id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                         account_no VARCHAR(20) NOT NULL UNIQUE,
                                         username VARCHAR(50) NOT NULL UNIQUE,
                                         password_hash VARCHAR(255) NOT NULL,
                                         email VARCHAR(100) NOT NULL UNIQUE,
                                         phone_number VARCHAR(15) NOT NULL UNIQUE,
                                         last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                         status ENUM('ACTIVE', 'LOCKED', 'DISABLED') DEFAULT 'ACTIVE',
                                         created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: users
CREATE TABLE IF NOT EXISTS users (
                                     id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                     user_id VARCHAR(20) NOT NULL UNIQUE,
                                     name VARCHAR(100) NOT NULL,
                                     email VARCHAR(255) NOT NULL UNIQUE,
                                     gender ENUM('Male', 'Female') NOT NULL,
                                     balance DECIMAL(10, 2) NOT NULL,
                                     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                     username VARCHAR(100) NOT NULL UNIQUE,
                                     password VARCHAR(555),
                                     Acc_Number VARCHAR(20) NOT NULL UNIQUE,
                                     verified TINYINT(1) NOT NULL DEFAULT 0,
                                     role ENUM('admin', 'user', 'editor', 'viewer') DEFAULT 'user'
);

-- Add foreign key constraints
ALTER TABLE logs ADD CONSTRAINT fk_logs_user_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE transactions ADD CONSTRAINT fk_transactions_account_no FOREIGN KEY (account_no) REFERENCES accounts(account_no);
ALTER TABLE transactions ADD CONSTRAINT fk_transactions_sender_user_id FOREIGN KEY (sender_user_id) REFERENCES users(id);
ALTER TABLE transactions ADD CONSTRAINT fk_transactions_receiver_user_id FOREIGN KEY (receiver_user_id) REFERENCES users(id);
ALTER TABLE transfer_form ADD CONSTRAINT fk_transfer_form_sender_user_id FOREIGN KEY (sender_user_id) REFERENCES users(id);
ALTER TABLE transfer_form ADD CONSTRAINT fk_transfer_form_receiver_user_id FOREIGN KEY (receiver_user_id) REFERENCES users(id);