<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ProductService
{
    public function getFiltered(array $filters): LengthAwarePaginator
    {
        $query = Product::with(['category', 'brand'])
            ->where('status', 1);

        if (!empty($filters['category_id'])) {
            $categoryId = is_array($filters['category_id'])
                ? $filters['category_id']
                : [$filters['category_id']];
            $query->whereIn('category_id', $categoryId);
        }

        if (!empty($filters['brand_id'])) {
            $brandId = is_array($filters['brand_id'])
                ? $filters['brand_id']
                : [$filters['brand_id']];
            $query->whereIn('brand_id', $brandId);
        }

        if (!empty($filters['price_min'])) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('sale_price', '>=', $filters['price_min'])
                    ->orWhere(function (Builder $q2) use ($filters) {
                        $q2->where('sale_price', 0)
                            ->where('price', '>=', $filters['price_min']);
                    });
            });
        }

        if (!empty($filters['price_max'])) {
            $query->where(function (Builder $q) use ($filters) {
                $q->where('sale_price', '<=', $filters['price_max'])
                    ->orWhere(function (Builder $q2) use ($filters) {
                        $q2->where('sale_price', 0)
                            ->where('price', '<=', $filters['price_max']);
                    });
            });
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $sortField = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        $allowedSorts = ['name', 'price', 'created_at', 'views', 'stock'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');

        $perPage = $filters['per_page'] ?? 12;

        return $query->paginate($perPage);
    }

    public function getBySlug(string $slug): Product
    {
        $product = Product::with(['category', 'brand', 'images', 'reviews' => function ($query) {
            $query->where('status', 1)->latest();
        }])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $product->increment('views');

        return $product;
    }

    public function getFeatured(int $limit = 8)
    {
        return Product::with(['category', 'brand'])
            ->where('is_featured', 1)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getBestSelling(int $limit = 8)
    {
        return Product::with(['category', 'brand'])
            ->where('status', 1)
            ->withCount(['orderDetails as sold_count' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('status', '!=', 4);
                });
            }])
            ->orderBy('sold_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getMostViewed(int $limit = 8)
    {
        return Product::with(['category', 'brand'])
            ->where('status', 1)
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }
}
