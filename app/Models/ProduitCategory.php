<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'produit_category',
        'parent_id',
        'status',
        'is_default',
        'UID'
    ];

    public function produits(){
        return $this->hasMany(Produit::class);
    }
}
