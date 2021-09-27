<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../app/Libraries/Shopify.php');
use App\Libraries\Shopify;

$data = trim(file_get_contents('php://input'));

$creds['shop_name']     = 'borrowbeez';
$creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
$creds['api_password']  = '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';
$sp = new Shopify($creds);

if(null !== $data && !empty($data)) {
	//start
	$data = json_decode($data);
	file_put_contents(__DIR__."/data.log", print_r($data, true).PHP_EOL, FILE_APPEND);
}

?>