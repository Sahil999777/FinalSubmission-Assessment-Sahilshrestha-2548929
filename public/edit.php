<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$id = $_GET["id"] ?? null;
if (!$id) { header("Location: index.php"); exit; }

$stmt = $pdo->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) { header("Location: index.php"); exit; }

$msg = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $price = $_POST["price"];
    $location = $_POST["location"];
    $description = $_POST["description"];
    $type = $_POST["type"] ?? "";

    $imageName = $p["image"];
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
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = time() . "_" . basename($_FILES["image"]["name"]);
            move_uploaded_file($fileTmp, $uploadDir . $imageName);
        }
    }

    if ($ok) {
        $upd = $pdo->prepare(
            "UPDATE properties SET title=?, price=?, location=?, description=?, type=?, image=? WHERE id=?"
        );
        $upd->execute([$title, $price, $location, $description, $type, $imageName, $id]);

        $msg = "Property updated";
    }
}
?>

<div class="card p-4 shadow-sm">
    <div class="d-flex justify-content-between mb-3">
        <h5 class="fw-bold">Edit Property</h5>
        <a href="index.php" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    <?php if ($msg): ?>
        <div class="alert alert-success"><?= $msg ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input class="form-control mb-2" name="title" value="<?= htmlspecialchars($p['title']) ?>">
        <input class="form-control mb-2" name="price" value="<?= $p['price'] ?>">
        <input class="form-control mb-2" name="location" value="<?= htmlspecialchars($p['location']) ?>">
        <input class="form-control mb-2" name="type" value="<?= htmlspecialchars($p['type']) ?>">
        <textarea class="form-control mb-2" name="description"><?= htmlspecialchars($p['description']) ?></textarea>

        <input class="form-control mb-2" type="file" name="image">

        <?php if ($p["image"]): ?>
            <img src="../uploads/<?= htmlspecialchars($p['image']) ?>"
                 style="max-width:120px" class="border mt-2">
        <?php endif; ?>

        <button class="btn btn-primary btn-sm mt-3">Save</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
