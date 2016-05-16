<?php include"headerpage.php" ?>
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
                                    <form class="form-horizontal" role="form" method="post" action="#">
                                        <div class="form-group">
                                            <label for="inputFirstName" class="col-sm-3 control-label">First Name:<span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputFirstName" name="fist_name" required>
                                                <input type="hidden"  name = "INSERT" value="1">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputLastName" class="col-sm-3 control-label">Last Name:<span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputLastName" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEMail" class="col-sm-3 control-label">E-Mail:<span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="email" class="form-control" id="inputEMail" name="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPhone" class="col-sm-3 control-label">Phone:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputPhone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputFax" class="col-sm-3 control-label">Fax:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputFax" name="fax" required>
                                            </div>
                                        </div>
                                        <h3><i class="fa fa-truck"></i>Delivery Information</h3>
                                        <hr>
                                        <div class="form-group">
                                            <label for="inputCompany" class="col-sm-3 control-label">Company:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputCompany" name="company" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCompanyID" class="col-sm-3 control-label">CompanyID:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputCompanyID" name="company_id" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAdress1" class="col-sm-3 control-label">Address /1: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputAdress1" name="address" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAdress2" class="col-sm-3 control-label">Address /2:</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputAdress2" name="address2" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputCity" class="col-sm-3 control-label">City: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputCity" name="city" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPostCode" class="col-sm-3 control-label">Post Code: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="inputPostCode" name="post_code" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Contury: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="contury" class="form-control" required>
                                                    <option value="#">-All Conturies-</option>
                                                    <option value="#">Contury1</option>
                                                    <option value="#">Contury2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Region: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <select name="region" class="form-control" required>
                                                    <option value="#">-All Regions-</option>
                                                    <option value="#">Region1</option>
                                                    <option value="#">Region2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <h3><i class="fa fa-lock"></i>Password</h3>
                                        <hr>
                                        <div class="form-group">
                                            <label for="inputPassword1" class="col-sm-3 control-label">Password: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="inputPassword1" name="password" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword2" class="col-sm-3 control-label">Re-Password: <span class="text-error">*</span></label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="inputPassword2" name="password_again" required>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox">  I'v read and agreed on <a href="#">Condations</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-9">
                                                <button type="submit" class="btn-default-1">Register</button>
                                            </div>
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

<?php include"footer.php" ?>