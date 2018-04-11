@extends('layouts.default')

@section('content')
    <div class="container">

        <br/>

        <h1 class="text-center">{{ $pageTitle  }}</h1>

        <div id="recipes-json">
            <pre>{{ print_r( $jsonData) }}</pre>

        </div>

@if($recipes)
    @foreach($recipes as $recipe)
        <div class="row">
            <div class="col-md-2">

            </div>
            <div class="col-md-10">
                <h3><a>{{ $recipe['recipe_name'] }}</a></h3>
                <h4>{{ $recipe['description'] }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-push-2">
                <ul class="list-inline">
                    <li>{{ $recipe['cooking_time'] }}</li>
                </ul>
            </div>

        </div>
     @endforeach
@else
            <div class="alert alert-info text-center"><h3>No recipes</h3></div>
@endif

    </div>
@endsection
