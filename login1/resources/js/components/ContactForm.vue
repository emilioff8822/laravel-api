<script>
export default {
    name: 'ContactForm',
    data() {
        //creo i data che saranno aggangiati con i v-model
        return {
            name: '',
            email: '',
            message: ''
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
            console.log(data);

    }
    },
}
</script>

<template>
    <form @submit.prevent="sendForm()">
        <div>
            <input v-model.trim="name" type="text" name="name" id="" placeholder="Nome">
        </div>

        <div>
            <input  v-model.trim="email" type="email" name="email" id="" placeholder="E-mail">
        </div>

        <div>
            <textarea  v-model.trim="message" name="message" id="" cols="30" rows="10"></textarea>
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
</style>
