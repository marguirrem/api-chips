<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItems extends Model
{
    use HasFactory;

    protected $table = 'sales_items';


    protected $hidden = [
     
  
    ];

    public $timestamps = false;

    public function sales(){
        return $this->belongsTo(Sales::class);
    }
}
