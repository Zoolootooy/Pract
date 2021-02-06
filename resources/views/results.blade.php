@extends('layouts.app ')

@section('content')
        <table border="1">
            @foreach($searchResults as $row)
            <tr>
                <td>
                    <img src="{{ $row['preview'] }}" class="profile-img" style="max-width: 240px">
                </td>
                <td>
                   <div class="result">
                       <div class="result__title">
                           <a href="{{ $row['link'] }}">{{  $row['title'] }}</a>
                       </div>
                       <div class="result__channel">
                           <a href="{{ $row['channelLink'] }}">{{ $row['channel'] }}</a>
                       </div>
                   </div>
                </td>
            </tr>
            @endforeach
        </table>
@endsection
