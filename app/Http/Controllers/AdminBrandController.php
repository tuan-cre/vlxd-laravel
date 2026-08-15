<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminBrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->latest()->paginate(15);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $slug = Str::slug($request->name);
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $logo = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brands'), $filename);
            $logo = 'uploads/brands/' . $filename;
        }

        Brand::create([
            'name' => $request->name,
            'slug' => $slug,
            'logo' => $logo,
        ]);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Tạo thương hiệu thành công.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $brand = Brand::findOrFail($id);

        $data = $request->only(['name']);

        if ($request->filled('name') && $request->name !== $brand->name) {
            $slug = Str::slug($request->name);
            $count = Brand::where('slug', $slug)->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('logo')) {
            if ($brand->logo && File::exists(public_path($brand->logo))) {
                File::delete(public_path($brand->logo));
            }
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/brands'), $filename);
            $data['logo'] = 'uploads/brands/' . $filename;
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')
            ->with('success', 'Cập nhật thương hiệu thành công.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->products()->count() > 0) {
            return back()->with('error', 'Không thể xóa thương hiệu có sản phẩm.');
        }

        if ($brand->logo && File::exists(public_path($brand->logo))) {
            File::delete(public_path($brand->logo));
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Xóa thương hiệu thành công.');
    }
}
