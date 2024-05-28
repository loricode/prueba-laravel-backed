<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    
    /**
    * Create a new CountryController instance.
    *
    * @return void
    */
    public function __construct()

    {
        $this->middleware('auth:api', ['except' => ['listCountries']]);
    }

    /**
    * lista de paises.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function listCountries(Request $request)
    {

        $results = DB::select('CALL sp_list_countries()');

        return $results;
    }

}
