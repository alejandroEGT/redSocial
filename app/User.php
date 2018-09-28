<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use JD\Cloudder\Facades\Cloudder;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombres', 'email', 'password',
    ];

   
     public function message()
    {
        return $this->hasMany(Message::class);
    }
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function setNombresAttribute($nombres)
    {
        $this->attributes['nombres'] = ucfirst($nombres);
    }
    public function setApellidosAttribute($apellidos)
    {
        $this->attributes['apellidos'] = ucfirst($apellidos);
    }
    public function setNicknameAttribute($nickname)
    {
        $this->attributes['nickname'] = ucfirst($nickname);
    }
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function setNacimientoAttribute($nacimiento)
    {
        $this->attributes['nacimiento'] = date( 'Y-m-d', strtotime( $nacimiento ) );
    }
    protected function updateFoto($datos)
    {
        $datos->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $us = $this->find(Auth::user()->id);
        $image = $datos->file('foto');
        $name = time().'.'.$image->getClientOriginalExtension();

        if($datos->file('foto')->move(public_path('avatar'), $name)){

            Cloudder::upload('avatar/'.$name, $name);
            $result = Cloudder::getResult();

            $us->avatar = $result['url'];
           
            if ($us->save()) {
                 \File::delete('avatar/'.$name);

                return "Success";
            }
        }
        return "error";
    }
    protected function updateFotoback($datos)
    {
        //dd($datos->all());
        $datos->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $us = $this->find(Auth::user()->id);
        $image = $datos->file('foto');
        $name = time().'.'.$image->getClientOriginalExtension();
        if($datos->file('foto')->move(public_path('background'), $name)){

            Cloudder::upload('background/'.$name, $name);
            $result = Cloudder::getResult();

            $us->avatarback = $result['url'];
            if ($us->save()) {
                
                 \File::delete('background/'.$name);
                return $us->avatarback;
            }
        }
        return "error";
    }
}
