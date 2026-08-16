<?php

namespace App\Http\Controllers;

use App\Models\ImportBill;
use App\Models\ImportBillDetail;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminImportBillController extends Controller
{
    public function index(Request $request)
    {
        $query = ImportBill::with(['supplier', 'user', 'warehouse']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('id', $keyword)
                  ->orWhereHas('supplier', function ($sq) use ($keyword) {
                      $sq->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        $importBills = $query->latest('import_date')->paginate(15);

        return view('admin.imports.index', compact('importBills'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $warehouses = Warehouse::all();
        $products = Product::where('status', 1)->get();

        return view('admin.imports.create', compact('suppliers', 'warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'import_date' => 'required|date',
            'note' => 'nullable|string',
            'details' => 'required|array|min:1',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
            'details.*.import_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $nguoidung = session('nguoidung');
            $userId = $nguoidung ? $nguoidung['id'] : null;

            $totalMoney = 0;
            foreach ($request->details as $detail) {
                $totalMoney += $detail['quantity'] * $detail['import_price'];
            }

            $importId = DB::table('import_bills')->insertGetId([
                'supplier_id' => $request->supplier_id,
                'user_id' => $userId,
                'import_date' => $request->import_date,
                'total_money' => $totalMoney,
                'note' => $request->note,
                'status' => 'pending',
                'warehouse_id' => $request->warehouse_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($request->details as $detail) {
                $totalDetailMoney = $detail['quantity'] * $detail['import_price'];

                ImportBillDetail::create([
                    'import_id' => $importId,
                    'product_id' => $detail['product_id'],
                    'quantity' => $detail['quantity'],
                    'import_price' => $detail['import_price'],
                    'total_money' => $totalDetailMoney,
                ]);
            }
        });

        return redirect()->route('admin.imports.index')
            ->with('success', 'Import bill created successfully.');
    }

    public function show($id)
    {
        $importBill = ImportBill::with([
            'supplier',
            'user',
            'warehouse',
            'details.product',
        ])->findOrFail($id);

        return view('admin.imports.show', compact('importBill'));
    }

    public function approve($id)
    {
        $importBill = ImportBill::with('details')->findOrFail($id);

        if ($importBill->status == 'completed') {
            return back()->with('error', 'Import bill already approved.');
        }

        DB::transaction(function () use ($importBill) {
            foreach ($importBill->details as $detail) {
                Product::where('id', $detail->product_id)->increment('stock', $detail->quantity);

                $inventory = Inventory::where('product_id', $detail->product_id)
                    ->where('warehouse_id', $importBill->warehouse_id)
                    ->first();

                if ($inventory) {
                    $inventory->increment('stock', $detail->quantity);
                } else {
                    Inventory::create([
                        'product_id' => $detail->product_id,
                        'warehouse_id' => $importBill->warehouse_id,
                        'stock' => $detail->quantity,
                    ]);
                }
            }

            ImportBill::where('id', $importBill->id)->update(['status' => 'completed']);
        });

        return redirect()->route('admin.imports.show', $importBill->id)
            ->with('success', 'Import bill approved successfully.');
    }
}
