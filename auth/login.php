<?php
require "../config/db.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST["username"]]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user"] = $user["username"];
        $_SESSION["user_id"] = $user["id"];
        header("Location: ../public/index.php");
        exit;
    } else {
        $error = "Invalid login details";
    }
}

include "../includes/header.php";
?>

<div class="container d-flex align-items-center justify-content-center" style="min-height:75vh;">
    <div class="col-md-5 col-lg-4">

        <div class="card shadow-sm p-4">
            <h5 class="fw-bold mb-3 text-center">Login</h5>

            <?php if ($error): ?>
                <div class="alert alert-danger small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Email / Username</label>
                    <input
                        class="form-control"
                        name="username"
                        required
                        autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-semibold">Password</label>
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        required>
                </div>

                <button class="btn btn-primary w-100">
                    Login
                </button>
            </form>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
