@extends('layouts.app ')

@section('content')


<div class="content" id="app">
{{--    <search-form csrf="{{csrf_token()}}"></search-form>--}}
</div>
<form id="searchForm" method="POST" action="{{route('search.store')}}"  class="mt-5">
    @csrf
    <div class="row">
        <div class="col-8 offset-1 form-group">
            <input id="searchTerm" name="search" class="form-control shadow-sm" type="text" placeholder="Enter your search term">
        </div>

        <div class="col-2 text-right align-bottom">
            <button type="submit" class="btn btn-primary btn-block shadow-sm">Search</button>
        </div>
    </div>

</form>
@endsection
