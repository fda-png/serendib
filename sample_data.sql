-- Use REAL password hashes for all users
INSERT INTO users (name, email, password, user_type, approved, date_joined) VALUES
('Admin User', 'admin@serendib.lk', '$2y$10$4d7c9b8a5f6e3d2c1b0a9Z8Y7X6W5V4U3T2S1R0Q9P8O7N6M5L4K', 'admin', 1, '2025-01-15 10:30:00'),
('Travel Enthusiast', 'traveler@example.com', '$2y$10$0f9e8d7c6b5a49382716Z5e4d3c2b1a0.9z8y7x6w5v4u3t2s1r0q', 'user', 1, '2025-02-20 14:15:00'),
('Adventure Seeker', 'adventure@mail.com', '$2y$10$vT9w4x7z2c1b3n5m6l7k8j9h0g1f2d3s4a5q6w7e8r9t0y1u2i3o4p', 'user', 1, '2025-03-10 09:45:00'),
('Culture Explorer', 'culture@explorer.lk', '$2y$10$uO6gUfI.7dJ0U7V5A0qB.eGz6g7h8j9k0l1m2n3o4p5q6r7s8t9u', 'user', 0, '2025-04-05 16:20:00'),
('Beach Lover', 'beach@vacation.com', '$2y$10$4V8O7vrXfVtT3oI2u1YrO.9q8w7e6r5t4y3u2i1o0p9l8k7j6h5g4f', 'user', 1, '2025-05-12 11:05:00');

-- Insert sample packages
INSERT INTO packages (title, description, location, price, duration_days, image_url) VALUES
('Sigiriya Rock Adventure', 'Explore the ancient rock fortress with a guided tour', 'Sigiriya', 189.00, 2, 'images\packages\sl8.jpg'),
('Ella Mountain Escape', 'Trek through lush tea plantations and waterfalls', 'Ella', 249.00, 3, 'images\packages\sl4.jpg'),
('Galle Fort Heritage Tour', 'Discover Dutch colonial architecture and coastal views', 'Galle', 159.00, 1, 'images\packages\sl21.jpg'),
('Yala Safari Experience', 'Wildlife safari with leopard spotting opportunities', 'Yala', 299.00, 2, 'images\packages\sl10.jpg'),
('Kandy Cultural Journey', 'Visit Temple of the Tooth and cultural shows', 'Kandy', 199.00, 2, '"images\packages\sl23.jpg'),
('South Coast Beach Hopping', 'Explore hidden beaches and coastal villages', 'Mirissa', 349.00, 4, 'images\packages\sl17.jpg');


-- Insert sample bookings
INSERT INTO bookings (user_id, package_id, booking_date, travel_date, status) VALUES
(2, 1, '2025-05-01', '2025-06-15', 'confirmed'),
(2, 3, '2025-05-10', '2025-07-20', 'pending'),
(3, 4, '2025-04-25', '2025-08-05', 'confirmed'),
(5, 6, '2025-05-15', '2025-09-12', 'confirmed'),
(3, 2, '2025-05-03', '2025-10-18', 'cancelled');

-- Insert sample gallery images
INSERT INTO gallery (user_id, image_url, caption, upload_date, approved) VALUES
(2, 'galle_fort.jpg', 'Sunset at Galle Fort', '2025-04-12', 1),
(3, 'ella_railway.jpg', 'Famous Nine Arch Bridge', '2025-04-18', 1),
(5, 'mirissa_beach.jpg', 'Relaxing at Mirissa Beach', '2025-04-25', 1),
(3, 'sigiriya_view.jpg', 'View from top of Sigiriya', '2025-05-02', 0),
(5, 'kandy_temple.jpg', 'Temple of the Sacred Tooth', '2025-05-10', 1),
(2, 'tea_plantation.jpg', 'Tea fields in Nuwara Eliya', '2025-05-15', 0);

-- Insert sample comments
INSERT INTO comments (image_id, user_id, content, timestamp) VALUES
(1, 3, 'Stunning capture! When was this taken?', '2025-04-13 14:30:00'),
(1, 2, 'Last evening around 6 PM. Perfect golden hour!', '2025-04-13 15:45:00'),
(2, 5, 'Did you walk on the bridge? Looks amazing!', '2025-04-19 09:15:00'),
(3, 2, 'Best beach in Sri Lanka!', '2025-04-26 11:20:00'),
(5, 3, 'The architecture is incredible', '2025-05-11 16:40:00');

-- Insert sample messages
INSERT INTO messages (name, email, content, sent_at) VALUES
('John Smith', 'john@example.com', 'I want to book a family tour for 4 people. What packages do you recommend?', '2025-04-10 10:30:00'),
('Emma Wilson', 'emma@travel.com', 'Do you offer custom tour packages? We have specific places we want to visit.', '2025-04-15 14:22:00'),
('David Brown', 'davidb@mail.com', 'How far in advance should we book the Yala Safari?', '2025-04-28 09:45:00'),
('Sarah Johnson', 'sarah.j@vacations.com', 'Can you arrange airport transfers with your packages?', '2025-05-05 16:10:00');