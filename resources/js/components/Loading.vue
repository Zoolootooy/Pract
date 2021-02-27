<template lang="pug">
   <div class="container">
        <circle2></circle2>
   </div>
</template>

<script>
    import {Circle2} from 'vue-loading-spinner';

    export default {
        name: 'Loading',
        components: {
            Circle2
        },
    }
</script>

<style scoped>
.container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    max-width: 100% !important;
    background-color: white;
    opacity: 0.8;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
