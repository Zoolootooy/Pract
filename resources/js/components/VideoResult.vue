<template>
       <div class="video-result">
           <div class="video-result__preview"  v-bind:style="{'backgroundImage': 'url(' + video.preview + ')'}"></div>

           <div class="video-result__info">
               <div class="video-result__title">
                   <a v-bind:href="video.link">{{video.title}}</a>
               </div>
               <div class="video-result__publishedAt">
                   Published: {{format_date(video.published_at)}}
               </div>
               <div class="video-result__channel">
                   <a v-bind:href="video.channelLink">{{video.channel}}</a>
               </div>

               <div class="video-result__is-liked" v-if="video.favorite">In favorites</div>
           </div>

           <div class="video-result__mark">
               <div class="video-result__like js-video-like"
                    v-if="!video['favorite'] && !showLoading"
                    v-bind:title="addMessage"
                    @click="like">
                   <i class="fas fa-thumbs-up"></i>
               </div>

               <div v-if="showLoading">
               </div>

               <div class="video-result__dislike js-video-dislike"
                    v-if="video['favorite'] && !showLoading"
                    v-bind:title="deleteMessage"
                    @click="dislike">
                   <i class="fas fa-thumbs-down"></i>
               </div>
           </div>
       </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import {HourGlass} from 'vue-loading-spinner';
export default {
    props: ['video'],
    name: 'SearchResult',
    data() {
        return {
            searchResult: '',
            showLoading: false,
            deleteMessage: 'Delete from favorites',
            addMessage: 'Add to favorites'
        }
    },
    components: {
        HourGlass
    },
    methods: {
        format_date(value){
            if (value) {
                return moment(String(value)).format('DD.MM.YYYY')
            }
        },

        like() {
            this.showLoading = true;
            const axios = require('axios').default;
            axios.post('/like', {
                'id': this.video.id,
                'like': 1
            }).then(responce => (
                this.video.favorite = 1,
                this.showLoading = false
            ));
        },

        dislike(){
            this.showLoading = true;
            const axios = require('axios').default;
            axios.post('/like', {
                'id': this.video.id,
                'like': 0
            }).then(responce => (
                this.video.favorite = 0,
                this.showLoading = false
            ));
        }
    },
    mounted () {
    }
}
</script>

<style scoped lang="scss">
$videoResultHigh: 200px;
.video-result {
    display: flex;
    flex-direction: row;
    align-items: center;
    margin-top: 2%;
    margin-bottom: 2%;

    height: $videoResultHigh;
    background-color: #3fb984;
    border-radius: $videoResultHigh/2;

    @media(max-width: 767px) {
        flex-direction: column;
        height: $videoResultHigh*2.5;
        margin-top: 8%;
        margin-bottom: 8%;
    }

    &__preview {
        width: 40%;
        height: $videoResultHigh;
        border-radius:  $videoResultHigh/2 0 0 $videoResultHigh/2;
        background-position: center;

        @media(max-width: 767px) {
            width: 100%;
            height: $videoResultHigh*5;
            border-radius:  $videoResultHigh/2 $videoResultHigh/2 0 0;
        }
    }


    &__info {
        width: 60%;
        padding: 2.5%;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        height: 100%;

        @media(max-width: 767px) {
            width: 100%;
        }
    }

    &__publishedAt {
        color:#325361;
    }

    &__title a, &__channel a, &__is-liked {
        color: white;
    }

    &__title {
        @media(max-width: 767px) {
            text-align: justify;
        }

        a {
            font-size: 20px;
        }
    }


    &__channel a {
        font-size: 14px;
    }

    &__mark {
        display: flex;
        justify-content: center;
        align-items: center;
        width: $videoResultHigh/2 !important;
        max-width: $videoResultHigh/2 !important;
        height: 100%;

        border-radius:  0 $videoResultHigh/2 $videoResultHigh/2 0;

        background-color: #31475e;

        @media(max-width: 767px) {
            width: 100% !important;
            max-width: 100% !important;
            border-radius:  0 0 $videoResultHigh/2 $videoResultHigh/2;
        }
    }
    &__like:hover, &__dislike:hover {
        background-color: #31475e;
        cursor: pointer
    }

    &__like, &__dislike{
        display: flex;
        justify-content: center;
        align-items: center;

        width: 100%;
        height: 100%;

        border-radius:  0 $videoResultHigh/2 $videoResultHigh/2 0;

        background-color: #325361;
        color: white;

        font-size: 32px;

        @media(max-width: 767px) {
            width: 100% !important;
            max-width: 100% !important;
            border-radius:  0 0 $videoResultHigh/2 $videoResultHigh/2;
        }
    }

}
</style>
