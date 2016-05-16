<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">``
    <![endif]-->
    <title><?php $this->printData('pageTitle');?></title>
    <meta name="description" content="Effect, premium HTML5&amp;CSS3 template">
    <meta name="author" content="MosaicDesign">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/css/theme-style.css">
    <link rel="stylesheet" href="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/css/ie.style.css">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo Core::getBaseUrl() ?>app/design/default/assets/frontend/css/font-awesome-ie7.css">
    <![endif]-->
    <script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/modernizr.js"></script>
    <!--[if IE 8]>
    <script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/less-1.3.3.js"></script><![endif]-->
    <!--[if gt IE 8]><!--><script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/less.js"></script><!--<![endif]-->


    <?php $this->renderSpecialView(Core::VIEW_POSITION_TOP);?>
</head>
<body>



<?php $this->renderSpecialView(Core::VIEW_POSITION_BODY);?>
<?php $this->renderTemplate('header');?>


<?php $this->renderTemplate('content');?>



<?php $this->renderTemplate('footer');?>



<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.easing.1.3.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/bootstrap.js"></script>

<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.flexisel.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/wow.min.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.transit.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.jcountdown.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.jPages.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/owl.carousel.js"></script>

<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/responsiveslides.min.js"></script>
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.elevateZoom-3.0.8.min.js"></script>

<!-- jQuery REVOLUTION Slider  -->
<script type="text/javascript" src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/vendor/jquery.scrollTo-1.4.2-min.js"></script>

<!-- Custome Slider  -->
<script src="<?php echo Core::getBaseUrl()?>app/design/default/assets/frontend/js/main.js"></script>

<!--Here will be Google Analytics code from BoilerPlate-->
</body>
</html>
