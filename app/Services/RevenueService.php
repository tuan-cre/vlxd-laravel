<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RevenueService
{
    public function getRevenueStats(string $startDate, string $endDate): array
    {
        $stats = Order::where('status', '!=', 4)
            ->where('order_date', '>=', $startDate)
            ->where('order_date', '<=', $endDate . ' 23:59:59')
            ->selectRaw('
                COALESCE(SUM(total_money), 0) as total_revenue,
                COUNT(*) as order_count,
                COALESCE(AVG(total_money), 0) as avg_order_value
            ')
            ->first();

        return [
            'total_revenue' => (float) $stats->total_revenue,
            'order_count' => (int) $stats->order_count,
            'avg_order_value' => (float) $stats->avg_order_value,
        ];
    }

    public function getDailyRevenue(string $startDate, string $endDate): Collection
    {
        return Order::where('status', '!=', 4)
            ->where('order_date', '>=', $startDate)
            ->where('order_date', '<=', $endDate . ' 23:59:59')
            ->selectRaw('
                DATE(order_date) as date,
                COALESCE(SUM(total_money), 0) as revenue,
                COUNT(*) as order_count
            ')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getOrderStatusDistribution(string $startDate, string $endDate): Collection
    {
        return Order::where('order_date', '>=', $startDate)
            ->where('order_date', '<=', $endDate . ' 23:59:59')
            ->selectRaw('
                status,
                COUNT(*) as count
            ')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                $statusLabels = [
                    1 => 'Chờ xử lý',
                    2 => 'Đang xử lý',
                    3 => 'Hoàn thành',
                    4 => 'Đã hủy',
                ];
                $item->label = $statusLabels[$item->status] ?? 'Không xác định';
                return $item;
            });
    }

    public function getTopProducts(int $limit = 10, string $startDate = null, string $endDate = null): Collection
    {
        $query = OrderDetail::selectRaw('
                product_id,
                SUM(num) as total_quantity,
                SUM(total_money) as total_revenue
            ')
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->where('status', '!=', 4);
                if ($startDate) {
                    $q->where('order_date', '>=', $startDate);
                }
                if ($endDate) {
                    $q->where('order_date', '<=', $endDate . ' 23:59:59');
                }
            })
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit($limit);

        return $query->with('product')->get();
    }

    public function exportCsv(array $data): string
    {
        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');

            header('Content-Type: text/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename="export_' . date('Y-m-d_His') . '.csv"');

            fwrite($handle, "\xEF\xBB\xBF");

            if (!empty($data['headers'])) {
                fputcsv($handle, $data['headers'], ',', '"');
            }

            if (!empty($data['rows'])) {
                foreach ($data['rows'] as $row) {
                    fputcsv($handle, $row, ',', '"');
                }
            }

            fclose($handle);
        };

        return $callback();
    }
}
