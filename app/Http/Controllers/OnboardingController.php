<?php

namespace App\Http\Controllers;

use App\Models\Ahligizi;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index(){
        $ahliGizi = Ahligizi::all();
        return view('onboarding', compact('ahliGizi'));
    }

    public function showAhliGizi($id)
    {

        $ahliGizi = AhliGizi::findOrFail($id);


        return view('ahligizi.show', compact('ahliGizi'));
    }
}
