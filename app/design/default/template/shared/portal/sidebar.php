<?php
/**
 * Created by PhpStorm.
 * User: Gabriel
 * Date: 3/20/2015
 * Time: 2:03 AM
 */
?>

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
        </div>
        <div class="pull-left info">
            <p><?php echo $this->data['user']->Name ?></p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>

        <li class="<?php echo $this->isCurrentUri('index', 'dashboard', 'dashboard')? 'active':'' ;?>">
            <a href="<?php echo Core::getActionUrl('index', 'dashboard', 'dashboard')?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                <?php echo $this->isCurrentUri('index', 'dashboard', 'dashboard')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

            </a>
        </li>

        <?php if($this->isUserInRole(Core::OPEN_ROLE_ADMIN)) {?>

            <li class="treeview<?php echo Core::isCurrentModule('admin') || Core::isCurrentModule('cms') ? ' active':'';?>">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>Admin</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="<?php echo $this->isCurrentUri('index', 'users', 'admin')? 'active':'';?>">
                        <a href="<?php echo Core::getActionUrl('index', 'users', 'admin')?>">
                            <i class="fa fa-circle-o"></i> <span>Users</span>
                            <?php echo $this->isCurrentUri('index', 'users', 'admin')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                        </a>
                    </li>

                    <li class="<?php echo $this->isCurrentUri('index', 'plans', 'admin')? 'active':'';?>">
                        <a href="<?php echo Core::getActionUrl('index', 'plans', 'admin')?>">
                            <i class="fa fa-circle-o"></i> <span>Plans</span>
                            <?php echo $this->isCurrentUri('index', 'plans', 'admin')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                        </a>
                    </li>

                    <li class="<?php echo $this->isCurrentUri('index', 'categories', 'admin')? 'active':'';?>">
                        <a href="<?php echo Core::getActionUrl('index', 'categories', 'admin')?>">
                            <i class="fa fa-circle-o"></i> <span>Categories</span>
                            <?php echo $this->isCurrentUri('index', 'categories', 'admin')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                        </a>
                    </li>

                    <li class="<?php echo $this->isCurrentUri('index', 'packages', 'admin')? 'active':'';?>">
                        <a href="<?php echo Core::getActionUrl('index', 'packages', 'admin')?>">
                            <i class="fa fa-circle-o"></i> <span>Packages</span>
                            <?php echo $this->isCurrentUri('index', 'packages', 'admin')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                        </a>
                    </li>


                    <li class="<?php echo $this->isCurrentUri('index', 'themes', 'admin')? 'active':'';?>">
                        <a href="<?php echo Core::getActionUrl('index', 'themes', 'admin')?>">
                            <i class="fa fa-circle-o"></i> <span>Theme</span>
                            <?php echo $this->isCurrentUri('index', 'themes', 'admin')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                        </a>
                    </li>
                </ul>
            </li>

        <?php } ?>


        <li>
            <a href="<?php echo Core::getActionUrl('logout', 'account', 'account')?>">
                <i class="fa fa-circle-o"></i> <span>Logoff</span>

            </a>
        </li>
        <!--

        <li class="treeview<?php echo Core::isCurrentModule('transactions') ? ' active':'';?>">
            <a href="#">
                <i class="fa fa-dropbox"></i> <span>Transactions</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li class="<?php echo $this->isCurrentUri('index', 'compose', 'sms')? 'active':'';?>">
                    <a href="<?php echo Core::getActionUrl('index', 'compose', 'sms')?>">
                        <i class="fa fa-circle-o"></i> <span>Deposits</span>
                        <?php echo $this->isCurrentUri('index', 'compose', 'sms')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                    </a>
                </li>

                <li class="<?php echo $this->isCurrentUri('index', 'sent', 'sms')? 'active':'';?>">
                    <a href="<?php echo Core::getActionUrl('index', 'sent', 'sms')?>">
                        <i class="fa fa-circle-o"></i> <span>Withdrawals</span>
                        <?php echo $this->isCurrentUri('index', 'sent', 'sms')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                    </a>
                </li>
            </ul>
        </li>



        <li class="treeview<?php echo Core::isCurrentModule('account') ? ' active':'';?>">
            <a href="#">
                <i class="fa fa-deviantart"></i> <span>Transfers</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">

                <li class="<?php echo $this->isCurrentUri('index', 'account', 'account')? 'active':'';?>">
                    <a href="<?php echo Core::getActionUrl('index', 'account', 'account')?>">
                        <i class="fa fa-circle-o"></i> <span>Send Money</span>
                        <?php echo $this->isCurrentUri('index', 'account', 'account')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                    </a>
                </li>

                <li class="<?php echo $this->isCurrentUri('index', 'recharge', 'account')? 'active':'';?>">
                    <a href="<?php echo Core::getActionUrl('index', 'recharge', 'account')?>">
                        <i class="fa fa-circle-o"></i> <span>History</span>
                        <?php echo $this->isCurrentUri('index', 'recharge', 'account')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

                    </a>
                </li>

            </ul>
        </li>

        <li class="<?php echo Core::isCurrentModule('settings') ? 'active':'';?>">
            <a href="<?php echo Core::getActionUrl('index', 'settings', 'settings')?>">
                <i class="fa fa-cogs"></i> <span>Settings</span>
                <?php echo $this->isCurrentUri('index', 'settings', 'settings')? '<i class="fa fa-arrow-right pull-right"></i>':'' ;?>

            </a>
        </li>
        -->

    </ul>
</section>
<!-- /.sidebar -->