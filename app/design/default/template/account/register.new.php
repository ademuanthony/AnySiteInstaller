<?php
/**
 * Created by PhpStorm.
 * User: ANTHONY
 * Date: 3/25/2016
 * Time: 5:23 PM
 */
?>

<section>
    <div class="second-page-container">
        <div class="block">
            <div class="container">
                <div class="header-for-light">
                    <h1 class="wow fadeInRight animated" data-wow-duration="1s">Create new <span>Account</span></h1>
                </div>
                <div class="row">
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="block-form box-border wow fadeInLeft animated" data-wow-duration="1s">
                            <h3><i class="fa fa-user"></i>Personal Information</h3>
                            <hr>

                            <form role="form" action="<?php echo Core::getActionUrl('register')?>" method="post">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="Name" placeholder="Your fullname">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="LoginId" required
                                               name="LoginId" placeholder="Enter you desired username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" required id="password"
                                               name="Password" placeholder="Enter your password">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="EmailId"
                                               required placeholder="Enter a valid Email Address">
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" id="number" name="MobileNo"
                                               required placeholder="Enter your phone number">
                                    </div>


                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="Address"
                                               required placeholder="Enter your address">
                                    </div>

                                </div><!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Create Account</button>
                                </div>
                            </form>
                        </div>
                    </article>
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                        <div class="block-form box-border wow fadeInRight animated" data-wow-duration="1s">
                            <h3><i class="fa fa-check"></i>Conditions</h3>
                            <hr>
                            <p>
                                File in all the forms in order to get registered, all the asteris all the compulsory one.
                            </p>
                            <blockquote>
                                <p>
                                    <abbr title="." class="initialism"></abbr>
                                    Send us your full details and your product specification for us to serve you better.
                                </p>
                            </blockquote>

                            <a href="#" class="btn-default-1">Read more</a>
                        </div>
                        <div class="block-form box-border wow fadeInRight animated" data-wow-duration="1s">
                            <h3><i class="fa fa-bookmark-o"></i>Checkout as Guest</h3>
                            <hr>
                            <p>Checkout as a guest instead!</p>

                            <a href="#" class="btn-default-1">As Guest</a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</section>