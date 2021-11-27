@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Orders List
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Orders List</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{--<div id="user_type_div">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="all_user" name="user_type" value="all" class="custom-control-input user-type" checked required>
                <label class="custom-control-label" for="all_user">All</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="blocked" name="user_type" value="blocked" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="blocked">Blocked</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="un_verified" name="user_type" value="unverified" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="un_verified">Unverified</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="un_paid" name="user_type" value="unpaid" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="un_paid">Unpaid</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="un_active" name="user_type" value="inactive" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="un_active">Inactive</label>
            </div>
        </div>--}}
        <div class="form-group">
            <input type="text" id="search_box" name="search_box" class="form-control"
                   placeholder="Type your search query here...">
        </div>
        <div class="table-responsive" id="dynamic_content"></div>

    </section>
    <!-- users section ends -->


@endsection

@section('js')
    <script>
        $(document).ready(function (){

            load_data(1);

            function load_data(page, query=''){
                $.ajax({
                    url: "/Adjax/search-order",
                    method: "POST",
                    data:{
                        page:page,
                        query:query
                    },
                    success:function(data){
                        $('#dynamic_content').html(data);
                    }
                })
            }

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                var query = $('#search_box').val();
                load_data(page, query);
            });

            $('#search_box').keyup(function(){
                var query = $('#search_box').val();
                load_data(1, query);
            });

        })


        function getUserCourseInfo(id){
            console.log(id);
            $.post("/adjax/fetchUserCourseRecord",{userId:id},function (data, status) {
                console.log(data);
                $('#associated_groups').html(data);
            });
            $('#modal-user-groups').modal("show");
        }


    </script>


@endsection
