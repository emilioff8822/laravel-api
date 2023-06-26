<script>
import { store } from './store/store.js';
import axios from 'axios';

export default {
    name: 'home',
    data() {
        return {
            posts: [],
            links: [],
            first_page_url:null,
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
    <div class="container">
        <h1>Elenco Post</h1>

        <ul>
            <li v-for="post in posts" :key="post.id">
                <span>{{ post.title }}</span> - <span>{{ formatData(post.date) }}</span>
            </li>
        </ul>

        <div>
            <button @click="getApi(first_page_url)" :disabled="current_page == 1">Inizio</button>
            <button v-for="(link,index) in links" key="index" v-html="link.label" @click="getApi(link.url)" :disabled="link.active || !link.url"></button>
            <button @click="getApi(last_page_url)" :disabled="current_page == last_page">Fine</button>

        </div>

    </div>
</template>


<style lang="scss" scoped>

button{
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    margin-right: 3px;
}


</style>
