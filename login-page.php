<?php
session_start();

include_once  "includes/layouts/header.php";
include_once  "connect.php";

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    try {
        // جهّز الاستعلام باستخدام PDO
        $stmt = $con->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["name"] = $user["name"];
                header("Location: index.php");
                exit;
            } else {
                $error = "كلمة المرور غير صحيحة.";
            }
        } else {
            $error = "البريد الإلكتروني غير موجود.";
        }
    } catch (PDOException $e) {
        // في حال حدوث خطأ
        $error = "حدث خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
    }
}
?>



<form method="POST">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body card-body-login p-5 text-center">
                        <h3 class="mb-5">تسجيل الدخول</h3>

                        <div class="form-outline mb-4 form-d-flex">
                            <label class="form-label form-login-input" for="typeEmailX-2">البريد الالكتروني :</label>
                            <input type="email" id="typeEmailX-2" name="email" placeholder="اكتب البريد الالكتروني هنا" class="form-control form-control-lg form-login-input" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                        </div>

                        <div class="form-outline mb-4 form-d-flex">
                            <div class="input-group align-items-start flex-column">
                                <label for="typePasswordX-2" class="form-label">كلمة المرور :</label>
                                <div class="d-flex flex-row align-items-center w-100">
                                    <div class="div-hide-password-login-form" id="togglePassword">
                                        <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0" id="eyeIcon"></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="password" id="typePasswordX-2" placeholder="اكتب كلمه السر هنا" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">

                                </div>
                            </div>
                        </div>
                        <?php if (!empty($error)): ?>
                            <div id="errorBox" class="alert alert-danger text-center"><?php echo $error; ?></div>
                        <?php endif; ?>


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
    // إخفاء رسالة الخطأ بعد 4 ثوانٍ
    setTimeout(function() {
        var errorBox = document.getElementById("errorBox");
        if (errorBox) {
            errorBox.style.display = "none";
        }
    }, 4000);

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
</script>


<?php include_once  "includes/layouts/footer.php"; ?>