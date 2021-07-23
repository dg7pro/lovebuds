@extends('layouts.app')



@section('content')


    <section class="main">

        <div>
            <input type="checkbox" id="cb">
            <br>
            <button id="my_btn" class="btn btn-coco"> Save</button>

        </div>




    </section>

@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('#my_btn').click(function(){


                if($('#cb').prop("checked") == true){
                    var sex = true;
                    console.log("Checkbox is checked.");
                }
                else if($('#cb').prop("checked") == false){
                    var sex = false;
                    console.log("Checkbox is unchecked.");
                }
                console.log(sex);
            });
        });
    </script>
@endsection