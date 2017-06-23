<?php
require_once('Encoding.php'); 
use \ForceUTF8\Encoding;  // It's namespaced now.

$from_ftp_server = "filetransfer.indico.net.br";
$from_ftp_user_name = "ext.mfs.romulo";
$from_ftp_user_pass = "Zuum@4566";

$to_ftp_server = "ftp.web1421.kinghost.net";
$to_ftp_user_name = "evarella";
$to_ftp_user_pass = "punk2017";

$TAB_DIST_CADT = array('in/TAB_DIST_CADT.txt', '_model/TAB_DIST_CADT.csv', '/MFS/indico2mfs/TAB_DIST_CADT.txt', '/punkmetrics/TAB_DIST_CADT.csv'); 
$Pedido_Cartao = array('in/Pedido_Cartao.txt', '_model/Pedido_Cartao.csv', '/MFS/indico2mfs/Pedido_Cartao.txt', '/punkmetrics/Pedido_Cartao.csv'); 
$Cartoes = array('in/Cartoes.txt', '_model/Cartoes.csv', '/MFS/indico2mfs/Cartoes.txt', '/punkmetrics/Cartoes.csv'); 
$Consumer_Transactions = array('in/Consumer_Transactions.txt', '_model/Consumer_Transactions.csv', '/MFS/indico2mfs/Consumer_Transactions.txt', '/punkmetrics/Consumer_Transactions.csv'); 
$DataMart = array('in/20170531_DataMart.txt', '_model/20170531_DataMart.csv', '/MFS/indico2mfs/Data_Mart/20170531_DataMart.txt', '/punkmetrics/20170531_DataMart.csv'); 
$TAB_BASE_CANL = array('in/TAB_BASE_CANL.txt', '_model/TAB_BASE_CANL.csv', '/MFS/indico2mfs/TAB_BASE_CANL.txt', '/punkmetrics/TAB_BASE_CANL.csv'); 
	
$files = array($TAB_DIST_CADT, $Pedido_Cartao, $Cartoes, $Consumer_Transactions, $DataMart, $TAB_BASE_CANL); 

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

	$encodingOutput = Encoding::fixUTF8(fgets($inputFile));
	fwrite($outputFile, $encodingOutput);
	
	$encodingOutput = Encoding::fixUTF8(fgets($inputFile));
	fwrite($outputFile, $encodingOutput);

	fclose($inputFile);
	fclose($outputFile);
	echo "== Encoding file $input_local_file [$inputSize] to $input_local_file: done                         \n";
}
echo "==========================================\n";
?>