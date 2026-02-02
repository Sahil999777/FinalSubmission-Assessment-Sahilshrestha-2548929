<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$msg = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $price = (int)$_POST["price"];
    $location = trim($_POST["location"]);
    $description = trim($_POST["description"]);
    $type = trim($_POST["type"]);
    $user_id = $_SESSION["user_id"];

    $imageName = null;
    $ok = true;

    if (!empty($_FILES["image"]["name"])) {
        $fileTmp = $_FILES["image"]["tmp_name"];
        $fileSize = $_FILES["image"]["size"];
        $mime = mime_content_type($fileTmp);
        $allowed = ["image/jpeg", "image/png", "image/gif"];

        if (!in_array($mime, $allowed) || $fileSize > 2 * 1024 * 1024) {
            $ok = false;
            $error = "Invalid image. Use JPG, PNG or GIF up to 2MB.";
        } else {
            $uploadDir = "../uploads/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $imageName = time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($fileTmp, $uploadDir . $imageName);
        }
    }

    if ($ok) {
        $stmt = $pdo->prepare(
            "INSERT INTO properties (title, price, location, description, type, image, user_id)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $title, $price, $location, $description, $type, $imageName, $user_id
        ]);

        $msg = "Property added successfully";
    }
}
?>

<div class="card p-4 shadow-sm">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold">Add Property</h5>
        <a href="index.php" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input class="form-control mb-2" name="title" placeholder="Title" required>
        <input class="form-control mb-2" name="price" type="number" placeholder="Price" required>
        <input class="form-control mb-2" name="location" placeholder="Location" required>

        <select class="form-select mb-2" name="type" required>
            <option value="">Select type</option>
            <option>Apartment</option>
            <option>House</option>
            <option>Villa</option>
            <option>Office</option>
        </select>

        <textarea class="form-control mb-2" name="description" placeholder="Description"></textarea>
        <input class="form-control mb-3" type="file" name="image">

        <button class="btn btn-primary btn-sm">Add Property</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
