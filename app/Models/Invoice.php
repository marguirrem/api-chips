<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'Facturas';

    protected $hidden = [
        'EventualRazonSocial',
        'EventualDireccion',
        'EventualTelefonos',
        'EventualIDTributario',
        'TarjetaEmisor',
        'TarjetaTipo',
        'TarjetaVoucher',
        'FELIden',
        'FELHora',
        'FELMone',
        'FELExpo',
        'FELAnulEsta',
        'FELEsta',
        'FELResp',
        'FELClav',
        'FELAnulResp',
        'FELCorrElec',
        'FELCorr',
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'Cliente', 'Cliente');
    }
}
