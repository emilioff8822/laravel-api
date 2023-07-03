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

    $post = Post::where('slug', $slug)->with('user', 'category', 'tags')->first();

    // Controlla se il post esiste prima di cercare di accedere alle sue proprietà
    if($post) {
        //aggiungo la condizione di verifica dell'immagine , voglio controllare se ce lato server
        // se c'e' l'img mi dai quella caricata
        if ($post->image_path)

        $post->image_path = asset('storage/' . $post->image_path);
        else{ //altrimenti mi dai il placeholder che ho messo in storage uploads
        $post->image_path = asset('storage/uploads/placeholder.png');
        //come nome metto no image
        $post->image_original_name = ' - no image -';
        }
        return response()->json($post);
    }

    // Se il post non esiste, restituisci un messaggio di errore o altro
    return response()->json(['message' => 'Post not found'], 404);
}

//aggiungo la funzione API PER RICHIAMARE LE PAROLE DIGITATE NELLA BARRA DI INPUT

// Questa funzione viene definita all'interno di un Controller di Laravel. Si chiama "search" e accetta un parametro chiamato "$tosearch". Questo parametro rappresenta la parola o la frase che l'utente sta cercando.
public function search($tosearch) {

    // "Post::where" è usato per filtrare i risultati in base ad una certa condizione.
    // 'title', 'like', '%'.$tosearch.'%' indica che stiamo cercando i post i cui titoli contengono la parola o la frase che l'utente ha digitato.
    // Il simbolo "%" prima e dopo "$tosearch" indica che stiamo cercando qualsiasi post che contiene la parola o frase di ricerca in qualsiasi punto del titolo.
    $posts = Post::where('title', 'like', '%'.$tosearch.'%')

        // "->with('user', 'category', 'tags')" è utilizzato per caricare le relazioni del modello Post. In questo caso, stiamo caricando le relazioni 'user', 'category', e 'tags'. Questo è chiamato "eager loading" e aiuta a migliorare le prestazioni delle query evitando il problema del "N+1 query problem".
        ->with('user', 'category', 'tags')

        // paginate è usato per eseguire la query e ottenere i risultati. Questi risultati vengono poi assegnati alla variabile $posts.
        ->paginate(10);

    // Infine, stiamo restituendo i risultati della query come una risposta JSON.
    // La funzione compact in PHP crea un array che contiene variabili e i loro valori. I nomi delle variabili passate come argomenti alla funzione compact diventano le chiavi dell'array, e i valori delle variabili diventano i valori dell'array.
    // return response()->json(compact('posts')); restituirà un JSON con un solo oggetto: posts. Questo oggetto conterrà i dati dei post recuperati dal database.
    return response()->json(compact('posts'));
}



}