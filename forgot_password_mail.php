<?php

include_once  "includes/layouts/header.php";
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['email'])) {
    require 'connect.php';

    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();



    if ($user) {
        if ($user->auth_provider === 'google') {
            header("Location: login-google.php"); // ← غيّر المسار حسب اسم ملف تسجيل الدخول باستخدام Google
            exit;
        }
        $token = md5(uniqid());
        $expires = date("Y-m-d H:i:s", time() + 3600); // صلاحية 1 ساعة

        // حفظ التوكن وتاريخ الانتهاء في قاعدة البيانات
        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        // تحضير الرابط
        $reset_link = "http://localhost:8080/patriarch/reset_password_mail.php?token=$token";

        // إعدادات البريد
        $subject = "🔐 طلب إعادة تعيين كلمة المرور";

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: bavlywagih696@gmail.com\r\n";


        $message = '
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>إعادة تعيين كلمة المرور</title>
        </head>
        <body style="font-family: Tahoma, sans-serif; background-color: #f9f9f9; padding: 20px;">
            <div style="max-width: 600px; margin: auto; background-color: white; border-radius: 10px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        
                <div style="text-align: center;">
                    <img src="https://raw.githubusercontent.com/bavlywagih/BavlyWagih/refs/heads/main/trans-logo.png" alt="شعار الموقع" style="max-width: 50%; margin-bottom: 20px;">
                </div>
        
                <h2 style="color: #333; text-align:center;">طلب إعادة تعيين كلمة المرور</h2>
        
                <p style="color: #555;text-align: end;">  مرحبًا</p>
                <p style="color: #555;text-align: end;">لقد تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك. إذا كنت أنت من أرسل الطلب، يمكنك تعيين كلمة مرور جديدة من خلال الضغط على الزر التالي:</p>
        
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . $reset_link . '" style="background-color: #007BFF; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px;">
                        إعادة تعيين كلمة المرور
                    </a>
                </div>
        
                <p style="color: #999; text-align:center; ">إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذه الرسالة.</p>
        
                <hr style="margin-top: 40px;">
                <p style="font-size: 12px; color: #aaa; text-align: center;">© ' . '2025 جميع الحقوق محفوظة - مهرجان الكرازة </p>
            </div>
        </body>
        </html>';


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
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body card-body-login p-5 text-center">
                        <h3 class="mb-5"> نسيت كلمة المرور</h3>

                        <div class="form-outline mb-4 form-d-flex">
                            <label class="form-label form-login-input" for="typeEmailX-2">البريد الالكتروني :</label>
                            <input type="email" id="typeEmailX-2" name="email" placeholder="اكتب البريد الالكتروني هنا" class="form-control form-control-lg form-login-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                        </div>


                        <button class="btn btn-primary btn-lg w-100 btn-block" type="submit">تسجيل الدخول</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
include_once "includes/layouts/footer.php";
?>

<!-- https://chatgpt.com/share/68498d5b-5e38-8012-b399-5a7da22a7aa7 -->