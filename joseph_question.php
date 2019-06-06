<?php

function joseph_question(int $n, int $m)
{
    $p = 0;
    for ($i = 2; $i <= $n; $i++) {
        $p = ($p - $m) % $i;
    }

    echo abs($p) + 1;
}
echo joseph_question(4, 2);

