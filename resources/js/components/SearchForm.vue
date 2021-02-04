<template>
    <form id="searchForm"  class="mt-5" @submit.prevent="submitForm">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <div class="row">
            <div class="col-8 offset-1 form-group">
                <input id="searchTerm" v-model='query' class="form-control shadow-sm" type="text" placeholder="Enter your search term">
            </div>

            <div class="col-2 text-right align-bottom">
                <button type="submit" class="btn btn-primary btn-block shadow-sm">Search</button>
            </div>
        </div>

    </form>
</template>

<script>
import axios from "axios";

export default {
    props: ['csrf', 'oldName'],
    name: 'SearchForm',
    data() {
        return {
            query: '',
        }
    },
    methods: {
        submitForm() {
            axios.post('/search', {
                query: this.query
            }).then(response => {
                this.response = JSON.stringify(response, null, 2)
            })
        }
    }
}
</script>

<style scoped>

</style>
