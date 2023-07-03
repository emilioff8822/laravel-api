
<script>
import axios from 'axios';
import { store } from '../store/store.js';


export default {
    name: 'FormSearch',
    data() {
        return {
        tosearch: ''
    }
    },
  methods: {
        getApi() {
            axios.get(store.apiUrl + 'posts/search/' + this.tosearch)
                .then(response => {
                    store.posts = response.data.posts.data;
                    this.tosearch = '';
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }


}
</script>

<template>
    <input type="text" name="" id="" placeholder="Cerca" v-model.trim="tosearch"  @keyup.enter="getApi()">
    <button @click="getApi()"> Invia</button>

</template>



<style lang="scss" scoped>

input, button {
    padding: 10px;
    border-radius: 10px;
    margin-right: 20px;
    margin-bottom: 20px;
}

button{
    border: none;
    cursor: pointer;
    &:hover{
    background-color: blue;
    color: orange;
    }
}

</style>
