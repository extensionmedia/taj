<?php

namespace App\Http\Controllers;

use App\Models\ProduitMarque;
use Illuminate\Http\Request;

class ProduitMarqueController extends Controller{

    public function search(Request $r){

        $query = ProduitMarque::query();
        if($r->has('text') &&  $r->text != ''){
            $query->where('produit_marque', 'like', "%{$r->text}%");
        }

        if($r->has('status')){
            $query->where('status', '=', $r->status);
        }

        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد منتوج في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($query->orderBy('produit_marque')->get() as $p){
            $trs .= view('settings.pages.produit_marque.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $query->count();
        }


        return $data;

    }

    public function isExists($produit_marque){
        $result = ProduitMarque::where('produit_marque', $produit_marque)->get();
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
        return view('settings.pages.produit_marque.partials.create');

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
            'produit_marque' => 'required|string|max:255',
        ]);

        ProduitMarque::create([
            'produit_marque'  =>  $request->produit_marque,
            'status'            =>  $request->has('status'),
            'is_default'        =>  $request->has('is_default')
        ]);
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Marque Created'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitMarque  $produitMarque
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitMarque $produitMarque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitMarque  $produitMarque
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitMarque $produitMarque)
    {
        return view('settings.pages.produit_marque.partials.update')->with(['marque'=>$produitMarque]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitMarque  $produitMarque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitMarque $produitMarque)
    {
        $request->validate([
            'produit_marque' => 'required|string|max:255',
        ]);

        $produitMarque->produit_marque = $request->produit_marque;
        $produitMarque->status = $request->has('status');
        $produitMarque->is_default = $request->has('is_default');
        $produitMarque->save();
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Marque Updated'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitMarque  $produitMarque
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitMarque $produitMarque)
    {
        return $produitMarque->delete();
    }
}
