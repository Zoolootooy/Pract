<template>
<div class="my-container">
    <loading v-if="showLoading"></loading>

    <div class="menu"
         v-if="show !== 'search'">
        <div class="btn btn-menu"
                @click="routeHome">
            Home
        </div>


        <div class="btn btn-menu"
                v-if="show !== 'results'"
                @click="submitForm">
            Search results
        </div>

        <div class="btn btn-menu"
                v-if="show !== 'favorites'"
                @click="routeFavorites">
            Favorites list
        </div>

        <form class="searchForm-container">
            <input type="hidden"  name="_token" v-bind:value="csrf">
            <div class="row menu-searchForm">
                <input id=""
                       class=" shadow-sm menu-searchForm__field"
                       v-model='search'
                       type="text"
                       autocomplete="on"
                       placeholder="Enter your search term">

                <div class="btn menu-searchForm__button"
                     @click="submitForm">
                    <i class="fas fa-search mr-3"></i>
                </div>
            </div>
        </form>
    </div>

    <form id="searchForm"  class="searchForm-container"
          v-if="show === 'search'">
        <input type="hidden"  name="_token" v-bind:value="csrf">
        <div class="row searchForm">
                <input id="searchTerm"
                       class=" shadow-sm searchForm__field"
                       v-model='search'
                       type="text"
                       autocomplete="off"
                       placeholder="Enter your search term">

                <div class="btn searchForm__button"
                    @click="submitForm">
                        <i class="fas fa-search mr-3"></i>
                        Search
                </div>
        </div>
    </form>



    <div  v-if="show === 'results'" class="videos">
        <video-result  v-for="video in videos" :key="video.id" :video="video"></video-result>
    </div>

    <div v-if="show === 'favorites'" class="videos">
        <video-result  v-for="video in videos" :key="video.id" :video="video"></video-result>
    </div>


</div>
</template>

<script>
    import VideoResult from './VideoResult.vue';
    import Loading from './Loading.vue';
    import axios from "axios";


    export default {
        props: ['csrf'],
        name: 'App',
        data() {
            return {
                show: 'search',
                showLoading: false,
                searchQuery: '',
                videos: [],
                search: '',
            }
        },
        components: {
            VideoResult,
            Loading
        },
        methods: {
            submitForm() {
                if ((this.search !== '') && (this.search !== this.searchQuery)) {
                    const axios = require('axios').default;
                    this.showLoading = true;
                    axios({
                        method: 'post',
                        url: '/search',
                        data: {
                            'search': this.search
                        }
                    })
                    .then(response => (
                        this.videos = response.data['videos'],
                            this.searchQuery = response.data['search'],
                            this.show = 'results',
                            this.showLoading = false
                    ));
                }
            },

            routeHome() {
                this.showLoading = true;
                this.show = 'search';
                this.showLoading = false;
            },


            routeFavorites() {
                const axios = require('axios').default;
                this.showLoading = true;
                axios({
                    method: 'get',
                    url: '/favorites',
                })
                .then(response => (
                    this.videos = response.data['videos'],
                        this.searchQuery = response.data['search'],
                        this.show = 'favorites',
                        this.showLoading = false
                ));
            }
        }
    }
</script>

<style scoped lang="scss">
$searchFormHigh: 100px;


.menu {
    width: 100%;
    height: $searchFormHigh;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;

    position: fixed;
    top:0;
    left: 0;
    z-index: 9000;

    background-color: #f8fafc;
}

.menu-searchForm {
    height: $searchFormHigh/2;
    display: flex;
    flex-direction: row;
    align-items: center;

    border-radius: $searchFormHigh/2;

    &__field {
        width: 72.5%;
        height: $searchFormHigh/2;
        border-radius: $searchFormHigh/2 0 0 $searchFormHigh/2;
        margin-left: 2.5%;
        padding-left: 3%;
        border: 0;
        &:focus {
            outline: none;
        }

        &::placeholder {
            color: #325361;
        }
    }

    &__button {
        background-color: #325361;
        color: white;
        width: 25%;
        height: $searchFormHigh/2;
        border-radius: 0 $searchFormHigh/2 $searchFormHigh/2 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 14px;

        &:hover {
            background-color: #31475e;
        }
    }
}


.btn-menu {
    background-color: #325361;
    color: white;
    display: flex;
    height: $searchFormHigh/2;
    align-items: center;

    &:hover {
        background-color: #31475e;
    }
}

.searchQuery {
    background-color: #325361;
    color: white;
    display: flex;
    align-items: center;

    font-size: 32px;
    border-radius: 0.25rem;
    padding-left: 12px;
    padding-right: 12px;
    padding-top: 6px;
    padding-bottom: 6px;
}


.searchForm-container {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.searchForm {
    height: $searchFormHigh;
    display: flex;
    flex-direction: row;
    align-items: center;

    background-color: #3fb984;
    border-radius: $searchFormHigh/2;

    &__field {
        width: 72.5%;
        height:  $searchFormHigh*0.45;
        border-radius: $searchFormHigh/2 0 0 $searchFormHigh/2;
        margin-left: 2.5%;
        padding-left: 3%;
        border: 0;
        &:focus {
            outline: none;
        }

        &::placeholder {
            color: #325361;
        }
    }

    &__button {
        background-color: #325361;
        color: white;
        width: 25%;
        height: 100%;
        border-radius: 0 $searchFormHigh/2 $searchFormHigh/2 0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;

        &:hover {
            background-color: #31475e;
        }
    }
}


.videos {
    position: relative;
    top: $searchFormHigh;
}
</style>
