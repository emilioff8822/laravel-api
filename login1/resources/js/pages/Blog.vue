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
            last_page: null,
            categories:[]
        };
    },
    methods: {
        getApi(endpoint) {
            axios.get(endpoint)
                .then(results => {
                    this.posts = results.data.data;
                    this.links = results.data.links;
                    this.first_page_url = results.data.first_page_url;
                    this.last_page_url = results.data.last_page_url;
                    this.current_page = results.data.current_page;
                    this.last_page = results.data.last_page;
                });
        },

        // nei methods aggiungo getcategories dell;' API -PostController, l'apiurl e' store.js e gli concateno categories

        getCategories() {
            axios.get(store.apiUrl + 'posts/categories')
                .then(result => {
                    this.categories = result.data;
            })

        },



        formatData(dateString) {
            const d = new Date(dateString);
            return d.toLocaleDateString();
        }
    },
    mounted() {
        this.getApi(store.apiUrl + 'posts');
        this.getCategories();
    }
}
</script>

<template>
    <div class="container-inner">
        <h1>Blog</h1>

        <div class="page-wrapper">
            <div class="left">
                <ItemPost v-for="post in posts" :key="post.id" :post="post" />

                <button @click="getApi(first_page_url)" :disabled="current_page == 1">
                    Inizio
                </button>

                <button v-for="(link, index) in links" :key="index" v-html="link.label" @click="getApi(link.url)"
                    :disabled="link.active || !link.url" />

                <button @click="getApi(last_page_url)" :disabled="current_page == last_page">
                    Fine
                </button>
            </div>

            <div class="right">
            <h2>Categorie</h2>
            <button v-for="category in categories " :key="category.id">{{category.name}}</button>

        </div>

        </div>


    </div>

</template>

<style lang="scss" scoped>
.page-wrapper{
    display: flex;
    .left{
        width: 100%;
    }
    .right{
    border-left: 1px solid black ;
    padding: 0  30px;
    }
}

</style>
