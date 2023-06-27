
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
    <div class="container-inner">
        <h1>Blog</h1>

        <div>
    <ItemPost v-for="post in posts" :key="post.id" :post="post"/>

        </div>



    </div>
</template>

<style>

</style>
