<?php
include "router.php";

Router::make("home", ["pattern" => "/", "controller" => "HomeController", "method" => "index", "request_method" => "GET"]);
Router::make("users", ["pattern" => "/users/", "controller" => "UserController", "method" => "index", "request_method" => "GET"]);
Router::make("user", ["pattern" => "/users/([0-9])", "controller" => "UserController", "method" => "details", "request_method" => "GET"]);
Router::route();

