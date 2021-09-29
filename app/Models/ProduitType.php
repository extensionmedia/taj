<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitType extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'produit_type',
        'status',
        'is_default'
    ];

    public function produits(){
        return $this->hasMany(Produit::class);
    }
}
