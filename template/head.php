<?php
/*
*    r2o-orders: The simple way to show orders from r2o API.
*    Copyright (c) 2022 Josef Müller
*
*    Please see LICENSE file for your rights under this license. */

$TITLE = get_company_name() . " Bestellungen";
?>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="default-src 'none'; base-uri 'none'; child-src 'self'; form-action 'self'; frame-src 'self'; font-src 'self'; connect-src 'self'; img-src 'self'; manifest-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'"
          http-equiv="Content-Security-Policy">
    <meta name="description" content="Bestellungen">
    <meta name="author" content="Josef Müller">
    <title><?php echo $TITLE; ?></title>

    <!-- CSS -->
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="../style/vendor/bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../style/css/adminlte.min.css">

    <!-- ICONS -->
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Font Awesome Icons -->
    <script defer src="../style/vendor/fontawesome-free/all.min.js"></script>

    <!-- FONTS -->
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</head>