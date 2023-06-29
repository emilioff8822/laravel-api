<script>
import axios from 'axios';
import { store } from '../store/store.js';
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
         <div v-if="post">

            <p> <strong>Titolo Post:</strong></p> <p>{{ post.title }}</p>

        </div>
        <Loader v-else />


    </div>

</template>


<style lang="scss" scoped>

div{
    margin: 10px;
}
</style>
