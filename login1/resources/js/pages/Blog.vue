<script>
import { store } from '../store/store';
import axios from 'axios';
import ItemPost from '../components/ItemPost.vue';
import Loader from '../components/Loader.vue';
import FormSearch from '../components/FormSearch.vue';

export default {
    name: 'Contacts',
    components: {
        ItemPost,
        Loader,
        FormSearch
    },
    data() {
        return {
            links: [],
            first_page_url: null,
            last_page_url: null,
            current_page: null,
            last_page: null,
            categories: [],
            tags: [],
            //imposto il loaded come falso
            loaded: false,
            store
        };
    },
    methods: {
        //do il deault all'endpoint e lo tolgo dal mounted
        getApi(endpoint = store.apiUrl + 'posts') {
            this.loaded = false;

            axios.get(endpoint)
                .then(results => {
                    store.posts = results.data.posts.data;
                    this.links = results.data.posts.links;
                    this.first_page_url = results.data.posts.first_page_url;
                    this.last_page_url = results.data.posts.last_page_url;
                    this.current_page = results.data.posts.current_page;
                    this.last_page = results.data.posts.last_page;
                    this.categories = results.data.categories;
                    this.tags = results.data.tags;
                    //qua il loading diventa true alla fine di tutte le chiamate
                    this.loaded = true;
                });
        },
        //siccome ho fatto un unca chiamata posso eliminare tags e categories

        // nei methods aggiungo getcategories dell;' API -PostController, l'apiurl e' store.js e gli concateno categories

        //getCategories() {
           // axios.get(store.apiUrl + 'posts/categories')
                //.then(result => {
                    //this.categories = result.data;
         //  })

       // },
//
        // getTags() {
          //  axios.get(store.apiUrl + 'posts/tags')
                //.then(result => {
             //       this.tags = result.data;
              //  })

       // },


// metodo per l'ora
        formatData(dateString) {
            const d = new Date(dateString);
            return d.toLocaleDateString();
        },

        //metto il metodo per il click sulle categorie per visualizzare tutti i post con quelle categories

        getPostsCategory(id) {
        this.getApi(store.apiUrl + 'posts/post-category/' +id)
        },

          getPostsTag(id) {
        this.getApi(store.apiUrl + 'posts/post-tag/' + id)
        }


    },
    mounted() {
        this.getApi();
        //non servono perche per tag e categories ho fatto un unica chiamata
        //this.getCategories();
        //this.getTags();
    }
}
</script>

<template>
    <div class="container-inner">

        <FormSearch />

        <h1>Blog</h1>


        <Loader v-if="!loaded" />

        <div v-else class="page-wrapper">
            <div class="left">
                <ItemPost v-for="post in store.posts" :key="post.id" :post="post" />

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
                <div>
                 <h2>Categorie</h2>
                <button class="btn-cat" v-for="category in categories " :key="category.id" @click="getPostsCategory(category.id)">{{ category.name }}</button>

                </div>
                <div>
                <h2>Tags</h2>
                <button class="btn-cat" v-for="tag in tags " :key="tag.id" @click="getPostsTag(tag.id)">{{ tag.name }}</button>

                </div>

                <div>
                    <button class="btn-reset" @click="getApi()">RESET</button>
                </div>





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
    div{
        margin-bottom: 20px;
    }

    }
    .btn-reset{
     background-color: rgb(15, 128, 194);
     color: white;
    font-size: bold;
    cursor: pointer;
    &:hover{
    background-color: blue;

    color: yellow;
    }

    }

}

.btn-cat{
    margin: 10px;
    cursor: pointer;
}

</style>
