<?php
class FontManager {
    public function getFontSize() {
        return $_COOKIE['font_size'] ?? '16px';
    }
}
$fm = new FontManager();
if (isset($_GET['size'])) {
    setcookie('font_size', $_GET['size'], time() + 3600);
    header("Location: index.php");
}
?>
<div style="font-size: <?php echo $fm->getFontSize(); ?>;">
    <h1>Текст із змінним шрифтом</h1>
    <a href="?size=20px">Великий шрифт</a> |
    <a href="?size=16px">Середній шрифт</a> |
    <a href="?size=12px">Маленький шрифт</a>
</div>