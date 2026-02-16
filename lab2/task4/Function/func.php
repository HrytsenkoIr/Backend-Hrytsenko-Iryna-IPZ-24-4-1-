<?php
function my_sin(float $x): float { return sin($x); }
function my_cos(float $x): float { return cos($x); }
function my_tg(float $x): float { return tan($x); }

function my_custom_tg(float $x): ?float {
    $c = cos($x);
    if (abs($c) < 1e-10) return null;
    return sin($x) / $c;
}

function my_pow(float $x, float $y): float { return pow($x, $y); }

function my_factorial(int $n): ?int {
    if ($n < 0) return null;
    $res = 1;
    for ($i = 2; $i <= $n; $i++) $res *= $i;
    return $res;
}
?>