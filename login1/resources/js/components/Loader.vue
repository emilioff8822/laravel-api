<template>
    <div class="loader"></div>
</template>

<script>
export default {
    name: "Loader"
}
</script>

<style scoped lang="scss">
.loader {
    border: 16px solid #f3f3f3;
    /* Bordo grigio */
    border-top: 16px solid purple;
    /* Bordo superiore viola */
    border-radius: 50%;
    /* Forma circolare */
    width: 60px;
    /* Dimensione */
    height: 60px;
    animation: spin 2s linear infinite;
    /* Animazione */
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}</style>
