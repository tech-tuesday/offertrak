<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
<!-- Bootstrap CSS -->
<link href="/offertrak/web-assets/css/bootstrap.min.css?v=4.3.1" rel="stylesheet"/>
<link href="/offertrak/web-assets/css/site.css" rel="stylesheet"/>
<title><?php if ( isset($page_title) and !empty($page_title) ) { echo $page_title; } else { echo "OfferTrak"; } ?></title>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <a class="navbar-brand" href="/offertrak/">OfferTrak</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

</nav>

<main role="main" class="container-fluid">


