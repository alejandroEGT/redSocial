<?php

namespace App\Http\Controllers;

use App\ComentarioSimple;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PensamientoController extends Controller/*Pensamiento simple*/
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        Carbon::setLocale('es');
    }
    public function index()
    {

        //$c = ComentarioSimple::all()->first();
        //dd($c->created_at);
        $arr = [];
        $query =DB::table('comentario_simple')
        ->select([
            'comentario_simple.id',
            'comentario_simple.texto',
            'users.id as id_user',
            'users.nickname',
            'users.nombres',
            'users.apellidos',
            'users.avatar',
            ('comentario_simple.created_at'),
            'comentario_simple.foto',
            'comentario_simple.url'
        ])
        ->join('users','users.id','comentario_simple.id_user')->orderBy('comentario_simple.created_at','DESC')->get();

        for ($i=0; $i < $query->count() ; $i++) { 
            $query[$i]->created_at = Carbon::parse($query[$i]->created_at)->diffForHumans();
        }

        return $query;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coment = new ComentarioSimple;
        $coment->id_user = Auth::user()->id;
        $coment->texto = $request->text;
        $coment->url = $request->url;
        if($coment->save()){
        	return "success";
        }
        return "denied";
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return "retornar ".$id;
        return ComentarioSimple::where('id_user', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function jsonFoto(Request $datos)
    {
      //return ($datos);
        $coment = new ComentarioSimple;
        $coment->id_user = Auth::user()->id;
        $coment->texto = $datos->texto;

        if($files=$datos->file('fotos')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('fotos',$name);
                $coment->foto = 'fotos/'.$name;

            }
        }
        if($coment->save()){
            return "true";
        }
        return "false";
         /*if($datos->hasFile('fotos'))
         {
            foreach ($datos->File('fotos') as $file) {
                $name = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('fotos'), $name);
            }
         }*/
    }
}
