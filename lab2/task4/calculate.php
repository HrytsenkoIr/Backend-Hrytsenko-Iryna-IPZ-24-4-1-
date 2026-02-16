<?php
require 'Function/func.php';

$x = (float)$_POST['x'];
$y = (float)$_POST['y'];

$pow_res = my_pow($x, $y);
$fact_res = my_factorial((int)$x);
$custom_tg = my_custom_tg($x);
$sin_res = my_sin($x);
$cos_res = my_cos($x);
$tg_res = my_tg($x);
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin-top: 20px;
        }
        th {
            background-color: yellow;
            color: black;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>x^y</th>
        <th>x!</th>
        <th>my_tg(x)</th>
        <th>sin(x)</th>
        <th>cos(x)</th>
        <th>tg(x)</th>
    </tr>
    <tr>
        <td><?php echo $pow_res; ?></td>
        <td><?php echo ($fact_res !== null) ? $fact_res : 'Помилка'; ?></td>
        <td><?php echo ($custom_tg !== null) ? $custom_tg : 'Невизначено'; ?></td>
        <td><?php echo $sin_res; ?></td>
        <td><?php echo $cos_res; ?></td>
        <td><?php echo $tg_res; ?></td>
    </tr>
</table>

<br>

</body>
</html>