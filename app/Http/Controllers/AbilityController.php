<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AbilityController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name'=>'required|uniques:abilities']);
        Bouncer::ability()->create([
            'name'=>$request->name,
            'title'=>ucfirst(str_replace('-','',$request->name))
        ]);
        return back();
    }
}
