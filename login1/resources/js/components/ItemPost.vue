
<script>
export default {
    name: 'ItemPost',
    props: {
    post: Object
    },
    //utilizzo una computed per avere la data in italiano
    computed: {
        formattedData() {
            const d = new Date(this.post.date);
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            //funzione stefano sigla data
            function getUserLocale() {
                const userLocale = navigator.languages && navigator.languages.length
                    ? navigator.languages[0]
                    : navigator.language;
                return userLocale;
            }

            return d.toLocaleString(getUserLocale(), options);
    }
    }

}
</script>


<template>
    <div>
        <h3> Titolo: {{post.title}}</h3>
        <h3>{{ formattedData }}</h3>
        <h3>Categoria</h3>
        <h3>Tag</h3>
    </div>



</template>

<style lang="scss" scoped>
div{
    border-bottom: 1px solid black;
    margin-bottom: 20px;
}

</style>
