<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$total = $pdo->query("SELECT COUNT(*) FROM properties WHERE user_id = " . (int)$_SESSION['user_id'])->fetchColumn();
$avg   = $pdo->query("SELECT AVG(price) FROM properties WHERE user_id = " . (int)$_SESSION['user_id'])->fetchColumn();
?>

<div class="container mt-4">
    <div class="row">

        <div class="col-lg-3 mb-4">
            <div class="card p-3 shadow-sm sticky-top" style="top:20px;">
                <h6 class="fw-bold mb-3">Filters</h6>

                <form id="filterForm">
                    <div class="mb-2">
                        <input class="form-control form-control-sm"
                               name="q"
                               placeholder="Location">
                    </div>

                    <div class="mb-2">
                        <select class="form-select form-select-sm" name="type">
                            <option value="">All Types</option>
                            <option>Apartment</option>
                            <option>House</option>
                            <option>Villa</option>
                            <option>Office</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <input class="form-control form-control-sm"
                               name="min_price"
                               type="number"
                               placeholder="Min price">
                    </div>

                    <div class="mb-2">
                        <input class="form-control form-control-sm"
                               name="max_price"
                               type="number"
                               placeholder="Max price">
                    </div>
                </form>

                <hr class="my-2">

                <div class="small">Total: <strong><?= (int)$total ?></strong></div>
                <div class="small">
                    Avg:
                    <strong>₹<?= $avg ? number_format($avg, 0) : 0 ?></strong>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Available Properties</h5>
                <a href="add.php" class="btn btn-primary btn-sm">+ Add Property</a>
            </div>

            <div id="results" class="row g-4"></div>
        </div>

    </div>
</div>

<script src="../assets/js/search.js"></script>

<?php include "../includes/footer.php"; ?>
