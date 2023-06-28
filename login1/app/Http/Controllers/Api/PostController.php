<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{

public function index(){
    //aggiungo user prendere l'user
    $posts = Post::with('category' , 'tags', 'user' )->paginate(10);
    //voglio mettere tutto dentro index per fare una sola chiamata api
    $categories = Category::all();
    $tags = Tag::all();




    return response()->json(compact('posts', 'categories' , 'tags'));

}

//siccome voglio con dei pulsanti in vuejs visualizzare tutte le categorie devo fare una seconda chiamata API
//devo creare una seconda rotta api che restituisca un json con tutte le categorie
public function getCategories(){

        $category = Category::all();

        return response()->json($category);

}

//voglio cliccare su una categorie a e visualizzare tutti i pos che c'e' l'hanno
//devo quindi creare una funzione che mostri il post in base alla categoria che passo
//sto creando UNA TERZA API

public function getPostsByCategory($id){
$posts = Post::where('category_id', $id)->with('category', 'tags' , 'user')->paginate(10);
$categories = Category::all();
$tags = Tag::all();

    return response()->json(compact('posts', 'categories' , 'tags'));
}


public function getPostsByTag($id) {
    //metodo 2
    //prendo i post con tutte le relazioni
    $posts = Post::with('category', 'tags' , 'user')
        //faccio una sottoquery dell'elemento in relazione
        ->whereHas('tags' , function(Builder $query) use ($id) {
            //all'interno fa la sottoquery
            $query->where('tag_id', $id);

        })->paginate(10);

    $tags = Tag::all();
    $categories = Category::all();

    //infine stampo l'array
    return response()->json(compact('posts', 'categories' , 'tags'));
}



// faccio la stessa chiamata API  MA PER I TAGS
public function getTags(){

        $tags = Tag::all();

        return response()->json($tags);

}

//aggiungo una funzione per il dettaglio dei post

public function getPostDetail($slug){

    $post = Post::where('slug', $slug)->with('user', 'categories', 'tags')->first();

    //aggiungo la condizioone di veriifca dell'immagine , voglio controllare se ce lato server
    // se c'e' l'img mi dai quella caricata
        if ($post->image_path)

        $post->image_path = asset('storage/' . $post->image_path);
        else{ //alrimenti mi dai il placeholder che ho messo in storage uploads
        $post->image_path = asset('storage/uploads/placeholder.png');
        //come nome metto no image
        $post->image_original_name = ' - no image -';
        }


    return response()->json($post);


}

}