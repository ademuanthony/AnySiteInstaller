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
        Manage Categories <small><a href="<?php echo Core::getActionUrl('Add')?>">Create Category</a></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Core::getActionUrl('Index', 'Dashboard', 'Admin')?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Manage Plans</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">


            <!-- GROUP LIST -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Category List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Short Description</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach($this->data['categories'] as $u){ ?>
                            <tr>
                                <td><?php echo ++$this->data['sn']; ?></td>
                                <td><?php echo $u->Name; ?></td>
                                <td><?php echo $u->ShortDescription; ?></td>
                                <td><?php echo $u->Price; ?></td>
                                <td>
                                    <a href="<?php echo Core::getActionUrl('manage', 'categories', 'admin', [0 => $u->Id])?>"
                                       class="btn btn-info">Manage</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->

        </div><!-- /.col -->

    </div><!-- /.row -->

</section><!-- /.content -->