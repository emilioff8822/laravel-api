<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{

//4 se sono valdi salvo i dati nel db
//per salvere i dati nel dbvado nel  model LEAD e fillo i dati



    use HasFactory;

      protected $fillable = [
        'name',
        'email',
        'message'
    ];

}