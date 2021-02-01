<?php 
require_once "../functions.php";
require_once "../config.php";
$idxx=$_SESSION['id'];
$userxx=query("SELECT a.id, a.nama, b.role 
             FROM user a JOIN role_user b ON a.id_role = b.id WHERE a.id='$idxx'")[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>AHP-TOPSIS BANSOS</title>

  <!-- General CSS Files -->
  <link rel="icon" type="image/png" href="../assets/img/logo.png"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <!-- dataTables -->
  <link rel="stylesheet" href="../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

  <!-- Template CSS -->
  <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
  <link rel="stylesheet" href="../assets/css/components.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>

<style type="text/css">
.size {
  width: 50px;
}
</style>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div>
            <img class="size" src="../assets/img/logo.png">
        </div>
        <a href="index.php" class="navbar-brand sidebar-gone-hide mx-3 text-white">AHP-TOPSIS BANSOS</a>
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        </div>
        <div class="nav-collapse">
          <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
          </a>
        </div>
        <div class="form-inline ml-auto">
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"><b>[<?=$userxx['role']?>]</b> <?=$userxx['nama']?></div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="profil.php" class="dropdown-item has-icon">
                <i class="far fa-user"></i> My Profile
              </a>
              <div class="dropdown-divider"></div>
               <a href="#" class="dropdown-item has-icon text-danger" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
        </div>
      </nav>

     