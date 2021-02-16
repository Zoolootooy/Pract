$(function () {
    $(document).on('click', '.js-video-like', function () {
        const axios = require('axios').default
        let video =  $(this).closest('.video'),
            isLiked = video.find('.video__is-liked'),
            like = video.find('.video__like'),
            dislike = video.find('.video__dislike');
        let id = $(this).attr('video-id')

        axios.post('/like', {
            'id': id,
            'like': 1
        }).then(function (response){
            if(response) {
                console.log(response)
                isLiked.attr('hidden', false)
                like.attr('hidden', true)
                dislike.attr('hidden', false)
            }
        })
    })

    $(document).on('click', '.js-video-dislike', function () {
        const axios = require('axios').default
        let video =  $(this).closest('.video'),
            isLiked = video.find('.video__is-liked'),
            like = video.find('.video__like'),
            dislike = video.find('.video__dislike');
        let id = $(this).attr('video-id')

        axios.post('/like', {
            'id': id,
            'like': 0
        }).then(function (response){
            if(response) {
                console.log(response)
                isLiked.attr('hidden', true)
                like.attr('hidden', false)
                dislike.attr('hidden', true)
            }
        })
    })
})
