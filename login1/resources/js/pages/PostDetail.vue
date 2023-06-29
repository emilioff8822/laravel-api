<script>
// Importazioni di librerie e componenti necessari
import axios from 'axios';
import { store } from '../store/store.js';
import Loader from '../components/Loader.vue';

export default {
    name: 'PostDetail',
    components: {
        // Registro il componente del Loader
        Loader
    },
    data() {
        return {
            // Inizializzo il post a null
            post: null,
            // Flag per il controllo dello stato di caricamento
            loaded: false
        }
    },
    methods: {
        getApi() {
            // Imposto il flag di caricamento a false
            this.loaded = false;
            // Eseguo la chiamata API per ottenere i dettagli del post
            axios.get(store.apiUrl + 'posts/' + this.$route.params.slug)
                .then(result => {
                    // Quando ottengo una risposta, aggiorno lo stato del post e del flag di caricamento
                    this.post = result.data;
                    this.loaded = true;
                });
        }
    },
    computed: {
        formattedData() {
            // Formatto la data in italiano
            const d = new Date(this.post.date);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            function getUserLocale() {
                // Ottengo la lingua dell'utente
                const userLocale = navigator.languages && navigator.languages.length
                    ? navigator.languages[0]
                    : navigator.language;
                return userLocale;
            }
            return d.toLocaleString(getUserLocale(), options);
        },
        category() {
            // Se non è presente una categoria, restituisco '-no category'
            if (!this.post.category) return '-no category';
            // Altrimenti, restituisco il nome della categoria
            return `<span class="badge badge-category">${this.post.category.name}</span>`;
        }
    },
    mounted() {
        // Quando il componente è montato, chiamo il metodo per ottenere i dati dal backend
        this.getApi();
    },
}
</script>



<template>
    <div class="container-inner">
         <div v-if="loaded">

            <p> <strong>Titolo Post:</strong></p> <p>{{ post.title }}</p>
            <i><strong>Scritto il giorno: </strong>{{formattedData}} <strong>da:</strong> {{ post.user.name }}</i>

            <div>
        <img :src="post.image_path" :alt="post.image_original_name">
        <i>{{ post.image_original_name }}</i>
           </div>

        </div>
        <Loader v-else />


    </div>

</template>


<style lang="scss" scoped>

div{
    margin: 10px;
}
</style>
