<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LeadController extends Controller
{
// il lead controller ricevera in post il dato dal form , lo salva nel db e fa l'invio
public function store (Request $request){
// 1 ricevo i dati dal form in post
// 2 verfifico la validita dei dati
//3 se non sono  validi restittuisco in json con success = false e lista di errori
//4 se sono valdi salvo i dati nel db
//6 invio la mail
// 7 restituisco un jsom succeess  = true


}


}