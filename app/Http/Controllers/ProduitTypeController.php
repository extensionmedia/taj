<?php

namespace App\Http\Controllers;

use App\Models\ProduitType;
use Illuminate\Http\Request;

class ProduitTypeController extends Controller
{

    public function search(Request $r){

        $query = ProduitType::query();
        if($r->has('text') &&  $r->text != ''){
            $query->where('produit_type', 'like', "%{$r->text}%");
        }

        if($r->has('status')){
            $query->where('status', '=', $r->status);
        }

        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد شيء في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($query->orderBy('produit_type')->get() as $p){
            $trs .= view('settings.pages.produit_type.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $query->count();
        }


        return $data;

    }

    public function isExists($produit_type){
        $result = ProduitType::where('produit_type', $produit_type)->get();
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
        return view('settings.pages.produit_type.partials.create');

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
            'produit_type' => 'required|string|max:255',
        ]);

        ProduitType::create([
            'produit_type'    =>  $request->produit_type,
            'status'            =>  $request->has('status'),
            'is_default'        =>  $request->has('is_default')
        ]);
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Type Created'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitType  $produitType
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitType $produitType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitType  $produitType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitType $produitType)
    {
        return view('settings.pages.produit_type.partials.update')->with(['type'=>$produitType]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitType  $produitType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitType $produitType)
    {
        $request->validate([
            'produit_type' => 'required|string|max:255'
        ]);

        $produitType->produit_type = $request->produit_type;
        $produitType->status = $request->has('status');
        $produitType->is_default = $request->has('is_default');
        $produitType->save();
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Type Updated'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitType  $produitType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitType $produitType)
    {
        return $produitType->delete();

    }
}
