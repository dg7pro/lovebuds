@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Site Settings        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="table-responsive" id="dynamic_content">
            <label>Admin needs to twik it with care</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>setting</th>
                    <th>Value</th>
                    <th>action</th>
                </tr>
                @foreach($settings as $setting)
                <tr>
                    <td>{{$setting['id']}}</td>
                    {{--<td><span id="ic">{{$del_images ? count($del_images) : 0}}</span> unlinked images</td>--}}
                   {{-- <td><span id="ic">{{$del_images}}</span> unlinked images</td>--}}
                    <td> {{$setting['parameter']}}</td>
                    <td> {{$setting['value']?'On':'Off'}}</td>
                    <td>
                        {{--<i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>
                        <a href="" class="text-danger" onclick="delUnlinkedIMages(event)"> Delete permanently</a>--}}
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input admin-switch"  {{$setting['value']? 'checked':''}} data-id="{{$setting['id']}}" id="customSwitch{{$setting['id']}}">
                            <label class="custom-control-label" for="customSwitch{{$setting['id']}}">Toggle the switch </label>
                        </div>
                    </td>

                </tr>
                @endforeach
                {{-- {{$setting['value']? 'checked':''}}--}}
            </table>
        </div>

    </section>
    <!-- users section ends -->
@endsection

@section('js')

    <script>
        $(document).ready(function () {

            $('.admin-switch').change(function() {

                var setId = $(this).data('id');
                //var setVa = $(this).val();
                var setVa = $(this).prop('checked');
                alert($(this).prop('checked'));

                console.log(setId);
                console.log(setVa);
                //console.log($(this).prop('checked'));

                $.ajax({
                    url: "/adjax/manageAdminSettings",
                    method: 'post',
                    data: {
                        setId:setId,
                        setVa:setVa     // when you pass boolean through post it will get converted to string
                    },
                    dataType: "json",
                    success: function (data, status) {
                        console.log(status);
                        console.log(data);

                    }
                });

            });

        });


       /* $('#customSwitch1').change(function() {
            alert($(this).prop('checked'));
            console.log($(this).prop('checked'));
        })
        */
    </script>

@endsection

