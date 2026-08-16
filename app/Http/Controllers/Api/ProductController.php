<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['category', 'brand'])
            ->where('status', 1);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->boolean('is_featured')) {
            $query->where('is_featured', 1);
        }

        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'best_selling':
                $query->join('order_details', 'products.id', '=', 'order_details.product_id')
                    ->selectRaw('products.*, SUM(order_details.num) as total_sold')
                    ->groupBy('products.id')
                    ->orderBy('total_sold', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $perPage = min($request->per_page ?? 12, 50);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
            'links' => [
                'first' => $products->url(1),
                'last' => $products->url($products->lastPage()),
                'prev' => $products->previousPageUrl(),
                'next' => $products->nextPageUrl(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::with(['category', 'brand', 'images'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        Product::where('id', $product->id)->increment('views');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->with(['category', 'brand'])
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'sale_price' => (float) $product->sale_price,
                'thumbnail' => $product->thumbnail ? asset('images/products/' . $product->thumbnail) : null,
                'description' => $product->description,
                'content' => $product->content,
                'unit' => $product->unit,
                'stock' => $product->stock,
                'views' => $product->views,
                'is_featured' => (bool) $product->is_featured,
                'created_at' => $product->created_at?->toISOString(),
                'category' => $product->category ? [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'slug' => $product->category->slug,
                ] : null,
                'brand' => $product->brand ? [
                    'id' => $product->brand->id,
                    'name' => $product->brand->name,
                ] : null,
                'images' => $product->images->map(fn ($img) => [
                    'id' => $img->id,
                    'image_path' => $img->image_path,
                ]),
                'discount_percent' => $product->sale_price > 0
                    ? round((1 - $product->sale_price / $product->price) * 100)
                    : 0,
            ],
            'related' => $relatedProducts->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => (float) $p->price,
                'sale_price' => (float) $p->sale_price,
                'thumbnail' => $p->thumbnail ? asset('images/products/' . $p->thumbnail) : null,
                'category' => $p->category?->name,
            ]),
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = Category::where('status', 1)
            ->withCount(['products as product_count' => fn ($q) => $q->where('status', 1)])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    public function brands(): JsonResponse
    {
        $brands = Brand::withCount(['products as product_count' => fn ($q) => $q->where('status', 1)])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $brands,
        ]);
    }
}
