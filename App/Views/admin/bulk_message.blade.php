@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Send Bulk Email/SMS
        </h3>

        @include('layouts.partials.alert')

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bulk Messaging</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="table-responsive mt-5" id="dynamic_content">
            <h5 class="text-primary">Send Bulk Email:</h5>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Message Type</th>
                    <th>User count</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><a href="{{'/admin/inactive-users-list'}}"> Send Complete your profile Reminder</a></td>
                    <td>{{$iuc}}</td>
                    <td>
                        {{--<i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>--}}
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="{{'/admin/complete-your-profile-reminder'}}" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>
                <tr>
                    <td><a href="{{'/admin/active-users-list'}}">Send New matches Reminder</a></td>
                    <td>{{$auc}}</td>
                    <td>
                        {{--<i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>--}}
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="{{'/admin/new-matches-reminder'}}" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>
                <tr>
                    <td><a href="{{'/admin/non-photo-users-list'}}">Send upload photo reminder</a></td>
                    <td>{{$npc}}</td>
                    <td>
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="{{'/admin/send-photo-upload-reminder'}}" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>
                {{--<tr>
                    <td>Send User Inactivity Notice</td>
                    <td></td>
                    <td>
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="{{'/admin/send-user-inactivity-notice'}}" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>--}}
            </table>
        </div>

        <div class="table-responsive mt-5" id="dynamic_content">
            <h5 class="text-primary">Send Bulk Sms:</h5>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Message Type</th>
                    <th>User count</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Msg to all Inactive Users</td>
                    <td></td>
                    <td>
                        {{--<i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>--}}
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>
                <tr>
                    <td>Send Photo upload reminder</td>
                    <td>{{$npc}}</td>
                    <td>
                        <i class="fas fa-paper-plane text-success" aria-hidden="true"> </i>
                        <a href="{{'/adminSms/photo-upload-reminder'}}" class="text-primary"> Send Bulk Message</a>
                    </td>
                </tr>

            </table>
        </div>

    </section>
    <!-- users section ends -->


@endsection

@section('js')
    <script>
        $(document).ready(function (){


        });

        function delUnlinkedIMages(e){
            e.preventDefault();
            console.log('del unlinked clicked');

            //alert("The data-id of clicked item is: " + id);
            $.confirm({
                title: 'Delete Images ',
                content: ' <strong>Unlinked </strong> images will be deleted from record as well as server',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            console.log('You given confirmation');

                            $.ajax({

                                url: "/Adjax/del-useless-images",
                                method: 'post',
                                data: {},
                                dataType:"json",
                                success: function (data, status) {
                                    console.log(data);
                                    console.log(status);
                                    setTimeout(function(){
                                        toastr.success(data.msg);
                                    }, 100);
                                    if(data.flag){
                                        $('#ic').html(data.ic);
                                    }
                                }
                            });

                        }
                    },
                    cancel: function(){
                        $.alert('You clicked <strong>cancel</strong>. Thanx we can\'t continue.');
                    },

                }
            });

        }


        function delUselessNotices(e){
            e.preventDefault();
            console.log('del useless notices clicked');

            //alert("The data-id of clicked item is: " + id);
            $.confirm({
                title: 'Delete Notices ',
                content: ' <strong>Useless </strong> notices will be deleted from record',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            console.log('You given confirmation');
                            $.ajax({

                                url: "/Adjax/del-useless-notices",
                                method: 'post',
                                data: {},
                                dataType:"json",
                                success: function (data, status) {
                                    console.log(data);
                                    console.log(status);
                                    setTimeout(function(){
                                        toastr.success(data.msg);
                                    }, 100);
                                    if(data.flag){
                                        $('#nc').html(data.nc);
                                    }
                                }
                            });
                        }
                    },
                    cancel: function(){
                        $.alert('You clicked <strong>cancel</strong>. Thanx we can\'t continue.');
                    },

                }
            });

        }

    </script>

@endsection
