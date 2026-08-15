<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Product performance indexes
        DB::statement('CREATE INDEX idx_products_category ON products(category_id)');
        DB::statement('CREATE INDEX idx_products_brand ON products(brand_id)');
        DB::statement('CREATE INDEX idx_products_status ON products(status)');
        DB::statement('CREATE INDEX idx_products_featured ON products(is_featured)');
        DB::statement('CREATE INDEX idx_products_slug ON products(slug)');
        DB::statement('CREATE INDEX idx_products_price ON products(price)');

        // Order indexes
        DB::statement('CREATE INDEX idx_orders_customer ON orders(customer_id)');
        DB::statement('CREATE INDEX idx_orders_status ON orders(status)');
        DB::statement('CREATE INDEX idx_orders_date ON orders(order_date)');
        DB::statement('CREATE INDEX idx_orders_payment ON orders(payment_method, payment_status)');

        // Order details indexes
        DB::statement('CREATE INDEX idx_order_details_order ON order_details(order_id)');
        DB::statement('CREATE INDEX idx_order_details_product ON order_details(product_id)');

        // Inventory indexes
        DB::statement('CREATE INDEX idx_inventory_product ON inventory(product_id)');
        DB::statement('CREATE INDEX idx_inventory_warehouse ON inventory(warehouse_id)');

        // Customer indexes
        DB::statement('CREATE INDEX idx_customers_email ON customers(email)');
        DB::statement('CREATE INDEX idx_customers_level ON customers(member_level)');

        // Review indexes
        DB::statement('CREATE INDEX idx_reviews_product ON reviews(product_id)');
        DB::statement('CREATE INDEX idx_reviews_status ON reviews(status)');

        // News indexes
        DB::statement('CREATE INDEX idx_news_slug ON news(slug)');
        DB::statement('CREATE INDEX idx_news_status ON news(status)');
        DB::statement('CREATE INDEX idx_news_category ON news(category)');

        // Coupon indexes
        DB::statement('CREATE INDEX idx_coupons_code ON coupons(code)');
        DB::statement('CREATE INDEX idx_coupons_status ON coupons(status)');

        // Import bill indexes
        DB::statement('CREATE INDEX idx_import_bills_supplier ON import_bills(supplier_id)');
        DB::statement('CREATE INDEX idx_import_bills_status ON import_bills(status)');
        DB::statement('CREATE INDEX idx_import_bills_date ON import_bills(import_date)');
    }

    public function down(): void
    {
        $indexes = [
            'idx_products_category', 'idx_products_brand', 'idx_products_status',
            'idx_products_featured', 'idx_products_slug', 'idx_products_price',
            'idx_orders_customer', 'idx_orders_status', 'idx_orders_date', 'idx_orders_payment',
            'idx_order_details_order', 'idx_order_details_product',
            'idx_inventory_product', 'idx_inventory_warehouse',
            'idx_customers_email', 'idx_customers_level',
            'idx_reviews_product', 'idx_reviews_status',
            'idx_news_slug', 'idx_news_status', 'idx_news_category',
            'idx_coupons_code', 'idx_coupons_status',
            'idx_import_bills_supplier', 'idx_import_bills_status', 'idx_import_bills_date',
        ];

        foreach ($indexes as $index) {
            DB::statement("DROP INDEX IF EXISTS $index ON products");
        }
    }
};
