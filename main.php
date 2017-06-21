<?php
$outputFile = fopen('/data/out/tables/result.csv', 'w');

fwrite($outputFile, "col1,col2,col3\n");
fwrite($outputFile, "1,2,3\n");
fwrite($outputFile, "1,2,3\n");
fwrite($outputFile, "1,2,3\n");

fclose($outputFile);
?>