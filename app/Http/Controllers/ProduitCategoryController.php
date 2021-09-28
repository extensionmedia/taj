<?php

namespace App\Http\Controllers;

use App\Models\ProduitCategory;
use Illuminate\Http\Request;

class ProduitCategoryController extends Controller
{

    public function search(Request $r){

        $query = ProduitCategory::query();
        if($r->has('text') &&  $r->text != ''){
            $query->where('produit_category', 'like', "%{$r->text}%");
        }

        if($r->has('status')){
            $query->where('status', '=', $r->status);
        }

        $result = $query->get();


        $data = [
            'trs'   =>  '<tr><td colspan="6"> <div class="py-4 text-center text-2xl text-green-500">لا يوجد منتوج في نتيجة البحث</div> </td></tr>',
            'count' =>  0
        ];
        $trs = '';
        foreach($query->get() as $p){
            $trs .= view('settings.pages.produit_category.table.row')->with([
                'p'     =>  $p
            ]);
        }
        if($trs != ''){
            $data['trs'] = $trs;
            $data['count'] = $query->count();
        }


        return $data;

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
        return view('settings.pages.produit_category.partials.create');
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
            'produit_category' => 'required|string|max:255',
        ]);

        ProduitCategory::create([
            'produit_category'  =>  $request->produit_category,
            'status'            =>  $request->has('status'),
            'is_default'        =>  $request->has('is_default'),
            'parent_id'         =>  -1,
            'UID'               =>  ''
        ]);
        return [
            'status'    =>  'success',
            'message'   =>  'Produit Category Created'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProduitCategory  $produitCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProduitCategory $produitCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProduitCategory  $produitCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProduitCategory $produitCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProduitCategory  $produitCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProduitCategory $produitCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProduitCategory  $produitCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProduitCategory $produitCategory)
    {
        //
    }
}
