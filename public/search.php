<?php
require "../includes/auth_check.php";
require "../config/db.php";

$user_id = $_SESSION['user_id'];

$q    = trim($_GET['q'] ?? '');
$type = trim($_GET['type'] ?? '');
$min  = $_GET['min_price'] ?? '';
$max  = $_GET['max_price'] ?? '';

$sql = "SELECT * FROM properties WHERE user_id = ?";
$params = [$user_id];

if ($q !== '') {
    $sql .= " AND location LIKE ?";
    $params[] = "%$q%";
}

if ($type !== '') {
    $sql .= " AND LOWER(type) = LOWER(?)";
    $params[] = $type;
}

if ($min !== '' && $max !== '') {
    $sql .= " AND price BETWEEN ? AND ?";
    $params[] = $min;
    $params[] = $max;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

if (!$rows) {
    echo '<div class="col-12 text-center text-muted">No properties found</div>';
    exit;
}

foreach ($rows as $p):
?>
<div class="col-md-6 col-xl-4">
    <div class="card h-100 shadow-sm">

        <?php if (!empty($p['image'])): ?>
            <img src="../uploads/<?= htmlspecialchars($p['image']) ?>"
                 class="card-img-top"
                 style="height:190px; object-fit:cover;">
        <?php else: ?>
            <div class="bg-light d-flex align-items-center justify-content-center"
                 style="height:190px;">
                No Image
            </div>
        <?php endif; ?>

        <div class="card-body d-flex flex-column">
            <h6 class="fw-bold mb-1"><?= htmlspecialchars($p['title']) ?></h6>

            <div class="text-muted small mb-1">
                <?= htmlspecialchars($p['location']) ?>
            </div>

            <div class="fw-semibold mb-3">
                ₹<?= number_format($p['price']) ?>
            </div>

            <div class="mt-auto d-flex justify-content-between">
                <a href="edit.php?id=<?= $p['id'] ?>"
                   class="btn btn-outline-primary btn-sm">
                    Edit
                </a>

                <a href="delete.php?id=<?= $p['id'] ?>"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('Delete this property?')">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
