<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    protected $table = 'sales';

    protected $hidden = [
    ];

    protected $fillable = [
        'id',
        'invoice_code',
        'client_id',
        'notes',
        'total',
        'status',
        'tendered',
        'is_guest',
        'user_id',
        'delete_flag',
        'created_at',
        'updated_at',
        'geolocalizacion',
        'attachment',
        'forma_pago',
        'trnasporte',
        'bodega',
    ];
    public $timestamps = false;

    public function items(){
        return $this->hasMany(SalesItems::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
