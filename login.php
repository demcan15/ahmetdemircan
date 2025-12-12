<?php
require __DIR__.'/inc/db.php';
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$stmt = $pdo->prepare('SELECT id,username,password_hash FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();
if($user && password_verify($password,$user['password_hash'])){
$_SESSION['user'] = $user['username'];
header('Location: /index.php');
exit;
} else {
$error = 'Invalid credentials';
}
}
require __DIR__.'/inc/header.php';
?>
<div class="listing">
<div class="card" style="max-width:420px;margin:40px auto">
<h3>Login</h3>
<?php if(!empty($error)) echo '<p style="color:#e53e3e">'.htmlspecialchars($error).'</p>'?>
<form method="post">
<div style="margin:12px 0"><input name="username" placeholder="Username" required style="width:100%;padding:10px;border-radius:6px;border:1px solid #ccc"></div>
<div style="margin:12px 0"><input name="password" type="password" placeholder="Password" required style="width:100%;padding:10px;border-radius:6px;border:1px solid #ccc"></div>
<div><button class="btn" type="submit">Login</button></div>
</form>
</div>
</div>
<?php require __DIR__.'/inc/footer.php'; ?>