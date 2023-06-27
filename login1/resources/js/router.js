//importo il router
import { createRouter, createWebHistory } from "vue-router";

//importo le pagine che ho creato home, contacts, erro404 ecc..

import Home from './pages/Home.vue';
import Contacts from './pages/Contacts.vue';

//inizializzo una variabile che chiamo route
const route = createRouter({
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

