@extends('layouts.app')

@section('title', 'Page Title')

{{--@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection--}}

@section('page-css')
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

    <div class="content">
        <div class="row justify-content-center">
            <h3 class="text-muted mb-5">Welcome {{ $profile->first_name.': '}}<a href="{{'/profile/'.$profile->pid}}">{{$profile->pid}}</a></h3>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-success">
                        <h2 class="">Basic Information</h2>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="fn_update">First name</label>
                                <input type="text" class="form-control" id="fn_update" name="fn_update" placeholder="First name" value="{{ucfirst($profile->first_name)}}" required>

                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="ln_update">Last name</label>
                                <input type="text" class="form-control" id="ln_update" name="ln_update" placeholder="Last name" value="{{ucfirst($profile->last_name)}}" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <!-- *** -->
                            <div class="col-md-4 mb-3 px-2">
                                <label for="rel_update">Religion</label>
                                <select id="rel_update" name="rel_update" class="form-control" disabled>
                                    <option>Choose...</option>
                                    @foreach($religions as $religion)
                                        <option value="{{$religion->id}}" {{($profile->religion_id==$religion->id)?'Selected':''}}>{{$religion->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="gen_update">Gender</label>
                                <select id="gen_update" name="gen_update" class="form-control" disabled>
                                    <option selected>Choose...</option>
                                    <option value="1" {{($profile->gender==1)?'Selected':''}}>Male</option>
                                    <option value="2" {{($profile->gender==2)?'Selected':''}}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="dob">Date of Birth</label>
                                <input type="text" class="form-control" id="dob" value="{{Carbon\Carbon::parse($profile->dob)->isoFormat('LL')}}" disabled>
                                {{-- {{ Carbon\Carbon::parse($profile->dob)->isoFormat('LLL') }}--}}
                                {{--                                    <input type="date" class="form-control" name="dob" id="dob" value="{{$profile->dob}}"  min="1951-01-01" max="1998-12-31">--}}
                            </div>
                            <!-- *** -->
                            <div class="col-md-6 mb-3 px-2">
                                <label for="com_update">Community</label>
                                <select id="com_update" name="com_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($languages as $community)
                                        <option value="{{$community->value}}" {{($profile->community_id==$community->value)?'Selected':''}}>{{$community->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="mt_update">Mother Tongue</label>
                                <select id="mt_update" name="mt_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($tongues as $tongue)
                                        <optgroup label="{{$tongue['direction']}}">
                                            @foreach($tongue['lang'] as $lang)
                                                <option value="{{$lang["id"]}}" {{($profile->language_id==$lang["id"])?'Selected':''}}>{{$lang["name"]}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <!-- *** -->
                            <div class="col-md-6 mb-3 px-2">
                                <label for="ms_update">Marital Status</label>
                                <select id="ms_update" name="ms_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($maritals as $marital)
                                        <option value="{{$marital->id}}" {{($profile->marital_id==$marital->id)?'Selected':''}}>{{$marital->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="ht_update">Height</label>
                                <select id="ht_update" name="ht_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($heights as $height)
                                        <option value="{{$height->id}}" {{($profile->height_id==$height->id)?'Selected':''}}>{{$height->feet}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- *** -->
                            <div class="col-md-4 mb-3 px-2">
                                <label for="cn_update">Living In Country:</label>
                                <select id="cn_update" name="cn_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($countries as $country)
                                        <optgroup label="{{$country['alpha']}}">
                                            @foreach($country['coni'] as $con)
                                                <option value="{{$con["id"]}}" {{($profile->country_id==$con["id"])?'Selected':''}}>{{$con["name"]}}</option>
                                                {{--                                                <option value="{{$con["id"]}}" {{($profile->country_id==0)?(77==$con["id"]):$profile->country_id==$con['id']?'Selected':''}}>{{$con["name"]}}</option>--}}
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="st_update">State</label>
                                <select id="st_update" name="st_update" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->id}}" {{($profile->state_id==$state->id)?'Selected':''}}>{{$state->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="ds_update">Districts/Cities</label>
                                <select id="ds_update" name="ds_update" class="form-control">
                                    <option value="">Select state first</option>
                                    @foreach($userDistricts as $ud)
                                        <option value="{{$ud->id}}" {{($profile->district_id==$ud->id)?'Selected':''}}>{{$ud->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" id="basic-info-update" name="basic-info-update" value="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-warning">
                        <h2 class="">Caste Preferences:</h2>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12 mb-3 px-2">
                                <label for="my-preferred-caste">Preferred caste for marriage? (Select more than one)</label>
                                <select multiple id="my-preferred-caste" class="js-example-basic-multiple form-control d-sm-none d-md-block">
                                    <option value="">Choose...</option>
                                    @foreach($allCastes as $caste)
                                        <option value="{{$caste->value}}" {{in_array($caste->value,json_decode($profile->mycastes))?'Selected':''}}>{{$caste->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="caste-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-danger">
                        <h2 class="">Education & Career</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="education">Highest Education</label>
                                <select id="education" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($educations as $education)
                                        <optgroup label="{{$education['stream']}}">
                                            @foreach($education['edu'] as $edu)
                                                <option value="{{$edu['id']}}" {{($profile->education_id==$edu['id'])?'Selected':''}}>{{$edu['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="degree">UG Degree</label>
                                <select id="degree" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($degrees as $degree)
                                        <option value="{{$degree->id}}" {{($profile->degree_id==$degree->id)?'Selected':''}}>{{$degree->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="university">University</label>
                                <select id="university" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($universities as $university)
                                        <option value="{{$university->id}}" {{($profile->university_id==$university->id)?'Selected':''}}>{{$university->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="otherDeg">Other UG Degree</label>
                                <input type="text" class="form-control" name="otherDeg" id="otherDeg" placeholder="Other Degree" value="{{$profile->other_deg}}">
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="sector">Employed In (Sector)</label>
                                <select id="sector" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($sectors as $sector)
                                        <option value="{{$sector->id}}" {{($profile->sector_id==$sector->id)?'Selected':''}}>{{$sector->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="occupation">Occupation</label>
                                <select id="occupation" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($occupations as $occupation)
                                        <optgroup label="{{$occupation['category']}}">
                                            @foreach($occupation['occ'] as $occ)
                                                <option value="{{$occ['id']}}" {{($profile->occupation_id==$occ['id'])?'Selected':''}}>{{$occ['name']}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="organization">Working In</label>
                                <input type="text" class="form-control" name="organization" id="organization" placeholder="Name of Organization" value="{{$profile->working_in}}">
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="income">Annual Income</label>
                                <select id="income" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($incomes as $income)
                                        <option value="{{$income->id}}" {{($profile->income_id==$income->id)?'Selected':''}}>{{$income->ranze}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="education-career-update" type="submit">Submit form</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-info">
                        <h2 class="">Family Details</h2>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="father">Father Is</label>
                                <select id="father" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($fathers as $father)
                                        <option value="{{$father->id}}" {{($profile->father_id==$father->id)?'Selected':''}}>{{$father->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="mother">Mother Is</label>
                                <select id="mother" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($mothers as $mother)
                                        <option value="{{$mother->id}}" {{($profile->mother_id==$mother->id)?'Selected':''}}>{{$mother->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-2 px-2">
                                <label for="brother">Brothers</label>
                                {{--<div class="input-group">
                                    --}}{{--<div class="input-group-prepend">
                                        <span class="input-group-text">No of Brothers of which Married</span>
                                    </div>--}}{{--
                                    <input type="text" id="bros" aria-label="First name" placeholder="No. of Brothers" class="form-control" value="{{$profile->bros}}">
                                    <input type="text" id="mbros" aria-label="Last name" placeholder="married one's" class="form-control" value="{{$profile->mbros}}">
                                </div>--}}

                                <div class="input-group mb-2">
                                    <select class="custom-select" style="margin-left: 0; background: none" id="bros">
                                        <option selected>Brothers</option>
                                        @for($b=1;$b<=7;$b++)
                                            <option value="{{$b}}" {{($profile->bros==$b)?'Selected':''}}>{{$b}}</option>
                                        @endfor
                                    </select>
                                    <select class="custom-select" style="background: none" id="mbros">
                                        <option selected>Married ones</option>
                                        @for($mb=1;$mb<=$profile->bros;$mb++)
                                            <option value="{{$mb}}" {{($profile->mbros==$mb)?'Selected':''}}>{{$mb}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-2 px-2">
                                <label for="sisters">Sisters</label>
                                {{--<div class="input-group">
                                    --}}{{--<div class="input-group-prepend">
                                        <span class="input-group-text">No of Sisters of which Married</span>
                                    </div>--}}{{--
                                    <input type="text" id="sis" aria-label="sisters" placeholder="No. of Sisters" class="form-control" value="{{$profile->sis}}">
                                    <input type="text" id="msis" aria-label="married_sis" placeholder="married one's" class="form-control" value="{{$profile->msis}}">
                                </div>--}}

                                <div class="input-group mb-2">
                                    <select class="custom-select" style="margin-left: 0; background: none" id="sis">
                                        <option selected>Sisters</option>
                                        @for($s=1;$s<=7;$s++)
                                            <option value="{{$s}}" {{($profile->sis==$s)?'Selected':''}}>{{$s}}</option>
                                        @endfor
                                    </select>
                                    <select class="custom-select" style="background: none" id="msis">
                                        <option selected>Married ones</option>
                                        @for($ms=1;$ms<=$profile->sis;$ms++)
                                            <option value="{{$ms}}" {{($ms==$profile->msis)?'Selected':''}}>{{$ms}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="affluence">Family Status</label>
                                <select id="affluence" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($famAffluence as $affluence)
                                        <option value="{{$affluence->id}}" {{($profile->famAffluence_id==$affluence->id)?'Selected':''}}>{{$affluence->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famType">Family Type</label>
                                <select id="famType" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($famTypes as $famType)
                                        <option value="{{$famType->id}}" {{($profile->famType_id==$famType->id)?'Selected':''}}>{{$famType->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famValue">Family Values</label>
                                <select id="famValue" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($famValues as $value)
                                        <option value="{{$value->id}}" {{($profile->famValue_id==$value->id)?'Selected':''}}>{{$value->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="famIncome">Family Income</label>
                                <select id="famIncome" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($famIncomes as $famIncome)
                                        <option value="{{$famIncome->id}}" {{($profile->famIncome_id==$famIncome->id)?'Selected':''}}>{{$famIncome->level}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="family-info-update" type="submit">Update Family Details</button>

                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-warning">
                        <h2 class="">Lifestyle</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3 px-2">
                                <label for="diet">Dietary Habits</label>
                                <select id="diet" name="diet" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($diets as $diet)
                                        <option value="{{$diet->id}}" {{($profile->diet_id==$diet->id)?'Selected':''}}>{{$diet->type}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="smoke">Smoking Habit</label>
                                <select id="smoke" name="smoke" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($smokes as $smoke)
                                        <option value="{{$smoke->id}}" {{($profile->smoke_id==$smoke->id)?'Selected':''}}>{{$smoke->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3 px-2">
                                <label for="drink">Drinking Habits</label>
                                <select id="drink" name="drink" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($drinks as $drink)
                                        <option value="{{$drink->id}}" {{($profile->drink_id==$drink->id)?'Selected':''}}>{{$drink->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-4 mt-4 px-2">
                                <label class="mr-5">Opened to Pets: </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pets-1" name="pets" value="1" class="custom-control-input" {{($profile->pets==1)?'checked':''}}>
                                    <label class="custom-control-label" for="pets-1"> Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="pets-2" name="pets" value="0" class="custom-control-input" {{($profile->pets==0)?'checked':''}}>
                                    <label class="custom-control-label" for="pets-2"> No</label>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="house">Own a House?</label>
                                <select id="house" name="house" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($profile->house==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($profile->house==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="car">Own a Car?</label>
                                <select id="car" name="car" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($profile->car==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($profile->car==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="btype">Body type</label>
                                <select id="btype" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($bodies as $body)
                                        <option value="{{$body->id}}" {{($profile->body_id==$body->id)?'Selected':''}}>{{$body->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="complexion">Complexion</label>
                                <select id="complexion" name="complexion" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($complexions as $complexion)
                                        <option value="{{$complexion->id}}" {{($profile->complexion_id==$complexion->id)?'Selected':''}}>{{$complexion->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="wt">Weight(kgs)</label>
                                <select id="wt" name="wt" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($wts as $wt)
                                        <option value="{{$wt}}" {{($profile->weight_id==$wt)?'Selected':''}}>{{$wt.' kgs'}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="bGroup">Blood Group</label>
                                <select id="bGroup" name="bGroup" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($bGroups as $value)
                                        <option value="{{$value->id}}" {{($profile->bGroup_id==$value->id)?'Selected':''}}>{{$value->type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hiv">HIV+</label>
                                <select id="hiv" name="hiv" class="form-control">
                                    <option value =''>Please Select</option>
                                    <option value ='1' {{($profile->hiv==1)?'Selected':''}}>Yes</option>
                                    <option value ='2' {{($profile->hiv==2)?'Selected':''}}>No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="thalassemia">Thalassemia</label>
                                <select id="thalassemia" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($thalassemia as $value)
                                        <option value="{{$value->id}}" {{($profile->thalassemia_id==$value->id)?'Selected':''}}>{{$value->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 px-2">
                                <label for="challenged">Physically Challenged?</label>
                                <select id="challenged" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($challenges as $challenge)
                                        <option value="{{$challenge->id}}" {{($profile->challenged_id==$challenge->id)?'Selected':''}}>{{$challenge->status}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="citizenship">Residential Status</label>
                                <select id="citizenship" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($citizenship as $value)
                                        <option value="{{$value->id}}" {{($profile->citizenship_id==$value->id)?'Selected':''}}>{{$value->status}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12 mb-3 px-2">
                                <label for="langs">Languages Known?</label>
                                <select multiple id="langs" name="langs[]" class="js-example-basic-multiple form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($languages as $language)
                                        <option value="{{$language->value}}" {{in_array($language->value,str_replace('"','', (array)json_decode($profile->langs)))?'Selected':''}}>{{$language->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="lifestyle-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom" style="background-color: crimson">
                        <h2 class="">Your Likes:</h2>
                    </div>
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-6 mb-3 px-2">
                                <label for="my-hobbies">Hobbies?</label>
                                <select multiple id="my-hobbies" class="js-example-basic-multiple form-control d-sm-none d-md-block" required>
                                    <option value="">Choose...</option>
                                    @foreach($hobbies as $hobby)
                                        <option value="{{$hobby->value}}" {{in_array($hobby->value,json_decode($profile->myhobbies))?'Selected':''}}>{{$hobby->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="my-interests">Interests?</label>
                                <select multiple id="my-interests" class="js-example-basic-multiple form-control" required>
                                    <option value="">Choose...</option>
                                    @foreach($interests as $interest)
                                        <option value="{{$interest->value}}" {{in_array($interest->value,json_decode($profile->myinterests))?'Selected':''}}>{{$interest->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="likes-info-update" type="submit">Submit form</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom bg-primary">
                        <h2 class="">Horoscope</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            {{--<div class="col-md-4 mb-3 px-2">
                                <label for="cn_update">Living In Country:</label>
                                <select id="cn_update" name="cn_update" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($countries as $country)
                                        <optgroup label="{{$country['alpha']}}">
                                            @foreach($country['coni'] as $con)
                                                <option value="{{$con["id"]}}" {{($profile->country_id==$con["id"])?'Selected':''}}>{{$con["name"]}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>--}}
                            {{--<div class="col-md-6 mb-3 px-2">
                                <label for="sob">Place of Birth</label>
                                <select id="sob" class="form-control">
                                    <option value="">Choose...</option>
                                    @foreach($states as $state)
                                        <option value="{{$state->text}}" {{($profile->state_id==$state->id)?'Selected':''}}>{{$state->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 px-2">
                                <label for="district">Districts/Cities</label>
                                <select id="district" class="form-control">
                                    <option value="7">Select state first</option>
                                </select>
                            </div>--}}
                            <div class="col-md-4 mb-3 px-2">
                                <label for="sunSign">Sun Sign</label>
                                <select id="sunSign" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($signs as $ss)
                                        <option value="{{$ss->id}}" {{($profile->sun_id==$ss->id)?'Selected':''}}>{{$ss->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="moonSign">Moon Sign</label>
                                <select id="moonSign" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($signs as $ms)
                                        <option value="{{$ms->id}}" {{($profile->moon_id==$ms->id)?'Selected':''}}>{{$ms->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="nakshatra">Nakshatra</label>
                                <select id="nakshatra" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($nakshatras as $nak)
                                        <option value="{{$nak->id}}" {{($profile->nakshatra_id==$nak->id)?'Selected':''}}>{{$nak->text}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="manglik">Manglik Status</label>
                                <select id="manglik" class="form-control">
                                    <option>Choose...</option>
                                    @foreach($mangliks as $manglik)
                                        <option value="{{$manglik->id}}" {{($profile->manglik_id==$manglik->id)?'Selected':''}}>{{$manglik->status}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hm">Horoscope Match</label>
                                <select id="hm" class="form-control">
                                    <option>Choose...</option>
                                    <option value=1 {{($profile->hm==1)?'Selected':''}}>Necessary</option>
                                    <option value=0 {{($profile->hm==0)?'Selected':''}}>Not Necessary</option>
                                    <option value="3" {{($profile->hm==3)?'Selected':''}}>May be</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 px-2">
                                <label for="hp">Horoscope Privacy</label>
                                <select id="hp" class="form-control">
                                    <option>Choose...</option>
                                    <option value="1" {{($profile->hp==1)?'Selected':''}}>Visible</option>
                                    <option value="0" {{($profile->hp==0)?'Selected':''}}>Hide</option>
                                    <option value="3" {{($profile->hp==3)?'Selected':''}}>On demand</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-4 mt-4 px-2">
                                <label class="mr-5">I have Horoscope: </label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="horo-1" name="horo" value="1" class="custom-control-input" {{($profile->horoscope==1)?'checked':''}}>
                                    <label class="custom-control-label" for="horo-1"> Yes</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="horo-2" name="horo" value="0" class="custom-control-input" {{($profile->horoscope==0)?'checked':''}}>
                                    <label class="custom-control-label" for="horo-2"> No</label>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="horoscope-info-update" type="submit">Update Astro Details</button>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2 class="">Education & Career</h2>
                    </div>
                    <div class="card-body">
                        <form >
                            <div class="form-row">
                                <div class="col-md-6 mb-3 px-2">
                                    <label for="education">Highest Education</label>
                                    <select id="education" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($educations as $education)
                                            <option value="{{$education->id}}" {{($profile->education_id==$education->id)?'Selected':''}}>{{$education->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 px-2">
                                    <label for="degree">UG Degree</label>
                                    <select id="degree" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($degrees as $degree)
                                            <option value="{{$degree->id}}" {{($profile->degree_id==$degree->id)?'Selected':''}}>{{$degree->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 px-2">
                                    <label for="university">University</label>
                                    <select id="university" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($universities as $university)
                                            <option value="{{$university->id}}" {{($profile->university_id==$university->id)?'Selected':''}}>{{$university->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3 px-2">
                                    <label for="otherDeg">Other UG Degree</label>
                                    <input type="text" class="form-control" name="otherDeg" id="otherDeg" placeholder="Other Degree" value="{{$profile->other_deg}}">
                                </div>

                                --}}{{--<b>...</b>--}}{{--
                                <div class="col-md-6 mb-3 px-2">
                                    <label for="sector">Employed In (Sector)</label>
                                    <select id="sector" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($sectors as $sector)
                                            <option value="{{$sector->id}}" {{($profile->sector_id==$sector->id)?'Selected':''}}>{{$sector->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3 px-2">
                                    <label for="occupation">Occupation</label>
                                    <select id="occupation" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($occupations as $occupation)
                                            <option value="{{$occupation->id}}" {{($profile->occupation_id==$occupation->id)?'Selected':''}}>{{$occupation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3 px-2">
                                    <label for="organization">Working In</label>
                                    <input type="text" class="form-control" name="organization" id="organization" placeholder="Name of Organization" value="{{$profile->working_in}}">
                                </div>

                                <div class="col-md-6 mb-3 px-2">
                                    <label for="occupation">Occupation</label>
                                    <select id="occupation" class="form-control">
                                        <option>Choose...</option>
                                        @foreach($incomes as $income)
                                            <option value="{{$income->id}}" {{($profile->income_id==$income->id)?'Selected':''}}>{{$income->ranze}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">

                                </div>

                                <div class="col-md-6 mb-3">

                                </div>

                                <div class="col-md-6 mb-3 px-2">

                                </div>

                                <div class="col-md-6 mb-3 px-2">

                                </div>

                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="validationServer03">City</label>
                                    <input type="text" class="form-control" id="validationServer03" placeholder="City" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid city.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer04">State</label>
                                    <input type="text" class="form-control" id="validationServer04" placeholder="State" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid state.
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="validationServer05">Zip</label>
                                    <input type="text" class="form-control" id="validationServer05" placeholder="Zip" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid zip.
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit form</button>
                            --}}{{--<div class="d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>--}}{{--

                        </form>
                    </div>
                </div>
            </div>

        </div>--}}
    </div>
@endsection

@section('page-script')
    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script src="/assets/plugins/jquery-mask-input/jquery.mask.min.js"></script>
@endsection

@section('app-script')

    @include('request.last_online')
    @include('request.load_notification')

    <script>
        $(document).ready(function(){
            $('#bros').on('change', function(){
                var brosID = $(this).val();
                console.log(brosID);
                if(brosID){
                    $.ajax({
                        type:'POST',
                        url:'/ajax/brosMarried',
                        data:{
                            bros_id:brosID
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#mbros').html(data);
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
                        url:'/ajax/sisMarried',
                        data:{
                            sis_id:sisID
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#msis').html(data);
                        }
                    });
                }else{
                    $('#msis').html('<option value="">Select brothers first</option>');
                }
            });
        });

    </script>
    <script>
        /*$(document).ready(function(){
            $('#rel_update').on('change', function(){
                var religionID = $(this).val();
                console.log(religionID);
                if(religionID){
                    $.ajax({
                        type:'POST',
                        url:'ajax/select-caste.php',
                        data:{
                            religion_id:religionID
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#cas_update').html(data);
                        }
                    });
                }else{
                    $('#cas_update').html('<option value="">Select religion first</option>');
                }
            });
        });*/

        $(document).ready(function(){
            $('#st_update').on('change', function(){
                var stateID = $(this).val();
                if(stateID){
                    $.ajax({
                        type:'POST',
                        url:'ajax/select-district.php',
                        data:{
                            state_id:stateID
                        },
                        success:function(data,status){
                            //console.log(data);
                            //console.log(status);
                            $('#ds_update').html(data);
                        }
                    });
                }else{
                    $('#ds_update').html('<option value="">Select state first</option>');
                }
            });
        });
    </script>



    <script>

        /*======== 5. TOASTER ========*/
        var toaster = $('#toaster');
        function callToaster(positionClass, message) {
            toastr.options = {
                closeButton: true,
                debug: false,
                newestOnTop: false,
                progressBar: true,
                positionClass: positionClass,
                preventDuplicates: false,
                onclick: null,
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };
            toastr.success(message);
        }
        // if(toaster.length != 0){
        //
        //     if (document.dir != "rtl") {
        //         callToaster("toast-top-right");
        //     } else {
        //         callToaster("toast-top-left");
        //     }
        //
        // }

    </script>

    <script>

        // ==================================
        // Basic Information
        // Update profiles table
        // ==================================
        $(document).ready(function () {

            $('#basic-info-update').on('click', function () {

                var bis = $('#basic-info-update').val();
                var fn = $('#fn_update').val();
                var ln = $('#ln_update').val();
                //var gen = $('#gen_update').val();
                //var rel = $('#rel_update').val();
                var com = $('#com_update').val();
                var mt = $('#mt_update').val();

                var ms = $('#ms_update').val();
                var ht = $('#ht_update').val();

                var cn = $('#cn_update').val();
                var st = $('#st_update').val();
                var ds = $('#ds_update').val();
                //console.log('reached here');
                $.ajax({
                    url: "/ajax/updateBasicInfo",
                    method: 'post',
                    data: {
                        bis:bis,
                        first_name: fn,
                        last_name: ln,
                        community_id:com,
                        language_id:mt,
                        marital_id:ms,
                        height_id:ht,
                        country_id:cn,
                        state_id:st,
                        district_id:ds
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data.msg);
                        console.log(status);
                    }
                });
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

                $.ajax({
                    url: "/ajax/updateEduCareerInfo",
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
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }

                        }
                        console.log(data);
                        console.log(status);
                    }
                });
            });

        });

    </script>

    <script>
        // ==================================
        // Family Information
        // Update profiles table
        // ==================================
        $(document).ready(function () {

            $('#family-info-update').on('click', function () {

                var fis = $('#family-info-update').val();
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

                $.ajax({
                    url: "/ajax/updateFamilyInfo",
                    method: 'post',
                    data: {
                        fis:fis,
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
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data);
                        console.log(status);
                    }
                });
            });
        });
    </script>

    <script>
        // ==================================
        // Lifestyle Information
        // Update profiles table
        // ==================================
        $(document).ready(function () {

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
                console.log(langs);

                $.ajax({
                    url: "/ajax/lifestyleInfo",
                    method: 'post',
                    data: {
                        lis:lis,
                        diet_id:diet,
                        smoke_id:smoke,
                        drink_id:drink,
                        pets:pets,
                        house:house,
                        car:car,
                        body_id:btype,
                        complexion_id:complexion,
                        weight_id:wt,
                        bGroup_id:bGroup,
                        hiv:hiv,
                        thalassemia_id:thalassemia,
                        challenged_id:challenged,
                        citizenship_id:citizenship,
                        langs:langs
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data.msg);
                        console.log(status);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('#likes-info-update').on('click', function () {

                var lik = $('#likes-info-update').val();
                var myHobbies = $('#my-hobbies').val();
                var myInterests  = $('#my-interests').val();
                console.log(myInterests);

                $.ajax({
                    url: "/ajax/likesInfo",
                    method: 'post',
                    data: {
                        lik:lik,
                        myhobbies:myHobbies,
                        myinterests:myInterests
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data);
                        console.log(status);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('#caste-info-update').on('click', function () {

                var cas = $('#caste-info-update').val();
                var myCastes = $('#my-preferred-caste').val();
                console.log(myCastes);

                $.ajax({
                    url: "/ajax/updateCasteInfo",
                    method: 'post',
                    data: {
                        cas:cas,
                        mycastes:myCastes
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data);
                        console.log(status);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('#horoscope-info-update').on('click', function () {

                var his = $('#horoscope-info-update').val();
                var sunSign = $('#sunSign').val();
                var moonSign = $('#moonSign').val();
                var nakshatra = $('#nakshatra').val();
                var horo = $("input[name='horo']:checked").val();
                var manglik = $('#manglik').val();
                var hm = $('#hm').val();
                var hp = $('#hp').val();


                //console.log('Hello');

                $.ajax({
                    url: "/ajax/horoscopeInfo",
                    method: 'post',
                    data: {
                        his:his,
                        sun_id:sunSign,
                        moon_id:moonSign,
                        nakshatra_id:nakshatra,
                        horoscope:horo,
                        manglik_id:manglik,
                        hm:hm,
                        hp:hp
                    },
                    dataType: "json",
                    success: function (data, status) {
                        var message = data.msg;
                        if(toaster.length != 0){
                            if (document.dir != "rtl") {
                                callToaster("toast-top-right",message);
                            } else {
                                callToaster("toast-top-left",message);
                            }
                        }
                        console.log(data);
                        console.log(status);
                    }
                });
            });
        });
    </script>

@endsection