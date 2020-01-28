<?php

namespace App\Exports;

use App\Seller;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SellersExport implements FromView
{
    public function view(): View
    {
        return view('exports.sellers', [
            'sellers' => Seller::all()
        ]);
    }
}
