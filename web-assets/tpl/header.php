<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/web-assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/web-assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="/web-assets/css/style.css" rel="stylesheet">
  </head>
  <body>
    <!-- Fixed navbar -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Sarah's Project</a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="/">Home</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="/phpmyadmin/">Database</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/db.php"; ?>
  <div class="container">
