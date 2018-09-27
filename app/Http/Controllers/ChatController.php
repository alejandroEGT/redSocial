<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageSentEvent;
use App\Notificachat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function fetch($id)
    {

        return Chat::getMensajes($id);
    }

    public function sentMessage(Request $request)
    {
        //dd(date('Y/m/d H:m:s'));
        $user = Auth::user();
        $cod ='';
        $message = new Chat;
          $message->id_user_envia = Auth::user()->id;
		  $message->id_user_recibe = $request->id_recibe;
		  $message->mensaje = $request->message['mensaje'];
		  if($message->save()){

               // $verify = Notificachat::where('codigo_chat', $cod)->first();
                $verify = Notificachat::where([
                    'user_envia'=> Auth::user()->id,
                    'user_recibe'=> $request->id_recibe
                ])->orWhere('user_envia','=',$request->id_recibe)
                ->where('user_recibe','=', Auth::user()->id)->first();

                //return $verify;

                if ($verify) {
                    $verify->id_chat = $message->id;
                    $verify->save();
                }else{
                    $nch = new Notificachat;
                    $nch->user_envia = Auth::user()->id;
                    $nch->user_recibe = $request->id_recibe;
                    $nch->id_chat = $message->id;
                    $nch->save();
                }


                broadcast(new MessageSentEvent($user, $message))->toOthers();
                return "true";
                    
          }



    }
    public function sendFoto(Request $dato){
        //dd($dato->file('fotos'));
         $user = Auth::user();
        if($files=$dato->file('fotos')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                $file->move('fotos_messenger',$name);

                $message = new Chat;
                $message->id_user_envia = Auth::user()->id;
                $message->id_user_recibe = $dato->id_recibe;
                $message->archivo = 'fotos_messenger/'.$name;

                if($message->save()){
                    broadcast(new MessageSentEvent($user, $message))->toOthers();
                    return "true";

                }
                return "false";

            }
        }
    }
    public  function show_notificacion_mensaje($id){
        $yo = Auth::user();
        
        $show = Notificachat::join('chat as ch','ch.id','id_chat')
               ->join('users as u','u.id','ch.id_user_envia')
               ->where('id_user_envia', $yo->id)
               ->orWhere('id_user_recibe', $yo->id)
               ->select([
                    DB::raw("concat(u.nombres,' ',u.apellidos) as nombre"),
                     'u.avatar', 'ch.id_user_envia as envia', 'ch.id_user_recibe as recibe',
                     'ch.mensaje','u.nickname as nick'
               ])
               ->orderBy('notifica_chat.updated_at','DESC')->get();
        
        if (count($show) > 0) {
            return $show;
        }else{
            return "null";
        }

    }
}
