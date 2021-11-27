@extends('layouts.app')

@section('page_css')
    <link rel="stylesheet" href="/css/select2.min.css">
    <style>
        .select2-container, .select2-selection--multiple{
            width: 100%!important;
            min-height: 70px!important;
        }

        .select2-container--default, .select2-selection--multiple{
            border-radius: 0!important;
        }

    </style>
@endsection


@section('content')

    <!-- login section -->
    <section class="main">

        <h1 class="large text-green">
            Settings
        </h1>
        <p class="lead"><i class="fas fa-cogs text-blue mb-3"> </i> Twik your preferences & settings </p>

        <div style="max-width: 75%">
            <div class="mb-5 form">

                <h4 class="text-blue mt-4">Select your caste preferences</h4>
                <div class="form-group">
                    <select multiple id="my-preferred-caste" class="js-example-basic-multiple select-multiple" required>
                        @foreach($allCastes as $caste)
                            <option value="{{$caste->value}}" {{in_array($caste->value,json_decode($authUser->mycastes))?'Selected':''}}>{{$caste->text}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="cnb" {{($authUser->cnb)?'checked':''}} value=0>
                    <label class="form-check-label" for="cnb">Caste no bar (willing to marry in any caste)</label>
                </div>

                <h4 class="text-blue mt-4">Partner Physical Traits</h4>

                <div class="flex-row form-group">
                    <div class="flex-field-2">
                        <label for="min_age">Age min:</label>
                        <select id="min_age" name="min_age">
                            <option value="" selected>Select</option>
                            @foreach($age_rows as $row)
                                <option value="{{$row}}" {{($authUser->min_age==$row)?'Selected':''}}>{{$row}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-field-2">
                        <label for="max_age">Age max:</label>
                        <select id="max_age" name="max_age">
                            <option value="" selected>Select</option>
                            @foreach($age_rows as $row)
                                <option value="{{$row}}" {{($authUser->max_age==$row)?'Selected':''}}>{{$row}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex-row form-group">
                    <div class="flex-field-2">
                        <label for="min_ht">Min height:</label>
                        <select id="min_ht" name="min_ht">
                            <option value="" selected>Select</option>
                            @foreach($heights as $ht)
                                <option value="{{$ht->id}}" {{($authUser->min_ht==$ht->id)?'Selected':''}}>{{$ht->feet}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-field-2">
                        <label for="max_ht">Max height:</label>
                        <select id="max_ht" name="max_ht">
                            <option value="" selected>Select</option>
                            @foreach($heights as $ht)
                                <option value="{{$ht->id}}" {{($authUser->max_ht==$ht->id)?'Selected':''}}>{{$ht->feet}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($authUser->religion_id==1)
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="pm" {{($authUser->pm)?'checked':''}}>
                        <label class="form-check-label" for="pm">Preferably Manglik <br>(leave unchecked if you are non-manglik)</label>
                    </div>
                @endif
                <button type="submit" class="btn btn-green" id="save-partner-preference" value="update_pp">Save Partner Preferences</button>
            </div>
        </div>


    </section>
    <!-- login ends -->

@endsection

@section('js')
    @include('request.dashboard.partner_preference')

    <script src="/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>

@endsection