<?php
// Завдання 4. Робота з функціями. Форма для вводу даних та виклику математичних функцій (sin, cos, tg, факторіал тощо), підключених з окремого файлу.
?>
<!DOCTYPE html>
<html>
<body>
<form action="calculate.php" method="post">
    x: <input type="text" name="x" required>
    y: <input type="text" name="y" required>
    <button type="submit">=</button>
</form>
</body>
</html>