    
    
    <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <title>عنوان الصفحة</title>
  <meta name="description" content="وصف الصفحة" />
  <meta name="robots" content="index, follow" />
  <link rel="canonical" href="https://example.com/page-url" />

  <!-- Open Graph -->
  <meta property="og:title" content="عنوان الصفحة" />
  <meta property="og:description" content="وصف الصفحة" />
  <meta property="og:image" content="https://example.com/image.jpg" />
  <meta property="og:url" content="https://example.com/page-url" />
  <meta property="og:type" content="website" />

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="عنوان الصفحة" />
  <meta name="twitter:description" content="وصف الصفحة" />
  <meta name="twitter:image" content="https://example.com/image.jpg" />
</head>

    
    
    
        <title><?php echo htmlspecialchars($title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>" />

    <h1><?php echo htmlspecialchars($patriarchs[$id]['name']); ?></h1>
    <p><?php echo htmlspecialchars($patriarchs[$id]['description']); ?></p>













<?php
include_once  "includes/layouts/header.php";
include_once  "connect.php";

$email = "";
$password = "";
$err = "";

// إذا وُجدت رسالة خطأ نعرضها ونُعيد القيم
if (isset($_GET['error'])) {
    if ($_GET['error'] == "email") {
        $err = "المستخدم غير موجود.";
    } elseif ($_GET['error'] == "password") {
        $err = "كلمة المرور خاطئة.";
    } elseif ($_GET['error'] == "userpass") {
        $err = "اسم المستخدم وكلمة المرور غير صحيحة.";
    }

    if (isset($_GET['email'])) {
        $email = htmlspecialchars($_GET['email']);
    }
    if (isset($_GET['password'])) {
        $password = htmlspecialchars($_GET['password']);
    }
}
?>

<form action="loginpost.php" method="POST">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body card-body-login p-5 text-center">
                        <h3 class="mb-5">تسجيل الدخول</h3>

                        <?php if ($err) { ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="error-alert">
                                <strong><?php echo $err; ?></strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php } ?>

                        <div class="form-outline mb-4 form-d-flex">
                            <label class="form-label form-login-input" for="typeEmailX-2">البريد الالكتروني :</label>
                            <input type="email" id="typeEmailX-2" name="email" placeholder="اكتب البريد الالكتروني هنا" class="form-control form-control-lg form-login-input" value="<?php echo $email; ?>" />
                        </div>

                        <div class="form-outline mb-4 form-d-flex">
                            <div class="input-group align-items-start flex-column">
                                <label for="typePasswordX-2" class="form-label">كلمة المرور :</label>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="div-hide-password-login-form" id="togglePassword">
                                        <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0" id="eyeIcon"></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="password" id="typePasswordX-2" placeholder="password" value="<?php echo $password; ?>">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-lg w-100 btn-block" type="submit">تسجيل الدخول</button>

                        <hr class="my-4">

                        <a href="login-google.php" class="btn btn-lg btn-block" style="background-color: #dd4b39; color: white;"><i class="fab fa-google me-2"></i> تسجيل الدخول بواسطه جوجل</a><br><br>



                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById('typePasswordX-2');
        var eyeIcon = document.getElementById('eyeIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

    document.getElementById('togglePassword').addEventListener('click', togglePasswordVisibility);

    document.addEventListener('DOMContentLoaded', function() {
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 500);
            }, 3000);
        }
    });
</script>

<?php include_once  "includes/layouts/footer.php"; ?>



 الخطوات الكاملة لتفعيل mail() في XAMPP باستخدام Gmail SMTP:
🔧 1. افتح ملف إعدادات PHP
افتح هذا الملف:

makefile
Copy
Edit
C:\xampp\php\php.ini
وابحث عن هذا السطر:

ini
Copy
Edit
;sendmail_path =
واستبدله بـ:

ini
Copy
Edit
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"
🔧 2. إعداد sendmail
افتح هذا الملف:

makefile
Copy
Edit
C:\xampp\sendmail\sendmail.ini
ثم عدّل الإعدادات التالية:

ini
Copy
Edit
smtp_server=smtp.gmail.com
smtp_port=587
smtp_ssl=tls

auth_username=your-email@gmail.com
auth_password=your-app-password
❗ مهم: يجب استخدام "App Password" من إعدادات Gmail، وليس كلمة المرور العادية.
اتبع الخطوات هنا: https://myaccount.google.com/apppasswords

🔧 3. فعّل الامتداد openssl في php.ini
افتح php.ini مرة أخرى وابحث عن:

ini
Copy
Edit
;extension=openssl
واحذف الـ ; لتصبح:

ini
Copy
Edit
extension=openssl
