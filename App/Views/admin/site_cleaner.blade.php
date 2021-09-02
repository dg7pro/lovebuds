@extends('layouts.app')

@section('content')

    <!-- users section -->
    <section class="main">

        <h3 class="text-blue">
            Site Cleaner
        </h3>

        <div class="row mt-3">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-info">
                        <li class="breadcrumb-item"><a href="{{'/'}}">JuMatrimony</a></li>
                        <li class="breadcrumb-item"><a href="{{'/admin/index'}}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Site Cleaner</li>
                    </ol>
                </nav>
            </div>
        </div>


        <div class="table-responsive" id="dynamic_content">
            <label>Records need your attention</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>type</th>
                    <th>records found</th>
                    <th>action</th>
                </tr>
                <tr>
                    <td>Images</td>
                    {{--<td><span id="ic">{{$del_images ? count($del_images) : 0}}</span> unlinked images</td>--}}
                    <td><span id="ic">{{$del_images}}</span> unlinked images</td>
                    <td>
                        <i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>
                        <a href="" class="text-danger" onclick="delUnlinkedIMages(event)"> Delete permanently</a>

                    </td>

                </tr>
                <tr>
                    <td>Notifications</td>
                    <td><span id="nc">{{$del_notices}}</span> useless notifications</td>
                    <td>
                        <i class="fa fa-trash-alt text-red" aria-hidden="true"> </i>
                        <a href="" class="text-danger" onclick="delUselessNotices(event)"> Delete permanently</a>
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
