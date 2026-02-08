<?php
$poem = [
        [['text' => 'Полину в мріях в купель океану,']],
        [['text' => 'Відчую '], ['text' => 'шовковистість', 'class' => 'bold'], ['text' => ' глибини,']],
        [['text' => 'Чарівні мушлі з дна собі дістану,']],
        [['text' => 'Щоб '], ['text' => 'взимку', 'class' => 'bold italic']],
        [['text' => 'тішили', 'class' => 'indent-1 underline']],
        [['text' => 'мене', 'class' => 'indent-2']],
        [['text' => 'вони…', 'class' => 'indent-3']]
];

$hryvnias = 1500;
$rate = 44.06;
$dollars = (int) floor($hryvnias / $rate);

$month = 4;
if ($month >= 3 && $month <= 5) {
    $season = 'Весна';
} elseif ($month >= 6 && $month <= 8) {
    $season = 'Літо';
} elseif ($month >= 9 && $month <= 11) {
    $season = 'Осінь';
} else {
    $season = 'Зима';
}

$letter = 'о';
switch (mb_strtolower($letter, 'UTF-8')) {
    case 'а': case 'е': case 'є': case 'и': case 'і': case 'ї': case 'о': case 'у': case 'ю': case 'я':
    $letterType = 'голосна';
    break;
    default:
        $letterType = 'приголосна';
        break;
}

$number = mt_rand(100, 999);
$first = intdiv($number, 100);
$second = intdiv($number % 100, 10);
$third = $number % 10;
$sum = $first + $second + $third;
$reverse = ($third * 100) + ($second * 10) + $first;
$digits = [$first, $second, $third];
rsort($digits);
$max = (int) implode('', $digits);

function renderColors($rows, $cols) {
    $html = '<table class="color-table">';
    for ($i = 0; $i < $rows; $i++) {
        $html .= '<tr>';
        for ($j = 0; $j < $cols; $j++) {
            $colors = ['red', 'orange', 'yellow', 'green', 'blue', 'purple', 'pink', 'brown', 'gray'];
            $html .= '<td style="background-color: ' . $colors[array_rand($colors)] . ';"></td>';
        }
        $html .= '</tr>';
    }
    return $html . '</table>';
}

function renderSquares($n) {
    $html = '<div class="square-scene">';
    for ($i = 0; $i < $n; $i++) {
        $s = mt_rand(40, 120);
        $t = mt_rand(0, 320);
        $l = mt_rand(0, 620);
        $html .= '<div class="square" style="width: '.$s.'px; height: '.$s.'px; top: '.$t.'px; left: '.$l.'px;"></div>';
    }
    return $html . '</div>';
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Lab 1</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .indent-1 { margin-left: 40px; }
        .indent-2 { margin-left: 80px; }
        .indent-3 { margin-left: 120px; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .italic { font-style: italic; }
        .color-table td { width: 50px; height: 50px; border: 1px solid #ccc; }
        .square-scene { position: relative; width: 760px; height: 420px; background: black; }
        .square { position: absolute; background: red; }
    </style>
</head>
<body>
<h1>Лабораторна робота 1</h1>
<section>
    <h2>Завдання 2</h2>
    <div class="poem">
        <?php foreach ($poem as $row): ?>
            <div><?php foreach ($row as $p): ?>
                    <span class="<?php echo $p['class'] ?? ''; ?>"><?php echo $p['text']; ?></span>
                <?php endforeach; ?></div>
        <?php endforeach; ?>
    </div>
</section>
<section>
    <h2>Завдання 3</h2>
    <p><?php echo "$hryvnias грн. можна обміняти на $dollars долар"; ?></p>
</section>
<section>
    <h2>Завдання 4</h2>
    <p>Місяць <?php echo $month; ?> — це <?php echo $season; ?></p>
</section>
<section>
    <h2>Завдання 5</h2>
    <p>Символ <?php echo $letter; ?> — <?php echo $letterType; ?> літера.</p>
</section>
<section>
    <h2>Завдання 6</h2>
    <p>Число: <?php echo $number; ?>, сума: <?php echo $sum; ?>, зворотне: <?php echo $reverse; ?>, макс: <?php echo $max; ?></p>
</section>
<section>
    <h2>Завдання 7</h2>
    <?php echo renderColors(5, 5); ?>
    <?php echo renderSquares(8); ?>
</section>
</body>
</html>