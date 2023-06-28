//importo il router
import { createRouter, createWebHistory } from "vue-router";

//importo le pagine che ho creato home, contacts, erro404 ecc..

import Home from './pages/Home.vue';
import Contacts from './pages/Contacts.vue';
import About from './pages/About.vue';
import Error404 from './pages/Error404.vue';
import Blog from './pages/Blog.vue';
import PostDetail from './pages/PostDetail.vue';

//inizializzo una variabile che chiamo route
const router = createRouter({
    history: createWebHistory(),
    //aggiungo una classe per i colori del click al router
    linkExactActiveClass: 'active',



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
            name: 'contacts',
            component: Contacts
        },
          //questa e' la rotta about
         {
            path: '/about',
            name: 'about',
            component: About
        },

          //questa e' la rotta blog
         {
            path: '/blog',
            name: 'blog',
            component: Blog
        },
         {
            path: '/dettaglio-post/:slug',
            name: 'postDetail',
            component: PostDetail
        },

        //rotta 404 da mettere infondo
        {
            path: '/:pathMatch(.*)*',
            component: Error404


        }


    ]


 })

export {router}

//alla fine e' tutto confenzionato ma biosgna importarlo nel nostro progetto vue
//lo devo importare nel javascrip principale nel mio caso AppGuest.js
