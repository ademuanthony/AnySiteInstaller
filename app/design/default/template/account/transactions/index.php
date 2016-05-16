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
        Account
        <small>Transactions</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo Core::getActionUrl('index', 'account', 'account')?>"><i class="fa fa-user"></i> Account</a></li>
        <li class="active">Transactions</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-md-12">


            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title">Transactions</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php if(count($this->data['transactions']) < 1){?>
                        <p class="text-danger">No record found</p>
                    <?php } else { ?>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">Amount</th>
                                <th class="text-left">Units</th>
                                <th class="text-left">Type</th>
                                <th class="text-left">Payment Method</th>
                                <th class="text-left">Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($this->data['transactions'] as $tran){?>
                                <tr>
                                    <td><?php echo $tran->Id;?></td>
                                    <td><?php echo $tran->Date;?></td>
                                    <td><?php echo $tran->Amount;?></td>
                                    <td><?php echo $tran->Unit;?></td>
                                    <td><?php echo $tran->Type;?></td>
                                    <td><?php echo $tran->PaymentMethod;?></td>
                                    <td><?php echo $tran->Status;?></td>

                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>

                    <?php } ?>
                </div>

            </div><!-- /.box -->

        </div><!-- /.col -->
    </div><!-- /.row -->


</section><!-- /.content -->