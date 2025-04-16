<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all();
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'staff') {
            return view('component.produk.index', compact('products'));
        } else {
            return redirect()->route('error-permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('component.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $dataProduct = [
            'name_product' => $request->name_product,
            'stock' => $request->stock,
            'price' => $request->hargaValue,
        ];
        
        if ($request->file('image')->isValid()) {
            $file = $request->file('image');
            $path = $file->store('photoProduk', 'public');
            $dataProduct['image'] = $path;
        }
        
        Product::create($dataProduct);
        
        return redirect()->route('product.index')->with('success', 'Berhasil menambahkan data produk!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::find($id);
        return view('component.produk.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'name_product' => 'required',
            'hargaValue' => 'required',
        ]);


        $updateData = [
            'name_product' => $validatedData['name_product'],
            'price' => $validatedData['hargaValue'],
        ];

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(storage_path('app/public/' . $product->image))) {
                unlink(storage_path('app/public/' . $product
                ->image));
            }

            $file = $request->file('image');
            $path = $file->store('photoProduk', 'public');
            
            $updateData['image'] = $path;
        }

        $product = Product::findOrFail($id);
        // dd($updateData);
        $product->update($updateData);

        return redirect()->route('product.index')->with('success', 'Data Produk berhasil diperbarui!');
    }

    public function updateStok(Request $request, $id)
    {
        $validatedData = $request->validate([
            'stock' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $updateStok = [
            'stock' => $validatedData['stock'],
        ];
        // dd($updateStok);
        $product->update($updateStok);

        return redirect()->route('product.index')->with('success', 'Stok berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }
        $penjualanUsingProduk = $product->detail_sales()->exists();
        
        if ($penjualanUsingProduct) {
            return redirect()->back()->with('failed', 'Produk sudah digunakan dalam penjualan');
        } else {
        $product->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus produk');
        }
    }
}
