<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?= '../Assets/Css/style.css' ?>">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center LogReg">
        <div class="login-card border border-3 col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3 p-4 p-sm-5 shadow-lg rounded rounded-4 bg-light">
            <h1 class="fw-bold text-success text-center py-3 display-4">Register</h1>
            <form action="../Controllers/authController.php?action=register" method="post">
                <div class="d-flex flex-column my-3">
                    <label for="username" class="fw-bold text-success">Username</label>
                    <div class="d-flex position-relative">
                        <i class="bi bi-person icon"></i>
                        <input type="text" name="username" class="w-100 rounded rounded-3 border-1 ps-5 py-1" required>
                    </div>
                    <?php if (isset($_SESSION['errors'])): ?>
                        <span class="text-danger my-1 text-nowrap">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['errors']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column my-3">
                    <label for="email" class="fw-bold text-success">Email</label>
                    <div class="d-flex position-relative">
                        <i class="bi bi-envelope-at icon"></i>
                        <input type="email" name="email" class="w-100 rounded rounded-3 border-1 ps-5 py-1" required>
                    </div>
                    <?php if (isset($_SESSION['errors'])): ?>
                        <span class="text-danger my-1 text-nowrap">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['errors']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column my-3">
                    <label for="password" class="fw-bold text-success">Password</label>
                    <div class="d-flex position-relative">
                        <i class="bi bi-lock icon"></i>
                        <input type="password" name="password" class="w-100 rounded rounded-3 border-1 ps-5 py-1" required>
                    </div>
                    <?php if (isset($_SESSION['errors'])): ?>
                        <span class="text-danger my-1 text-nowrap">
                            <i class="bi bi-exclamation-triangle me-2"></i><?= $_SESSION['errors']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember_me" id="flexCheckDefault">
                    <label class="form-check-label text-nowrap" for="flexCheckDefault">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="w-100 btn btn-outline-success fw-bold rounded rounded-3 my-3">Register</button>
            </form>
            <p class="text-center">Sudah Punya akun? <a href="../Auth/login.php">Login Sekarang!</a></p>
        </div>
    </div>
    <?php require_once "../Components/Modal.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="<?= '../Assets/Js/main.js' ?>"></script>
</body>
</html>
<?php unset($_SESSION['errors']); ?>
