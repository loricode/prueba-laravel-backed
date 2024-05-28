<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class CityController extends Controller
{
 /**
    * Create a new CityController instance.
    *
    * @return void
    */
    public function __construct()

    {
        $this->middleware('auth:api', ['except' => ['listCities', 'detail', 'getData']]);
    }

    /**
    * lista de ciudades.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function listCities(Request $request)
    {
        try {

          $results = DB::select('CALL sp_list_cities(?)', [$request['countryId']]);

          return $results;

        } catch (Throwable $e) {
          report($e);
 
          return false;
        }
    }

    /**
    * detalle ciudad.
    *
    * @return \Illuminate\Http\JsonResponse
    */
    public function detail(Request $request){
        try {

        $results = DB::select('CALL sp_detail_city(?)', [$request['currencyId']]);
        return response()->json([
            'result' => $results[0],
        ], 200);

      } catch (Throwable $e) {
        report($e);
 
        return false;
      }
    }

      public function getData(Request $request)
      {

          $codeCurrency = $request['currencyCode'];

          $headers = [
            'user-agent' => 'Freecurrencyapi/PHP/0.1',
            'accept' => 'application/json',
            'content-type' => 'application/json',
            "apikey" => 'fca_live_PUVHVdrEoXyNzKYdhSHXqfHGBTrSdctDuFrQP9q5'
          ];

          // Realizar la solicitud GET
          $response = Http::withHeaders($headers)->get('https://api.freecurrencyapi.com/v1/latest?base_currency=USD&currencies='+$codeCurrency);
          
          //$responseDetail = Http::withHeaders($headers)->get('https://api.freecurrencyapi.com/v1/currencies?base_currency=USD&currencies='+$codeCurrency );
  
          // Verificar si la solicitud fue exitosa
          if ($response->successful()) {
              // Obtener los datos de la respuesta
              $data = $response->json();

              //$detail =  $responseDetail->json();
              // Retornar los datos (esto puede variar según tus necesidades)
              return response()->json(['divisa' => $data]);
          } else {
              // Manejar el error (puede ser más específico según el código de error)
              return response()->json(['error' => 'Failed to fetch data'], $response->status());
          }

      }
       
    
}
