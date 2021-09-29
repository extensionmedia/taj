<?php

namespace App\Http\Controllers;

use App\Models\ProduitStatus;
use Illuminate\Http\Request;

class ProduitStatusController extends Controller{

    public function search(Request $r){

        $query = ProduitStatus::query();
        if($r->has('text') &&  $r->text != ''){
            $query->where('produit_status', 'like', "%{$r->text}%");
        }

        if($r->has('status')){
            $query->where('status', '=', $r->status);
        }

        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد شيء في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($query->orderBy('produit_status')->get() as $p){
            $trs .= view('settings.pages.produit_status.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $query->count();
        }


        return $data;

    }

    public function isExists($produit_status){
        $result = ProduitStatus::where('produit_status', $produit_status)->get();
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
        return view('settings.pages.produit_status.partials.create');
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
            'produit_status' => 'required|string|max:255',
        ]);

        ProduitStatus::create([
            'produit_status'    =>  $request->produit_status,
            'status'            =>  $request->has('status'),
            'is_default'        =>  $request->has('is_default'),
            'style'             =>  $request->style,
        ]);
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Status Created'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitStatus  $produitStatus
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitStatus $produitStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitStatus  $produitStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitStatus $produitStatus)
    {
        return view('settings.pages.produit_status.partials.update')->with(['status'=>$produitStatus]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitStatus  $produitStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitStatus $produitStatus)
    {
        $request->validate([
            'produit_status' => 'required|string|max:255',
            'style' => 'required|string|max:255',
        ]);

        $produitStatus->produit_status = $request->produit_status;
        $produitStatus->style = $request->style;
        $produitStatus->status = $request->has('status');
        $produitStatus->is_default = $request->has('is_default');
        $produitStatus->save();
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Status Updated'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitStatus  $produitStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitStatus $produitStatus)
    {
        return $produitStatus->delete();

    }
}
