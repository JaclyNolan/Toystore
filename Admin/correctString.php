<?php 
function correctString(string $name) {
    $i = 0;
    while ($i < strlen($name)) {
        if ($name[$i] == "'") {
            for ($j = strlen($name); $j > $i; $j--) {
                $name[$j] = $name[$j - 1];
            }
            $name[$i] = "\\";
            $i++;
        }
        $i++;
    }
    return $name;
}
?>