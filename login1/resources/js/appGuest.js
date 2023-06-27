import { createApp } from "vue";
import App from './App.vue';

//importo il router.js
import { router } from "./router";

//dico a createapp di usare il router


createApp(App).use(router).mount('#app');
