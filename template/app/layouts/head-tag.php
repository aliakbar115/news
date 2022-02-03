<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php echo $setting["title"] ?>
    </title>


    <link href="<?= asset('public/css/app/style.css') ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

</head>

<body style="direction: rtl;">
    <section class="app">
        <header>
            <nav class="header">
                <img class="header-logo" src="<?= asset($setting['logo']); ?>" alt="logo picture">
                <button class="header-menu-burger" onclick="showMenu()" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="header-menu" id="menu">
                    <?php foreach ($menus as $menu) { ?>

                        <li class="header-menu-item">
                            <?php if (is_null($menu["parent_id"])) { ?>
                                <a class="header-menu-item-link" href="<?php echo $menu["url"] ?>">
                                    <?php echo $menu["name"] ?>
                                </a>
                            <?php } ?>

                            <?php if ($menu["submenu_count"] > 0) { ?>
                                <span>
                                    <?php foreach ($submenus as $submenu) {

                                        if ($submenu["parent_id"] == $menu["id"]) { ?>

                                            <a href="<?php echo $submenu["url"] ?>">
                                                <?php echo $submenu["name"] ?>
                                            </a>

                                        <?php } ?>

                                    <?php } ?>
                                </span>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <section class="clear-fix"></section>
                <?php
                    use AdminDashboard\Auth;
                    $auth = new Auth();
                ?>
                <?php if (!$auth->checkUser()) { ?>
                    <div class="btn-group mb-1">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            ورود / ثبت نام
                        </button>
                        <div class="dropdown-menu" style="text-align: center;">
                            <a class="dropdown-item" href="<?= url('login'); ?>">ورود</a>
                            <a class="dropdown-item" href="<?= url('register'); ?>">ثبت نام</a>

                            <?php if ($auth->checkAdmin2()) { ?>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"> پنل مدیریت</a>

                            <?php } ?>

                        </div>
                    </div>
                <?php } ?>

            </nav>


            <!--end of navbar-->
        </header>
        <!--end of header-->