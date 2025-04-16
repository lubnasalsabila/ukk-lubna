<?php

namespace App\Http\Controllers;


use App\Models\Costumer;
use App\Models\Detail_sale;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        $detail_sales = Detail_sale::all();
        $sales = Sale::all();
        if ($user->role === 'admin' || $user->role === 'staff') {
            return view('component.transaksi.index', compact('sales', 'detail_sales'));
        } else {
            return redirect()->route('error-permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $cart = json_decode(urldecode($request->query('cart')), true);

        return view('component.transaksi.create', compact('cart'));
    }

    /**
     * Store a newly created resource in storage.
     */

    //  yang kirim kondisi data ke 4 tabel sekaligus (member, penjualan, transaksi, produk)
    public function store4crud(Request $request)
    {
        //
        $products = $request->shop;
        $total_pay = (int)str_replace(['Rp. ', '.'], '', $request->totalBayarValue);
        $grandTotal = (int)$request->grandTotal;
        $customer_id = null;

        if ($request->customer == 'member') {
            $no_telp = $request->no_telp;
            $existCustomer = Customer::where('no_telp', $no_telp)->first();

            $isFirstPurchase = false;

            if ($existCustomer) {

                $jumlahTransaksi = Sale::where('customer_id', $existCustomer->id)->count();
                $isFirstPurchase = $jumlahTransaksi == 0;

                $existCustomer->update([
                    'poin' => $existCustomer->poin + ($grandTotal / 100),
                ]);
                $customer_id = $existCustomer->id;
            } else {
                $newCustomer = Customer::create([
                    'no_telp' => $no_telp,
                    'poin' => $grandTotal / 100,
                ]);
                $customer_id = $newCustomer->id;
                $isFirstPurchase = true;
            }
        }

        // Buat transaksi baru
        $sale = Sale::create([
            'sale_date' => now(),
            'customer_id' => $customer_id, 
            'total_price' => $grandTotal,
            'total_pay' => $total_pay,
            'cashback' => $total_pay - $grandTotal,
            'earned_poin' => 0,
            'used_poin' => 0,
            'user_id' => Auth::user()->id,
        ]);

        // Simpan detail produk yang dibeli
        foreach ($products as $product) {
            $product = explode(';', $product);
            $id = $product[0];
            $name = $product[1];
            $price = number_format($product[2], 0, ',', '.');
            $quantity = (int)$product[3];
            $sub_total = (int)$product[4];

            $sales_products[] = "{$name} ( {$quantity} : Rp. {$price} )";

            // Update stok produk
            $productModel = Product::find($id);
            // dd($id, $jumlahDibeli, $productModel->stok);
            if ($productModel) {
                $productModel->update(['stock' => $productModel->stock - $quantity]);
            }

            // Simpan detail penjualan
            Detail_sale::create([
                'sale_id' => $sale->id,
                'produk_id' => $id,
                'quantity' => $quantity,
                'sub_total' => $sub_total,
            ]);
        }

        // Update sales_products di Sale setelah data dikumpulkan
        // $transaksi->update(['sales_products' => implode(' , ', $sales_products)]);

        // Redirect sesuai kondisi
        if ($request->customer == 'member') {
            return redirect()->route('transaksi.next-create', $sale->id)->with('isFirstPurchase', $isFirstPurchase);
        }

        return redirect()->route('transaksi.print', $sale->id);
    }  

    /**
     * Display the specified resource.
     */
    public function nextCreate($id)
    {
        $sale = Sale::with(['detail_sales', 'customer'])->findOrFail($id);
        $isFirstPurchase = session('isFirstPurchase', false); // default false kalau tidak ada session

        return view('component.transaksi.nextCreate', compact('sale', 'isFirstPurchase'));
    }


    public function submitNextCreate(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $customer_name = $request->input('customer_name');
        $gunakanPoin = $request->has('gunakan_poin'); 

        if ($customer_name && $transaksi->customer) {
            if ($transaksi->customer->customer_name !== $customer_name) {
                $transaksi->customer->update([
                    'customer_name' => $customer_name,
                ]);
            }
        }

        // Kalau checkbox "gunakan poin" dipilih
        if ($gunakanPoin && $sale->customer) {
            $poin = $sale->customer->poin;

            // Update total bayar dan poin
            $sale->update([
                'total_price' => $sale->total_price - $poin,
                'cashback' => $sale->total_pay - ($sale->total_price - $poin),
                'used_poin' => $poin,
            ]);

            $sale->customer->update([
                'poin' => $sale->customer->poin - $poin,
            ]);
        }

        return redirect()->route('transaksi.print', $sale->id);
    }

    public function print($id)
    {
        //
        $transaksi = Transaksi::with(['penjualans', 'user', 'member'])->findOrFail($id);
        return view('component.transaksi.print', compact('transaksi'));
    }

    public function exportPDF($id)
    {
        $transaksi = Transaksi::with('member', 'user')->findOrFail($id);
        $penjualan = Penjualan::where('transaksi_id', $transaksi->id)->with('produk')->get();

        $data = [
            'transaksi' => $transaksi,
            'penjualan' => $penjualan,
            'isMember' => $transaksi->member != null,
        ];
        // return view('views.pdf.invoice', $data);
        $pdf = Pdf::loadView('component.transaksi.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('Struk-belanja.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new TransaksiExport, 'laporan-pembelian.xlsx');
    }

    public function lihat($id)
    {
        $transaksi = Transaksi::with(['penjualans.produk', 'member', 'user'])->find($id);
        // dd($transaksi);
        if (!$transaksi) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($transaksi->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        //
    }
}
