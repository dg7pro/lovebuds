@extends('layouts.app')

@section('content')

    <!-- registration section -->
    <section class="main">
        <h2 class="text-blue">
            Pro Dashboard
            {{--<br><small class="text-muted" style="font-size: 20px">Marketing Manager</small>--}}
        </h2>
        <div>
            <ul class="list-group">
                <li class="list-group-item">No. of Footprints: {{$footprint}}</li>
                <li class="list-group-item">Footprints Converted to Signup: {{$signup}}</li>
                <li class="list-group-item">Paid Users: {{$paid}}</li>
                <li class="list-group-item">Company Earning: {{$tap}}/- INR</li>
                <li class="list-group-item">Your Commission: {{$ear}}/- INR</li>
            </ul>
        </div>
        {{---------------------------------------------------------------------------------}}

        <h3 class="text-blue mt-5">
            Your Footprints
        </h3>
        <div id="user_type_div">
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="all_user" name="user_type" value="all" class="custom-control-input user-type" checked required>
                <label class="custom-control-label" for="all_user">All</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="signup" name="user_type" value="signup" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="signup">Registered Users </label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" id="paid" name="user_type" value="paid" class="custom-control-input user-type" required>
                <label class="custom-control-label" for="paid">Paid Users</label>
            </div>
        </div>
        <div class="form-group">
            <input type="text" id="search_box" name="search_box" class="form-control"
                   placeholder="Type your search query here...">
        </div>
        <div class="table-responsive" id="dynamic_content"></div>


    </section>
    <!-- registration ends -->


@endsection

@section('js')
    <script>
        $(document).ready(function (){

            load_data(1);

            function load_data(page, query=''){
                var ut = $("input[name='user_type']:checked").val();
                $.ajax({
                    url: "/adjax/pro-stats",
                    method: "POST",
                    data:{
                        page:page,
                        query:query,
                        category:ut,
                        uid:{{$uid}}
                    },
                    success:function(data){
                        $('#dynamic_content').html(data);
                    }
                });
            }

            $(document).on('click','.user-type',function(){
                console.log('radio changed');
                var query = $('#search_box').val();
                load_data(1, query);
            });

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                var query = $('#search_box').val();
                load_data(page, query);
            });

            $('#search_box').keyup(function(){
                var query = $('#search_box').val();
                load_data(1, query);
            });

        });

    </script>

@endsection


