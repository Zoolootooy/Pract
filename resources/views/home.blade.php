@extends('layouts.app ')

@section('content')


<div class="content" id="app">
    <search-form csrf="{{csrf_token()}}"></search-form>
</div>
@endsection
