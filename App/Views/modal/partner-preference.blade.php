<!-- Signup modal -->
<div class="modal fade" id="partnerPreferenceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog signin-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div> -->
            <div class="modal-body signin-modal">

                <!-- Tab Button -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#caste" role="tab" aria-controls="home" aria-selected="true">Caste</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#others" role="tab" aria-controls="profile" aria-selected="false">Others</a>
                    </li>
                </ul>

                <div class="tab-content signin-tab" id="myTabContent">

                    <!-- Tab Content 1 -->
                    <div class="tab-pane fade show active" id="caste" role="tabpanel" aria-labelledby="profile-tab">
                        <form class="mb-5 form">

                            <h4 class="text-blue mt-4">Select your caste preferences</h4>
                            <div class="form-group">
                                <select class="js-example-basic-multiple select-multiple" name="states[]" multiple="multiple">
                                    <option value="AL">Alabama</option>
                                    <option value="AL">UP</option>
                                    <option value="AL">Bihar</option>
                                    <option value="AL">WB</option>
                                    <option value="AL">MP</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>


                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck10">
                                <label class="form-check-label" for="exampleCheck1">Caste no bar (willing to marry in any caste)</label>
                            </div>
                            <button type="submit" class="btn btn-green btn-block">Save</button>
                        </form>
                    </div>



                    <!-- Tab Content 2 -->
                    <div class="tab-pane fade" id="others" role="tabpanel" aria-labelledby="home-tab">
                        <form class="mb-5 form">

                            <h4 class="text-blue mt-4">Partner Physical Traits</h4>

                            <div class="flex-row form-group">
                                <div class="flex-field-2">
                                    <label for="religion">Age min:</label>
                                    <select id="religion" name="religion">
                                        <option value="" selected>Select</option>
                                        <option value=1>Hindu</option>
                                        <option value=1>Muslim</option>
                                    </select>
                                </div>
                                <div class="flex-field-2">
                                    <label for="community">Age max:</label>
                                    <select name="community">
                                        <option value="" selected>Select</option>
                                        <option value=1>Hindi</option>
                                        <option value=1>English</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex-row form-group">
                                <div class="flex-field-2">
                                    <label for="religion">Min height:</label>
                                    <select id="religion" name="religion">
                                        <option value="" selected>Select</option>
                                        <option value=1>Hindu</option>
                                        <option value=1>Muslim</option>
                                    </select>
                                </div>
                                <div class="flex-field-2">
                                    <label for="community">Max height:</label>
                                    <select name="community">
                                        <option value="" selected>Select</option>
                                        <option value=1>Hindi</option>
                                        <option value=1>English</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck10">
                                <label class="form-check-label" for="exampleCheck1">Preferably Manglik <br>(leave unchecked if you are non-manglik)</label>
                            </div>

                            <button type="submit" class="btn btn-green btn-block">Save</button>

                        </form>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>
<!-- End signup modal -->