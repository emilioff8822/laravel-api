<script>
import { store } from './store/store.js';
import axios from 'axios';

export default {
    name: 'home',
    data() {
        return {
            posts: []
        };
    },
    methods: {
        getApi() {
            console.log(store.apiUrl);
            //faccio la chiamata axios
            axios.get(store.apiUrl + 'posts')
                .then(results => {
                    this.posts = results.data;
                    console.log(results.data);
                });
        },
        formatData(dateString) {
            const d = new Date(dateString);
            return d.toLocaleDateString();
        }
    },
    mounted() {
        this.getApi();
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

    </div>
</template>

<style></style>
