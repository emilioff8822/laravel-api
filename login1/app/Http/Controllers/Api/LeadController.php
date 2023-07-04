<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//importo il NewContact in mail
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
//importo il validator per il punto 2
use Illuminate\Support\Facades\Validator;

//IMPORTO MAIL la facades
use Illuminate\Support\Facades\Mail;


class LeadController extends Controller
{
// il lead controller ricevera in post il dato dal form , lo salva nel db e fa l'invio
public function store (Request $request){
// 1 ricevo i dati dal form in post
//per leggere tutti i dati di una request che arriva in post

$data = request()->all();
// 2 verfifico la validita dei dati,  la faccio cosi perchela validazione deve avvenire all'interno , se ci sono errori non deve avvenire nessun reindirzzamento, ma deve stamparli nel json. non usiamo quindi request come fatto nel postcontroller api
//La funzione make ha bisogno di due argomenti: i dati da validare e le regole di validazione.
        $validator = Validator::make($data, [
    'name' => 'required|min:2|max:255',
    'email' => 'required|email|max:255', // usa 'email', non 'mail'
    'message' => 'required|min:10',
],
        //scrivo i messaggi di errore
        [
            'name.required' => ' Il nome e un campo obbligatorio',
            'name.min' => ' Il nome deve contenere minimo :min caratteri',
            'name.max' => ' Il nome deve contenere massimo :max caratteri',
            'email.required' => ' La mail e un campo obbligatorio',
            'email.email' => ' Mail non corretta',
            'email.max' => ' La mail  deve contenere massimo :max caratteri',
            'message.required' => ' Il messaggio e un campo obbligatorio',
            'message.min' => 'Il messaggio deve contenere minimo :min caratteri',
        ]

    );
//3 se non sono  validi restittuisco in json con success = false e lista di errori
        if ($validator->fails()) {
            $success = false;
            $errors = $validator->errors();
            return response()->json(compact('success', 'errors'));
        }
//4 se sono valdi salvo i dati nel db
//per salvere i dati nel dbvado nel  model LEAD con il protected fillable
//dopo aver fatto il lead lo salvo nel db con il fill
//Cosi facendo ogni cosa che invio nel form e salvata nel db

        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();
        //oppure con create faccio un unico passaggio
        //$new_lead=Lead::create($data)


//5 invio la mail , istanzio un new contact passandogli il new lead
    Mail::to('info@boolean.com')->send(new NewContact($new_lead));


// 7 restituisco un jsom succeess  = true
$success = true;

return response() ->json(compact('success'));


}


}