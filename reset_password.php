<?php
require 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); // استخدم هذا


    if ($user) {
        // إذا تم إرسال النموذج
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                echo "❌ كلمتا المرور غير متطابقتين.";
            } elseif (strlen($newPassword) < 8) {
                echo "❌ يجب أن تكون كلمة المرور 8 أحرف على الأقل.";
            } else {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
                $update->execute([$hashedPassword, $user['id']]);

                echo "✅ تم تحديث كلمة المرور بنجاح. <a href='login-page.php'>تسجيل الدخول</a>";
                exit;
            }
        }

        // النموذج
        echo '<form method="POST">
                <input type="password" name="new_password" placeholder="كلمة المرور الجديدة" required><br>
                <input type="password" name="confirm_password" placeholder="تأكيد كلمة المرور" required><br>
                <button type="submit">تحديث</button>
              </form>';
    } else {
        echo "الرابط غير صالح.";
    }
} else {
    echo "لا يوجد توكن.";
}
?>

<!-- https://chatgpt.com/share/68498d5b-5e38-8012-b399-5a7da22a7aa7 -->