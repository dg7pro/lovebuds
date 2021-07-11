@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/pswipe/photoswipe.css">
    <link rel="stylesheet" href="/pswipe/default-skin/default-skin.css">
@endsection

@section('content')

    <section class="profiles-buttons">
        <div class="btn-group">
           <a class="btn btn-pink beautiful_brides" id="pills-home-tab">
               <i class="fas fa-user-circle text-white"></i>
               Beautiful Brides
           </a>

           <a class="btn btn-blue smart_grooms" id="pills-contact-tab" >
               <i class="fas fa-graduation-cap text-white"></i>
               Smart Grooms
           </a>

       </div>

   </section>

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
                        url:'/ajaxRegistration/select-gender-popup',
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

        /* For first time load */
        $(document).ready(function(){
            loadQuickSearchResults();
        });

        /* New Profiles */
        function loadQuickSearchResults(sex=''){

            //console.log(jsonString);
            console.log('hello shakti');
            console.log(sex);

            var gender = "{{$_GET['gender'] ??''}}";
            var minAge = "{{$_GET['minAge'] ??''}}";
            var maxAge = "{{$_GET['maxAge'] ??''}}";
            var rel = "{{$_GET['rel'] ??''}}";
            var lan = "{{$_GET['lan'] ??''}}";

            if(sex!==''){
                gender = '';
            }
            console.log(gender);
            console.log(minAge);
            console.log(maxAge);
            console.log(rel);
            console.log(lan);

            $.ajax({
                url: "/quick/ajax-search-profiles",
                method: "POST",
                data:{
                    sex:sex,
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

        $('.smart_grooms').on('click', function(){
            loadQuickSearchResults(1);
            console.log('grooms clicked');
        });

        $('.beautiful_brides').on('click', function(){
            loadQuickSearchResults(2);
            console.log('brides clicked');
        });
    </script>

@endsection