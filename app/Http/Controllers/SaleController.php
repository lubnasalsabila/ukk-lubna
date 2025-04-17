<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Customer;
use App\Models\Detail_sale;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $earn_poin = 0;
        $customer_id = null;

        // dd($request);
        if ($request->customer == 'customer') {
            $earn_poin = $grandTotal / 100 ;
            $no_telp = $request->input('no_telp');
            $existCustomer = Customer::where('no_telp', $no_telp)->first();

            $isFirstPurchase = false;

            if ($existCustomer) {

                $jumlahTransaksi = Sale::where('customer_id', $existCustomer->id)->count();
                $isFirstPurchase = $jumlahTransaksi == 0;

                $existCustomer->update([
                    'poin' => $existCustomer->poin + $earn_poin,
                ]);
                $customer_id = $existCustomer->id;
            } else {
                $newCustomer = Customer::create([
                    'no_telp' => $no_telp,
                    'poin' => $earn_poin,
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
            'earn_poin' => $earn_poin,
            'used_poin' => 0,
            'staff_id' => Auth::user()->id,
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

            $productModel = Product::find($id);
            if ($productModel) {
                $productModel->update(['stock' => $productModel->stock - $quantity]);
            }

            Detail_sale::create([
                'sale_id' => $sale->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'sub_total' => $sub_total,
            ]);
        }

        if ($request->customer == 'customer') {
            return redirect()->route('sale.next-create', $sale->id)->with('isFirstPurchase', $isFirstPurchase);
        }

        return redirect()->route('sale.print', $sale->id);
    }

    /**
     * Display the specified resource.
     */
    public function nextCreate($id)
    {
        $sale = Sale::with(['detail_sales', 'customers'])->findOrFail($id);
        $isFirstPurchase = session('isFirstPurchase', true);
        // $isFirstPurchase = session()->get('isFirstPurchase', false);

        return view('component.transaksi.nextCreate', compact('sale', 'isFirstPurchase'));
    }


    public function submitNextCreate(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $customer_name = $request->input('customer_name');
        $gunakanPoin = $request->has('gunakan_poin');

        if ($customer_name && $sale->customers) {
            if ($sale->customers->customer_name !== $customer_name) {
                $sale->customers->update([
                    'customer_name' => $customer_name,
                ]);
            }
        }

        if ($gunakanPoin && $sale->customers) {
            $poin = $sale->customers->poin;

            // Update total bayar dan poin
            $sale->update([
                'total_price' => $sale->total_price - $poin,
                'cashback' => $sale->total_pay - ($sale->total_price - $poin),
                'used_poin' => $poin,
            ]);

            $sale->customers->update([
                'poin' => $sale->customers->poin - $poin,
            ]);
        }

        return redirect()->route('sale.print', $sale->id);
    }

    public function print($id)
    {
        //
        $sale = Sale::with(['detail_sales', 'users', 'customers'])->findOrFail($id);
        return view('component.transaksi.print', compact('sale'));
    }

    public function exportPDF($id)
    {
        $sale = Sale::with('customers', 'users')->findOrFail($id);
        $detail_sale = Detail_sale::where('sale_id', $sale->id)->with('products')->get();

        $data = [
            'sale' => $sale,
            'detail_sale' => $detail_sale,
            'isMember' => $sale->customer != null,
        ];
        // return view('views.pdf.invoice', $data);
        $pdf = Pdf::loadView('component.transaksi.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('Struk-belanja.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'laporan-pembelian.xlsx');
    }

    public function lihat($id)
    {
        $sale = Sale::with(['detail_sales.product', 'customers', 'users'])->find($id);
        // dd($transaksi);
        if (!$sale) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($sale->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
