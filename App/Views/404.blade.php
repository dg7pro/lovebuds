@extends('layouts.app')

@section('content')

    <div class="main">
        <h3 class="text-red">
            404 Not Found Error
        </h3>
        <p class="baloo mt-3">{{$msg}}</p>
        <div class="buttons">
            @include('layouts.partials.revert')
        </div>
    </div>


@endsection

@section('js')
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
@endsection