<?php
require "../config/db.php";
include "../includes/header.php";

$msg = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);

    if ($check->rowCount() > 0) {
        $error = "Username already exists";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        $msg = "Registration successful. You can login.";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh">
<div class="col-md-4">
<div class="card p-4 shadow">

<h4 class="text-center mb-3">Register</h4>

<?php if ($msg): ?><div class="alert alert-success"><?= $msg ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>

<form method="post">
    <input class="form-control mb-3" name="username" placeholder="Username" required>
    <input type="password" class="form-control mb-3" name="password" placeholder="Password" required>
    <button class="btn btn-primary w-100">Register</button>
</form>

<p class="text-center mt-3 small">
Already registered? <a href="login.php">Login</a>
</p>

</div>
</div>
</div>

<?php include "../includes/footer.php"; ?>
