@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Input Mobiles
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Input Numbers</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('layouts.partials.alert')

        <div>
            <form class="form" action="{{'/admin/save-person'}}" method="POST">
                @for($r=1;$r<=5;$r++)
                    <div class="flex-row form-group">
                        <input type="hidden"  name="contact[{{$r}}][sno]" value={{$r}}>
                        <div class="flex-field-2">
                            <input type="text"  name="contact[{{$r}}][name]" placeholder="{{$r.'. Person name'}} {{$i<=2?'*':''}}" {{$i<=2?'required':''}} value="Person">
                        </div>
                        <div class="flex-field-2">
                            <input type="text" name="contact[{{$r}}][mobile]" placeholder="mobile no. {{$i<=2?'*':''}} {{$i==1?'(10 digits)':''}}" {{$i<=2?'required':''}}>
                        </div>
                    </div>
                    <span hidden>{{$i++}}</span>
                @endfor
                <input type="submit" value="Submit contacts" name="add-numbers-submit" class="btn btn-green may-1">
            </form>
        </div>

    </section>
    <!-- users section ends -->





@endsection

@section('js')

@endsection
