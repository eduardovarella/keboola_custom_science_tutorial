<?php
$inputFile = fopen('/data/in/tables/source.csv','r');
$outputFile = fopen('/data/out/tables/result.csv', 'w');

$lineNumber = 0;
while ($line = fgets($inputFile)) {
    
    $newLine = "";
    if($lineNumber == 0){
        $newLine = str_replace("\r\n", ",double_number\r\n", $line);
    }
    else {
        $columns = explode(",", $line);

        $newLine = $columns[0] . "," .  str_replace("\r\n", "", $columns[1]) . "," . $columns[0] . "\r\n";
    }
    
    fwrite($outputFile, $newLine);
    $lineNumber++;
}

fclose($outputFile);
fclose($inputFile);
?>