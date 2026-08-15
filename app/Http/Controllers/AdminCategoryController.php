<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->latest()->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::where('parent_id', null)->where('status', 1)->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $slug = Str::slug($request->name);
        $count = Category::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $thumbnail = 'uploads/categories/' . $filename;
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'thumbnail' => $thumbnail,
            'status' => 1,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Tạo danh mục thành công.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::where('parent_id', null)
            ->where('id', '!=', $id)
            ->where('status', 1)
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $category = Category::findOrFail($id);

        $data = $request->only(['name', 'parent_id']);

        if ($request->filled('name') && $request->name !== $category->name) {
            $slug = Str::slug($request->name);
            $count = Category::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail && File::exists(public_path($category->thumbnail))) {
                File::delete(public_path($category->thumbnail));
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/categories'), $filename);
            $data['thumbnail'] = 'uploads/categories/' . $filename;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có sản phẩm.');
        }

        if ($category->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con.');
        }

        if ($category->thumbnail && File::exists(public_path($category->thumbnail))) {
            File::delete(public_path($category->thumbnail));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Xóa danh mục thành công.');
    }
}
