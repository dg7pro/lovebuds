@extends('layouts.app')

@section('page_css')

@endsection

@section('content')

    <section class="main">
        <h3 class="text-blue">
            Add User to group
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
                        <li class="breadcrumb-item active"><a href="{{'/profile/'.$user->pid}}" target="_blank">{{$user->pid}}</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('layouts.partials.alert')

        <div>
            <h4>{{$user->id.' '.$user->first_name.' '.$user->last_name}}</h4>
            <form action="{{'/group/add-user'}}" method="POST">

                <input type="hidden" name="user_id" value="{{$user->id}}">
                @foreach($groups as $group)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="group_list[]" value="{{$group->id}}" id="defaultCheck{{$group->id}}" {{ in_array($group->id,$f)?'checked':' ' }}>
                        <label class="form-check-label" for="defaultCheck{{$group->id}}">
                            {{$group->title}}
                        </label>
                    </div>
                @endforeach
                <button class="btn btn-blue mt-3" type="submit" id="basic-info-update" name="basic-info-update" value="submit">Add to checked groups</button>

            </form>
        </div>

    </section>

@endsection
