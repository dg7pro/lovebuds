<!-- Signup modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="home" aria-selected="true">Privacy</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false">Others</a>
                    </li>
                </ul>

                <div class="tab-content signin-tab" id="myTabContent">

                    <!-- Tab Content 1 -->
                    <div class="tab-pane fade show active mb-5" id="signin" role="tabpanel" aria-labelledby="home-tab">
                        <form>
                            <h4 class="text-blue mt-4">Your contact visibility</h4>
                            <div class="form-check my-1">
                                <input class="form-check-input" type="radio" name="contactRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Open to all (anyone can view your contact)
                                </label>
                            </div>
                            <div class="form-check my-1">
                                <input class="form-check-input" type="radio" name="contactRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Visible only on acceptance
                                </label>
                            </div>


                            <h4 class="text-blue mt-4">Photo visibility</h4>
                            <div class="form-check my-1">
                                <input class="form-check-input" type="radio" name="photoRadios" id="exampleRadios1" value="option1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Visible to everyone
                                </label>
                            </div>
                            <div class="form-check my-1">
                                <input class="form-check-input" type="radio" name="photoRadios" id="exampleRadios2" value="option2">
                                <label class="form-check-label" for="exampleRadios2">
                                    Visible only when you give permission
                                </label>
                            </div>
                            <button type="submit" class="btn btn-blue mt-5">Save Setting</button>
                        </form>
                    </div>

                    <!-- Tab Content 2 -->
                    <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="profile-tab">
                        <form>
                            <div class="form-group">
                                <!-- <label for="exampleInputEmail1">Mobile no.</label> -->
                                <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Mobile no. (10 digits)">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group">
                                <!-- <label for="exampleInputEmail1">Email address</label> -->
                                <input type="email" class="form-control"  aria-describedby="emailHelp" placeholder="Email">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                            <div class="form-group">
                                <!-- <label for="exampleInputPassword1">Password</label> -->
                                <input type="password" class="form-control" placeholder="New password">
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">I agree with tnc and privacy policy</label>
                            </div>


                            <button type="submit" class="btn btn-green btn-block">Register</button>
                            <p class="signin-link">Already have an account? <a data-toggle="tab" href="#signin" role="tab">Sign In</a></p>
                        </form>
                    </div>

                </div>

            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>
<!-- End signup modal -->