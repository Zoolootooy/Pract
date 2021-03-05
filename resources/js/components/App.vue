<template>
<div class="my-container">
    <loading v-if="showLoading"></loading>

    <div class="menu"
         v-if="show !== 'search'">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation"
                    :ref="menuBurger">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
                <ul class="navbar-nav mr-auto mt-2">
                    <li class="nav-item mb-2">
                        <div class="btn btn-menu"
                             @click="routeHome">
                            Home
                        </div>
                    </li>
                    <li class="nav-item mb-2"  v-if="show !== 'favorites'">
                        <div class="btn btn-menu"
                             @click="routeFavorites">
                            Favorites list
                        </div>
                    </li>
                    <li class="nav-item mb-2" v-if="show !== 'results'">
                        <div class="btn btn-menu"
                            @click="submitForm">
                            Search results
                        </div>
                    </li>
                </ul>
                <div>
                    <input type="hidden"  name="_token" v-bind:value="csrf">
                    <div class="menu-searchForm">
                        <input
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
                </div>
            </div>
        </nav>
    </div>

    <div id="searchForm"  class="searchForm-container"
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

        <div class="favorite-container text-center">
            <div class="btn favorite"
                @click="routeFavorites">
                Favorites list
            </div>
        </div>
    </div>



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
                    )).catch(error =>  (
                        this.showLoading = false,
                        alert(error)
                    ));
                } else if(this.search === this.searchQuery) {
                    this.showLoading = true;
                    this.show = 'results';
                    this.showLoading = false;
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
                )).catch(error =>  (
                    this.showLoading = false,
                    alert(error)
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
    @media(max-width: 991px) {
        display: block;
        height: 0;
    }

    & nav {
        width: 90%;

        @media(max-width: 991px) {
            width: 100%;
        }
    }

    & li {
        margin-right: 3%;
        @media(max-width: 991px) {
            margin-right: 0;
        }
    }

}

.menu-searchForm {
    height: $searchFormHigh/2;
    display: flex;
    flex-direction: row;
    align-items: center;

    border-radius: $searchFormHigh/2;

    @media(max-width: 991px) {
        width: 100%;
        font-size: 24px;
    }
    &__field {
        width: 72.5%;
        height: $searchFormHigh/2;
        border-radius: $searchFormHigh/2 0 0 $searchFormHigh/2;
        margin-left: 2.5%;
        padding-left: 3%;
        border: 0;
        @media(max-width: 991px) {
            margin-left: 0;
        }
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

        @media(max-width: 991px) {
            width: 27.5%;
            font-size: 24px;
        }

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
    width: 130px;
    justify-content: center;
    @media(max-width: 991px) {
        width: 100%;
        border-radius: $searchFormHigh/2;
        justify-content: center;
        font-size: 24px;
    }
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

    @media(max-width: 767px) {
        height: $searchFormHigh*2.5;
    }

    @media(max-width: 575px) {
        margin-left: 2%;
        margin-right: 2%;
    }

    &__field {
        width: 72.5%;
        height:  $searchFormHigh*0.45;
        border-radius: $searchFormHigh/2 0 0 $searchFormHigh/2;
        margin-left: 2.5%;
        padding-left: 3%;
        border: 0;

        @media(max-width: 767px) {
            width: 90%;
            height:  $searchFormHigh*0.9;
            margin-left: 5%;
            margin-top: 5%;
            border-radius: $searchFormHigh/2 $searchFormHigh/2 $searchFormHigh/2 $searchFormHigh/2;
            font-size: 24px;
            text-align: center
        }

        @media(max-width: 575px) {
            font-size: 18px;
        }

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

        @media(max-width: 767px) {
            width: 90%;
            margin-left: 5%;
            margin-top: 5%;
            margin-bottom: 5%;
            height:  $searchFormHigh*0.9;
            border-radius: $searchFormHigh/2 $searchFormHigh/2 $searchFormHigh/2 $searchFormHigh/2;
        }

        @media(max-width: 575px) {
            font-size: 24px;
        }

        &:hover {
            background-color: #31475e;
        }
    }
}

.favorite-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: $searchFormHigh/4;

    @media(max-width: 767px) {
        width: 100%;
    }
}

.favorite {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 25%;
    height: $searchFormHigh/2;
    border-radius: $searchFormHigh/4;


    background-color: #325361;
    color: white;
    font-size: 24px;

    @media(max-width: 767px) {
        width: 95%;
    }

    &:hover {
        background-color: #31475e;
    }
}

.videos {
    position: relative;
    top: $searchFormHigh;

    @media(max-width: 767px) {
        top: $searchFormHigh/2;
    }
}
</style>
