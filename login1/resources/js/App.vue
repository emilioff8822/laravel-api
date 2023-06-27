
<script>
//importo l'header
import Header from './components/Header.vue';

export default {
    name: 'App',
 //importo l'header nei componenti , infine lo metto nel template
    components: {
        Header
    }


}
</script>


<template>
<Header />


 <router-view></router-view>


</template>

<style>

</style>
