<?php
/**
 * Created by Ademu Anthony.
 * User: Tony
 * Date: 3/20/2015
 * Time: 3:34 PM
 */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Manage Accounts
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Core::getActionUrl('Index', 'Dashboard', 'Admin')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage Accounts</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-7">


            <!-- GROUP LIST -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Account List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <p class="text-center">
                        <?php if($this->data['status'] == Core::OPEN_USER_STATUS_PENDING_APPROVAL){?>
                            Pending Accounts
                            <?php
                        }else{?>
                            <a href="<?php echo Core::getActionUrl('index', 'accounts', 'admin',
                                ['parameter1' => 1, 'parameter2' => Core::OPEN_USER_STATUS_PENDING_APPROVAL])?>" class="btn btn-primary btn-xs">Pending Accounts</a>
                            <?php
                        }
                        echo ' | ';
                        if($this->data['status'] == Core::OPEN_USER_STATUS_ACTIVE){?>
                            Active Accounts
                            <?php
                        }else{?>
                            <a href="<?php echo Core::getActionUrl('index', 'accounts', 'admin',
                                ['parameter1' => 1, 'parameter2' => Core::OPEN_USER_STATUS_ACTIVE])?>" class="btn btn-primary btn-xs">Active Accounts</a>
                            <?php
                        }
                        echo ' | ';
                        if($this->data['status'] == Core::OPEN_USER_STATUS_INACTIVE){?>
                            Inactive Accounts
                            <?php
                        }else{?>
                            <a href="<?php echo Core::getActionUrl('index', 'accounts', 'admin',
                                ['parameter1' => 1, 'parameter2' => Core::OPEN_USER_STATUS_INACTIVE])?>" class="btn btn-primary btn-xs">Inactive Accounts</a>
                            <?php
                        }?>

                    </p>
                    <hr/>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Account Number</th>
                                <th>Phone Number</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach($this->data['users'] as $u){ ?>
                                <tr>
                                    <td><?php echo ++$this->data['sn']; ?></td>
                                    <td><?php echo $u->Name; ?></td>
                                    <td><?php echo $u->Number; ?></td>
                                    <td><?php echo $u->PhoneNumber; ?></td>
                                    <td>
                                        <a href="<?php echo Core::getActionUrl('manage', 'accounts', 'admin',
                                            ['parameter1' => $u->Number, 'parameter2' => $this->data['page']])?>" class="btn btn-info">Manage</a> |
                                        <a onclick="confirm('This account will be deleted. Do you want to continue?')"
                                           href="<?php echo Core::getActionUrl('delete', 'accounts', 'admin',
                                               ['parameter1' => $u->Number, 'parameter2' => $this->data['page']])?>" class="btn btn-warning">Delete</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div><!-- /.col -->


        <div class="col-md-5">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">New Account</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->

                <form role="form" action="<?php echo Core::getActionUrl('add', '', '',
                    ['parameter1' => $this->data['page'], 'parameter2' => $this->data['status']] )?>" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="AccountNumber">Account Number</label>
                            <input value="<?php echo $this->getFormData('AccountNumber')?>" type="text" class="form-control"
                                   id="accountNumber" name="AccountNumber" placeholder="The Account number">
                        </div>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input value="<?php echo $this->getFormData('Name')?>" type="text" class="form-control" id="name" name="Name" placeholder="Customer's name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input value="<?php echo $this->getFormData('LoginId')?>" type="text" class="form-control" id="LoginId" required
                                   name="LoginId" placeholder="Enter your desired username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" required id="password"
                                   name="Password" placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input value="<?php echo $this->getFormData('EmailId')?>" type="email" class="form-control" id="email" name="EmailId"
                                   required placeholder="Enter a valid Email Address">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input value="<?php echo $this->getFormData('MobileNo')?>" type="text" class="form-control" id="number" name="MobileNo"
                                   required placeholder="Enter your phone number">
                        </div>


                        <div class="form-group">
                            <label for="address">Address</label>
                            <input value="<?php echo $this->getFormData('Address')?>" type="text" class="form-control" id="address" name="Address"
                                   required placeholder="Enter your address">
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </div>
                </form>
            </div>


        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->