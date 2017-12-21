<?php  
include 'connection.php';

// if (!isset($_SESSION['logged_id'])) {
//   header("location:login.php");
// }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TK SINAR PRIMA | Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="dashboard/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="dashboard/plugins/fontawesome/css/font-awesome.min.css">
  <!-- <link rel="stylesheet" href="dashboard/https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
  <link rel="stylesheet" href="dashboard/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dashboard/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="dashboard/plugins/iCheck/flat/blue.css">
  <link rel="stylesheet" href="dashboard/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="dashboard/plugins/morris/morris.css">
  <link rel="stylesheet" href="dashboard/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="dashboard/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="dashboard/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="dashboard/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
    .skin-black-light .main-header .navbar .navbar-nav > li > a {
        border-right: none;
    }
    @media screen and (max-width: 766px) {
      #navbar-collapse {
        width: 100%;
      }
    }
  </style>
</head>
<body class="hold-transition skin-black-light layout-top-nav">

  <div class="wrapper">
    <?php 

    require 'header.php';
    // require 'sidebar.php'; 

    ?>

    <div class="content-wrapper">

      <section class="content">
