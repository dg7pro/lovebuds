@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
@endsection

@section('content')

    <h5>This is new 2</h5>

    <!-- profiles section starts -->
    <section class="profiles" id="quick-search-profiles">



    </section>
    <!-- profiles section ends -->



    @include('modal.signup-login')
    @include('modal.photoswipe')


@endsection

@section('js')

    <!-- photoswipe js code -->
    @include('searchJS.pswipeFunctions')

    <script>
        $(document).ready(function(){
            $('#for_popup').on('change', function(){
                var forID = $(this).val();
                if(forID){
                    $.ajax({
                        type:'POST',
                        url:'/ajax/select-gender-popup',
                        data:{
                            for_id:forID
                        },
                        success:function(data,status){
                            console.log(data);
                            //console.log(status);
                            $('#gender_popup').html(data);
                        }
                    });
                }else{
                    $('#gender_popup').html('<option value="">Gender</option>');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function(){
            $(".contact").on("click", function(){
                var dataId = $(this).attr("data-id");
                //alert("The data-id of clicked item is: " + dataId);

                var cbtn = document.getElementById("contact-btn-"+dataId);
                var addr = document.getElementById("ups-ab-overlay-"+dataId);
                addr.style.width= 0;
                addr.style.left= 100;
                cbtn.setAttribute('disabled','disabled');
            });
        });

        function showCon(id){
            console.log('contact clicked');
            console.log(id);
            //alert("The data-id of clicked item is: " + id);

            var cbtn = document.getElementById("contact-btn-"+id);
            var addr = document.getElementById("ups-ab-overlay-"+id);
            addr.style.width= 0;
            addr.style.left= 100;
            cbtn.setAttribute('disabled','disabled');
        }


    </script>

    <script>

        //====================
        // For first time load
        //====================
        $(document).ready(function(){
            loadQuickSearchResults();
        });

        //=====================
        // New Profiles
        //=====================
        function loadQuickSearchResults(){

            //console.log(jsonString);

            var gender = "{{$_GET['gender'] ??''}}";
            var minAge = "{{$_GET['minAge'] ??''}}";
            var maxAge = "{{$_GET['maxAge'] ??''}}";
            var rel = "{{$_GET['rel'] ??''}}";
            var lan = "{{$_GET['lan'] ??''}}";

            console.log(gender);
            console.log(minAge);
            console.log(maxAge);
            console.log(rel);
            console.log(lan);

            $.ajax({
                url: "/quick/ajax-search-profiles",
                method: "POST",
                data:{
                    gender:gender,
                    minAge:minAge,
                    maxAge:maxAge,
                    rel:rel,
                    lan:lan
                },
                success:function(data){
                    $('#quick-search-profiles').html(data);
                }
            });
        }

        /*$('.new-profiles').on('click', function(){
            loadQuickSearchResults();
            console.log('brides button clicked');
        });*/
    </script>




@endsection