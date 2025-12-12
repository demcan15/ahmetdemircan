<?php
require __DIR__.'/inc/db.php';
require __DIR__.'/inc/header.php';
$perPage = 8;
$page = max(1,intval($_GET['page'] ?? 1));
$search = trim($_GET['q'] ?? '');
$params = [];
$where = '';
if($search !