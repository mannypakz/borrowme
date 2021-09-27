<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

require_once('../../app/Libraries/Shopify.php');
require_once '../../vendor/autoload.php';

use App\Libraries\Shopify;
use Swift_Mailer as SwiftMailer;
use Swift_SmtpTransport as SmtpTransport;
use Swift_SendmailTransport as SendmailTransport;
use Swift_MailTransport as MailTransport;
use Illuminate\Mail\Transport\MailgunTransport;
use Illuminate\Mail\Transport\MandrillTransport;
use Illuminate\Mail\Transport\LogTransport;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\Mail\Mailer;

// $resolver = new EngineResolver;
// $resolver->register('php', function()
// {
//     return new PhpEngine;
// });
// $finder = new FileViewFinder(new Filesystem, ['email']);
// $view = new Factory($resolver, $finder, new Dispatcher());

// $transport = new \Swift_SmtpTransport('smtp.gmail.com', '587');
// $transport->setUsername('bios.apiv3@gmail.com');
// $transport->setPassword('B10sP@ass!82');
// $transport->setEncryption('tls');

// $swift = new SwiftMailer($transport);

// $mailer = new Mailer('Order Confirmation', $view, $swift);

// $data = [
// 	'greeting' => 'Hello',
// ];

// $mailer->send('email', $data, function($message)
// {
//     $message->from('bios.apiv3@gmail.com', 'BorrowMe');
//     $message->to('suson.emmanuel@gmail.com', 'Tester');
//     $message->subject('Order Confirmation');
// });

if(isset($_POST) && !empty($_POST)) {
	// file_put_contents(__DIR__."/shopify.log", print_r($_POST, true), FILE_APPEND);
	$creds['shop_name']     = 'borrowbeez';
	$creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
	$creds['api_password']  = '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';
	$sp = new Shopify($creds);

	$id = $_POST['product_id'];

	$product = $sp->s_get("products/" . $id . ".json");
	$metafields = $sp->s_get("products/" . $id . "/metafields.json");

	$resolver = new EngineResolver;
	$resolver->register('php', function()
	{
	    return new PhpEngine;
	});
	$finder = new FileViewFinder(new Filesystem, ['email']);
	$view = new Factory($resolver, $finder, new Dispatcher());

	$transport = new \Swift_SmtpTransport('smtp.gmail.com', '587');
	$transport->setUsername('bios.apiv3@gmail.com');
	$transport->setPassword('B10sP@ass!82');
	$transport->setEncryption('tls');

	$swift = new SwiftMailer($transport);

	$mailer = new Mailer('Order Confirmation', $view, $swift);
	$flat = '';
	$building = '';
	$street = '';
	$area = '';
	$city = '';
	$neighborhood = '';
	$phone = '';
	$owner_mail = '';
	$vendor_id = '';
	$order_data = [
		"product_id" => $id,
		"rented" => 0,
		"bought" => 0,
		"status" => '',
		"date_rented" => '',
		"date_available" => '',
	];

	$host = "127.0.0.1";
	$username = "ceypdgthuq";
	$password = "WSkCuy2vgp";
	$db = "ceypdgthuq";

	$con = mysqli_connect($host, $username, $password, $db);
	if(!$con) {
		die("Connection failed");
		file_put_contents(__DIR__."/die.log", "Connection failed", FILE_APPEND);
	}


	if($_POST['mode'] == 'rent') {
		foreach($metafields['result']->metafields as $meta) {
			if($meta->namespace == 'rent_status') {
				$metafield = (object)array(
                	"metafield" => (object)array(
                    	"id" => $meta->id,
                    	"value" => "Currently Rented"
                	)
            	);
            	$r = $sp->s_put("metafields/".$meta->id.".json", $metafield);
			}
			if($meta->namespace == 'date_rented') {
				$metafield = (object)array(
                	"metafield" => (object)array(
                    	"id" => $meta->id,
                    	"value" => $_POST['contact']['Start Date']
                	)
            	);
            	$r = $sp->s_put("metafields/".$meta->id.".json", $metafield);
			}
			if($meta->namespace == 'date_available') {
				$metafield = (object)array(
                	"metafield" => (object)array(
                    	"id" => $meta->id,
                    	"value" => $_POST['contact']['End Date']
                	)
            	);
            	$r = $sp->s_put("metafields/".$meta->id.".json", $metafield);
			}
			if($meta->namespace == 'flat_number') {
				$flat = $meta->value;
			}
			if($meta->namespace == 'building_name') {
				$building = $meta->value;
			}
			if($meta->namespace == 'street_number') {
				$street = $meta->value;
			}
			if($meta->namespace == 'area_name') {
				$area = $meta->value;
			}
			if($meta->namespace == 'city_name') {
				$city = $meta->value;
			}
			if($meta->namespace == 'neighborhood') {
				$neighborhood = $meta->value;
			}
			if($meta->namespace == 'phone') {
				$phone = $meta->value;
			}
			if($meta->namespace == 'email') {
				$owner_mail = $meta->value;
			}
			if($meta->namespace == 'vendor_id') {
				$vendor_id = $meta->value;
			}
		}
		$d_rented = new DateTime($_POST['contact']['Start Date']);
		$d_available = new DateTime($_POST['contact']['End Date']);

		$order_data["date_rented"] = '2020-11-16 00:00:00';
		$order_data["date_available"] = '2020-11-16 00:00:00';
		$order_data["rented"] = 1;
		$order_data["status"] = "Currently Borrowing";

		$price = (float) filter_var( $_POST['contact']['Product Price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

		$sql = "INSERT INTO orders (vendor_id, product_id, rented, bought, status, price, date_rented, date_available, created_at, updated_at) VALUES ({$vendor_id}, {$order_data['product_id']}, {$order_data['rented']}, {$order_data['bought']}, '{$order_data['status']}', {$price}, '{$order_data['date_rented']}', '{$order_data['date_available']}', now(), now())";

		$res = mysqli_query($con, $sql);
		if($res) {
			// file_put_contents(__DIR__."/inserted.log", print_r($res, true), FILE_APPEND);
		}
		else {
			// echo mysqli_error($con);
			file_put_contents(__DIR__."/insert_error.log", mysqli_error($con), FILE_APPEND);
		}
		
		//Email for customer
		$data = [
			'greeting' => 'Hello',
			'name' => $_POST['contact']['Name'],
			'body' => 'You have requested to rent the item <b>' . $_POST['contact']['Product Name'] . '</b> from <b>' . $product['result']->product->vendor . "</b>.".' Starting from ' . '<b>' . $_POST['contact']['Start Date'] . '</b>' . ' until ' . '<b>' . $_POST['contact']['End Date'] . '</b>.',
			'flat' => $flat,
			'building' => $building,
			'street' => $street,
			'area' => $area,
			'city' => $city,
			'neighborhood' => $neighborhood,
			'phone' => $phone,
			'sal' => 'Lender',
			'note' => $_POST['contact']['Message']
		];
		$mailer->send('email', $data, function($message)
		{
		    $message->from('bios.apiv3@gmail.com', 'BorrowMe');
		    $message->to($_POST['contact']['email'], $_POST['contact']['Name']);
		    $message->subject('Rental Confirmation');
		});

		//Email for vendor
		$data2 = [
			'greeting' => 'Hello',
			'name' => $product['result']->product->vendor,
			'body' => $_POST['contact']['Name'] . ' wants to lend the item <b>' . $_POST['contact']['Product Name'] . '</b> . Starting from <b>' . $_POST['contact']['Start Date'] . '</b> until <b>' .  $_POST['contact']['End Date'] . '</b>.',
			'customer_email' => $_POST['contact']['email'],
			'note' => $_POST['contact']['Message']
		];
		$mailer->send('vendor', $data2, function($message)
		{
		    $message->from('bios.apiv3@gmail.com', 'BorrowMe');
		    $message->to($owner_mail, $product['result']->product->vendor);
		    $message->subject('BorrowMe Notification');
		});
	}
	else {
		foreach($metafields['result']->metafields as $meta) {
			if($meta->namespace == 'sale_status') {
				$metafield = (object)array(
                	"metafield" => (object)array(
                    	"id" => $meta->id,
                    	"value" => "Sold"
                	)
            	);
            	$r = $sp->s_put("metafields/".$meta->id.".json", $metafield);
			}
			if($meta->namespace == 'flat_number') {
				$flat = $meta->value;
			}
			if($meta->namespace == 'building_name') {
				$building = $meta->value;
			}
			if($meta->namespace == 'street_number') {
				$street = $meta->value;
			}
			if($meta->namespace == 'area_name') {
				$area = $meta->value;
			}
			if($meta->namespace == 'city_name') {
				$city = $meta->value;
			}
			if($meta->namespace == 'neighborhood') {
				$neighborhood = $meta->value;
			}
			if($meta->namespace == 'phone') {
				$phone = $meta->value;
			}
			if($meta->namespace == 'vendor_id') {
				$vendor_id = $meta->value;
			}
		}
		$order_data["bought"] = 1;
		$order_data["status"] = "Purchased";
		
		$price = (float) filter_var( $_POST['contact']['Product for sale price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );

		$sql = "INSERT INTO orders (vendor_id, product_id, rented, bought, status, price, date_rented, date_available, created_at, updated_at) VALUES ({$vendor_id}, {$order_data['product_id']}, {$order_data['rented']}, {$order_data['bought']}, '{$order_data['status']}', {$price}, '{$order_data['date_rented']}', '{$order_data['date_available']}', now(), now())";

		$res = mysqli_query($con, $sql);
		if($res) {
			// file_put_contents(__DIR__."/inserted.log", print_r($res, true), FILE_APPEND);
		}
		else {
			// echo mysqli_error($con);
			file_put_contents(__DIR__."/insert_error.log", mysqli_error($con), FILE_APPEND);
		}

		//Email for customer
		$data = [
			'greeting' => 'Hello',
			'name' => $_POST['contact']['Name'],
			'body' => 'You have requested to buy the item <b>' . $_POST['contact']['Product Name'] . '</b> from <b>' . $product['result']->product->vendor . "</b>.",
			'flat' => $flat,
			'building' => $building,
			'street' => $street,
			'area' => $area,
			'city' => $city,
			'neighborhood' => $neighborhood,
			'phone' => $phone,
			'sal' => 'Seller',
			'note' => $_POST['contact']['Message']
		];
		$mailer->send('email', $data, function($message)
		{
		    $message->from('bios.apiv3@gmail.com', 'BorrowMe');
		    $message->to($_POST['contact']['email'], $_POST['contact']['Name']);
		    $message->subject('Sale Confirmation');
		});
		//Email for vendor
		$data2 = [
			'greeting' => 'Hello',
			'name' => $product['result']->product->vendor,
			'body' => $_POST['contact']['Name'] . ' wants to buy the item <b>' . $_POST['contact']['Product Name'] . '</b> ',
			'customer_email' => $_POST['contact']['email'],
			'note' => $_POST['contact']['Message']
		];
		$mailer->send('vendor', $data2, function($message)
		{
		    $message->from('bios.apiv3@gmail.com', 'BorrowMe');
		    $message->to($owner_mail, $product['result']->product->vendor);
		    $message->subject('BorrowMe Notification');
		});
	}
	
}
else {
	echo "error";
}

?>