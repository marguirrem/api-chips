<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    public function client(){
        return $this->belongsTo(Client::class, 'Cliente', 'Cliente');
    }


    public function vendedor(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'cantidad',
        'cliente_id',
        'tipo_abono',
        'vendedor_id',
    ];
    public $timestamps = false;
}
