<?php

$ftp_server = "ftp.web1421.kinghost.net";
$ftp_user_name = "evarella";
$ftp_user_pass = "punk2017";

// define some variables
$local_file = '/data/out/tables/local_TAB_DIST_CADT_varella.csv';
$server_file = '/punkmetrics/TAB_DIST_CADT_varella.csv';

// set up basic connection
echo "Connecting to " . $ftp_server . "\n";
$conn_id = ftp_connect($ftp_server);
echo "conn_id: " . $conn_id . "\n";

// login with username and password
echo "Authenticating " . $ftp_user_name . "\n";
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

ftp_pasv($conn_id, TRUE);

// try to download $server_file and save to $local_file
if (ftp_get($conn_id, $local_file, $server_file, FTP_ASCII)) {
    echo "Successfully written to $local_file\n";
} else {
    echo "There was a problem\n";
}

// close the connection
ftp_close($conn_id);

$outputFile = fopen('/data/out/tables/result.csv', 'w');
//$outputFile = fopen('result.csv', 'w');

fwrite($outputFile, "col1,col2,col3\n");
fwrite($outputFile, "1,2,3\n");
fwrite($outputFile, "1,2,3\n");
fwrite($outputFile, "1,2,3\n");

fclose($outputFile);
?>