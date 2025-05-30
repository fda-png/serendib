ALTER TABLE users
ADD COLUMN phone VARCHAR(20) AFTER email,
ADD COLUMN address VARCHAR(255) AFTER phone;

ALTER TABLE bookings
ADD COLUMN travelers INT NOT NULL DEFAULT 1 AFTER travel_date,
ADD COLUMN notes TEXT AFTER travelers;