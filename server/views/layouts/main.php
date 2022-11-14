<?php

/**
 * main.php
 * User: kzoltan
 * Date: 2022-05-16
 * Time: 7:18
 */

use app\core\Application;
use app\core\Functions;
use app\core\Language;

$host = Application::$app->getHost();
$request_url = filter_input(INPUT_SERVER, 'REQUEST_URI');
$active_menu = Functions::getActiveMenu();
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" 
              integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" 
              href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
        
        <!-- Option 1: jQuery -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        
        <title><?php echo $this->title; ?></title>
    </head>
    <body>
      
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item <?php echo ( $active_menu === '' ) ? 'active' : ''; ?>">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item <?php echo ( $active_menu === 'contact' ) ? 'active' : ''; ?>">
                        <a class="nav-link" href="/contact"><?php echo Language::trans('contact') ?></a>
                    </li>
                    
                    <li class="nav-item <?php echo ( $active_menu === 'companies') ? 'active' : ''; ?>">
                        <a class="nav-link" href="/companies"><?php echo Language::trans('companies'); ?></a>
                    </li>
                    
                    <li class="nav-item <?php echo ( $active_menu === 'humans') ? 'active' : ''; ?>">
                        <a class="nav-link" href="/humans"><?php echo Language::trans('humans'); ?></a>
                    </li>
                    
                    <li class="nav-item <?php echo ( $active_menu === 'users' ) ? 'active' : ''; ?>">
                        <a class="nav-link" href="/users"><?php echo Language::trans('users'); ?></a>
                    </li>
                    <li class="nav-item <?php echo ( $active_menu === 'currency' ) ? 'active' : ''; ?>"></li>
                    <!--
                    <li class="nav-item <?php //echo (Functions::is_active_menu('currencies')) ? 'active' : ''; ?>">
                        <a class="nav-link" href="/currencies"><?php echo Language::trans('currencies'); ?></a>
                    </li>
                    -->
                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                          Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Disabled</a>
                    </li>
                    -->
                </ul>
                
                
                <!--<ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                </ul>-->
                
                <?php if( Application::isGuest() ): ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/login"><?php echo Language::trans('login'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register"><?php echo Language::trans('register'); ?></a>
                    </li>
                </ul>
                <?php else: ?>
                <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item <?php echo (Functions::is_active_menu('profile')) ? 'active' : ''; ?> ">
                        <a class="nav-link" href="/profile"><?php echo Language::trans('profile'); ?></a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Welcome <?php echo Application::$app->user->getDisplayName(); ?> (Logout)</a>
                    </li>
                    
                </ul>
                <?php endif; ?>
                <!--
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                -->
            </div>
        </nav>
    
        <div class="container">
            <?php if(Application::$app->session->getFlash('success')): ?>
            <div class="alert alert-success">
                <?php echo Application::$app->session->getFlash('success'); ?>
            </div>
            <?php endif; ?>
            {{content}}
        </div>

        <!-- Optional JavaScript; choose one of the two! -->

        
                
        <!-- Option 2: Bootstrap Bundle (includes Popper) -->        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" 
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" 
                integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" 
                crossorigin="anonymous"></script>
        
        <!-- Option 3: Separate Popper and Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" 
                integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" 
                crossorigin="anonymous"></script>
                
        <script src="<?php echo $host; ?>/dist/js/modal.js"></script>
        
    </body>
</html>