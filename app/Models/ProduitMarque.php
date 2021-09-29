<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitMarque extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'produit_marque',
        'status',
        'is_default'
    ];

    public function produits(){
        return $this->hasMany(Produit::class);
    }
}
