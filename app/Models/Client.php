<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    use HasFactory;
    protected $table = 'Clientes';

    /*public function invoices(){
        return $this->hasMany(Invoice::class,'Cliente', 'Cliente')->orderBy('FECHA', 'desc')->take(3);
    }*/

    public function invoices(){
        return $this->hasMany(Account::class,'Cliente', 'Cliente')->where('SaldoActual','>','0')->orderBy('FechaEmision', 'desc')->take(3);
    }
}
