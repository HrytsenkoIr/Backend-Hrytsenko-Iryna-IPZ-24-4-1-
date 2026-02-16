<?php
// Завдання 2. Робота з масивами (4 завдання). Включає пошук повторюваних елементів, генератор імен тварин,
// роботу з двома масивами (об'єднання, унікальність, сортування) та сортування асоціативного масиву користувачів.

function findDuplicates($arr) {
    $counts = array_count_values($arr);
    foreach ($counts as $val => $count) {
        if ($count > 1) echo "Повторюється: $val <br>";
    }
}

function generateName($syllables) {
    return $syllables[array_rand($syllables)] . $syllables[array_rand($syllables)];
}

function createArray() {
    $len = rand(3, 7);
    $arr = [];
    for ($i = 0; $i < $len; $i++) $arr[] = rand(10, 20);
    return $arr;
}

function processArrays($arr1, $arr2) {
    $merged = array_merge($arr1, $arr2);
    $unique = array_unique($merged);
    sort($unique);
    return $unique;
}

function sortUsers(&$arr, $byAge = true) {
    if ($byAge) uasort($arr, fn($a, $b) => $a <=> $b);
    else uksort($arr, fn($a, $b) => strcmp($a, $b));
}

// Демонстрація
echo "<h3>1. Повторювані елементи:</h3>";
findDuplicates([1, 2, 2, 3, 4, 4, 5]);

echo "<h3>2. Генератор імен:</h3>";
$syllables = ['Мур', 'Бар', 'Кі', 'Тя', 'Пуш'];
echo "Ваш улюбленець: " . generateName($syllables);

echo "<h3>3. Робота з двома масивами:</h3>";
$arr1 = createArray();
$arr2 = createArray();
echo "Масив 1: " . implode(", ", $arr1) . "<br>";
echo "Масив 2: " . implode(", ", $arr2) . "<br>";
$result = processArrays($arr1, $arr2);
echo "Результат (об'єднані, унікальні, відсортовані): " . implode(", ", $result);

echo "<h3>4. Сортування користувачів:</h3>";
$users = ["Ivan" => 20, "Anna" => 25, "Oleg" => 18];

echo "Сортування за віком:<br>";
sortUsers($users, true);
print_r($users);

echo "<br><br>Сортування за іменами:<br>";
sortUsers($users, false);
print_r($users);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Завдання 2</title>
</head>
<body>
</body>
</html>