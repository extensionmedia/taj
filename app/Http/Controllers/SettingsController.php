<?php

namespace App\Http\Controllers;

use App\Models\ProduitCategory;
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
                    'categories'   =>  ProduitCategory::where('status', 1)->get()
                ]);
            }
        }else{
            abort(404);
        }
    }

}
