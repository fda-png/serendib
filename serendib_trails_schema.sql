CREATE DATABASE IF NOT EXISTS serendib_trails;
USE serendib_trails;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('admin', 'user') DEFAULT 'user',
    approved BOOLEAN DEFAULT 0,
    date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE packages (
    package_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    duration_days INT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    travel_date DATE NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (package_id) REFERENCES packages(package_id)
);

CREATE TABLE gallery (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    caption VARCHAR(255),
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved BOOLEAN DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (image_id) REFERENCES gallery(image_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);