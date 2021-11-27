@extends('layouts.app')

@section('page_css')

@endsection

@section('content')

    <!-- userprofile (up) section starts -->
    <section class="main">
        @include('layouts.partials.alert')

        <h2 class="large text-heading">Create Group</h2>

        <p>Create new group for your caste</p>

        <form action="{{'/group/save'}}" class="form" method="post" autocomplete="off">

            <div>
                <input type="hidden" name="token" value="{{$_SESSION['csrf_token']}}" />
            </div>

            <div class="form-group inputWithIcon">
                <label for="group-title">Group name:</label>
                <input type="text" id="group-title" name="title" required autocomplete="off">
            </div>

            <div class="form-group inputWithIcon">
                <label for="group-desc">Description:</label>
                <textarea id="group-desc" name="description" required autocomplete="off"></textarea>
            </div>

            <input type="submit" value="Create Group" class="btn btn-green">
        </form>


    </section>
    <!-- profiles section ends -->



@endsection

@section('js')

@endsection