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
            errors: {},
            sending: false,
            success:false
    }
    },
    methods: {
        //prende i data aggancaiti al v model li impacchetta e comunica con api
        sendForm() {
            this.sending = true;
            const data = {
                name: this.name,
                email: this.email,
                message: this.message,
            }
            //metto il collegamento con axios per comunicare con l'api concatenandndo la nuova rotta contacts. primo parametro url secondo parametro oggetto
            axios.post(`${store.apiUrl}contacts`, data)
                .then(result => {
                    this.sending = false;
                    console.log(result.data);
                    this.success = result.data.success;
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
    <form v-if="!success" @submit.prevent="sendForm()">
        <div>
            <input :class="{'error-form' : errors.name}" v-model.trim="name" type="text"  placeholder="Nome">
            <p v-for="(error,index) in errors.name" :key="index" class="error-msg">{{ error }}</p>
        </div>

        <div>
            <input :class="{ 'error-form': errors.email }"  v-model.trim="email" type="email"   placeholder="E-mail">
                <p v-for="(error, index) in errors.email" :key="index" class="error-msg">{{ error }}</p>

        </div>

        <div>
            <textarea :class="{ 'error-form': errors.message }"  v-model.trim="message"  cols="30" rows="10"></textarea>
            <p v-for="(error, index) in errors.message" :key="index" class="error-msg">{{ error }}</p>

        </div>

        <button type="submit" :disabled="sending">{{sending ? 'Invio in coso...' : 'Invia'}}</button>
    </form>

    <div v-else> <h2 class="success"> Form inviato correttamente</h2></div>
</template>

<style lang="scss" scoped>
input,
textarea,
button {
    width: 100%;
    margin-top: 10px;
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

.error-msg{
    color: red;
    font-size: .9rem;
}

.success{
    color: green;
}
</style>
