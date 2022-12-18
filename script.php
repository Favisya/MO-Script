#!/usr/bin/php
<?php

require 'vendor/phplucidframe/console-table/src/LucidFrame/Console/ConsoleTable.php';

function f(float $x): float
{
    return pow($x, 2) - 16;
}

function Halfmethod(float $a, float $b, float $eps)
{
    echo "\t" ."\t" . 'Dichotomy method' . PHP_EOL;

    $table = new LucidFrame\Console\ConsoleTable();
    $table->setHeaders(['step', 'c', 'a', 'b', 'f(c)']);

    $count = 0;
    $c = 0;
    while (abs($b - $a) > $eps) {
        $count++;
        $c = ($a + $b) / 2;
        $fc = f($c);

        if (f($b) * f($c) < 0)
            $a = $c;
        else
            $b = $c;
        $table->addRow([$count, $c, $a, $b, $fc]);

        if (abs(f($c)) < $eps) {
            $table->display();
            return $c;
        }
    }

    $table->display();
    return ($a + $b) / 2;
}


function fib(float $a, float $b, float $eps)
{
    echo "\t" ."\t" . 'Fibonacci method' . PHP_EOL;

    $table = new LucidFrame\Console\ConsoleTable();
    $table->setHeaders(['step', 'a', 'b', 'b - a', 'a+i*c', 'a+k*c']);

    $g = (sqrt(5) - 1.0) / 2;
    $k = 0;
    $a1 = $a + (1 - $g) * ($b - $a);
    $b1 = $a + $g * ($b - $a);
    $count = 0;
    $bb = 0;
    while (abs($b - $a) > $eps) {
        $count++;
        $bb = $b;
        $aa = $a;
        $ba = $b - $a;


        if (f($a1) > f($b1)) {
            $a = $a1;
            $a1 = $b1;
            $b1 = $a + $g * ($b - $a);
        } else {
            $b = $b1;
            $b1 = $a1;
            $a1 = $a + (1 - $g) * ($b - $a);
        }

        if (++$k > 1e5) {
            break;
        }
        $table->addRow([$count, $a, $bb, $ba, $b1, $b]);
    }
    $table->display();
    return ($a + $b) / 2;
}


$a   = halfMethod($argv[1], $argv[2], $argv[3]);
$fib = fib($argv[1], $argv[2], $argv[3]);

echo "\t" . 'Dichotomy\Fibonacci' . PHP_EOL;
echo 'Ext = ' . $a . '\\' . $fib . PHP_EOL;
echo 'Difference between D and F methos is: ' . ($a - $fib) . PHP_EOL;
