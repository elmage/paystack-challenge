<?php

namespace App\Http\Controllers;

use App\Supplier\Supplier;
use App\Transfer\Transfer;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_suppliers = Cache::remember('total_suppliers', 30, function () {
            return (new Supplier)->count();
        });

        $transfers_total = Cache::remember('transfers_total', 60, function () {
            return (new Transfer)->count();
        });

        $recent_transfers = Cache::remember('recent_transfers', 30, function () {
            return (new Transfer)->latest()->limit(6)->get();
        });



        return view('dashboard.index',[
            'home'=>1,
            'total_suppliers'=>$total_suppliers,
            'transfers_total'=>$transfers_total,
            'recent_transfers'=>$recent_transfers
        ]);
    }

    public function handleRoot() {
        return redirect()->route('home');
    }
}
