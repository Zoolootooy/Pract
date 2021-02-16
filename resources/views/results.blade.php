@extends('layouts.app ')

@section('content')
        <table border="1">

            <h3>По запросу "@if(isset($search->query)){{$search->query}} @elseif(isset($search)){{$search}}@endif"</h3>
            @foreach($videos as $video)
            <tr>
                <td>
                    <img src="{{ $video['preview'] }}" class="video__prev" style="max-width: 240px">
                </td>
                <td>
                   <div class="video">
                       <div class="video__title">
                           <a href="{{ $video['link'] }}">{{  $video['title'] }}</a>
                       </div>
                       <div class="video__channel">
                           <a href="{{ $video->channel['link'] }}">{{ $video->channel['name'] }}</a>
                       </div>

                       <div class="video__like" @if($video->favorite) hidden  @endif>
                           <button type="button" class="btn btn-primary js-video-like" video-id="{{ $video->id }}">Добавить в любимое</button>
                       </div>

                       <div class="video__dislike" @if(!$video->favorite) hidden  @endif>
                           <button type="button" class="btn btn-primary js-video-dislike" video-id="{{ $video->id }}">Удалить из любимого</button>
                       </div>

                       <div class="video__is-liked" @if(!$video->favorite) hidden @endif>В любимых</div>
                   </div>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $videos->links() }}
@endsection
