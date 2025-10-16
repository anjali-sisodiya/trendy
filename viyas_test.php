<?php


$var = 3;

function check_number($var) {
    if ($var % 2 == 0) {
        echo "Even number\n";
    } else {
        echo "Odd number\n";
    }
}

check_number($var);

?>
