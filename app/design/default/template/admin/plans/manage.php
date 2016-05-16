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
        <?php echo $this->data['title'] ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Core::getActionUrl('Index', 'Dashboard', 'Dashboard')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo Core::getActionUrl('Index')?>"><i class="fa fa-group"></i> Plans</a></li>
        <li class="active"><?php echo $this->data['title'] ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">


            <!-- GROUP LIST -->
            <div class="box box-danger">

                <form method="post"
                      action="<?php echo Core::getActionUrl($this->data['formAction'], 'plans', 'admin', [0 => $this->data['plan']->Id])?>">
                    <div class="box-header with-border">
                        <h3 class="box-title">Plan Detail</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div><!-- /.box-header -->


                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input value="<?php echo !empty($this->data['plan']->Name)?$this->data['plan']->Name:''; ?>"
                                           type="text" class="form-control" id="name" name="name" placeholder="Plan name">
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="name">Keywords(comma separated)</label>
                                    <input value="<?php echo !empty($this->data['plan']->Keywords)?$this->data['plan']->Keywords:''; ?>"
                                           type="text" class="form-control" id="name" name="keywords" placeholder="Keywords">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="username">Short Description</label>
                                    <textarea class="form-control" name="shortDescription">
                                        <?php echo !empty($this->data['plan']->ShortDescription)?$this->data['plan']->ShortDescription:''; ?>
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="username">Description</label>
                                    <textarea class="form-control" name="description">
                                        <?php echo !empty($this->data['plan']->Description)?$this->data['plan']->Description:''; ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="name">Price</label>
                                    <input value="<?php echo !empty($this->data['plan']->Price)?$this->data['plan']->Price:''; ?>"
                                            type="text" class="form-control" id="name" name="price" placeholder="Plan Price">
                                </div>
                            </div>

                        </div>
                    </div><!-- /.box-body -->


                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <button name="resetPassword" style="color: #ffffff" class="pull-right btn btn-default btn-success">Update <i class="fa fa-save"></i></button>
                    </div>

                </form>
            </div><!-- /.box -->

        </div><!-- /.col -->
    </div><!-- /.row -->

</section><!-- /.content -->