<?php

namespace App\Http\Controllers;

use App\Models\ProduitColor;
use Illuminate\Http\Request;

class ProduitColorController extends Controller{


    public function search(Request $r){

        $query = ProduitColor::query();
        if($r->has('text') &&  $r->text != ''){
            $query->where('produit_color', 'like', "%{$r->text}%");
        }

        if($r->has('status')){
            $query->where('status', '=', $r->status);
        }

        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد منتوج في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($query->orderBy('produit_color')->get() as $p){
            $trs .= view('settings.pages.produit_color.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $query->count();
        }


        return $data;

    }

    public function isExists($produit_color){
        $result = ProduitColor::where('produit_color', $produit_color)->get();
        if($result->count()){
            return 1;
        }else{
            return 0;
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.pages.produit_color.partials.create');

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
            'produit_color' => 'required|string|max:255',
        ]);

        ProduitColor::create([
            'produit_color'  =>  $request->produit_color,
            'status'            =>  $request->has('status'),
            'is_default'        =>  $request->has('is_default')
        ]);
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Couleur Created'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitColor  $produitColor
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitColor $produitColor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitColor  $produitColor
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitColor $produitColor)
    {
        return view('settings.pages.produit_color.partials.update')->with(['color'=>$produitColor]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitColor  $produitColor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitColor $produitColor)
    {
        $request->validate([
            'produit_color' => 'required|string|max:255',
        ]);

        $produitColor->produit_color = $request->produit_color;
        $produitColor->status = $request->has('status');
        $produitColor->is_default = $request->has('is_default');
        $produitColor->save();
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Couleur Updated'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitColor  $produitColor
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitColor $produitColor)
    {
        return $produitColor->delete();

    }
}
