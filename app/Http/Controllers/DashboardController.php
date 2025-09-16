<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::latest()->paginate(10);
        
               
        
                // Ambil jumlah pengembalian minggu ini
                $returnsThisWeek = Borrowing::whereBetween('returned_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count();
        
                // Kirim data ke view
                return view('dashboard', compact('borrowingsThisWeek', 'returnsThisWeek'));

                $borrowings = Borrowing::with('user')->latest()->paginate(5); // 5 data per halaman
                return view('dashboard', compact('borrowings'));
            
            }
        
}
