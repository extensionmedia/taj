<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Produit;
use App\Models\ProduitCategory;
use App\Models\ProduitMarque;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('produit.index')->with([
            'produits'              =>      Produit::all(),
            'produit_categories'    =>      ProduitCategory::orderBy('produit_category')->get(),
            'magasins'              =>      Magasin::all(),
            'produit_marques'               =>      ProduitMarque::orderBy('produit_marque')->get()

        ]);
    }

    public function search(Request $r){

        $query = Produit::query();
        if($r->has('text')){
            $query->orWhere(function($q) use ($r){
                $q->where('code', 'like', "%{$r->text}%");
                $q->orWhere('barcode', '=', $r->text);
            });
            $query->orWhere(function($q) use ($r){
                $q->where('code', 'like', "%{$r->text}%");
                $q->orWhere('barcode_2', '=', $r->text);
            });
            $query->orWhere(function($q) use ($r){
                $q->where('barcode', '=', $r->text);
                $q->orWhere('barcode_2', '=', $r->text);
            });
        }
        $trs = '';
        foreach($query->get() as $p){
            $trs .= view('produit.table.row')->with([
                'p'     =>  $p
            ]);
        }
        echo $trs;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function show(Produit $produit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function edit(Produit $produit)
    {
        dd($produit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produit $produit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produit  $produit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produit $produit)
    {
        //
    }
}
