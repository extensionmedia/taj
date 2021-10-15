<?php

namespace App\Http\Controllers;

use App\Models\Magasin;
use App\Models\Produit;
use App\Models\ProduitCategory;
use App\Models\ProduitColor;
use App\Models\ProduitMarque;
use App\Models\ProduitOfMagasin;
use App\Models\ProduitStatus;
use App\Models\ProduitType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MarkSitko\LaravelUnsplash\Unsplash;

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
            'produits'              =>      Produit::where('produit_status_id', 1)->get(),
            'produit_categories'    =>      ProduitCategory::orderBy('produit_category')->get(),
            'magasins'              =>      Magasin::all(),
            'produit_marques'       =>      ProduitMarque::orderBy('produit_marque')->get(),
            'statuses'              =>      ProduitStatus::all()

        ]);
    }

    public function search(Request $r){

        $query = Produit::query();
        if($r->has('text') &&  $r->text != ''){
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

        if($r->has('category')  &&  $r->category != '-1'){
            $query->where('produit_category_id', '=', $r->category);
        }

        if($r->has('marque')  &&  $r->marque != '-1'){
            $query->where('produit_marque_id', '=', $r->marque);
        }
        if($r->has('status')){
            $query->where('produit_status_id', '=', $r->status);
        }

        $produit_result = $query->get();
        if($r->has('magasin')  &&  $r->magasin != '-1'){
            $produit_result = $produit_result->filter(function($p) use ($r){
                foreach($p->magasins as $k=>$m){
                    if($m->magasin_id == $r->magasin){
                        return $p;
                    }
                }
            });
        }
        //dd($query->toSql());

        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد منتوج في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($produit_result as $p){
            $trs .= view('produit.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $produit_result->count();
        }


        return $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('produit.create')->with([
            'categories'            =>      ProduitCategory::orderBy('produit_category')->get(),
            'magasins'              =>      Magasin::all(),
            'marques'               =>      ProduitMarque::orderBy('produit_marque')->get(),
            'statuses'              =>      ProduitStatus::all(),
            'types'                 =>      ProduitType::all(),
            'colors'                =>      ProduitColor::all(),
            'UID'                   =>      Str::uuid()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'date_reception'        => 'required|date',
            'code'                  => 'required|max:255',
            'libelle'               => 'required|max:255',
            'produit_category_id'   => 'required|max:255',
            'magasin'               =>  'required'
        ]);

        $produit = Produit::create([
            'produit_marque_id'             =>      $request->produit_marque_id,
            'produit_color_id'              =>      $request->produit_color_id,
            'produit_category_id'           =>      $request->produit_category_id,
            'produit_sous_category_id'      =>      0,
            'produit_status_id'             =>      $request->produit_status_id,
            'produit_type_id'               =>      $request->produit_type_id,
            'created_by'                    =>      0,
            'barcode'                       =>      $request->barcode,
            'barcode_2'                     =>      $request->barcode_2,
            'UID'                           =>      $request->UID,
            'notes'                         =>      '',
            'date_reception'                =>      $request->date_reception,
            'taille'                        =>      $request->taille,
            'code'                          =>      $request->code,
            'libelle'                       =>      $request->libelle,
            'prix_achat'                    =>      $request->prix_achat,
            'prix_vente'                    =>      $request->prix_vente,
            'prix_location'                 =>      $request->prix_location,
            'qte'                           =>      $request->qte,
            'fournisseur_id'                =>      0
        ]);
        if($request->has('magasin')){
            foreach($request->magasin as $m){
                ProduitOfMagasin::create([
                    'magasin_id'    =>  $m,
                    'produit_id'    =>  $produit->id
                ]);
            }
        }


        return redirect()->route('produit.list');
        return [
            'status'    =>  'success',
            'message'   =>  'Produit has been created'
        ];

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
        return view('produit.update')->with([
            'categories'            =>      ProduitCategory::orderBy('produit_category')->get(),
            'magasins'              =>      Magasin::all(),
            'marques'               =>      ProduitMarque::orderBy('produit_marque')->get(),
            'statuses'              =>      ProduitStatus::all(),
            'types'                 =>      ProduitType::all(),
            'colors'                =>      ProduitColor::all(),
            'produit'=>$produit
        ]);
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
