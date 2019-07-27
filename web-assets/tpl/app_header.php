<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'] . '/bdpa-loans/db.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/bdpa-loans/web-assets/css/bootstrap.min.css?>"> <!--I don't know why that href works necessarily. -->

    <title><?php echo $page_title ?></title>
  </head>
  <body>
    
