<?php
namespace App\Http\Controllers;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
      * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('component.user.index', compact('users'));
    }
    /**
      * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('component.user.create');
    }
    /**
      * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        // dd($request->all());
        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan data user!');
    }
    /**
      * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }
    // controller data buat chart
    public function adminPage()
    {

        $salesCountToday = Sale::whereDate('created_at', Carbon::today())->count();

        $latestSale = Sale::latest()->first();
        $sales = Sale::selectRaw("DATE(CONVERT_TZ(created_at, '+00:00', '+07:00')) as date, COUNT(*) as total_sales")
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();
        //   bar
        $dates = $sales->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d F Y'))->toArray();
        $salesCountChart = $sales->pluck('total_sales')->toArray();
        //   pie
        $productSales = DB::table('sales')
            ->join('detail_sales', 'sales.id', '=', 'detail_sales.sale_id')
            ->join('products', 'detail_sales.product_id', '=', 'products.id')
            ->selectRaw('products.name_product as product_name, SUM(detail_sales.quantity) as total_sold')
            ->groupBy('product_name')
            ->get();
        // Format data Pie Chart
        $productNames = $productSales->pluck('product_name')->toArray();
        $productTotals = $productSales->pluck('total_sold')->toArray();
        return view('home', compact(
            'salesCountToday',     // buat kasir
            'latestSale',     // buat kasir
            'dates',
            'salesCountChart',     // buat chart bar admin
            'productNames',
            'productTotals'
        ));
    }
    /**
      * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $users = User::find($id);
        return view('component.user.edit', compact('users'));
    }
    /**
      * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $updateData = [
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        User::where('id', $id)->update($updateData);
        return redirect()->route('user.index')->with('success', 'Data User berhasil diperbarui!');
    }
    /**
      * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        User::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }
}
