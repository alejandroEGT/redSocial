<?php

namespace App\Http\Controllers;

use App\ComentarioMultiple;
use App\ComentarioSimple;
use Illuminate\Http\Request;

class postear_a_alguienController extends Controller
{
	public function index()
	{
		
	}
    public function create()
    {
        //s
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $coment = ComentarioMultiple::comentar_a($request);
        if ($coment) {
        	return "true";
        }
        return "false";
       
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
       $a = ComentarioSimple::join('users as u','comentario_simple.id_user','u.id')
        ->where('id_user', $id)->get();
        $b = ComentarioMultiple::traerComentariosDelMuro($id);
        $c = ComentarioMultiple::yoAalguien($id);

        
    	//$a = '{"1":"A","2":"V","3":"C"}';
		//$b = '{"1":"X","2":"XL","3":"XM","4":"L"}';

		$a = json_decode($a,true);
		$b = json_decode($b,true);
		$c = json_decode($c,true);

		$order = array_merge($a, $b, $c);

		return ($order);
        //return json_encode(array_merge(array_filter($a),json_decode($b, true)));
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
      
    }
    public function dirigidos($id)
    {
    	return ComentarioMultiple::yoAalguien($id);
    }
 
}
