<?php

namespace App\Http\Controllers;

use App\Solicitud;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravolt\Avatar\Avatar;
use Vikin\Laricon\Facades\Laricon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $user = new User;
        $avatar = new Avatar;
        $uriAvatar = 'avatar/'.time().'.png';
        $urlBack = 'background/'.time().'-'.$request->email.'.png';
        $avatar->create(strtoupper($request->nombres.' '.$request->apellidos))->setBackground($this->aleatorio_colors())->save($uriAvatar, $quality = 90);

        $avatar->create(strtoupper($request->nickname.' '.$request->email))
        ->setBackground('#9B59B6')
        ->setDimension(200, 300)
        ->setShape('square')
        ->save($urlBack, $quality = 90);

        $user->nombres = $request->nombres;
        $user->apellidos = $request->apellidos;
        $user->nickname = $request->nickname;
        $user->nacimiento = $request->nacimiento;
        $user->id_sexo = $request->sexo;
        $user->email = $request->email;
        $user->password = $request->clave;
        $user->avatar = $uriAvatar;
        $user->avatarback = $urlBack;
        if($user->save()){
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
        //
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
    public function update_foto(Request $dato){
        return User::updateFoto($dato);
    }
    public function update_fotoback(Request $dato){
        return User::updateFotoback($dato);
    }

    public function aleatorio_colors(){
        $array =  Array('#F5B041','#EC7063','#B2BABB','#45B39D','#BB8FCE','#3498DB','#5D6D7E');
        $rand = random_int ( 0 , 6 );
        return $array[$rand];
    } 

    public function users_en_comun()
    {
        $i = 0;
        $ids = [];
        $yo = Auth::user()->id;

        
        $user_yo_uno=Solicitud::select('user_seguido')->where('user_seguidor', $yo )->where('id_estado', '1')->get();
        $user_yo_dos=Solicitud::select('user_seguidor')->where('user_seguido', $yo )->where('id_estado', '1')->get();

        // return [
        //     $user_yo_uno,
        //     $user_yo_dos
        // ];


        foreach ($user_yo_uno as $key) {
            $ids[$i]['id'] = $key->user_seguido;
            $i++;
        }

        foreach ($user_yo_dos as $key) {
            $ids[$i]['id'] = $key->user_seguidor;
            $i++;
        }
        return User::whereNotIn('id', $ids)->where('id','!=', $yo)->get();
    }
}
