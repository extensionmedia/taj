<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitOfMagasin extends Model
{
    use HasFactory;

    public function produit(){
        return $this->belongsTo(Produit::class, 'produit_id', 'id');
    }
    public function magasin(){
        return $this->belongsTo(Magasin::class, 'magasin_id', 'id');
    }
}
