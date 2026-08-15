<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminWarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::withCount('inventories')->latest()->paginate(15);

        return view('admin.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('admin.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'address' => 'nullable|string',
        ]);

        Warehouse::create([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Tạo kho hàng thành công.');
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        return view('admin.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code,' . $id,
            'address' => 'nullable|string',
        ]);

        $warehouse = Warehouse::findOrFail($id);

        $warehouse->update([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Cập nhật kho hàng thành công.');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if ($warehouse->inventories()->where('stock', '>', 0)->count() > 0) {
            return back()->with('error', 'Không thể xóa kho hàng còn tồn kho.');
        }

        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')
            ->with('success', 'Xóa kho hàng thành công.');
    }
}
