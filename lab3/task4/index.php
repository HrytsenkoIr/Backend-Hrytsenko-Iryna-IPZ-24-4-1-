<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завантаження зображення</title>
</head>
<body>
<h2>Завантажте зображення</h2>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Надіслати</button>
</form>
</body>
</html>