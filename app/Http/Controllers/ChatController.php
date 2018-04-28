<?php

namespace App\Http\Controllers;

use App\Chat;
use App\Events\MessageSentEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetch($id)
    {

        return Chat::getMensajes($id);
    }

    public function sentMessage(Request $request)
    {

        $user = Auth::user();

        $message = new Chat;
          $message->id_user_envia = Auth::user()->id;
		  $message->id_user_recibe = $request->id_recibe;
		  $message->mensaje = $request->message['mensaje'];
		 $message->save();

        broadcast(new MessageSentEvent($user, $message))->toOthers();
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
}
