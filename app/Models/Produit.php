<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'produit_marque_id',
        'produit_color_id',
        'produit_category_id',
        'produit_sous_category_id',
        'produit_status_id',
        'produit_type_id',
        'created_by',
        'barcode',
        'barcode_2',
        'UID',
        'notes',
        'date_reception',
        'taille',
        'code',
        'libelle',
        'prix_achat',
        'prix_vente',
        'prix_location',
        'qte',
        'fournisseur_id'
    ];

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
