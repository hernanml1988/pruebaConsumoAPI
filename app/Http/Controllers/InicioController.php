<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InicioController extends Controller
{
    public function index(){

        $url = env('URL_API', 'https://rickandmortyapi.com/api/character');
        $res = Http::get($url);
        $arrayRes = $res->json();
        $personajes = $arrayRes['results'];
        

        $especies = array();
        $estados = array();

        //realizamo un ciclo para poder obtener todas las especies  y los estados
        for ($i=1; $i < $arrayRes['info']['pages']; $i++) { 
             $res_aux = Http::get($url.'/?page='.$i);
             $arrayRes_aux = $res_aux->json();
             $personajes_aux = $arrayRes_aux['results'];

             foreach ($personajes_aux as $key ) {
                if(!in_array($key['species'], $especies)){
                    $especies[] = $key['species'];
                     
                }
             }
             

             foreach ($personajes_aux as $key ) {
                 if(!in_array($key['status'], $estados)){                     
                     $estados[] = $key['status'];
                }
                
             }
            
        }    
        
        return view('/welcome', ['personajes' => $personajes, 'especies' => $especies, 'estados' => $estados, 'pagina' => 1]);
    }


    
    public function mostrarDetalle($id){


        $url = env('URL_API', 'https://rickandmortyapi.com/api/character');
        $res = Http::get($url.'/'.$id);
        $personaje = $res->json();     
        return view('mostrar_detalle', ['personaje' => $personaje]);
    }


}