<?php
require __DIR__.'/inc/db.php';
require __DIR__.'/inc/header.php';
$perPage = 6;
$page = max(1,intval($_GET['page'] ?? 1));
$search = trim($_GET['q'] ?? '');
$params = [];
$where = '';
if($search !== ''){
$where = 'WHERE title LIKE ? OR company LIKE ? OR location LIKE ?';
$like = "%$search%";
$params = [$like,$like,$like];
}
$totalStmt = $pdo->prepare("SELECT COUNT(*) FROM jobs $where");
$totalStmt->execute($params);
$total = $totalStmt->fetchColumn();
$offset = ($page-1)*$perPage;
$stmt = $pdo->prepare("SELECT * FROM jobs $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$jobs = $stmt->fetchAll();
?>
<div class="listing">
<div class="breadcrumbs">Home / Jobs</div>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
<form class="search-box" method="get">
<input name="q" placeholder="Search jobs" value="<?php echo htmlspecialchars($search) ?>">
<button class="btn" type="submit">Search</button>
</form>
<div>Results: <?php echo $total ?></div>
</div>
<div class="grid">
<?php foreach($jobs as $job): ?>
<div class="card">
<img src="/assets/images/<?php echo htmlspecialchars($job['image'] ?: 'placeholder.jpg') ?>" alt="">
<h3><?php echo htmlspecialchars($job['title']) ?></h3>
<p><strong>Company:</strong> <?php echo htmlspecialchars($job['company']) ?></p>
<p class="location"><?php echo htmlspecialchars($job['location']) ?></p>
<p><strong>Type:</strong> <?php echo htmlspecialchars($job['type']) ?> <strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']) ?></p>
</div>
<?php endforeach; ?>
</div>
<div style="margin-top:20px">
<ul class="pagination">
<?php for($i=1;$i<=ceil($total/$perPage);$i++): ?>
<li><a href="?page=<?php echo $i?>&q=<?php echo urlencode($search)?>"><?php echo $i?></a></li>
<?php endfor; ?>
</ul>
</div>
</div>
<?php require __DIR__.'/inc/footer.php'; ?>