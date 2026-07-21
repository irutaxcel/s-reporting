<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SATRACO-CONSTRUCTION ERP | <?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/v1/') ?>dist/css/adminlte.min.css">

    <style>
    :root {
        --satraco-green: #74c476;
        --satraco-green-dark: #3f9f46;
        --satraco-yellow: #f1e879;
        --satraco-dark: #102033;
        --satraco-white: #ffffff;
    }

    body.login-page {
        background:
            linear-gradient(135deg,
                rgba(16, 32, 51, 0.96) 0%,
                rgba(31, 70, 47, 0.94) 45%,
                rgba(116, 196, 118, 0.92) 100%);
    }

    .login-box {
        width: 420px;
        max-width: 92%;
    }

    @media (max-width: 576px) {

        body.login-page {
            padding: 15px;
            align-items: flex-start;
            padding-top: 35px;
        }

        .login-box {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        .satraco-logo {
            margin-bottom: 15px;
        }

        .satraco-logo img {
            width: 85px;
            height: 85px;
            padding: 8px;
            margin-bottom: 8px;
        }

        .satraco-logo h3 {
            font-size: 24px;
        }

        .satraco-logo span {
            font-size: 12px;
        }

        .login-card-body {
            padding: 22px 18px;
            border-radius: 12px;
        }

        .login-box-msg {
            font-size: 14px;
            padding-bottom: 10px;
        }

        .input-group .form-control {
            height: 44px;
            font-size: 14px;
        }

        .btn-satraco {
            height: 44px;
            font-size: 14px;
        }

        .row.align-items-center {
            display: block;
        }

        .row.align-items-center .col-7,
        .row.align-items-center .col-5 {
            max-width: 100%;
            width: 100%;
            flex: 0 0 100%;
        }

        .row.align-items-center .col-5 {
            margin-top: 15px;
        }
    }

    .satraco-logo {
        text-align: center;
        margin-bottom: 20px;
        color: var(--satraco-white);
    }

    .satraco-logo img {
        width: 115px;
        height: 115px;
        object-fit: contain;
        background: var(--satraco-white);
        border-radius: 50%;
        padding: 12px;
        margin-bottom: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
    }

    .satraco-logo h3 {
        font-weight: 800;
        margin-bottom: 2px;
        letter-spacing: 1px;
    }

    .satraco-logo span {
        font-size: 14px;
        color: #eef7ee;
    }

    .login-card-body {
        border-radius: 14px;
        border-top: 5px solid var(--satraco-green);
    }

    .login-box-msg {
        color: #334155;
        font-weight: 500;
    }

    .form-control:focus {
        border-color: var(--satraco-green);
        box-shadow: 0 0 0 0.2rem rgba(116, 196, 118, .25);
    }

    .btn-satraco {
        background: var(--satraco-green);
        border-color: var(--satraco-green);
        color: #fff;
        font-weight: 700;
    }

    .btn-satraco:hover {
        background: var(--satraco-green-dark);
        border-color: var(--satraco-green-dark);
        color: #fff;
    }

    .icheck-primary>input:first-child:checked+label::before {
        background-color: var(--satraco-green);
        border-color: var(--satraco-green);
    }

    hr {
        border-top: 1px solid #e5e7eb;
    }
    </style>

    <link rel="manifest" href="<?= base_url('manifest.json'); ?>">

    <meta name="theme-color" content="#0f766e">

    <meta name="application-name" content="SATRACO">

    <meta name="mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="apple-mobile-web-app-title" content="SATRACO">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/pwa/icons/icon-192x192.png'); ?>">

    <link rel="icon" type="image/png" sizes="192x192" href="<?= base_url('assets/pwa/icons/icon-192x192.png'); ?>">

    <link rel="icon" type="image/png" sizes="512x512" href="<?= base_url('assets/pwa/icons/icon-512x512.png'); ?>">
</head>