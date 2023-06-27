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

In app vue importo header

Import header from./components

Export default {

Name:App
Components :{
Header
}

---

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

-vado nel router e importo import blog ‘./pages/blog.vue’
E lo metto anche. Nei router link dell header vue

Nel blog devo fare la chiamata API
Import store. ../store/store
Import axios
Import Itempost

Components :{

}

Prendo tutti data

Creo item post.vue che avrà il dettaglio del post

-   per scrivere nelle card uso le props in itempostvue

props{
Post : object

}

Template

V-for post in posts

In itempost vue script uso una computed

function getUserLocale(){
const userLocale = navigator.languages && navigator.languages.length
? navigator.languages[0]
: navigator.language;
return userLocale;
}

Per stampare i tag facciamo una computed category(){

if(!this.post.category) return no category

Return `<span>`$

Per stampare tag e categorie vado nel progetto di laravel
