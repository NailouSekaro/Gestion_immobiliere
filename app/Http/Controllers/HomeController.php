<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    // App/Http/Controllers/HomeController.php

    public function index() {
        // $chambres = Chambre::where( 'disponible', true )->get();
        // return view( 'home', compact( 'chambres' ) );
        return view( 'home');
    }
}
