<?php
session_start();
ob_start();
require_once 'connect.php';

if (!isset($_SESSION['name'])) {
    header('Location: login-page.php');
    exit();
}

require_once "./includes/layouts/header.php";

// تحديد المعرف
// if (isset($_GET['id'])) {
//     $userId = $_GET['id'];
// } else {
    $userId = $_SESSION['user_id'];
// }

$query = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);
// if ($user == false) {
//     header('Location: index.php');
//     exit();
// }

// جلب بيانات المستخدم
$name = $user->name;
$fullname = $user->fullname ?? null;
$email = $user->email;
$group_id = $_SESSION['group_id'] ;
$auth_provider = $_SESSION['auth_provider'];

// $query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
// $stmt = $pdo->prepare($query);
// $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
// $stmt->execute();
// $result = $stmt->fetch(PDO::FETCH_OBJ);

ob_end_flush();
?>

    <div class="container-xl container-xl-profile px-4 mt-4">
        <nav class="nav nav-borders row-profile">
            <a class="nav-link active ms-0" href="#">Profile</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row row-profile justify-content-center">
            <div class="col-xl-8 ">
                <div class="card mb-4">
                    <div class="card-header">تفاصيل الحساب</div>
                    <div class="card-body">
                        <form id="profileForm" action="update_profile.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($userId); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم المستخدم :</label>
                                <input type="text" class="form-control form-control-align-start form-control-align-end-placeholder" id="name" name="name" value="<?= htmlspecialchars($name); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="fullname" class="form-label">اسم المستخدم كامل :</label>
                                <input type="email" class="form-control form-control-align-end form-control-align-end-placeholder" id="fullname" name="fullname" value="<?= empty($fullname) ? "" : htmlspecialchars($fullname); ?>" placeholder="لا يوجد اسم كامل .... اكتب هنا !!"  required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"> البريد الالكتروني :</label>
                                <input type="email" class="form-control form-control-align-end form-control-align-end-placeholder text-end" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">تاريخ الميلاد</label>
                                <input type="date" class="form-control form-control-align-end form-control-align-end-placeholder text-end" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control form-control-align-end form-control-align-end-placeholder text-end" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- 
    <script>
        <?php // if (!isset($_GET['id'])) { ?>
            document.getElementById('profileImagesInput').addEventListener('change', function(event) {
                const formData = new FormData();
                const files = event.target.files;
                const spinner = document.getElementById('spinner');

                // إظهار الـ spinner
                spinner.style.display = 'block';

                for (let i = 0; i < files.length; i++) {
                    if (files[i].size > 10 * 1024 * 1024) {
                        alert("حجم الصورة كبير جداً. الرجاء اختيار صور أصغر.");
                        spinner.style.display = 'none'; // إخفاء الـ spinner عند حدوث خطأ
                        return;
                    }
                    formData.append('profile_images[]', files[i]);
                }

                fetch('upload_image_profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        if (item.status === 'success') {
                            document.getElementById('profileImage').src = item.image_path;
                        } else {
                            alert(item.message);
                        }
                    });
                    spinner.style.display = 'none'; // إخفاء الـ spinner بعد الانتهاء
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = 'none'; // إخفاء الـ spinner عند حدوث خطأ
                });
            });
        <?php //} ?>
    </script> -->

    <?php require_once './includes/layouts/footer.php'; ?>
