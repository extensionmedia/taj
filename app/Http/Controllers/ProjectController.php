<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller{

    public function store(Request $request)    {
        $request->validate([
            'project_name' => 'required|string|max:255',
        ]);

        if(Project::first()){
            if( Project::first()->update($request->all()) )
                return [
                    'status'    =>  'success',
                    'message'   =>  'Project has been updated'
                ];
        }else{
            $request['date_creation'] = Carbon::now();
            if( Project::create($request->all()) )
                return [
                    'status'    =>  'success',
                    'message'   =>  'Project has been created'
                ];
        }

    }

}
