-- Insert Admin
INSERT INTO Users (first_name, last_name, email, password_hash, user_type, is_verified)
VALUES ('Leo', 'Admin', 'admin@gmail.com', 'a', 'admin', 1);

-- Insert Customer
INSERT INTO Users (first_name, last_name, email, password_hash, user_type, is_verified)
VALUES ('Yen', 'Customer', 'yen@gmail.com', 'hashed_customer_pw', 'customer', 1);

-- Insert Service Provider
INSERT INTO Users (first_name, last_name, email, password_hash, user_type, is_verified, gender, account_status)
VALUES ('Kang', 'Je Sun', 'kang@gmail.com', '213', 'provider', 1, 'Other', 'Active');

INSERT INTO Categories (name, color) VALUES 
('Maintenance & Repair', '#4CAF50'),        -- Green
('Home Improvement', '#2196F3'),            -- Blue
('Security & Smart Home', '#FF9800'),       -- Orange
('Cleaning Services', '#9C27B0'),            -- Purple
('Outdoor & Landscaping', '#00BCD4'),       -- Cyan
('Other Services', '#FF5722');               -- Deep Orange


-- Assume (user_id = 2) is the provider
INSERT INTO Services (provider_id, title, description, service_fee, average_rating, is_active)
VALUES 
(2, 'Aircon Cleaning', 'Full cleaning of air conditioning units.', 1499.00, NULL, 1),
(2, 'Electrical Repair', 'Fix wiring and electrical fixtures.', 1799.00, NULL, 1),
(2, 'Pipe Leak Fix', 'Repair minor pipe leaks and drips.', 899.00, NULL, 1);

-- Aircon Cleaning (service_id = 1)
INSERT INTO ServiceCategoryLink (service_id, category_id) VALUES
(1, 1),  -- Maintenance & Repair
(1, 4);  -- Cleaning Services

-- Electrical Repair (service_id = 2)
INSERT INTO ServiceCategoryLink (service_id, category_id) VALUES
(2, 1),  -- Maintenance & Repair
(2, 2);  -- Home Improvement

-- Pipe Leak Fix (service_id = 3)
INSERT INTO ServiceCategoryLink (service_id, category_id) VALUES
(3, 1),  -- Maintenance & Repair
(3, 2);  -- Home Improvement


INSERT INTO Wallets (provider_id, balance)
VALUES (2, 0.00);

-- Simulate a Booking first
INSERT INTO Bookings (service_id, customer_id, scheduled_for, status)
VALUES (1, 2, GETDATE(), 'completed');

-- Add Review for it
INSERT INTO Reviews (booking_id, rating, comment)
VALUES (1, 5, 'Great aircon cleaning service!');

-- Service 1: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (1, 'assets/images/services/cleaning1.jpg', 1),
       (1, 'assets/images/services/cleaning2.jpg', 0);

-- Service 2: One image
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (2, 'assets/images/services/plumbing1.jpg', 1);

-- Service 3: Three images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (3, 'assets/images/services/electrical1.jpg', 0),
       (3, 'assets/images/services/electrical2.jpg', 0),
       (3, 'assets/images/services/electrical3.jpg', 1);

-- Service 4: One image
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (4, 'assets/images/services/electrical1.jpg', 1);

-- Service 5: One image
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (5, 'assets/images/services/pestcontrol1.jpg', 1);

-- Service 6: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (6, 'assets/images/services/housepainting1.jpg', 1),
       (6, 'assets/images/services/housepainting2.jpg', 0);

 -- Service 7: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (7, 'assets/images/services/carpentry1.jpeg', 1),
       (7, 'assets/images/services/carpentry2.jpeg', 0);      

-- Service 8: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (8, 'assets/images/services/appliance-repair1.jpg', 1),
       (8, 'assets/images/services/appliance-repair2.jpg', 0);

-- Service 9: One images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (9, 'assets/images/services/moving-help.jpg', 1);

-- Service 10: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (10, 'assets/images/services/laundry1.jpg', 1),
       (10, 'assets/images/services/laundry2.jpg', 0);         

-- just in case na need for examples sa demo

/* Service 11: One images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (9, 'assets/images/services/outletinstallation.jpg', 1);

    Service 12: Two images
INSERT INTO ServiceImages (service_id, image_path, is_primary)
VALUES (10, 'assets/images/services/guttercleaning.jpg', 1),
       (10, 'assets/images/services/guttercleaning2.jpg', 0);  

*/




