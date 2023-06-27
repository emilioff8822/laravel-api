<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;

class PostController extends Controller
{

public function index(){

        $posts = Post::with('category' , 'tags')->paginate(10);

        return response()->json($posts);

}

//siccome voglio con dei pulsanti in vuejs visualizzare tutte le categorie devo fare una seconda chiamata API
//devo creare una seconda rotta api che restituisca un json con tutte le categorie
public function getCategories(){

        $category = Category::all();

        return response()->json($category);

}

//voglio cliccare su una categorie a e visualizzare tutti i pos che c'e' l'hanno
//devo quindi creare una funzione che mostri il post in base alla categoria che passo
//sto creando un altra API

public function getPostsByCategory($id){
$posts = Post::where('category_id', $id)->with('category', 'tags')->paginate(10);
return response()->json($posts);
}




// faccio la stessa chiamata API  MA PER I TAGS
public function getTags(){

        $tags = Tag::all();

        return response()->json($tags);

}

}