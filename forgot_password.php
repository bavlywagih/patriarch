<?php
if (isset($_POST['email'])) {
    require 'connect.php';

    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = md5(uniqid());
        $expires = date("Y-m-d H:i:s", time() + 3600); // صلاحية 1 ساعة

        // حفظ التوكن وتاريخ الانتهاء في قاعدة البيانات
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        // تحضير الرابط
        $reset_link = "http://localhost:8080/patriarch/reset_password.php?token=$token";

        // إعدادات البريد
        $subject = "إعادة تعيين كلمة المرور";
        $message = "مرحبًا،\n\nلقد طلبت إعادة تعيين كلمة المرور.\nاضغط على الرابط التالي:\n$reset_link\n\nالرابط صالح لمدة ساعة.";
        $headers = "From: bavlywagih696@gmail.com\r\n"; // عدّله لبريدك الحقيقي

        // إرسال البريد
        if (mail($email, $subject, $message, $headers)) {
            echo "✅ تم إرسال رابط إعادة تعيين كلمة المرور إلى بريدك الإلكتروني.";
        } else {
            echo "❌ حدث خطأ أثناء إرسال البريد.";
        }
    } else {
        echo "البريد غير موجود.";
    }
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="أدخل بريدك الإلكتروني" required>
    <button type="submit">إرسال الرابط</button>
</form>


<!-- https://chatgpt.com/share/68498d5b-5e38-8012-b399-5a7da22a7aa7 -->