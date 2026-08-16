<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('slug', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        DB::transaction(function () use ($request) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            $thumbnail = null;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $filename);
                $thumbnail = 'uploads/products/' . $filename;
            }

            $productId = DB::table('products')->insertGetId([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'slug' => $slug,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'thumbnail' => $thumbnail,
                'description' => $request->description,
                'content' => $request->content,
                'unit' => $request->unit,
                'stock' => $request->stock,
                'views' => 0,
                'is_featured' => $request->is_featured ?? 0,
                'status' => $request->status ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($request->hasFile('images')) {
                $sortOrder = 0;
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . $sortOrder . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $filename);

                    ProductImage::create([
                        'product_id' => $productId,
                        'image_url' => 'uploads/products/' . $filename,
                        'sort_order' => $sortOrder,
                    ]);
                    $sortOrder++;
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'category', 'brand'])->findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        DB::transaction(function () use ($request, $product) {
            $data = $request->only([
                'name', 'category_id', 'brand_id', 'price', 'sale_price',
                'description', 'content', 'unit', 'stock', 'is_featured', 'status',
            ]);

            if ($request->filled('name') && $request->name !== $product->name) {
                $slug = Str::slug($request->name);
                $count = Product::where('slug', $slug)->where('id', '!=', $product->id)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                $data['slug'] = $slug;
            }

            if ($request->hasFile('thumbnail')) {
                if ($product->thumbnail && File::exists(public_path($product->thumbnail))) {
                    File::delete(public_path($product->thumbnail));
                }
                $file = $request->file('thumbnail');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/products'), $filename);
                $data['thumbnail'] = 'uploads/products/' . $filename;
            }

            $product->update($data);

            if ($request->hasFile('images')) {
                foreach ($product->images as $img) {
                    if (File::exists(public_path($img->image_url))) {
                        File::delete(public_path($img->image_url));
                    }
                    $img->delete();
                }

                $sortOrder = 0;
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . $sortOrder . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads/products'), $filename);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => 'uploads/products/' . $filename,
                        'sort_order' => $sortOrder,
                    ]);
                    $sortOrder++;
                }
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        Product::where('id', $id)->update(['status' => 0]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product hidden.');
    }
}
