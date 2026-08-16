<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared('
            CREATE PROCEDURE sp_order_total(IN p_order_id INT)
            BEGIN
                SELECT
                    o.id AS order_id,
                    o.fullname,
                    o.phone_number,
                    o.total_money,
                    o.payment_method,
                    o.status,
                    COUNT(od.id) AS item_count
                FROM orders o
                LEFT JOIN order_details od ON od.order_id = o.id
                WHERE o.id = p_order_id
                GROUP BY o.id;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_stock_summary(IN p_product_id INT)
            BEGIN
                SELECT
                    w.id AS warehouse_id,
                    w.name AS warehouse_name,
                    w.code AS warehouse_code,
                    i.stock
                FROM inventory i
                JOIN warehouses w ON i.warehouse_id = w.id
                WHERE i.product_id = p_product_id
                ORDER BY i.stock DESC;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_revenue_report(
                IN p_start_date DATE,
                IN p_end_date DATE
            )
            BEGIN
                SELECT
                    DATE(o.order_date) AS order_day,
                    COUNT(o.id) AS total_orders,
                    SUM(o.total_money) AS total_revenue,
                    AVG(o.total_money) AS avg_order_value
                FROM orders o
                WHERE o.order_date BETWEEN p_start_date AND p_end_date
                  AND o.status != 5
                GROUP BY DATE(o.order_date)
                ORDER BY order_day;
            END
        ');

        DB::unprepared('
            CREATE PROCEDURE sp_top_products(IN p_limit INT)
            BEGIN
                SELECT
                    p.id,
                    p.name,
                    p.slug,
                    p.price,
                    p.sale_price,
                    p.thumbnail,
                    SUM(od.num) AS total_sold,
                    SUM(od.total_money) AS total_revenue
                FROM order_details od
                JOIN products p ON od.product_id = p.id
                JOIN orders o ON od.order_id = o.id
                WHERE o.status != 5
                GROUP BY p.id
                ORDER BY total_sold DESC
                LIMIT p_limit;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_order_total");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_stock_summary");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_revenue_report");
        DB::unprepared("DROP PROCEDURE IF EXISTS sp_top_products");
    }
};
