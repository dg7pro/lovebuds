<!-- Signup modal -->
<div class="modal fade" id="contactsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog signin-dialog">
        <div class="modal-content">

            <div class="modal-body signin-modal">

                <!-- Tab Button -->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="home" aria-selected="true">Contact</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false">T&C</a>
                    </li>
                </ul>

                <div class="tab-content signin-tab" id="myTabContent">

                    <!-- Tab Content 1 -->
                    <div class="tab-pane fade show active mb-5" id="signin" role="tabpanel" aria-labelledby="home-tab">
                        {{--<form>--}}
                            <h4 class="text-blue mt-4">Your contact details</h4>
                           {{-- <div class="form-group">
                                --}}{{--<label for="contactEmail">Email address</label>--}}{{--
                                <input type="email" id="contactEmail" class="form-control"  aria-describedby="emailHelp" placeholder="Email" value="{{$authUser->email}}" disabled>
                                <small id="emailHelp" class="form-text text-muted">Email associated with account can't be changed</small>
                            </div>--}}
                            <div class="form-group">
                                {{--<label for="contactMobile">Mobile no.</label>--}}
                                <input type="text" id="contactMobile" class="form-control"  aria-describedby="mobileHelp" placeholder="Mobile no. (10 digits)" value="{{$authUser->mobile}}" {{$authUser->mv?'disabled':''}} required>
                                <small id="mobileHelp" class="form-text text-muted">Mobile no: Primary contact number - {{$authUser->mv?'verified':''}}</small>
                            </div>
                            <div class="form-group">
                                {{--<label for="contactWhatsapp">Whatsapp no.</label>--}}
                                <input type="text" id="contactWhatsapp" class="form-control"  aria-describedby="whatsappHelp" placeholder="Enter whatsapp no." value="{{$authUser->whatsapp}}" required>
                                <small id="whatsappHelp" class="form-text text-muted">Whatsapp no: For sending & receiving interest</small>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" id="one_way_cb" name="one_way" {{$authUser->one_way?'checked':''}}>
                                <label for="one_way_cb">Enable Oneway Privacy</label>
                                <div class="form-text">
                                    Your contact details are not visible, instead you will receive notification when
                                    interested users tries to view your address. This way only you can contact them.
                                </div>
                            </div>

                            <button type="submit" id="contact-info-update" class="btn btn-blue mt-2">Save Setting</button>
                        {{--</form>--}}
                    </div>

                    <!-- Tab Content 2 -->
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="profile-tab">
                        <h5 class="text-blue mt-4 baloo">Terms & Conditions</h5>
                        <div class="mb-5">
                            <p class="baloo">By providing your contact number, you agree to abide by our rules of polite and gentle
                                conversation with other members, who are also searching their life partner like you.
                                In case you are not interested in any body’s profile, decline in gentle manner, respecting
                                the feeling of others. You will not do untimely or spam calls.
                            </p>
                            <p class="baloo">You also agree that contact number provided by you is of concerned & authorized person.
                                No third person is allowed to talk about, anyone else marriage, only parents and self are
                                allowed for marriage related talks, chats & dealings.
                            </p>
                            <p class="baloo">
                                In case of discrepancy we have power to block your account
                            </p>
                            <p class="baloo">Team JuMatrimony</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End signup modal -->