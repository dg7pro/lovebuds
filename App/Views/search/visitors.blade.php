@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">

@endsection

@section('content')

    <section class="profiles-buttons">
        <div>
            <ul class="nav nav-pills mb-3">
                <li class="nav-item" role="presentation">
                    <a class="btn btn-yellow nav-item" href="{{'/search/index'}}">
                        <i class="fas fa-angle-double-left text-white"></i>
                        Back to Main Search
                    </a>
                </li>
            </ul>
        </div>
    </section>

    <h4 class="text-center text-secondary">-- Recent Profile Visitors --</h4>

    <section class="profiles" id="new-profiles">


    </section>





    @include('modal.photoswipe')

@endsection

@section('js')

    {{--@include('request.view_address')
    @include('request.view_photo')--}}

    @include('searchJS.pswipeFunctions')
    @include('searchJS.moveFunctions')

    <!-- custom js code -->

    <script>
        $(document).ready(function (){

            load_data(1);

            function load_data(page, query=''){
                $.ajax({
                    headers:{
                        'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "/AjaxSearch/recentVisitors",
                    method: "POST",
                    data:{
                        page:page,
                        query:query
                    },
                    success:function(data){
                        $('#new-profiles').html(data);
                    }
                });
            }

            $(document).on('click', '.page-link', function(){
                var page = $(this).data('page_number');
                load_data(page);
            });


        });

    </script>


    <script>

        function viewContactAdd(id){
            console.log('contact clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);
            $.confirm({
                title: 'View Contact details ',
                content: 'The number of contacts viewed by you is counted and recorded to fight <strong>spam</strong>',
                icon: 'fa fa-question-circle',
                animation: 'scale',
                closeAnimation: 'scale',
                opacity: 0.5,
                buttons: {
                    'confirm': {
                        text: 'Proceed',
                        btnClass: 'btn-blue',
                        action: function(){
                            $.ajax({
                                headers:{
                                    'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                                },
                                url: "/AjaxActivity/show-contact",
                                method: 'post',
                                data: {
                                    other_id:id
                                },
                                dataType:"json",
                                success: function (data, status) {
                                    console.log(data);
                                    console.log(status);
                                    setTimeout(function(){
                                        toastr.success(data.msg);
                                    }, 1000);
                                },
                                error: function( jqXhr, textStatus, errorThrown ){
                                    console.log( jqXhr.responseJSON.message );
                                    console.log( errorThrown );
                                    //console.log( jqXhr.responseText );
                                    $.alert({
                                        title: 'Security Alert!',
                                        content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                                        icon: 'fa fa-skull',
                                        animation: 'scale',
                                        closeAnimation: 'scale',
                                        buttons: {
                                            okay: {
                                                text: 'Okay',
                                                btnClass: 'btn-blue'
                                            }
                                        }
                                    });
                                }
                            });

                            var cbtn = document.getElementById("contact-btn-"+id);
                            var addr = document.getElementById("ups-ab-overlay-"+id);
                            addr.style.width= 0;
                            addr.style.left= 100;
                            cbtn.setAttribute('disabled','disabled');
                        }
                    },
                    cancel: function(){
                        $.alert('You clicked <strong>cancel</strong>. Thanx we can\'t continue.');
                    },

                }
            });

        }

        function sendWhatsappInterest(id){
            console.log('send whatsapp clicked');
            console.log(id);

            $.ajax({
                headers:{
                    'CsrfToken': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "/AjaxActivity/show-contact",
                method: 'post',
                data: {
                    other_id:id
                },
                dataType:"json",
                success: function (data, status) {
                    console.log(data);
                    console.log(status);
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( jqXhr.responseJSON.message );
                    console.log( errorThrown );
                    //console.log( jqXhr.responseText );
                    $.alert({
                        title: 'Security Alert!',
                        content: jqXhr.responseJSON.message + ' Please logout and login after sometime to continue.',
                        icon: 'fa fa-skull',
                        animation: 'scale',
                        closeAnimation: 'scale',
                        buttons: {
                            okay: {
                                text: 'Okay',
                                btnClass: 'btn-blue'
                            }
                        }
                    });
                }
            });

        }
    </script>

@endsection