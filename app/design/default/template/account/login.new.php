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
                    <h1 class="wow fadeInRight animated" data-wow-duration="1s"><span>Login</span> or <span>Register</span></h1>
                </div>
                <div class="row">
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="block-form box-border wow fadeInLeft animated" data-wow-duration="1s">
                            <h3><i class="fa fa-unlock"></i>Login</h3>
                            <p>Please login using your existing account</p>
                            <form action="<?php echo Core::getActionUrl('login')?>" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input name="LoginId" type="text" class="form-control" placeholder="Username">
                                    </div>
                                    <div class="col-md-6">
                                        <input name="Password" type="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <input type="submit"  value="Login"  class="btn-default-1">
                                        <input type="reset" value="Reset password" class="btn-default-1">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </article>
                    <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="block-form box-border wow fadeInRight animated" data-wow-duration="1s">
                            <h3><i class="fa fa-pencil"></i>Create new account</h3>
                            <p>Registration allows you to avoid filling in billing and shipping forms every time you checkout on this website.</p>
                            <hr>
                            <a href="<?php echo Core::getActionUrl('register')?>" class="btn-default-1">Register</a>
                        </div>
                        <div class="block-form box-border wow fadeInRight animated" data-wow-duration="1s">
                            <h3><i class="fa fa-bookmark-o"></i>Checkout as Guest</h3>
                            <p>Checkout as a guest instead!</p>
                            <hr>
                            <a href="#" class="btn-default-1">As Guest</a>
                        </div>

                    </article>
                </div>
            </div>
        </div>
    </div>
</section>






<section>
    <div class="block color-scheme-white-90">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <article class="payment-service">
                        <a href="#"></a>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <i class="fa fa-thumbs-up"></i>
                            </div>
                            <div class="col-md-8">
                                <h3 class="color-active">Safe Payments</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="payment-service">
                        <a href="#"></a>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div class="col-md-8">
                                <h3 class="color-active">Free shipping</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="payment-service">
                        <a href="#"></a>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <i class="fa fa-fax"></i>
                            </div>
                            <div class="col-md-8">
                                <h3 class="color-active">24/7 Support</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </article>
                </div>
            </div>



        </div>
    </div>
</section>