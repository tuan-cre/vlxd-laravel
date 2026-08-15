-- 1. TẠO DATABASE VÀ CHỌN DATABASE
DROP DATABASE IF EXISTS vlxd_db;
CREATE DATABASE vlxd_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vlxd_db;

-- =======================================================
-- NHÓM 1: BASIC INDEPENDENT TABLES (DANH MỤC, QUYỀN, ETC.)
-- =======================================================

-- Bảng Quyền hạn (Admin, Staff, Customer)
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description VARCHAR(255)
) ENGINE=InnoDB;

-- Bảng Danh mục
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    parent_id INT DEFAULT 0,
    thumbnail VARCHAR(255),
    status TINYINT DEFAULT 1
) ENGINE=InnoDB;

-- Bảng Thương hiệu
CREATE TABLE brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100),
    logo VARCHAR(255)
) ENGINE=InnoDB;

-- Nhà cung cấp
CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255),
    tax_code VARCHAR(50)
) ENGINE=InnoDB;

-- Kho hàng
CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(50) DEFAULT NULL,
    address VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (code)
) ENGINE=InnoDB;

-- Mã giảm giá (Must be created before orders/customer_coupons)
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
-- NHÓM 2: USERS & PRODUCTS (LEVEL 1 DEPENDENCIES)
-- =======================================================

-- Bảng Người dùng (Depends on roles)
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

-- Bảng nhân viên (Depends on users)
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

-- Bảng Sản phẩm (Depends on categories, brands)
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
-- NHÓM 3: DEEP DEPENDENCIES (CUSTOMERS, INVENTORY, ORDERS)
-- =======================================================

-- Bảng Thư viện ảnh (Depends on products)
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Bảng Khách hàng (Depends on users)
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

-- Bảng địa chỉ khách hàng (Depends on customers)
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

-- Khách hàng sở hữu Coupon (Depends on customers, coupons)
CREATE TABLE IF NOT EXISTS customer_coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    coupon_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (coupon_id) REFERENCES coupons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tồn kho (Depends on products, warehouses)
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

-- Phiếu nhập kho (Depends on suppliers, users, warehouses)
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

-- Đơn hàng (Depends on customers, coupons)
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

-- Chi tiết đơn hàng (Depends on orders, products)
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

-- Ghi chép phân bổ tồn kho (Depends on orders, products, warehouses)
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

-- Đánh giá sản phẩm (Depends on users, products)
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

-- Tin tức / Blog (Depends on users)
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

-- 1. Thêm Role
INSERT INTO roles (name, description) VALUES 
('Admin', 'Quản trị viên hệ thống'), 
('Customer', 'Khách hàng mua vật liệu'),
('Nhan Vien', 'Nhân viên / Staff');

-- 2. Thêm User
INSERT INTO users (fullname, email, password, role_id) VALUES 
('Quản Trị Viên', 'admin@vlxd.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
('Nguyễn Văn A', 'khachhang@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 2);

-- 3. Thêm Employees (Phải có user trước)
INSERT INTO employees (user_id, role_id, position, department, phone_number, email, hire_date, salary, status) VALUES
(NULL, 3, 'Quản lý kho', 'Kho', '0918765432', 'kho1@vlxd.com', '2020-01-15', 12000000, 1),
(NULL, 3, 'Nhân viên bán hàng', 'Sales', '0912345679', 'sales1@vlxd.com', '2021-08-01', 8000000, 1),
(1, 3, 'Kỹ thuật', 'Kỹ thuật', '0912345680', 'tech1@vlxd.com', '2022-05-20', 9000000, 1);

-- 4. Thêm Khách hàng mẫu (Phải có users trước nếu link)
INSERT INTO customers (user_id, role_id, fullname, email, phone_number, address, member_level, loyalty_points, total_spent, total_orders) VALUES
(2, 2, 'Nguyễn Văn A', 'khachhang@gmail.com', '0912345678', 'Số 10, Đường Láng, Đống Đa, Hà Nội', 'silver', 500, 15000000, 3),
(NULL, 2, 'Trần Thị B', 'tranthib@gmail.com', '0923456789', 'Số 25, Phố Huế, Hai Bà Trưng, Hà Nội', 'bronze', 150, 3500000, 1),
(NULL, 2, 'Lê Văn C', 'levanc@gmail.com', '0934567890', 'Số 88, Giải Phóng, Thanh Xuân, Hà Nội', 'gold', 1200, 28000000, 7),
(NULL, 2, 'Phạm Thị D', 'phamthid@gmail.com', '0945678901', 'Số 42, Cầu Giấy, Cầu Giấy, Hà Nội', 'bronze', 80, 2100000, 1);

-- 5. Thêm địa chỉ giao hàng
INSERT INTO customer_addresses (customer_id, receiver_name, phone_number, province, district, ward, address_detail, is_default) VALUES
(1, 'Nguyễn Văn A', '0912345678', 'Hà Nội', 'Đống Đa', 'Láng Thượng', 'Số 10, Đường Láng', 1),
(1, 'Nguyễn Văn A (Công trình)', '0912345678', 'Hà Nội', 'Nam Từ Liêm', 'Cầu Diễn', 'Công trình xây dựng, Khu đô thị mới', 0),
(2, 'Trần Thị B', '0923456789', 'Hà Nội', 'Hai Bà Trưng', 'Phố Huế', 'Số 25, Phố Huế', 1),
(3, 'Lê Văn C', '0934567890', 'Hà Nội', 'Thanh Xuân', 'Khương Mai', 'Số 88, Giải Phóng', 1),
(4, 'Phạm Thị D', '0945678901', 'Hà Nội', 'Cầu Giấy', 'Dịch Vọng', 'Số 42, Cầu Giấy', 1);

-- 6. Thêm Danh mục
INSERT INTO categories (name, slug) VALUES 
('Gạch Xây Dựng', 'gach-xay-dung'),
('Xi Măng & Cát Đá', 'xi-mang-cat-da'),
('Sắt Thép', 'sat-thep');

-- 7. Thêm Thương hiệu
INSERT INTO brands (name, slug) VALUES 
('Hòa Phát', 'hoa-phat'),
('Hà Tiên', 'ha-tien'),
('Viglacera', 'viglacera');

-- 8. Thêm Nhà cung cấp
INSERT INTO suppliers (name, phone, address) VALUES
('Công ty VLXD Miền Nam', '0909123456', 'Quận 7, TP.HCM');

-- 9. Thêm Coupons
INSERT INTO coupons (code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit, status, points_cost, min_member_level, requires_claim)
VALUES
('WELCOME10', 'percent', 10, 0, NULL, NULL, 1000, 1, 0, 'bronze', 0),
('SAVE20K', 'fixed', 20000, 50000, NULL, NULL, 500, 1, 100, 'bronze', 1),
('POINTS50', 'fixed', 50000, 0, NULL, NULL, 100, 1, 1000, 'silver', 1),
('LOYALTY500', 'fixed', 500000, 0, NULL, NULL, 10, 1, 5000, 'gold', 1);
-- Bronze points coupon for redeeming by 100 points
INSERT INTO coupons (code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit, status, points_cost, min_member_level, requires_claim)
VALUES ('BRONZE25', 'fixed', 25000, 0, NULL, NULL, 200, 1, 100, 'bronze', 1);

-- 10. Link Customer Coupon (Phải sau khi có customer và coupon)
INSERT INTO customer_coupons (customer_id, coupon_id) VALUES (1, 3);

-- 11. Thêm Sản phẩm
INSERT INTO products (category_id, brand_id, name, slug, price, unit, stock, thumbnail) VALUES 
(2, 2, 'Xi măng Hà Tiên Đa Dụng', 'xi-mang-ha-tien', 89000, 'Bao', 1000, 'ximang.jpg'),
(1, 3, 'Gạch ống 4 lỗ Viglacera', 'gach-ong-4-lo', 1200, 'Viên', 50000, 'gach.jpg'),
(3, 1, 'Thép cuộn phi 6 Hòa Phát', 'thep-cuon-hoa-phat', 15000, 'Kg', 2000, 'thep.jpg');

INSERT INTO products (category_id, brand_id, name, slug, price, sale_price, thumbnail, unit, stock, is_featured, description) VALUES 
(2, 2, 'Xi măng Hà Tiên Đa Dụng PCB40', 'xi-mang-ha-tien-pcb40', 89000, 85000, 'ximang.jpg', 'Bao', 5000, 1, 'Xi măng chất lượng cao, phù hợp mọi công trình'),
(2, 2, 'Xi măng Hà Tiên Xây Dựng PCB30', 'xi-mang-ha-tien-pcb30', 82000, 0, 'xi-mang-ha-tien.jpg', 'Bao', 3000, 0, 'Xi măng cho công trình xây dựng dân dụng'),
(2, 1, 'Cát Vàng Xây Dựng', 'cat-vang-xay-dung', 320000, 300000, 'cat-da.jpg', 'Khối', 500, 1, 'Cát vàng loại 1, sạch, độ mịn cao'),
(2, 1, 'Đá Xây 1x2', 'da-xay-1x2', 280000, 0, 'cat-da.jpg', 'Khối', 800, 0, 'Đá xây kích thước 1x2, sạch'),
(2, 1, 'Đá Mi Xây Dựng', 'da-mi-xay-dung', 250000, 240000, 'cat-da.jpg', 'Khối', 600, 0, 'Đá mi loại 1'),
(1, 3, 'Gạch Ống 4 Lỗ Viglacera 6x9x18', 'gach-ong-4-lo-viglacera', 1200, 1150, 'gach.jpg', 'Viên', 50000, 1, 'Gạch ống chất lượng cao Viglacera'),
(1, 3, 'Gạch Ống 2 Lỗ Viglacera 6x9x18', 'gach-ong-2-lo-viglacera', 900, 0, 'gach-ong-4-lo.jpg', 'Viên', 40000, 0, 'Gạch ống 2 lỗ tiêu chuẩn'),
(1, 3, 'Gạch Lát Nền 60x60 Viglacera', 'gach-lat-nen-60x60', 85000, 79000, 'gach-lat-nen.jpg', 'Viên', 10000, 1, 'Gạch lát nền cao cấp, vân đá tự nhiên'),
(1, 3, 'Gạch Lát Nền 80x80 Viglacera', 'gach-lat-nen-80x80', 145000, 135000, 'gach-lat-nen.jpg', 'Viên', 8000, 0, 'Gạch lát nền 80x80 sang trọng'),
(1, 3, 'Gạch Ốp Tường 30x60', 'gach-op-tuong-30x60', 65000, 0, 'gach-ong-4-lo.jpg', 'Viên', 15000, 0, 'Gạch ốp tường phòng khách, phòng ngủ'),
(3, 1, 'Thép Cuộn D6 Hòa Phát', 'thep-cuon-d6-hoa-phat', 15000, 14500, 'thep.jpg', 'Kg', 20000, 1, 'Thép cuộn phi 6 chính hãng Hòa Phát'),
(3, 1, 'Thép Cuộn D8 Hòa Phát', 'thep-cuon-d8-hoa-phat', 15200, 0, 'thep-cuon-hoa-phat.jpg', 'Kg', 18000, 0, 'Thép cuộn phi 8 Hòa Phát'),
(3, 1, 'Thép Cuộn D10 Hòa Phát', 'thep-cuon-d10-hoa-phat', 15500, 15000, 'thep-cuon-hoa-phat.jpg', 'Kg', 25000, 1, 'Thép cuộn phi 10 giá tốt'),
(3, 1, 'Thép Hình V 100x100 Hòa Phát', 'thep-hinh-v-100x100', 28000, 0, 'thep-hinh.jpg', 'Kg', 5000, 0, 'Thép hình chữ V 100x100'),
(3, 1, 'Thép Hình U 120x60 Hòa Phát', 'thep-hinh-u-120x60', 25000, 24000, 'thep-hinh.jpg', 'Kg', 6000, 0, 'Thép hình chữ U 120x60'),
(3, 1, 'Thép Tấm 2mm Hòa Phát', 'thep-tam-2mm', 32000, 0, 'thep.jpg', 'Kg', 3000, 0, 'Thép tấm dày 2mm');

-- 12. Setup Warehouses & Inventory
-- Ensure default warehouse for seeded data
INSERT INTO warehouses (name, code, address) VALUES ('Kho trung tâm', 'KHO-DEFAULT', 'Kho mặc định')
ON DUPLICATE KEY UPDATE name = VALUES(name);

-- Additional sample warehouses
INSERT INTO warehouses (name, code, address) VALUES
('Kho miền Bắc', 'KHO-NORTH', 'Hà Nội - Kho miền Bắc'),
('Kho miền Nam', 'KHO-SOUTH', 'TP.HCM - Kho miền Nam')
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
('pricesheet_sep2025.pdf', 'Bảng giá tháng 09/2025', '2025-09-01'),
('pricesheet_oct2025.pdf', 'Bảng giá tháng 10/2025', '2025-10-01');

INSERT INTO news (title, slug, thumbnail, summary, content, category, status, author_id) VALUES
('Mẹo chọn xi măng phù hợp cho công trình của bạn', 'meo-chon-xi-mang-phu-hop', 'news1.jpg', 'Tìm hiểu cách chọn xi măng phù hợp với từng loại công trình xây dựng.', 'Nội dung chi tiết về mẹo chọn xi măng...', 'Xây dựng', 'published', 1),
('Xu hướng sử dụng gạch lát nền trong năm 2025', 'xu-huong-su-dung-gach-lat-nen-2025', 'news2.jpg', 'Khám phá các xu hướng gạch lát nền đang thịnh hành trong năm 2025.', 'Nội dung chi tiết về xu hướng gạch lát nền...', 'Nội thất', 'published', 1);

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