<?php
include_once "connect.php";
include_once  'config.php';

session_start();

$client_id = $client_id_config;
$client_secret = $client_secret_confige;
$redirect_uri = $redirect_uri_confige;

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $token_url = 'https://oauth2.googleapis.com/token';

    $post_fields = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if (isset($response_data['access_token'])) {
        $access_token = $response_data['access_token'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $access_token
        ]);
        $user_info_response = curl_exec($ch);
        curl_close($ch);

        $user_info = json_decode($user_info_response, true);
        $name = $user_info['name'];
        $email = $user_info['email'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['group_id'] = $user['group_id'];
            $_SESSION['auth_provider'] = 'google';
            // echo "تسجيل دخول ناجح. مرحباً " . htmlspecialchars($user['name']);
            header("Location: /patriarch/index.php");
            exit;
        } else {
            $insert = $pdo->prepare("INSERT INTO users (name, email, password, auth_provider, group_id) VALUES (:name, :email, :password, :auth_provider, :group_id)");
            $result = $insert->execute([
                'name' => $name,
                'email' => $email,
                'password' => null,
                'group_id' => 0,
                'auth_provider' => 'google'
            ]);

            if ($result) {
                $new_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $new_id;
                $_SESSION['fullname'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['group_id'] = $group_id;
                $_SESSION['auth_provider'] = 'google';
                // echo "تم إنشاء الحساب بنجاح. مرحباً " . htmlspecialchars($name);
                header("Location: /patriarch/index.php");
                exit;
            } else {
                echo "حدث خطأ أثناء إنشاء الحساب.";
            }
        }
    } else {
        echo 'Error: Unable to retrieve access token';
    }
} else {
    echo 'Error: No authorization code provided';
}
