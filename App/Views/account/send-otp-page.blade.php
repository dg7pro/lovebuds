@extends('layouts.app')

@section('title', 'Page Title')

@section('app-css')
    <style>
        a.disabled{
            /* Make the disabled links grayish*/
            color: gray;
            /* And disable the pointer events */
            pointer-events: none;
        }
    </style>
@endsection

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                @include('layouts.partials.alert')
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card card-default">
                    <div class="card-header justify-content-center">
                        <h2 class="text-info" >Please verify your mobile number</h2>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row justify-content-center" style="font-size: 3rem">
                            <i class="mdi mdi-cellphone-iphone"></i>
                        </div>
                        <div class="mt-3 mb-4 row justify-content-center">
                            <h5 class="text-muted">OTP will be send on your mobile<br>
                                <span class="ml-5" id="mb_holder">{{'+91 '.$authUser->mobile}}</span> | <a class="text-info" href="#" onclick="getUserMobile({{$authUser->id}})" >Edit</a>
                            </h5>
                        </div>
                        <form class="form-inline justify-content-center" action="{{'/Account/send-otp'}}" method="POST">
                            <button type="submit" name="verify-mobile-submit" class="btn btn-primary mt-3 mb-3">Click to Send OTP</button>
                        </form>

                       {{-- <div class="mt-3 mb-4 row justify-content-center">
                            <h6 class="text-muted">Didn't received the OTP?<a class="ml-1 disabled" href="#" id="resend_otp">Resend OTP</a><span class="ml-2 text-warning" id="count"></span> sec</h6>
                        </div>--}}

                         <div class="mt-3 mb-4 row justify-content-center">
                            <h6 class="text-muted">This mobile number will be used to contact you</h6>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Edit Modal-->
    <div class="modal fade" id="updateMobileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Mobile No:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control" id="update_mobile" placeholder="Your Mobile">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateMobileDetail()">Update Mobile</button>
                    <input type="hidden" name="" id="hidden_user_id">
                </div>
            </div>
        </div>
    </div>




@endsection

@section('app-script')

    <script>

        function getUserMobile(id){
            console.log(id);
            $('#hidden_user_id').val(id);
            $.post("/ajax/user-mobile",{id:id},function (data, status) {
                var user = JSON.parse(data);
                $('#update_mobile').val(user.mobile);
                console.log(data);
            });
            $('#updateMobileModal').modal("show");
        }

        function updateMobileDetail(){

            var mobile = $('#update_mobile').val();
            //var hidden_user_id = $('#hidden_user_id').val();

            //console.log(hidden_user_id);
            $.post("/ajax/update-mobile",{
                mobile:mobile,
                //hidden_user_id:hidden_user_id

            },function (data, status) {
                var res = JSON.parse(data);
                console.log(res.msg);
                $('#mb_holder').text('+91 ' +res.mobile);
                $('#updateMobileModal').modal("hide");
            });

        }


        /*$(document).ready(function(){
            // Get refreence to span and button
            var spn = document.getElementById("count");
            var reo = document.getElementById("resend_otp");

            var count = 120;     // Set count
            var timer = null;  // For referencing the timer

            (function countDown(){
                // Display counter and start counting down
                spn.textContent = count;

                // Run the function again every second if the count is not zero
                if(count !== 0){
                    timer = setTimeout(countDown, 1000);
                    count--; // decrease the timer
                } else {
                    // Enable the button
                    reo.classList.remove("disabled");
                }
            }());
        });*/
    </script>

@endsection