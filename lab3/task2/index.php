<?php
session_start();
class Auth {
    public function login($u, $p) {
        if ($u === 'Admin' && $p === 'password') {
            $_SESSION['user'] = $u;
        }
    }
    public function logout() { session_destroy(); }
    public function isLogged() { return isset($_SESSION['user']); }
}
$auth = new Auth();
if (isset($_POST['login'])) $auth->login($_POST['user'], $_POST['pass']);
if (isset($_GET['logout'])) $auth->logout();
?>
<?php if ($auth->isLogged()): ?>
    <p>Добрий день, <?php echo $_SESSION['user']; ?>!</p>
    <a href="?logout=true">Вийти</a>
<?php else: ?>
    <form method="post">
        <input name="user" placeholder="Логін"><input type="password" name="pass" placeholder="Пароль">
        <button type="submit" name="login">Увійти</button>
    </form>
<?php endif; ?>