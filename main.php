<?php
require_once('Encoding.php'); 
use \ForceUTF8\Encoding;  // It's namespaced now.

$from_ftp_server = "filetransfer.indico.net.br";
$from_ftp_user_name = "ext.mfs.romulo";
$from_ftp_user_pass = "Zuum@4566";

$to_ftp_server = "ftp.web1421.kinghost.net";
$to_ftp_user_name = "evarella";
$to_ftp_user_pass = "punk2017";

$TAB_DIST_CADT = array('in/TAB_DIST_CADT.txt', 'out/TAB_DIST_CADT.csv', '/MFS/indico2mfs/TAB_DIST_CADT.txt', '/punkmetrics/TAB_DIST_CADT.csv'); 
$Pedido_Cartao = array('in/Pedido_Cartao.txt', 'out/Pedido_Cartao.csv', '/MFS/indico2mfs/Pedido_Cartao.txt', '/punkmetrics/Pedido_Cartao.csv'); 
$Cartoes = array('in/Cartoes.txt', 'out/Cartoes.csv', '/MFS/indico2mfs/Cartoes.txt', '/punkmetrics/Cartoes.csv'); 
$Consumer_Transactions = array('in/Consumer_Transactions.txt', 'out/Consumer_Transactions.csv', '/MFS/indico2mfs/Consumer_Transactions.txt', '/punkmetrics/Consumer_Transactions.csv'); 
$DataMart = array('in/20170531_DataMart.txt', 'out/20170531_DataMart.csv', '/MFS/indico2mfs/Data_Mart/20170531_DataMart.txt', '/punkmetrics/20170531_DataMart.csv'); 
$TAB_BASE_CANL = array('in/TAB_BASE_CANL.txt', 'out/TAB_BASE_CANL.csv', '/MFS/indico2mfs/TAB_BASE_CANL.txt', '/punkmetrics/TAB_BASE_CANL.csv'); 
	
//$files = array($TAB_DIST_CADT, $Pedido_Cartao, $Cartoes, $Consumer_Transactions, $DataMart, $TAB_BASE_CANL); 
$files = array($TAB_BASE_CANL); 

echo "==========================================\n";
echo "== Downloading files\n";
echo "==========================================\n";
echo "== Connecting to source ftp server " . $from_ftp_server . "\n";
$source_conn_id = ftp_connect($from_ftp_server);

echo "== Authenticating " . $from_ftp_user_name . " on source ftp server\n";
ftp_login($source_conn_id, $from_ftp_user_name, $from_ftp_user_pass);

ftp_pasv($source_conn_id, true);

foreach ($files as $file) {
	
	$input_local_file = $file[0];
	$output_local_file = $file[1];
	$from_server_file = $file[2];
	$to_server_file = $file[3];
	
	$server_size = ftp_size($source_conn_id, $from_server_file);
	
	echo "== Downloading file $from_server_file [size: $server_size] to $input_local_file:\r";
	$ret = ftp_nb_get($source_conn_id, $input_local_file, $from_server_file, FTP_ASCII);
	while ($ret == FTP_MOREDATA) {
		$ret = ftp_nb_continue($source_conn_id);
		clearstatcache();
		$currentSize = filesize($input_local_file);
		$progress = round(($currentSize/$server_size)*100);
		echo "== Downloading file $from_server_file [size: $server_size] to $input_local_file: $progress% [$currentSize]\r";
	}
	echo "== Downloading file $from_server_file [size: $server_size] to $input_local_file: done [$server_size]         \n";

}

echo "== Disconnecting from source ftp server " . $from_ftp_server . "\n";
ftp_close($source_conn_id);
echo "==========================================\n";

echo "==========================================\n";
echo "== Encoding files\n";
echo "==========================================\n";

foreach ($files as $file) {
	
	$input_local_file = $file[0];
	$output_local_file = $file[1];
	$from_server_file = $file[2];
	$to_server_file = $file[3];
	
	$inputSize = filesize($input_local_file);
	echo "== Encoding file $input_local_file [$inputSize] to $output_local_file: 0% [0]                   \r";

	$inputFile = fopen("$input_local_file","r");
	$outputFile = fopen($output_local_file, 'w');

	while(! feof($inputFile))
	{
		$encodingOutput = Encoding::fixUTF8(fgets($inputFile));
		fwrite($outputFile, $encodingOutput);
		clearstatcache();
		$currentSize = filesize($output_local_file);
		$progress = round(($currentSize/$inputSize)*100);
		echo "== Encoding file $input_local_file [$inputSize] to $output_local_file: $progress% [$currentSize]                       \r";
	}

	fclose($inputFile);
	fclose($outputFile);
	echo "== Encoding file $input_local_file [$inputSize] to $input_local_file: done                         \n";
}
echo "==========================================\n";
/*
echo "==========================================\n";
echo "== Uploading files \n";
echo "==========================================\n";

echo "== Connecting to destination ftp server " . $to_ftp_server . "\n";
$to_conn_id = ftp_connect($to_ftp_server);

echo "== Authenticating " . $to_ftp_user_name . " on source ftp server\n";
ftp_login($to_conn_id, $to_ftp_user_name, $to_ftp_user_pass);

ftp_pasv($to_conn_id, true);

foreach ($files as $file) {
	
	$input_local_file = $file[0];
	$output_local_file = $file[1];
	$from_server_file = $file[2];
	$to_server_file = $file[3];

	echo "== Uploading file  " . $output_local_file . " to " . $to_server_file . "...\n";
	if (ftp_put($to_conn_id, $to_server_file, $output_local_file, FTP_ASCII)) {
		echo "== Successfully written  $to_server_file\n";
	} else {
		echo "== There was a problem\n";
	}
}

echo "== Disconnecting from source ftp server " . $to_ftp_server . "\n";
ftp_close($to_conn_id);
echo "==========================================\n";
*/
?>