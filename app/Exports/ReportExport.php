<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Carbon;
use App\Models\Sales;
use Maatwebsite\Excel\Concerns\Exportable;

class ReportExport implements FromView
{
    use Exportable;

    private $userId;
    private $username;
    private $fecha;

    public function __construct(string $userId, string $username,$fecha)
    {
        $this->userId = $userId;
        $this->username  = $username;
        $this->fecha = $fecha;
    }

    public function view(): View
    {
        $sales = Sales::with('items')->where('user_id','=', $this->userId)->whereDate('created_At','=', $this->fecha)->get();

    
        return view('pedidos', [
            'sales' => $sales
        ]);
    }
}
