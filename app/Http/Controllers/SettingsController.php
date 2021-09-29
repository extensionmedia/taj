<?php

namespace App\Http\Controllers;

use App\Models\ProduitCategory;
use App\Models\ProduitColor;
use App\Models\ProduitMarque;
use App\Models\ProduitStatus;
use App\Models\ProduitType;
use App\Models\Project;
use Illuminate\Http\Request;

class SettingsController extends Controller{

    public function index(){

        $project = Project::first()? Project::first(): null;

        return view('settings.index')->with([
            'project'       =>  $project
        ]);
    }

    public function render($page){
        if ( view()->exists('settings.pages.'.$page.'.index') ) {
            if($page == 'project'){
                return view('settings.pages.'.$page.'.index')->with([
                    'project'   =>  Project::first()
                ]);
            }

            if($page == 'produit_category'){
                return view('settings.pages.'.$page.'.index')->with([
                    'categories'   =>  ProduitCategory::where('status', 1)->orderBy('produit_category')->get()
                ]);
            }

            if($page == 'produit_marque'){
                return view('settings.pages.'.$page.'.index')->with([
                    'marques'   =>  ProduitMarque::where('status', 1)->orderBy('produit_marque')->get()
                ]);
            }

            if($page == 'produit_color'){
                return view('settings.pages.'.$page.'.index')->with([
                    'colors'   =>  ProduitColor::where('status', 1)->orderBy('produit_color')->get()
                ]);
            }

            if($page == 'produit_status'){
                return view('settings.pages.'.$page.'.index')->with([
                    'statuses'   =>  ProduitStatus::where('status', 1)->orderBy('produit_status')->get()
                ]);
            }

            if($page == 'produit_type'){
                return view('settings.pages.'.$page.'.index')->with([
                    'types'   =>  ProduitType::where('status', 1)->orderBy('produit_type')->get()
                ]);
            }
        }else{
            abort(404);
        }
    }

}
