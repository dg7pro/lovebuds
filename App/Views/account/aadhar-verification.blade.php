@extends('layouts.app')

@section('page_css')
    <style>


        form {
            width: 100%;
            max-width: 300px;
            margin: 60px auto;
        }
        form input {
            font-size: 30px;
            padding: 0;
            border-left: 0;
            width: 100%;
            color: #666;
            font-family: 'PT Sans', sans-serif;
            font-weight: bold;
            background: black 2px no-repeat;

        }
        form input:focus {
            outline: 0;
        }
        label {
            color: #999;
            display: block;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 0.05em
        }
        .flex {
            display: flex;
            justify-content: space-around;
        }
        .flex input {
            font-size: 30px;
            color: #999;
            line-height: 2.5;
            background: white;
        }

        .flex #aadhar{
            border: 2px solid #ccc;
            border-radius: 7px;
            /*padding: 0 2px 0 20px;*/
            padding: 0 20px 0 20px;
        }

        .flex #part1{
            border: 2px solid #ccc;
            border-right: 0;
            border-radius: 7px 0 0 7px;
            /*padding: 0 2px 0 20px;*/
            padding: 0 0 0 20px;
        }
        .flex #part2{
            border: 2px solid #ccc;
            border-right: 0;
            border-left: 0;
            /*border-radius: 7px 0 0 7px;*/
            /*padding: 0 2px 0 2px;*/
            padding: 0 0 0 5px;
        }
        @media (max-width:340px) {
            .flex #part1{
                padding: 0 0 0 10px;
            }
        }
        .flex #part3{
            border: 2px solid #ccc;
            border-left: 0;
            border-radius: 0 7px 7px 0;
           /* padding: 0 20px 0 2px;*/
        }
        .btn-aadhar{
            font-size: 1.5em;
        }
    </style>
@endsection
@section('content')

    <section class="main">
        <div class="d-flex justify-content-center align-items-center">


            <form id="form" method="POST" action="{{'/account/save-aadhar'}}">

                <h4 class="mb-5">Enter aadhar of <span class="text-blue">{{$authUser->first_name}} :</span></h4>

                <label for="amount">Aadhar(12 Digits)</label>
                <div class="flex">
                    {{--<span class="currency"></span>--}}
                    {{--<input type="text" id="aadhar" name="aadhar" autofocus="" maxlength="14"
                           onkeyup="return checkDigit(event)" pattern="^\d{4}\s\d{4}\s\d{4}$" required>--}}
                    <input type="text" id="aadhar" name="aadhar" autofocus="" maxlength="14" pattern="^\d{4}\s\d{4}\s\d{4}$" required>
                    {{--<input type="number" id="part1" name="amount">--}}
                   {{-- <input id="part2" name="amount" type="text" maxlength="4" onkeyup="move(event,'part1','part2','part3')" required>
                    <input id="part3" name="amount" type="text" maxlength="4" onkeyup="move(event,'part2','part3',' ')" required>--}}
                </div>

                <input type="submit" class="btn btn-blue btn-lg btn-block mt-5 btn-aadhar"  name="submit-aadhar" value="Submit">
            </form>


        </div>

    </section>

@endsection

@section('js')

    <script>

        function checkDigit(event) {
            var code = (event.which) ? event.which : event.keyCode;

            if ((code < 48 || code > 57) && (code > 31)) {
                alert('Only numbers are allowed, don\'t type alphabets, spaces or special chars');
                return false;
            }

            return true;
        }

        function cc_format(value) {
            var v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '')
            var matches = v.match(/\d{4,14}/g);
            var match = matches && matches[0] || ''
            var parts = []

            for (i=0, len=match.length; i<len; i+=4) {
                parts.push(match.substring(i, i+4))
            }

            if (parts.length) {
                return parts.join(' ')
            } else {
                return value
            }
        }

        onload = function() {
            document.getElementById('aadhar').oninput = function() {
                this.value = cc_format(this.value)
            }
        }


    </script>

@endsection