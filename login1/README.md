26 06

PARTE 1 VUE INNESTATO IN LARAVEL

in Routes API

Cancello la rotta middlware di default , usremo solo rotte pubbliche

Le api restituiscono un JSON , i metodi del controller non restituiranno piu le view ma un json
usano una chiamata axios

Route::get('/prova-api', function () {

    $user = [
        'name' => 'Emilio',
        'lastname' => 'Cellini'
    ];

    return response()->json($user);

});

questa rotta non ha bisogno del name

http://127.0.0.1:8000/api/prova-api
prendo la rotta la metto in thunderclient e metto la base dell'endpoint, ottengo il json
cosi facendo ho soli i valori

se dovessi paassrlo in compact avrei anche le chiavi

-   creo un controller per le API, in una cartella api (non e' un resource controller)

php artisan make:controller Api/PostController

importo il modeluse App\Models\Post;

nella index stampo tutti i post
public function index(){

        $posts = Post::all();

        return response()->json($posts);

}
}

-VADO IN ROUTES API PHP E raggruppo tutte le rotte api relative ai post
innanzitutto mi importo il controller api
use App\Http\Controllers\Api\PostController;

do un name space alle rotte , tutte le rotte che prendo saranno sotto il nome Api

Creo dunque la rotta alla mia API

Route::
namespace('Api')
->prefix('posts')
->group(function () {

        Route::get('/', [PostController::class, 'index']);
    });

-ANDANDO SU THUNDERCLIENT http://127.0.0.1:8000/api/posts VEDO TUTTI I POST

---INNESTO VUE IN LARAVEL NELLE VIEWS IN GUEST in home blade

home blade estende layouts guest

inizio INSTALLANDO VUE COME PLUGIN

npm i vue@next

npm i @vitejs/plugin-vue --force

vado in vite config.js e gli dico di prendere il plugin

import vue from '@vitejs/plugin-vue';

vue({
template:{
transformAssetUrls:{
base: null,
includeAbsolute: false
}
}
})

Posso iniziare a lavorare sul progetto vue lavorando nella cartella JS
Creo in js App.vue
appvue dovra innestarsai in guest.blade e questo bisogna dirllo tramite APPGUEST.JS
e qui che devo dire prendi appvue e innestalo in home blade in guest

in app guest scrivo

import { createApp } from "vue";
import App from './App.vue';

createApp(App).mount('#app');

38recap

CHIAMATA API
in Js creo la cartella store e poi store.js
-Salvo l'endpoint base bnello store

import { reactive } from "vue";

export const store = reactive({

    apiUrl: 'http://127.0.0.1:8000/api/'

})

-vado in APPVUE e porendo in poost che avevo preso in post controller API con post all

<script>

import { store } from './store/store.js';
import axios from 'axios';

export default {
    name: 'home',
    data() {
        return {
        posts:[]
    }

    },
    methods: {
        getApi() {
            console.log(store.apiUrl);
            //faccio la chiamata axios
            axios.get(store.apiUrl + 'posts')
                .then(results => {
                    this.posts = results.data;
                    console.log(results.data);

            })
        }
    },

    mounted() {
        this.getApi();
    }


}
</script>

PER STAMPARLI nel template
<template>

<div class="container">
<h1>Elenco Post</h1>

        <ul>
            <li v-for="post in posts" :key="post.id">
                <span>{{ post.title }}</span> - <span>{{ post.date }}</span>
            </li>
        </ul>

    </div>

</template>

DATA FORMATTATA IN ITA

PAGINAZIONE QUANDO METTO IN POSTCONTROLLER API PAGINATE 10 MI METTE TUTTI I POST DENTRO Data

creo dei bottoni chje al click opassano i link diversi per ogni pagina
di default si parte da 1

---

27 06 ROUTER

step router

npm install vue-router@4 —force

Creo all inter di js una cartella chiamata pages con dentro

Home.vue

Contacts.vue

in js creo un file chiamato router.js

//importo il router
import { createRouter, createWebHistory } from "vue-router";

//importo le pagine che ho creato home, contacts, erro404 ecc..

import Home from './pages/Home.vue';
import Contacts from './pages/Contacts.vue';

//inizializzo una variabile che chiamo route
const router = createRouter({
history: createWebHistory(),
//questa è la rotta home
routes: [
{
path: '/',
name: 'home',
component: Home
},
//questa e' la rotta contatti
{
path: '/contacts',
name: 'Contacts',
component: Contacts
},

    ]

})

export {router}

//alla fine e' tutto confenzionato ma biosgna importarlo nel nostro progetto vue
//lo devo importare nel javascrip principale nel mio caso AppGuest.js

--in main.js in questo caso appGuest.js lo collego

import { createApp } from "vue";
import App from './App.vue';

//importo il router.js
import { router } from "./router";

//dico a createapp di usare il router

createApp(App).use(router).mount('#app');

metto la rotta trick in web php

//rotta trick per gestire il router di vue

Route::get('{any?}',function(){
return view('guest.home');
})->where('any','.\*')->name('home');

CREO IN STORE UN ALTRO APP.VUE E RINOMINO LA VECCHIA IN \_App.vue

Nella nuova app vue

Nel template metto

<Router-view> </router-vue>

In js creo un altra cartella che chiamo components

Dentro metto

Header.vue

In App.vue importo header

<script>
//importo l'header
import Header from './components/Header.vue';

export default {
    name: 'App',
 //importo l'header nei componenti , infine lo metto nel template
    components: {
        Header
    }


}
</script>

<template>

<Header />

<router-view></router-view>

## </template>

In header faccio il menu Di navigazione

Ul li home chi siamo contatti

Metto gli stili in header
Voglio che questi link in header home chi siamo funzionino

Anziché a mettiamo <router-link :to=“{name: home}”>. Home </routerr-link> e lo faccimao Per tutti e tre i link

Metto anche la classe active in

—— vado in home e creo un container-inner

Do gli stili in appguest

—API
Vado in pagine e creo blog.vue

-vado nel router js e importo import blog ‘./pages/blog.vue’
E lo metto anche. Nei router link dell header vue

Nel blog devo fare la chiamata API
IN BLOG

<script>
import { store } from '../store/store';
import axios from 'axios';
import ItemPost from '../components/ItemPost.vue';

export default {
    name: 'Contacts',
    components: {
        ItemPost

    },
      data() {
        return {
            posts: [],
            links: [],
            first_page_url: null,
            last_page_url: null,
            current_page: null,
            last_page: null
        };
    },
     methods: {
        getApi(endpoint) {
            console.log(store.apiUrl);
            //faccio la chiamata axios
            axios.get(endpoint)
                .then(results => {
                    this.posts = results.data.data
                    this.links = results.data.links
                    this.first_page_url = results.data.first_page_url
                    this.last_page_url = results.data.last_page_url
                    this.current_page = results.data.current_page
                    this.last_page = results.data.last_page
                });
        },
        formatData(dateString) {
            const d = new Date(dateString);
            return d.toLocaleDateString();
        }
    },
    mounted() {
        this.getApi(store.apiUrl + 'posts');
    }


}
</script>

<template>
    <div class="container-inner">
        <h1>Blog</h1>

        <div>
    <ItemPost v-for="post in posts" :key="post.id"/>

        </div>



    </div>

</template>

IN ITEM POST USO LE PROPS

<script>
export default {
    name: 'ItemPost',
    props: {
    post: Object
    }

}
</script>

In item post per gestire la data uso una computed

<script>
export default {
    name: 'ItemPost',
    props: {
    post: Object
    },
    //utilizzo una computed per avere la data in italiano
    computed: {
        formattedData() {
            const d = new Date(this.post.date);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            //funzione stefano sigla data
            function getUserLocale() {
                const userLocale = navigator.languages && navigator.languages.length
                    ? navigator.languages[0]
                    : navigator.language;
                return userLocale;
            }

            return d.toLocaleString(getUserLocale(), options);
    }
    }

}
</script>

<template>
    <div>
        <h3> Titolo: {{post.title}}</h3>
        <h3>{{ formattedData }}</h3>
        <h3>Categoria</h3>
        <h3>Tag</h3>
    </div>

</template>

SECONDA CHIAMATA API

abbiamo finora una chiama quella in controller api PostController
ne facciamo una seconda

//siccome voglio con dei pulsanti in vuejs visualizzare tutte le categorie devo fare una seconda chiamata API
//devo creare una seconda rotta api che restituisca un json con tutte le categorie

public function getCategories(){

        $category = Category::all();

        return response()->json($category);

}

VADO in ROUTES IN API.PHP
e aggiungo la rotta

Route::get('/categories', [PostController::class, 'getCategories']);

in thunderclient da qui posso vedere le rotte http://127.0.0.1:8000/api/posts/categories
ce il prefisso davanti posts che abbiamo messo nelle rotte api

vado in vue blog
// nei methods aggiungo getcategories dell;' API -PostController, l'apiurl e' store.js e gli concateno categories

        getCategories() {
            axios.get(store.apiUrl + 'posts/categories')
                .then(result => {
                    this.categories = result.data;
            })

        },

        lo metto nel mounted alla fine

           mounted() {
        this.getApi(store.apiUrl + 'posts');
        this.getCategories();
    }

}

infine lo stampo
<button class="btn-cat" v-for="category in categories " :key="category.id">{{category.name}}</button>

RIFACCIIO la stessa cosa per i tags
1 VADO in api postcontroller aggiungo sotto getCategories

public function getTags(){

        $tags = Tag::all();

        return response()->json($tags);

}

2 Vado nelle routes in api.php e aggiungo

Route::get('/tags', [PostController::class, 'getTags']);

3 infine aggiungo tutto in blog vue

nei methods

getTags() {
axios.get(store.apiUrl + 'posts/tags')
.then(result => {
this.tags = result.data;
})

        },

nel mounted

        this.getTags();

e nei data tags:[]

4 infine lo stampo

 <h2>Tags</h2>
            <button class="btn-cat" v-for="tag in tags " :key="tag.id">{{ tag.name }}</button>

CLICK SUL BOTTONE CATEGORIES E VISUALIZZO TUTTI I POST CHE HANNO QUELLA CATEGORIA
1vado in post controller e CREO UNA TERZA API

in post controller devo creare una funzione che mostri il post in base alla categoria che passo

public function getPostsByCategory($id){
$posts = Post::where('category_id', $id)->with('category', 'tags')->paginate(10);
return response()->json($posts);
}

2DEVO mettere la rotta in api php

Route::get('/post-category/{id}', [PostController::class, 'getPostsByCategory']);

in blog vue metto un altra funzione in methods

//metto il metodo per il click sulle categorie per visualizzare tutti i post con quelle categories

        getPostCategory(id) {
        this.getApi(store.apiUrl + 'posts/post-category/' +id)
        }

3infine per staparle aggiungo al bottone delle categorie il click per visualizzare ilo dettaglio dei post con una specifica categoria

<button class="btn-cat" v-for="category in categories " :key="category.id" @click="getPostCategory(category.id)">{{category.name}}</button>

**\_**-

==============================
28 GIUGNO

AGGIUNTA NOME DI CHI HA FATTO POST
(NUOVA ONE TO MANY)

-nel post controller API modifico la chiamata api aggiungendo user
$posts = Post::with('category' , 'tags', 'user' )->paginate(10);

-Bisogna creare la relazione tra User e Post all'interno dei modelli
sara' una relazione ONE TO MANY , un user tanti post

Nel model Post scrivo:
public function user(){
return $this->belongsTo(User::class);  
 }
Nel model User scrivo:
public function posts (){
return $this->hasMany(Post::class);
}

-Vado in itemPost

e stampo il name
<i>by {{ post.user.name }}<

---

VOGLIO UN UNICA CHIAMATA NEL POSTCONTROLLER
anziche tante api una per i tags una per le categorie

public function index(){
//aggiungo user prendere l'user
$posts = Post::with('category' , 'tags', 'user' )->paginate(10);
//voglio mettere tutto dentro index per fare una sola chiamata api
$categories = Category::all();
$tags = Tag::all();

    return response()->json(compact('posts', 'categories' , 'tags'));

lo stesso in get getPostsByCategory($id

public function getPostsByCategory($id){
$posts = Post::where('category_id', $id)->with('category', 'tags' , 'user')->paginate(10);
$categories = Category::all();
$tags = Tag::all();

    return response()->json(compact('posts', 'categories' , 'tags'));

di conseguenza nel blog vue cambiera axios

inserendo .post

methods: {
getApi(endpoint) {
axios.get(endpoint)
.then(results => {
this.posts = results.data.posts.data;
this.links = results.data.posts.links;
this.first_page_url = results.data.posts.first_page_url;
this.last_page_url = results.data.posts.last_page_url;
this.current_page = results.data.posts.current_page;
this.last_page = results.data.posts.last_page;
this.categories = results.data.categories;
this.tags = results.data.tags;
});

========

Voglio che cliccando sui tag succede la stessa cosa delle catageroie ovvero vedo tutti i post con le categorie
metto il click nel bottone
click="getPostsTag(tag.id)

mi scrivo la funzione

getPostsTag(id) {
this.getApi(store.apiUrl + 'posts/post-tag/' + id)
}

=== devo aggiungere la rotta in API.PHP

        Route::get('/post-tag/{id}', [PostController::class, 'getPostsByTag']);

==infine vado in api postcontroller e la facccio
ci sono due modi

METODO 1 PIU MACCHINO MA PIU LOGICO

public function getPostsByTag($id){
//metodo 1 piu facile ma meno bello,
//prendo il tag con tutti post ad esso relazionati
$tag = Tag::where('id', $id)->with('posts')->first();

    //creo un array vuoto da esportare
    $post = [];

    // ciclo i post del tag
    foreach ($tag->posts as $post) {
        //popolo l'array, prendo ogni post con le sue relazioni e lo pusho in $post
    $post[] = Post::where('id', $post->id)->with('category', 'tags' , 'user')->first();
    }
    $categories = Category::all();

$tags = Tag::all();

    //infine stampo l'array
    return response()->json(compact('posts', 'categories' , 'tags'));

}

METODO 2
query many to many con filtro

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

# }

====LOADING
//imposto il loaded come falso
ata() {
return {
posts: [],
links: [],
first_page_url: null,
last_page_url: null,
current_page: null,
last_page: null,
categories: [],
tags: [],
//imposto il loaded come falso
loaded: false
};

methods: {
getApi(endpoint) {
this.loaded = false;

            axios.get(endpoint)
                .then(results => {
                    this.posts = results.data.posts.data;
                    this.links = results.data.posts.links;
                    this.first_page_url = results.data.posts.first_page_url;
                    this.last_page_url = results.data.posts.last_page_url;
                    this.current_page = results.data.posts.current_page;
                    this.last_page = results.data.posts.last_page;
                    this.categories = results.data.categories;
                    this.tags = results.data.tags;
                    //qua il loading diventa true alla fine di tutte le chiamate
                    this.loaded = true;
                });
        },

infine lo metto in pagina

        <Loader v-if="!loaded" />

        <div v-else class="page-wrapper">

====BOTTONE RESET

DEVE CHIAMARE LA FUNZIONE AL MOUNTED CHE DA TUTTI I RIOSULTATI SENZXA FILTRO
metto all end point un default

methods: {
//do il deault all'endpoint e lo tolgo dal mounted
getApi(endpoint = store.apiUrl + 'posts') {
this.loaded = false;
poi nel bottone
<button class="btn-reset" @click="getApi()">RESET</button>

=====
DETTAGLIO POST
