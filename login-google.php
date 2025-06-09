<?php
// Google OAuth
$client_id = '320032618440-4eppq4g8fc1cpgesilnspg9ggll0e3mu.apps.googleusercontent.com';
$redirect_uri = 'http://localhost:8080/patriarch/callback-google.php';  // رابط الـ callback
$scope = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';  // نطاقات المعلومات المطلوبة

$auth_url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$client_id&redirect_uri=$redirect_uri&scope=$scope&access_type=offline";

header('Location: ' . $auth_url);
exit;
