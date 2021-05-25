<!-- Signup modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="home" aria-selected="true">Sign In</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#signup" role="tab" aria-controls="profile" aria-selected="false">Sign Up</a>
                    </li>
                </ul>

                <!-- Login through social -->
                <div class="social_login">
                    <p>with your social network</p>
                    <ul class="social_log">
                        <li><img src="/img/facebook-colored.svg" alt=""></li>
                        <li><img src="/img/google-plus-colored.svg" alt=""></li>
                        <li><img src="/img/twitter-colored.svg" alt=""></li>
                    </ul>
                    <p>or</p>
                </div>


                <div class="tab-content signin-tab" id="myTabContent">

                    <!-- Tab Content 1 -->
                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="home-tab">
                        <form>
                            <div class="form-group">
                                <!-- <label for="exampleInputEmail1">Email address</label> -->
                                <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Email">
                            </div>
                            <div class="">
                                <!-- <label for="exampleInputPassword1">Password</label> -->
                                <input type="password" class="form-control" placeholder="Password">
                            </div>
                            <!-- <div class="form-group form-check">
                              <input type="checkbox" class="form-check-input" id="exampleCheck1">
                              <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div> -->
                            <p class="forgot-link"><a href="#">Forgot your Password?</a></p>
                            <button type="submit" class="btn btn-green btn-block">Login</button>
                            <p class="signin-link">Don't have an account? <a data-toggle="tab" href="#signup" role="tab">SignUp</a></p>
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