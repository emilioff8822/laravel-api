
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
        },
        //faccio una computed che qualora non ci sia una categoria  ci restituisce -no category-
        category() {
            if (!this.post.category) return '-no category';
            return `<span class="badge badge-category">${this.post.category.name} </span>`

        }
    }

}
</script>


<template>
    <div>

        <h3><router-link :to="{name: 'postDetail', params:{slug: post.slug}}">Titolo Post: {{ post.title }}</router-link></h3>

        <p class="date"> <strong>Scritto il giorno:</strong> {{ formattedData }} <i>by {{ post.user.name }}</i></p>
        <p v-html="category"></p>
        <ul>
            <li class="badge badge-tag" v-for="tag in post.tags" :key="tag.id">{{ tag.name }}</li>
        </ul>
    </div>



</template>

<style lang="scss" scoped>
div{
    border-bottom: 1px solid black;
    margin-bottom: 20px;
    p{
        margin: 10px 0;
    }
    .date{
        font-size: .9rem;
        font-style: italic;
    }
}

ul{
    display: flex;
    list-style: none;
    margin-bottom: 10px;
    li{
        margin-right: 10px;
    }
}

</style>
