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

INSTALLAZIONE

npm install vue-router@4 —force

ROUTER

-   creo in js un file che chiamo router.js

Creo all inter di js una cartella chiamata pages con dentro

Home.vue

Contacts.vue

Error404.vue

In laravel
Creo il router che assomiglia a web php ma in javascript

Lo creo in js e lo chiamo router.js
In router js

Import {createRouter, createWebHistory} from “vue=router”;
Import Home from ‘./pages/Home.vue’
Import Contacts from ‘./pages/Contacts.vue’
Import Erro404 from ‘./pages/Error404.vue’

Const route = createRouter({
History:createWebHistory (),
//metto le rotte che sono un array di oggetti
Routes:[
{
Path: ‘/‘,
name: ‘home‘,
component: ‘home‘,},

{
Path: ‘/contacts‘,
name: ‘contacts‘,
component: ‘home‘
}

// rotta per 404

{
path: '/:pathMatch(._)_',
component: Error404
}

]

})

Export {router}

Importo in appGuest il router (o main.js)

Importo {router} from “./router”;

CreateApp(app).use(router).mount(‘#app’)

-VADO IN WEB PHP E METTO LA ROTTA TRICK PER IL ROUTER DI VUE
Va aggiunto se abbiamo vue dentro laravel

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
