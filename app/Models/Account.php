<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'ClientesCtaCte';


    protected $hidden = [
        'DocumentoTipo',
        'DocumentoSerie',
        'EventualTelefonos',
        'Tasa',
  
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'Cliente', 'Cliente');
    }


}
