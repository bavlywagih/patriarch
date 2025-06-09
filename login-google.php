<?php
include_once "connect.php";
include_once  'config.php';

session_start();

$client_id = $client_id_config;
$redirect_uri = $redirect_uri_confige;


$scope = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';  // نطاقات المعلومات المطلوبة

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&access_type=offline";

header('Location: ' . $auth_url);
exit;
