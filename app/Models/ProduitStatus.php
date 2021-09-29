<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitStatus extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'produit_status',
        'status',
        'is_default',
        'style'
    ];

    public function produits(){
        return $this->hasMany(Produit::class);
    }
}
