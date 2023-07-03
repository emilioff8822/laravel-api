<script>
//per comunicare con la api con il metodo POST importo axios

import axios from "axios";
import { store } from '../store/store';



export default {
    name: 'ContactForm',
    data() {
        //creo i data che saranno aggangiati con i v-model
        return {
            name: '',
            email: '',
            message: '',
            errors:{}
    }
    },
    methods: {
        //prende i data aggancaiti al v model li impacchetta e comunica con api
        sendForm() {
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
            }
            //metto il collegamento con axios per comunicare con l'api concatenandndo la nuova rotta contacts. primo parametro url secondo parametro oggetto
            axios.post(`${store.apiUrl}contacts`, data)
                .then(result => {
                    console.log(result.data);
                    if (result.data.success) {
                        this.errors = {};


                    } else {
                        this.errors = result.data.errors;
                    }

               })

    }
    },
}
</script>

<template>
    <form @submit.prevent="sendForm()">
        <div>
            <input :class="{'error-form' : errors.name}" v-model.trim="name" type="text"  placeholder="Nome">
        </div>

        <div>
            <input :class="{ 'error-form': errors.email }"  v-model.trim="email" type="email"   placeholder="E-mail">
        </div>

        <div>
            <textarea :class="{ 'error-form': errors.message }"  v-model.trim="message"  cols="30" rows="10"></textarea>
        </div>

        <button type="submit">Invia</button>
    </form>
</template>

<style lang="scss" scoped>
input,
textarea,
button {
    width: 100%;
    margin: 10px 0;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid lightslategray;
}
button{
    cursor: pointer;
}

.error-form{
        border: 1px solid red;

}
</style>
