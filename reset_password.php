<?php
require 'connect.php';
include_once  "includes/layouts/header.php";
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

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


                echo "<div style='color: green; font-weight: bold;'> ✅ تم تحديث كلمة المرور بنجاح. سيتم تحويلك إلى صفحة تسجيل الدخول خلال ثوانٍ...</div>";
                echo "<script> setTimeout(function() { window.location.href = 'login-page.php'; }, 3000);</script>";
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

                                <!-- كلمة المرور الجديدة -->
                                <div class="form-outline mb-4 form-d-flex">
                                    <div class="input-group align-items-start flex-column">
                                        <label for="newPassword" class="form-label">كلمة المرور الجديدة:</label>
                                        <div class="d-flex flex-row align-items-center w-100">
                                            <div class="div-hide-password-login-form togglePassword" data-target="newPassword">
                                                <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0"></span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" name="new_password" id="newPassword" placeholder="اكتب كلمه السر هنا" value="<?php echo isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- تأكيد كلمة المرور -->
                                <div class="form-outline mb-4 form-d-flex">
                                    <div class="input-group align-items-start flex-column">
                                        <label for="confirmPassword" class="form-label">تأكيد كلمة المرور:</label>
                                        <div class="d-flex flex-row align-items-center w-100">
                                            <div class="div-hide-password-login-form togglePassword" data-target="confirmPassword">
                                                <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0"></span>
                                            </div>
                                            <input type="password" class="form-control form-control-lg" name="confirm_password" id="confirmPassword" placeholder=" تأكيد كلمة المرور " value="<?php echo isset($_POST['confirm_password']) ? htmlspecialchars($_POST['confirm_password']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-lg w-100 btn-block" type="submit">تسجيل الدخول</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            // لجميع عناصر إظهار/إخفاء كلمة المرور
            document.querySelectorAll('.togglePassword').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('span');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            });
        </script>

<?php
    } else {
        echo "الرابط غير صالح.";
    }
} else {
    echo "لا يوجد توكن.";
}


include_once "includes/layouts/footer.php";

?>

<!-- https://chatgpt.com/share/68498d5b-5e38-8012-b399-5a7da22a7aa7 -->