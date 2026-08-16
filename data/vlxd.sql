-- 1. CREATE DATABASE AND SELECT DATABASE
DROP DATABASE IF EXISTS vlxd;
CREATE DATABASE vlxd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vlxd;

-- =======================================================
-- GROUP 1: BASIC INDEPENDENT TABLES (CATEGORIES, ROLES, ETC.)
-- =======================================================

-- Roles Table (Admin, Staff, Customer)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
) ENGINE=InnoDB;

-- Categories Table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    parent_id INT DEFAULT 0,
    thumbnail VARCHAR(255),
    status TINYINT DEFAULT 1
) ENGINE=InnoDB;

-- Brands Table
CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100),
    logo VARCHAR(255)
) ENGINE=InnoDB;

-- Suppliers Table
CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255),
    tax_code VARCHAR(50)
) ENGINE=InnoDB;

-- Warehouses Table
CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) DEFAULT NULL,
    address VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (code)
) ENGINE=InnoDB;

-- Coupons Table (Must be created before orders/customer_coupons)
CREATE TABLE coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_type ENUM('percent', 'fixed') DEFAULT 'fixed',
    discount_value DECIMAL(15, 0) NOT NULL,
    min_order_value DECIMAL(15, 0) DEFAULT 0,
    start_date DATETIME,
    end_date DATETIME,
    usage_limit INT DEFAULT 100,
    status TINYINT DEFAULT 1,
    points_cost INT DEFAULT 0,
    min_member_level ENUM('bronze','silver','gold','platinum') DEFAULT 'bronze',
    requires_claim TINYINT DEFAULT 0
) ENGINE=InnoDB;

-- =======================================================
-- GROUP 2: USERS & PRODUCTS (LEVEL 1 DEPENDENCIES)
-- =======================================================

-- Users Table (Depends on roles)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) DEFAULT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT DEFAULT 2,
    avatar VARCHAR(255),
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Employees Table (Depends on users)
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT DEFAULT NULL,
    role_id INT DEFAULT 3,
    position VARCHAR(100),
    department VARCHAR(100),
    phone_number VARCHAR(20),
    email VARCHAR(100) DEFAULT NULL,
    hire_date DATE DEFAULT NULL,
    salary DECIMAL(15, 0) DEFAULT NULL,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Products Table (Depends on categories, brands)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    brand_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    price DECIMAL(15, 0) NOT NULL,
    sale_price DECIMAL(15, 0) DEFAULT 0,
    thumbnail VARCHAR(255),
    description TEXT,
    content LONGTEXT,
    unit VARCHAR(50) NOT NULL,
    stock INT DEFAULT 0,
    views INT DEFAULT 0,
    is_featured TINYINT DEFAULT 0,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =======================================================
-- GROUP 3: DEEP DEPENDENCIES (CUSTOMERS, INVENTORY, ORDERS)
-- =======================================================

-- Product Images Table (Depends on products)
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Customers Table (Depends on users)
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    role_id INT DEFAULT 2,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    address VARCHAR(255),
    birthday DATE,
    gender ENUM('male', 'female', 'other'),
    avatar VARCHAR(255),
    member_level ENUM('bronze', 'silver', 'gold', 'platinum') DEFAULT 'bronze',
    loyalty_points INT DEFAULT 0,
    total_spent DECIMAL(15, 0) DEFAULT 0,
    total_orders INT DEFAULT 0,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_order_date DATETIME
) ENGINE=InnoDB;

-- Customer Addresses Table (Depends on customers)
CREATE TABLE customer_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    receiver_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    province VARCHAR(100),
    district VARCHAR(100),
    ward VARCHAR(100),
    address_detail VARCHAR(255) NOT NULL,
    is_default TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Customer Coupons (Depends on customers, coupons)
CREATE TABLE IF NOT EXISTS customer_coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    coupon_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Inventory (Depends on products, warehouses)
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    stock INT DEFAULT 0,
    CONSTRAINT chk_inventory_stock_nonneg CHECK (stock >= 0),
    UNIQUE KEY (product_id, warehouse_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Import Bills (Depends on suppliers, users, warehouses)
CREATE TABLE import_bills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_id INT,
    user_id INT,
    import_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_money DECIMAL(15, 0),
    note TEXT,
    status ENUM('pending','completed','cancelled') DEFAULT 'pending',
    warehouse_id INT DEFAULT NULL,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Chi tiết nhập kho (Depends on import_bills, products)
CREATE TABLE import_bill_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    import_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    import_price DECIMAL(15, 0) NOT NULL,
    total_money DECIMAL(15, 0) DEFAULT 0,
    FOREIGN KEY (import_id) REFERENCES import_bills(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE NO ACTION
) ENGINE=InnoDB;

-- Orders (Depends on customers, coupons)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    address VARCHAR(255) NOT NULL,
    note TEXT,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status INT DEFAULT 1, 
    payment_method VARCHAR(50) DEFAULT 'COD',
    payment_status TINYINT DEFAULT 0,
    shipping_fee DECIMAL(15, 0) DEFAULT 0,
    discount_amount DECIMAL(15, 0) DEFAULT 0,
    total_money DECIMAL(15, 0) NOT NULL,
    stock_applied TINYINT DEFAULT 0,
    coupon_id INT,
    earned_points INT DEFAULT 0,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Order Details (Depends on orders, products)
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    price DECIMAL(15, 0) NOT NULL,
    num INT NOT NULL,
    total_money DECIMAL(15, 0) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Order Inventory Allocation (Depends on orders, products, warehouses)
CREATE TABLE order_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    warehouse_id INT NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Product Reviews (Depends on users, products)
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    rating TINYINT DEFAULT 5,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status TINYINT DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- News / Blog (Depends on users)
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255),
    summary TEXT,
    content LONGTEXT,
    category VARCHAR(100) DEFAULT '',
    status ENUM('draft','published') DEFAULT 'published',
    views INT DEFAULT 0,
    author_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE price_sheets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pdf_url VARCHAR(255) NOT NULL,
    title VARCHAR(255) DEFAULT NULL,
    effective_date DATE DEFAULT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =======================================================
-- INSERT DỮ LIỆU MẪU (SEED DATA)
-- =======================================================

-- 1. Roles
INSERT INTO roles (name, description) VALUES 
('Admin', 'System administrator'), 
('Customer', 'Customer'),
('Staff', 'Staff employee');

-- 2. Users
INSERT INTO users (fullname, email, password, role_id) VALUES 
('Administrator', 'admin@vlxd.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
('John Customer', 'khachhang@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- 3. Employees
INSERT INTO employees (user_id, role_id, position, department, phone_number, email, hire_date, salary, status) VALUES
(NULL, 3, 'Warehouse Manager', 'Warehouse', '0918765432', 'kho1@vlxd.com', '2020-01-15', 12000000, 1),
(NULL, 3, 'Sales Representative', 'Sales', '0912345679', 'sales1@vlxd.com', '2021-08-01', 8000000, 1),
(1, 3, 'Technician', 'Technical', '0912345680', 'tech1@vlxd.com', '2022-05-20', 9000000, 1);

-- 4. Customers
INSERT INTO customers (user_id, role_id, fullname, email, phone_number, address, member_level, loyalty_points, total_spent, total_orders) VALUES
(2, 2, 'John Customer', 'khachhang@gmail.com', '0912345678', '10 Lang Street, Dong Da, Hanoi', 'silver', 500, 15000000, 3),
(NULL, 2, 'Jane Smith', 'janesmith@gmail.com', '0923456789', '25 Hue Street, Hai Ba Trung, Hanoi', 'bronze', 150, 3500000, 1),
(NULL, 2, 'Mike Johnson', 'mikej@gmail.com', '0934567890', '88 Giai Phong, Thanh Xuan, Hanoi', 'gold', 1200, 28000000, 7),
(NULL, 2, 'Sarah Lee', 'sarahl@gmail.com', '0945678901', '42 Cau Giay, Cau Giay, Hanoi', 'bronze', 80, 2100000, 1);

-- 5. Customer Addresses
INSERT INTO customer_addresses (customer_id, receiver_name, phone_number, province, district, ward, address_detail, is_default) VALUES
(1, 'John Customer', '0912345678', 'Hanoi', 'Dong Da', 'Lang Thuong', '10 Lang Street', 1),
(1, 'John Customer (Project Site)', '0912345678', 'Hanoi', 'Nam Tu Liem', 'Cau Dien', 'Construction site, New Urban Area', 0),
(2, 'Jane Smith', '0923456789', 'Hanoi', 'Hai Ba Trung', 'Pho Hue', '25 Hue Street', 1),
(3, 'Mike Johnson', '0934567890', 'Hanoi', 'Thanh Xuan', 'Khuong Mai', '88 Giai Phong Street', 1),
(4, 'Sarah Lee', '0945678901', 'Hanoi', 'Cau Giay', 'Dich Vong', '42 Cau Giay Street', 1);

-- 6. Categories
INSERT INTO categories (name, slug, thumbnail) VALUES 
('Bricks & Blocks', 'bricks-blocks', 'brickandblocks.jpg'),
('Cement, Sand & Gravel', 'cement-sand-gravel', 'cement.jpg'),
('Steel & Iron', 'steel-iron', 'steelandiron.jpg');

-- 7. Brands
INSERT INTO brands (name, slug) VALUES 
('Hoa Phat', 'hoa-phat'),
('Ha Tien', 'ha-tien'),
('Viglacera', 'viglacera');

-- 8. Suppliers
INSERT INTO suppliers (name, phone, address) VALUES
('Southern Construction Materials Co.', '0909123456', 'District 7, Ho Chi Minh City');

-- 9. Coupons
INSERT INTO coupons (code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit, status, points_cost, min_member_level, requires_claim)
VALUES
('WELCOME10', 'percent', 10, 0, NULL, NULL, 1000, 1, 0, 'bronze', 0),
('SAVE20K', 'fixed', 20000, 50000, NULL, NULL, 500, 1, 100, 'bronze', 1),
('POINTS50', 'fixed', 50000, 0, NULL, NULL, 100, 1, 1000, 'silver', 1),
('LOYALTY500', 'fixed', 500000, 0, NULL, NULL, 10, 1, 5000, 'gold', 1);
-- Bronze points coupon for redeeming by 100 points
INSERT INTO coupons (code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit, status, points_cost, min_member_level, requires_claim)
VALUES ('BRONZE25', 'fixed', 25000, 0, NULL, NULL, 200, 1, 100, 'bronze', 1);

-- 10. Link Customer Coupon (Must be after customer and coupon)
INSERT INTO customer_coupons (customer_id, coupon_id) VALUES (1, 3);

-- 11. Products
INSERT INTO products (category_id, brand_id, name, slug, price, unit, stock, thumbnail) VALUES 
(2, 2, 'Ha Tien Multi-Purpose Cement', 'ha-tien-multi-purpose-cement', 89000, 'Bag', 1000, 'cement.jpg'),
(1, 3, 'Viglacera 4-Hole Hollow Brick', 'viglacera-4-hole-hollow-brick', 1200, 'Piece', 50000, 'gach-ong-4-lo.jpg'),
(3, 1, 'Hoa Phat Steel Coil D6', 'hoa-phat-steel-coil-d6', 15000, 'Kg', 2000, 'steelandiron.jpg');

INSERT INTO products (category_id, brand_id, name, slug, price, sale_price, thumbnail, unit, stock, is_featured, description) VALUES 
(2, 2, 'Ha Tien Multi-Purpose Cement PCB40', 'ha-tien-pcb40-cement', 89000, 85000, 'ha-tien-pcb40.jpg', 'Bag', 5000, 1, 'High quality cement, suitable for all construction projects'),
(2, 2, 'Ha Tien Construction Cement PCB30', 'ha-tien-pcb30-cement', 82000, 0, 'ha-tien-pcb30.jpg', 'Bag', 3000, 0, 'Cement for residential construction projects'),
(2, 1, 'Yellow Construction Sand', 'yellow-construction-sand', 320000, 300000, 'cat-vang-xay-dung.jpg', 'Cubic Meter', 500, 1, 'Premium grade yellow sand, clean, high fineness'),
(2, 1, 'Construction Gravel 1x2', 'construction-gravel-1x2', 280000, 0, 'da-xay-1x2.jpg', 'Cubic Meter', 800, 0, 'Construction gravel size 1x2, clean'),
(2, 1, 'Fine Construction Gravel', 'fine-construction-gravel', 250000, 240000, 'da-mi-xay-dung.jpg', 'Cubic Meter', 600, 0, 'Grade 1 fine gravel'),
(1, 3, 'Viglacera 4-Hole Hollow Brick 6x9x18', 'viglacera-4-hole-hollow-brick-6x9x18', 1200, 1150, 'gach-ong-4-lo.jpg', 'Piece', 50000, 1, 'High quality Viglacera hollow brick'),
(1, 3, 'Viglacera 2-Hole Hollow Brick 6x9x18', 'viglacera-2-hole-hollow-brick-6x9x18', 900, 0, 'brickandblocks.jpg', 'Piece', 40000, 0, 'Standard 2-hole hollow brick'),
(1, 3, 'Viglacera Floor Tile 60x60', 'viglacera-floor-tile-60x60', 85000, 79000, 'gach-lat-nen.jpg', 'Piece', 10000, 1, 'Premium floor tile, natural stone pattern'),
(1, 3, 'Viglacera Floor Tile 80x80', 'viglacera-floor-tile-80x80', 145000, 135000, 'gach-lat-nen.jpg', 'Piece', 8000, 0, 'Luxury 80x80 floor tile'),
(1, 3, 'Wall Tile 30x60', 'wall-tile-30x60', 65000, 0, 'brickandblocks.jpg', 'Piece', 15000, 0, 'Wall tile for living room, bedroom'),
(3, 1, 'Hoa Phat Steel Coil D6', 'hoa-phat-steel-coil-d6', 15000, 14500, 'steelandiron.jpg', 'Kg', 20000, 1, 'Genuine Hoa Phat D6 steel coil'),
(3, 1, 'Hoa Phat Steel Coil D8', 'hoa-phat-steel-coil-d8', 15200, 0, 'hoa-phat-thep-cuon.jpg', 'Kg', 18000, 0, 'Hoa Phat D8 steel coil'),
(3, 1, 'Hoa Phat Steel Coil D10', 'hoa-phat-steel-coil-d10', 15500, 15000, 'hoa-phat-thep-cuon.jpg', 'Kg', 25000, 1, 'Hoa Phat D10 steel coil, best price'),
(3, 1, 'Hoa Phat V-Beam Steel 100x100', 'hoa-phat-v-beam-steel-100x100', 28000, 0, 'hoa-phat-thep-hinh.webp', 'Kg', 5000, 0, 'Hoa Phat V-shape steel beam 100x100'),
(3, 1, 'Hoa Phat U-Beam Steel 120x60', 'hoa-phat-u-beam-steel-120x60', 25000, 24000, 'hoa-phat-thep-hinh.webp', 'Kg', 6000, 0, 'Hoa Phat U-shape steel beam 120x60'),
(3, 1, 'Hoa Phat Steel Plate 2mm', 'hoa-phat-steel-plate-2mm', 32000, 0, 'steelandiron.jpg', 'Kg', 3000, 0, 'Hoa Phat 2mm thick steel plate');

-- 12. Setup Warehouses & Inventory
-- Ensure default warehouse for seeded data
INSERT INTO warehouses (name, code, address) VALUES ('Central Warehouse', 'KHO-DEFAULT', 'Default warehouse')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Additional sample warehouses
INSERT INTO warehouses (name, code, address) VALUES
('Northern Warehouse', 'KHO-NORTH', 'Hanoi - Northern Warehouse'),
('Southern Warehouse', 'KHO-SOUTH', 'Ho Chi Minh City - Southern Warehouse')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Populate inventory for default warehouse
INSERT INTO inventory (product_id, warehouse_id, stock)
SELECT p.id, w.id, p.stock
FROM products p
JOIN warehouses w ON w.code = 'KHO-DEFAULT'
LEFT JOIN inventory i ON i.product_id = p.id AND i.warehouse_id = w.id
WHERE i.id IS NULL;

-- Populate inventory for other warehouses (0 stock)
INSERT INTO inventory (product_id, warehouse_id, stock)
SELECT p.id, w.id, 0
FROM products p
JOIN warehouses w ON w.code = 'KHO-NORTH'
LEFT JOIN inventory i ON i.product_id = p.id AND i.warehouse_id = w.id
WHERE i.id IS NULL;

INSERT INTO inventory (product_id, warehouse_id, stock)
SELECT p.id, w.id, 0
FROM products p
JOIN warehouses w ON w.code = 'KHO-SOUTH'
LEFT JOIN inventory i ON i.product_id = p.id AND i.warehouse_id = w.id
WHERE i.id IS NULL;

INSERT INTO price_sheets (pdf_url, title, effective_date) VALUES
('pricesheet_sep2025.pdf', 'Price List September 2025', '2025-09-01'),
('pricesheet_oct2025.pdf', 'Price List October 2025', '2025-10-01');

INSERT INTO news (title, slug, thumbnail, summary, content, category, status, author_id) VALUES
('How to Choose the Right Cement for Your Project', 'how-to-choose-right-cement', 'news1.jpg', 'Learn how to select the appropriate cement for different construction projects.', 'Detailed guide on choosing cement...', 'Construction', 'published', 1),
('Floor Tile Trends in 2025', 'floor-tile-trends-2025', 'news2.jpg', 'Discover the latest floor tile trends for 2025.', 'Detailed content about floor tile trends...', 'Interior Design', 'published', 1);

-- =======================================================
-- TRIGGERS (DEFINED LAST TO AVOID ERRORS DURING SEEDING)
-- =======================================================

DELIMITER $$

CREATE TRIGGER trg_inventory_after_insert
AFTER INSERT ON inventory
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = (SELECT COALESCE(SUM(stock),0) FROM inventory WHERE product_id = NEW.product_id)
    WHERE id = NEW.product_id;
END$$

CREATE TRIGGER trg_inventory_after_update
AFTER UPDATE ON inventory
FOR EACH ROW
BEGIN
    IF NEW.product_id = OLD.product_id THEN
        UPDATE products
        SET stock = (SELECT COALESCE(SUM(stock),0) FROM inventory WHERE product_id = NEW.product_id)
        WHERE id = NEW.product_id;
    ELSE
        -- update for the new product
        UPDATE products
        SET stock = (SELECT COALESCE(SUM(stock),0) FROM inventory WHERE product_id = NEW.product_id)
        WHERE id = NEW.product_id;

        -- update for the old product (in case product_id changed)
        UPDATE products
        SET stock = (SELECT COALESCE(SUM(stock),0) FROM inventory WHERE product_id = OLD.product_id)
        WHERE id = OLD.product_id;
    END IF;
END$$

CREATE TRIGGER trg_inventory_after_delete
AFTER DELETE ON inventory
FOR EACH ROW
BEGIN
    UPDATE products
    SET stock = (SELECT COALESCE(SUM(stock),0) FROM inventory WHERE product_id = OLD.product_id)
    WHERE id = OLD.product_id;
END$$

DELIMITER ;