<?php
require '../config/db.php';

/*
=====================
STATS
=====================
*/

$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$totalLost = $pdo->query("SELECT COUNT(*) FROM lost_items")->fetchColumn();
$totalFound = $pdo->query("SELECT COUNT(*) FROM found_items")->fetchColumn();
$totalClaims = $pdo->query("SELECT COUNT(*) FROM claims")->fetchColumn();

/*
=====================
CATEGORY DATA
=====================
*/

$categoryData = $pdo->query("
SELECT category, COUNT(*) as total
FROM lost_items
GROUP BY category
")->fetchAll();

$labels = [];
$data = [];

foreach($categoryData as $c){
    $labels[] = $c['category'];
    $data[] = $c['total'];
}

/*
=====================
DEPARTMENT DATA
=====================
*/

$deptData = $pdo->query("
SELECT departments.name, COUNT(lost_items.id) as total
FROM lost_items
LEFT JOIN departments ON lost_items.department_id = departments.id
GROUP BY departments.name
")->fetchAll();

$deptLabels = [];
$deptValues = [];

foreach($deptData as $d){
    $deptLabels[] = $d['name'] ?? 'Unknown';
    $deptValues[] = $d['total'];
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Analytics Dashboard | CampuRecover</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{
    background:#F3F6F9;
    font-family:Segoe UI;
}

/* TOP BAR */
.topbar{
    background:linear-gradient(135deg,#0F766E,#14B8A6);
    color:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

/* STAT CARDS */
.stat-card{
    background:white;
    border-radius:18px;
    padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-card h5{
    color:#6B7280;
}

.stat-card h2{
    font-weight:bold;
}

/* ICON BACK */
.stat-card::after{
    content:"";
    position:absolute;
    right:-20px;
    top:-20px;
    width:100px;
    height:100px;
    background:#0F766E;
    opacity:0.08;
    border-radius:50%;
}

/* CHART BOX */
.chart-box{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.chart-box:hover{
    transform:translateY(-5px);
}

/* SECTION TITLE */
.section-title{
    font-weight:bold;
    margin-bottom:15px;
    color:#0F766E;
}

</style>

</head>

<body>

<div class="container py-4">

<!-- TOP BAR -->
<div class="topbar mb-4">
    <h2>📊 Analytics Dashboard</h2>
    <p class="mb-0">Real-time insights of CampuRecover system</p>
</div>

<!-- STATS -->
<div class="row g-4 mb-4">

<div class="col-md-3">
<div class="stat-card text-center">
<h5>Users</h5>
<h2><?= $totalUsers ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card text-center">
<h5>Lost Items</h5>
<h2><?= $totalLost ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card text-center">
<h5>Found Items</h5>
<h2><?= $totalFound ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="stat-card text-center">
<h5>Claims</h5>
<h2><?= $totalClaims ?></h2>
</div>
</div>

</div>

<!-- CHARTS -->
<div class="row g-4">

<div class="col-md-6">

<div class="chart-box">

<h5 class="section-title">📦 Lost Items by Category</h5>

<canvas id="catChart"></canvas>

</div>

</div>

<div class="col-md-6">

<div class="chart-box">

<h5 class="section-title">🏢 Department Wise Lost Items</h5>

<canvas id="deptChart"></canvas>

</div>

</div>

</div>

</div>

<script>

/* CATEGORY PIE */
new Chart(document.getElementById('catChart'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            data: <?= json_encode($data) ?>,
            backgroundColor: [
                '#0F766E',
                '#14B8A6',
                '#2563EB',
                '#F59E0B',
                '#EF4444'
            ],
            borderWidth: 2
        }]
    }
});

/* DEPARTMENT BAR */
new Chart(document.getElementById('deptChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($deptLabels) ?>,
        datasets: [{
            label: 'Lost Items',
            data: <?= json_encode($deptValues) ?>,
            backgroundColor: '#0F766E',
            borderRadius: 10
        }]
    }
});

</script>

</body>
</html>