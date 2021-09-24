<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(ProduitCategory::class, 'produit_category_id', 'id');
    }
    public function sous_category(){
        return $this->belongsTo(ProduitCategory::class, 'produit_sous_category_id', 'id');
    }
    public function status(){
        return $this->belongsTo(ProduitStatus::class, 'produit_status_id', 'id');
    }
    public function magasins(){
        return $this->hasMany(ProduitOfMagasin::class, 'produit_id', 'id');
    }
}
