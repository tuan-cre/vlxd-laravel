<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function home()
    {
        $featured = Product::with(['category', 'brand', 'images'])
            ->where('status', 1)
            ->where('is_featured', 1)
            ->limit(8)
            ->get();

        $bestSelling = Product::with(['category', 'brand', 'images'])
            ->where('status', 1)
            ->withCount(['orderDetails as total_sold' => function ($q) {
                $q->select(DB::raw('COALESCE(SUM(num),0)'));
            }])
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        $mostViewed = Product::with(['category', 'brand', 'images'])
            ->where('status', 1)
            ->orderByDesc('views')
            ->limit(8)
            ->get();

        $categories = \App\Models\Category::where('status', 1)->get();

        return view('home', compact('featured', 'bestSelling', 'mostViewed', 'categories'));
    }

    public function index(FilterProductRequest $request)
    {
        $query = $this->buildFilterQuery($request);
        $perPage = $request->per_page ?? 12;
        $products = $query->paginate($perPage);

        $categories = \App\Models\Category::where('status', 1)->get();
        $brands = \App\Models\Brand::all();

        return view('product.group', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 1)
            ->with(['category', 'brand', 'images', 'reviews' => function ($q) {
                $q->where('status', 1)->with('user')->latest();
            }])
            ->firstOrFail();

        Product::where('id', $product->id)->increment('views');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->with(['category', 'brand', 'images'])
            ->limit(4)
            ->get();

        return view('product.detail', compact('product', 'relatedProducts'));
    }

    public function filter(Request $request)
    {
        $query = $this->buildFilterQuery($request);
        $perPage = $request->per_page ?? 12;
        $page = $request->page ?? 1;
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        $categories = \App\Models\Category::where('status', 1)->get();
        $brands = \App\Models\Brand::all();

        $html = view('product._product-grid', compact('products', 'categories', 'brands'))->render();

        return response()->json(['html' => $html]);
    }

    private function buildFilterQuery(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
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

        return $query;
    }
}
