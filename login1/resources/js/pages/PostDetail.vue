<script>
import axios from 'axios';
import { store } from '../store/store';
import Loader from '../components/Loader.vue';

export default {
    name: 'PostDetail',
    components: {
    Loader

    },

    data() {
        return {
            post: null,
            loaded:false
        }
    },

   methods: {
       getApi() {
           this.loaded=false;
            axios.get(store.apiUrl + 'posts/' + this.$route.params.slug)
                .then(result => {
                    this.post = result.data;
                    this.loaded = true;
                });
        }
    },
    mounted() {
        this.getApi();
    },
}
</script>



<template>
    <div class="container-inner">
        <div v-if="loaded">
            <h1>Titolo Post {{ post.title }}</h1>
        </div>
        <Loader v-else />




</div></template>

<style></style>
