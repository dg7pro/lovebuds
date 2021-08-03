@extends('layouts.app')

@section('page_css')
    <style>
        .others {color:black}
    </style>
    <link href="/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

    <section class="main">
        <h1 class="large text-heading">
            Edit Profile
        </h1>
        <p class="lead"><i class="fas fa-user"> </i> You can review, change your profile or leave as it is</p>

        <div class="row justify-content-center mb-5" id="basic-info-card">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-blue">
                        <h3 class="">Basic Information</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="fn_update">First name</label>
                                <input type="text" class="form-control" id="fn_update" name="fn_update" placeholder="First name" value="{{ucfirst($authUser->first_name)}}" required>

                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="ln_update">Last name</label>
                                <input type="text" class="form-control" id="ln_update" name="ln_update" placeholder="Last name" value="{{ucfirst($authUser->last_name)}}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <!-- *** -->
                            <div class="col-md-4 mb-3 px-2">
                                <label for="rel_update">Religion</label>
                                <select id="rel_update" name="rel_update" class="form-control" disabled>
                                    <option value="">Choose...</option>
                                    @foreach($religions as $religion)
                                        <option value="{{$religion->id}}" {{($authUser->religion_id==$religion->id)?'Selected':''}}>{{$religion->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="gen_update">Gender</label>
                                <select id="gen_update" name="gen_update" class="form-control" disabled>
                                    <option selected value="">Choose...</option>
                                    <option value="1" {{($authUser->gender==1)?'Selected':''}}>Male</option>
                                    <option value="2" {{($authUser->gender==2)?'Selected':''}}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="dob">Date of Birth</label>
                                <input type="text" class="form-control" id="dob" value="{{Carbon\Carbon::parse($authUser->dob)->isoFormat('LL')}}" disabled>
                            </div>
                            <!-- *** -->
                            <div class="col-md-6 mb-3 px-2">
                                <label for="cas_update">Your Caste</label>
                                <select id="cas_update" name="cas_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @if($authUser->religion_id==1)
                                        @foreach($castes as $caste)
                                            <optgroup label="{{$caste['ast']}}">
                                                @foreach($caste['cas'] as $cast)
                                                    <option value="{{$cast['cid']}}" {{($authUser->caste_id==$cast['cid'])?'Selected':''}}>{{$cast['cst']}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @else
                                        @foreach($castes as $caste)
                                            <option value="{{$caste->value}}" {{($authUser->caste_id==$caste->value)?'Selected':''}}>{{$caste->text}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="mt_update">Mother Tongue</label>
                                <select id="mt_update" name="mt_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($tongues as $tongue)
                                        <optgroup label="{{$tongue['direction']}}">
                                            @foreach($tongue['lang'] as $lang)
                                                <option value="{{$lang["id"]}}" {{($authUser->tongue_id==$lang["id"])?'Selected':''}}>{{$lang["name"]}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <!-- *** -->
                            <div class="col-md-6 mb-3 px-2">
                                <label for="ms_update">Marital Status</label>
                                <select id="ms_update" name="ms_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($maritals as $marital)
                                        <option value="{{$marital->id}}" {{($authUser->marital_id==$marital->id)?'Selected':''}}>{{$marital->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="ht_update">Height</label>
                                <select id="ht_update" name="ht_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($heights as $height)
                                        <option value="{{$height->id}}" {{($authUser->height_id==$height->id)?'Selected':''}}>{{$height->feet}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- *** -->
                            <div class="col-md-4 mb-3 px-2">
                                <label for="cn_update">Living In Country:</label>
                                <select id="cn_update" name="cn_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($countries as $country)
                                        <optgroup label="{{$country['alpha']}}">
                                            @foreach($country['coni'] as $con)
                                                <option value="{{$con["id"]}}" {{($authUser->country_id==$con["id"])?'Selected':''}}>{{$con["name"]}}</option>
                                                {{--                                                <option value="{{$con["id"]}}" {{($authUser->country_id==0)?(77==$con["id"]):$authUser->country_id==$con['id']?'Selected':''}}>{{$con["name"]}}</option>--}}
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            @if($authUser->country_id==77)
                                <div class="col-md-4 mb-3 px-2">
                                    <label for="st_update">State</label>
                                    <select id="st_update" name="st_update" class="form-control">
                                        <option value="">Choose...</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->text}}" data-id="{{$state->id}}" {{($authUser->state==$state->text)?'Selected':''}}>{{$state->text}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" id="st_entry" name="st_entry" placeholder="State/Province" hidden>
                                </div>
                                <div class="col-md-4 mb-3 px-2">
                                    <label for="ds_update">Districts/Cities</label>
                                    <select id="ds_update" name="ds_update" class="form-control" >
                                        <option value="">Select state first</option>
                                        @foreach($userDistricts as $ud)
                                            <option value="{{$ud->text}}" {{($authUser->district==$ud->text)?'Selected':''}}>{{$ud->text}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" id="ds_entry" name="ds_entry" placeholder="City/Town" hidden>
                                </div>
                            @else
                                <div class="col-md-4 mb-3 px-2">
                                    <label for="st_update">State</label>
                                    <select id="st_update" name="st_update" class="form-control" hidden>
                                        <option value="">Choose...</option>
                                        @foreach($states as $state)
                                            <option value="{{$state->text}}" data-id="{{$state->id}}" {{($authUser->state==$state->text)?'Selected':''}}>{{$state->text}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" id="st_entry" name="st_entry" placeholder="State/Province" value="{{$authUser->state}}">
                                </div>
                                <div class="col-md-4 mb-3 px-2">
                                    <label for="ds_update">Districts/Cities</label>
                                    <select id="ds_update" name="ds_update" class="form-control" hidden>
                                        <option value="">Select state first</option>
                                        @foreach($userDistricts as $ud)
                                            <option value="{{$ud->text}}" {{($authUser->district==$ud->text)?'Selected':''}}>{{$ud->text}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" id="ds_entry" name="ds_entry" placeholder="City/Town" value="{{$authUser->district}}">
                                </div>

                            @endif
                        </div>
                        <button class="btn btn-blue" type="submit" id="basic-info-update" name="basic-info-update" value="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5" id="caste-preference-card">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-green">
                        <h3 class="">Caste Preferences:</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12 mb-3 px-2">
                                <label for="my-preferred-caste">Preferred caste for marriage? (Select more than one)</label>
                                <select multiple id="my-preferred-caste" class="js-example-basic-multiple form-control d-sm-none d-md-block">
                                    <option value="">Choose...</option>
                                    @foreach($allCastes as $caste)
                                        <option value="{{$caste->value}}" {{in_array($caste->value,json_decode($authUser->mycastes))?'Selected':''}}>{{$caste->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-green" id="caste-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5" id="edu-career-card">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-pink">
                        <h3 class="">Education & Career</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="education">Highest Education</label>
                                <select id="education" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($educations as $education)
                                        <optgroup label="{{$education['stream']}}">
                                            @foreach($education['edu'] as $edu)
                                                <option value="{{$edu['id']}}" {{($authUser->education_id==$edu['id'])?'Selected':''}}>{{$edu['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="degree">UG Degree</label>
                                <select id="degree" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($degrees as $degree)
                                        <option value="{{$degree->id}}" {{($authUser->degree_id==$degree->id)?'Selected':''}}>{{$degree->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="university">University</label>
                                <select id="university" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($universities as $university)
                                        <option value="{{$university->id}}" {{($authUser->university_id==$university->id)?'Selected':''}}>{{$university->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="otherDeg">Other UG Degree</label>
                                <input type="text" class="form-control" name="otherDeg" id="otherDeg" placeholder="Other Degree" value="{{$authUser->other_deg}}">
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="sector">Employed In (Sector)</label>
                                <select id="sector" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{$sector->id}}" {{($authUser->sector_id==$sector->id)?'Selected':''}}>{{$sector->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="occupation">Occupation</label>
                                <select id="occupation" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($occupations as $occupation)
                                        <optgroup label="{{$occupation['category']}}">
                                            @foreach($occupation['occ'] as $occ)
                                                <option value="{{$occ['id']}}" {{($authUser->occupation_id==$occ['id'])?'Selected':''}}>{{$occ['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="organization">Working In</label>
                                <input type="text" class="form-control" name="organization" id="organization" placeholder="Name of Organization" value="{{$authUser->working_in}}">
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="income">Annual Income</label>
                                <select id="income" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($incomes as $income)
                                        <option value="{{$income->id}}" {{($authUser->income_id==$income->id)?'Selected':''}}>{{$income->level}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-pink" id="education-career-update" type="submit">Submit form</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5" id="family_details">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-coco">
                        <h3 class="">Family Details</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">

                            <div class="col-md-6 mb-3 px-2">
                                <label for="father_name">Father's Name</label>
                                <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father name" value="{{$authUser->father_name}}">
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="father">Father Is</label>
                                <select id="father" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($fathers as $father)
                                        <option value="{{$father->id}}" {{($authUser->father_id==$father->id)?'Selected':''}}>{{$father->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="mother_name">Mother's Name</label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother name" value="{{$authUser->mother_name}}">
                            </div>


                            <div class="col-md-6 mb-3 px-2">
                                <label for="mother">Mother Is</label>
                                <select id="mother" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($mothers as $mother)
                                        <option value="{{$mother->id}}" {{($authUser->mother_id==$mother->id)?'Selected':''}}>{{$mother->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-2 px-2">
                                <label for="brother">Brothers</label>

                                <div class="input-group mb-2">
                                    <select class="custom-select" style="margin-left: 0; background: none" id="bros">
                                        <option value="" selected >Brothers</option>
                                        @for($b=1;$b<=7;$b++)
                                            <option value="{{$b}}" {{($authUser->bros==$b)?'Selected':''}}>{{$b}}</option>
                                        @endfor
                                        <option value=100 {{($authUser->bros==100)?'Selected':''}}>No Brother</option>
                                    </select>
                                    <select class="custom-select" style="background: none" id="mbros">
                                        @if($authUser->bros != 100)
                                            <option value="" selected>Married ones: 0</option>
                                            @for($mb=1;$mb<=$authUser->bros;$mb++)
                                                <option value="{{$mb}}" {{($authUser->mbros==$mb)?'Selected':''}}>{{$mb}}</option>
                                            @endfor
                                        @else
                                            <option value="" selected>Sorry!</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2 px-2">
                                <label for="sisters">Sisters</label>

                                <div class="input-group mb-2">
                                    <select class="custom-select" style="margin-left: 0; background: none" id="sis">
                                        <option value="" selected>Sisters</option>
                                        @for($s=1;$s<=7;$s++)
                                            <option value="{{$s}}" {{($authUser->sis==$s)?'Selected':''}}>{{$s}}</option>
                                        @endfor
                                        <option value=100 {{($authUser->sis==100)?'Selected':''}}>No Sister</option>
                                    </select>
                                    <select class="custom-select" style="background: none" id="msis">
                                        @if($authUser->sis != 100)
                                            <option value="" selected>Married ones: 0</option>
                                            @for($ms=1;$ms<=$authUser->sis;$ms++)
                                                <option value="{{$ms}}" {{($ms==$authUser->msis)?'Selected':''}}>{{$ms}}</option>
                                            @endfor
                                        @else
                                            <option value="" selected>Sorry!</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="affluence">Family Status</label>
                                <select id="affluence" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($famAffluence as $affluence)
                                        <option value="{{$affluence->id}}" {{($authUser->famAffluence_id==$affluence->id)?'Selected':''}}>{{$affluence->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famType">Family Type</label>
                                <select id="famType" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($famTypes as $famType)
                                        <option value="{{$famType->id}}" {{($authUser->famType_id==$famType->id)?'Selected':''}}>{{$famType->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famValue">Family Values</label>
                                <select id="famValue" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($famValues as $value)
                                        <option value="{{$value->id}}" {{($authUser->famValue_id==$value->id)?'Selected':''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famIncome">Family Income</label>
                                <select id="famIncome" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($famIncomes as $famIncome)
                                        <option value="{{$famIncome->id}}" {{($authUser->famIncome_id==$famIncome->id)?'Selected':''}}>{{$famIncome->level}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-coco" id="family-info-update" type="submit">Update Family Details</button>

                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-orange">
                        <h3 class="">Lifestyle</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3 px-2">
                                <label for="diet">Dietary Habits</label>
                                <select id="diet" name="diet" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($diets as $diet)
                                        <option value="{{$diet->id}}" {{($authUser->diet_id==$diet->id)?'Selected':''}}>{{$diet->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="smoke">Smoking Habit</label>
                                <select id="smoke" name="smoke" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($smokes as $smoke)
                                        <option value="{{$smoke->id}}" {{($authUser->smoke_id==$smoke->id)?'Selected':''}}>{{$smoke->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="drink">Drinking Habits</label>
                                <select id="drink" name="drink" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($drinks as $drink)
                                        <option value="{{$drink->id}}" {{($authUser->drink_id==$drink->id)?'Selected':''}}>{{$drink->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-4 mt-4 px-2">
                                <label class="mr-5">Opened to Pets: </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pets-1" name="pets" value="1" class="custom-control-input" {{($authUser->pets==1)?'checked':''}}>
                                    <label class="custom-control-label" for="pets-1"> Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pets-2" name="pets" value="0" class="custom-control-input" {{($authUser->pets==0)?'checked':''}}>
                                    <label class="custom-control-label" for="pets-2"> No</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="house">Own a House?</label>
                                <select id="house" name="house" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($authUser->house==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($authUser->house==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="car">Own a Car?</label>
                                <select id="car" name="car" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($authUser->car==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($authUser->car==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="btype">Body type</label>
                                <select id="btype" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($bodies as $body)
                                        <option value="{{$body->id}}" {{($authUser->body_id==$body->id)?'Selected':''}}>{{$body->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="complexion">Complexion</label>
                                <select id="complexion" name="complexion" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($complexions as $complexion)
                                        <option value="{{$complexion->id}}" {{($authUser->complexion_id==$complexion->id)?'Selected':''}}>{{$complexion->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="wt">Weight(kgs)</label>
                                <select id="wt" name="wt" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($wts as $wt)
                                        <option value="{{$wt}}" {{($authUser->weight_id==$wt)?'Selected':''}}>{{$wt.' kgs'}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="bGroup">Blood Group</label>
                                <select id="bGroup" name="bGroup" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($bGroups as $value)
                                        <option value="{{$value->id}}" {{($authUser->bGroup_id==$value->id)?'Selected':''}}>{{$value->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hiv">HIV+</label>
                                <select id="hiv" name="hiv" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($authUser->hiv==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($authUser->hiv==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="thalassemia">Thalassemia</label>
                                <select id="thalassemia" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($thalassemia as $value)
                                        <option value="{{$value->id}}" {{($authUser->thalassemia_id==$value->id)?'Selected':''}}>{{$value->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="challenged">Physically Challenged?</label>
                                <select id="challenged" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($challenges as $challenge)
                                        <option value="{{$challenge->id}}" {{($authUser->challenged_id==$challenge->id)?'Selected':''}}>{{$challenge->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="citizenship">Residential Status</label>
                                <select id="citizenship" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($citizenship as $value)
                                        <option value="{{$value->id}}" {{($authUser->citizenship_id==$value->id)?'Selected':''}}>{{$value->status}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12 mb-3 px-2">
                                <label for="langs">Languages Known?</label>
                                <select multiple id="langs" name="langs[]" class="js-example-basic-multiple form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($languages as $language)
                                        <option value="{{$language->value}}" {{in_array($language->value,str_replace('"','', (array)json_decode($authUser->langs)))?'Selected':''}}>{{$language->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-orange" id="lifestyle-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-blue">
                        <h3 class="">Your Likes:</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="my-hobbies">Hobbies?</label>
                                <select multiple id="my-hobbies" class="js-example-basic-multiple form-control d-sm-none d-md-block" required>
                                    <option value="">Choose...</option>
                                    @foreach($hobbies as $hobby)
                                        <option value="{{$hobby->value}}" {{in_array($hobby->value,json_decode($authUser->myhobbies))?'Selected':''}}>{{$hobby->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="my-interests">Interests?</label>
                                <select multiple id="my-interests" class="js-example-basic-multiple form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($interests as $interest)
                                        <option value="{{$interest->value}}" {{in_array($interest->value,json_decode($authUser->myinterests))?'Selected':''}}>{{$interest->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-blue" id="likes-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        @if( in_array($authUser->religion_id,[1,3,5,6]))
            <div class="row justify-content-center mb-5">
            <div class="col-xl-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-pink">
                        <h3 class="">Horoscope</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3 px-2">
                                <label for="sunSign">Sun Sign</label>
                                <select id="sunSign" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($signs as $ss)
                                        <option value="{{$ss->id}}" {{($authUser->sun_id==$ss->id)?'Selected':''}}>{{$ss->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="moonSign">Moon Sign</label>
                                <select id="moonSign" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($signs as $ms)
                                        <option value="{{$ms->id}}" {{($authUser->moon_id==$ms->id)?'Selected':''}}>{{$ms->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="nakshatra">Nakshatra</label>
                                <select id="nakshatra" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($nakshatras as $nak)
                                        <option value="{{$nak->id}}" {{($authUser->nakshatra_id==$nak->id)?'Selected':''}}>{{$nak->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="manglik">Manglik Status</label>
                                <select id="manglik" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($mangliks as $manglik)
                                        <option value="{{$manglik->id}}" {{($authUser->manglik_id==$manglik->id)?'Selected':''}}>{{$manglik->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hm">Horoscope Match</label>
                                <select id="hm" class="form-control">
                                    <option value="">Choose...</option>
                                    <option value=1 {{($authUser->hm==1)?'Selected':''}}>Necessary</option>
                                    <option value=0 {{($authUser->hm==0)?'Selected':''}}>Not Necessary</option>
                                    <option value="3" {{($authUser->hm==3)?'Selected':''}}>May be</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hp">Horoscope Privacy</label>
                                <select id="hp" class="form-control">
                                    <option value="">Choose...</option>
                                    <option value="1" {{($authUser->hp==1)?'Selected':''}}>Visible</option>
                                    <option value="0" {{($authUser->hp==0)?'Selected':''}}>Hide</option>
                                    <option value="3" {{($authUser->hp==3)?'Selected':''}}>On demand</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3 mt-3 px-2">
                                <label class="mr-5">I have Horoscope: </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="horo-1" name="horo" value="1" class="custom-control-input" {{($authUser->horoscope==1)?'checked':''}}>
                                    <label class="custom-control-label" for="horo-1"> Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="horo-2" name="horo" value="0" class="custom-control-input" {{($authUser->horoscope==0)?'checked':''}}>
                                    <label class="custom-control-label" for="horo-2"> No</label>
                                </div>
                            </div>
                            @if($authUser->horoscope==1)
                                <div id="kundliDiv" class="col-md-12 mb-4 px-2">
                                    {{--<label for="kundli_details">Kundli (Birth Details)</label>--}}
                                    <input type="text" class="form-control" name="kundli_details" id="kundli_details" placeholder="Please enter:   Date, Time & Place of birth" value="{{$authUser->kundli_details}}" required>
                                    <small id="kundli_details" class="form-text text-muted ml-2">Date, Time & Place of birth. (Example: 17 Dec 1989 10:20pm Varanasi UP IN)</small>
                                </div>
                            @else
                                <div id="kundliDiv" class="col-md-12 mb-4 px-2" hidden>
                                    {{--<label for="kundli_details">Kundli (Birth Details)</label>--}}
                                    <input type="text" class="form-control" name="kundli_details" id="kundli_details" placeholder="Please enter:   Date, Time & Place of birth" value="{{$authUser->kundli_details}}">
                                    <small id="kundli_details" class="form-text text-muted ml-2">Date, Time & Place of birth. (Example: 17 Dec 1989 10:20pm Varanasi UP IN)</small>
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-pink" id="horoscope-info-update" type="submit">Update Astro Details</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>



@endsection

@section('js')
    <script src="/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>

    <script>
        $(document).ready(function() {
            $("input[name$='horo']").click(function() {
                var kval = $(this).val();
                if(kval == 1){
                    $("#kundliDiv").attr('hidden',false);
                    $('#kundliDiv').show('slow');
                }else{
                    $('#kundliDiv').hide('slow');
                }

                //$("div.desc").hide();
                //$("#Cars" + test).show();
            });
        });

        $(document).ready(function(){
            $('#bros').on('change', function(){
                var brosID = $(this).val();
                console.log(brosID);
                if(brosID){
                    $.ajax({
                        type:'POST',
                        url:'/ajaxLoad/brosMarried',
                        data:{
                            bros_id:brosID
                        },
                        dataType: "json",
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#mbros').html(data.opt);
                        }
                    });
                }else{
                    $('#mbros').html('<option value="">Select brothers first</option>');
                }
            });
        });

        $(document).ready(function(){
            $('#sis').on('change', function(){
                var sisID = $(this).val();
                console.log(sisID);
                if(sisID){
                    $.ajax({
                        type:'POST',
                        url:'/ajaxLoad/sisMarried',
                        data:{
                            sis_id:sisID
                        },
                        dataType: "json",
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#msis').html(data.opt);
                        }
                    });
                }else{
                    $('#msis').html('<option value="">Select sister first</option>');
                }
            });
        });

        $(document).ready(function(){

            $('#cn_update').change(function(){
                var cntry = $(this).find(':selected').val();
                console.log(cntry);
                if(cntry!=77){
                    $('#st_update').hide().attr('hidden', true);
                    $('#ds_update').hide().attr('hidden', true);
                    $('#st_entry').attr('hidden', false);
                    $('#ds_entry').attr('hidden', false);
                    // $('#st_update').attr('hidden', true);
                    // $('#ds_update').attr('hidden', true);
                }
                else{
                    $('#st_entry').attr('hidden', true);
                    $('#ds_entry').attr('hidden', true);
                    $('#st_update').attr('hidden', false).show();
                    $('#ds_update').attr('hidden', false).show();
                    /*$('#st_update').show();
                    $('#ds_update').show();*/
                }
            });
        });

        $(document).ready(function(){
            $('#st_update').on('change', function(){
                //var stateID = $(this).val();
                var stateID = $(this).find(':selected').attr("data-id");
                console.log(stateID);
                if(stateID){
                    $.ajax({
                        type:'POST',
                        url:'/ajaxLoad/select-district',
                        data:{
                            state_id:stateID
                        },
                        dataType: "json",
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#ds_update').html(data.opt);
                        }
                    });
                }else{
                    $('#ds_update').html('<option value="">Select state first</option>');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('#basic-info-update').on('click', function () {

                var bis = $('#basic-info-update').val();
                var fn = $('#fn_update').val();
                var ln = $('#ln_update').val();
                //var gen = $('#gen_update').val();
                //var rel = $('#rel_update').val();
                //var com = $('#com_update').val();
                var cas = $('#cas_update').val();
                var mt = $('#mt_update').val();

                var ms = $('#ms_update').val();
                var ht = $('#ht_update').val();

                var cn = $('#cn_update').val();
                if(cn==77){
                    var st = $('#st_update').val();
                    var ds = $('#ds_update').val();
                }else{
                    var st = $('#st_entry').val();
                    var ds = $('#ds_entry').val();
                }
                //console.log(st);
                //console.log(ds);

                //console.log('reached here');

                if(fn && ln && cas && mt && ms && ht && cn && st && ds){
                    $.ajax({
                        url: "/ajaxUpdate/updateBasicInfo",
                        method: 'post',
                        data: {
                            bis:bis,
                            first_name: fn,
                            last_name: ln,
                            //community_id:com,
                            caste_id:cas,
                            tongue_id:mt,
                            marital_id:ms,
                            height_id:ht,
                            country_id:cn,
                            state:st,
                            district:ds
                        },
                        dataType: "json",
                        success: function (data, status) {
                            // var message = data.msg;
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                            //console.log(data.msg);
                            //console.log(status);
                        }
                    });
                }else{
                    $.alert({
                        title: 'Alert!',
                        content: 'Please fill all the fields of Basic Information Section',
                    });
                }

            });

            $('#education-career-update').on('click', function () {

                var ecs = $('#education-career-update').val();
                var education = $('#education').val();
                var degree = $('#degree').val();
                var university = $('#university').val();
                var otherDeg = $('#otherDeg').val();

                var sector = $('#sector').val();
                var occupation = $('#occupation').val();
                var organization = $('#organization').val();
                var income = $('#income').val();

                if(education && degree && university && otherDeg && sector && occupation && organization && income){

                    $.ajax({
                        url: "/ajaxUpdate/updateEduCareerInfo",
                        method: 'post',
                        data: {
                            ecs:ecs,
                            education_id: education,
                            degree_id: degree,
                            university_id:university,
                            other_deg:otherDeg,
                            sector_id:sector,
                            occupation_id:occupation,
                            working_in:organization,
                            income_id:income
                        },
                        dataType: "json",
                        success: function (data, status) {
                            //var message = data.msg;
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                            console.log(data);
                            console.log(status);
                        }
                    });
                }else{
                    $.alert({
                        title: 'Alert!',
                        content: 'Please fill all the fields of Education & Career',
                    });
                }


            });

            $('#family-info-update').on('click', function () {

                var fis = $('#family-info-update').val();
                var father_name = $('#father_name').val();
                var mother_name = $('#mother_name').val();
                var father = $('#father').val();
                var mother = $('#mother').val();
                var bros = $('#bros').val();
                var mbros = $('#mbros').val();
                var sis = $('#sis').val();
                var msis = $('#msis').val();

                var affluence = $('#affluence').val();
                var famType = $('#famType').val();
                var famValue = $('#famValue').val();
                var famIncome = $('#famIncome').val();

                if(father_name && mother_name && father && mother && bros && sis && affluence && famType && famValue && famIncome){
                    $.ajax({

                        url: "/ajaxUpdate/updateFamilyInfo",
                        method: 'post',
                        data: {
                            fis:fis,
                            father_name:father_name,
                            mother_name:mother_name,
                            father_id: father,
                            mother_id: mother,
                            bros:bros,
                            mbros:mbros,
                            sis:sis,
                            msis:msis,
                            famAffluence_id:affluence,
                            famType_id:famType,
                            famValue_id:famValue,
                            famIncome_id:famIncome
                        },
                        dataType: "json",
                        success: function (data, status) {
                            //var message = data.msg;
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                            //console.log(data);
                            //console.log(status);
                        }
                    });

                }else{

                    $.alert({
                        title: 'Alert!',
                        content: 'Please fill all the fields of Families Details, to update families section',
                    });
                }


            });

            $('#lifestyle-info-update').on('click', function () {

                var lis = $('#lifestyle-info-update').val();
                var diet = $('#diet').val();
                var smoke = $('#smoke').val();
                var drink = $('#drink').val();
                var pets = $("input[name='pets']:checked").val();
                var house = $('#house').val();
                var car = $('#car').val();
                var btype = $('#btype').val();
                var complexion = $('#complexion').val();
                var wt = $('#wt').val();
                var bGroup = $('#bGroup').val();
                var hiv = $('#hiv').val();
                var thalassemia = $('#thalassemia').val();
                var challenged = $('#challenged').val();
                var citizenship = $('#citizenship').val();
                var langs = $('#langs').val();
                //console.log(langs);

                if(diet && smoke && drink && pets && house && car && btype && complexion && wt && bGroup && hiv &&
                    thalassemia && challenged && citizenship && langs) {

                    $.ajax({
                        url: "/ajaxUpdate/lifestyleInfo",
                        method: 'post',
                        data: {
                            lis: lis,
                            diet_id: diet,
                            smoke_id: smoke,
                            drink_id: drink,
                            pets: pets,
                            house: house,
                            car: car,
                            body_id: btype,
                            complexion_id: complexion,
                            weight_id: wt,
                            bGroup_id: bGroup,
                            hiv: hiv,
                            thalassemia_id: thalassemia,
                            challenged_id: challenged,
                            citizenship_id: citizenship,
                            langs: langs
                        },
                        dataType: "json",
                        success: function (data, status) {
                            //var message = data.msg;
                            setTimeout(function () {
                                toastr.success(data.msg);
                            }, 500);
                            console.log(data.msg);
                            console.log(status);
                        }
                    });
                }else{
                    $.alert({
                        title: 'Alert!',
                        content: 'Please fill all the fields of Families Details, to update families section',
                    });
                }
            });

            $('#likes-info-update').on('click', function () {

                var lik = $('#likes-info-update').val();
                var myHobbies = $('#my-hobbies').val();
                var myInterests  = $('#my-interests').val();
                console.log(myInterests);

                if(myHobbies.length===0 || myInterests.length===0) {

                    $.alert({
                        title: 'Alert!',
                        content: 'Please select your hobbies and interests, may your life partner have similar hobbies and interests',
                    });

                }else{
                    $.ajax({
                        url: "/ajaxUpdate/likesInfo",
                        method: 'post',
                        data: {
                            lik:lik,
                            myhobbies:myHobbies,
                            myinterests:myInterests
                        },
                        dataType: "json",
                        success: function (data, status) {
                            var message = data.msg;
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                            console.log(data);
                            console.log(status);
                        }
                    });
                }


            });

            $('#caste-info-update').on('click', function () {

                var cas = $('#caste-info-update').val();
                var myCastes = $('#my-preferred-caste').val();
                console.log(myCastes);

                if(myCastes.length===0) {

                    $.alert({
                        title: 'Alert!',
                        content: 'Please select your preferred castes, we will search your partner within those caste',
                    });

                }else{
                    $.ajax({
                        url: "/ajaxUpdate/updateCasteInfo",
                        method: 'post',
                        data: {
                            cas: cas,
                            mycastes: myCastes
                        },
                        dataType: "json",
                        success: function (data, status) {
                            //var message = data.msg;
                            setTimeout(function () {
                                toastr.success(data.msg);
                            }, 500);
                            console.log(data);
                            console.log(status);
                        }
                    });
                }
            });

            $('#horoscope-info-update').on('click', function () {

                var his = $('#horoscope-info-update').val();
                var sunSign = $('#sunSign').val();
                var moonSign = $('#moonSign').val();
                var nakshatra = $('#nakshatra').val();
                var horo = $("input[name='horo']:checked").val();
                var manglik = $('#manglik').val();
                var hm = $('#hm').val();
                var hp = $('#hp').val();
                var kundli_details = $('#kundli_details').val();
                //console.log('Hello');

                if(sunSign && moonSign && nakshatra && horo && manglik && hm && hp) {

                    $.ajax({
                        url: "/ajaxUpdate/horoscopeInfo",
                        method: 'post',
                        data: {
                            his:his,
                            sun_id:sunSign,
                            moon_id:moonSign,
                            nakshatra_id:nakshatra,
                            horoscope:horo,
                            manglik_id:manglik,
                            hm:hm,
                            hp:hp,
                            kundli_details:kundli_details
                        },
                        dataType: "json",
                        success: function (data, status) {
                            var message = data.msg;
                            setTimeout(function(){
                                toastr.success(data.msg);
                            }, 500);
                            console.log(data);
                            console.log(status);
                        }
                    });

                }else{
                    $.alert({
                        title: 'Alert!',
                        content: 'Please select your preferred castes, we will search your partner within those caste',
                    });
                }


            });

        });
    </script>
@endsection