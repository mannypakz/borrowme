<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

$host = "127.0.0.1";
$username = "ceypdgthuq";
$password = "WSkCuy2vgp";
$db = "ceypdgthuq";

// $token = htmlspecialchars($_POST['token']);
$token = '2iubKHYaNTxCHQQncvu00oxgVW3lz2fVBERYHsnALdqDmi1WVwM6VvUWUuDzD9QawPNOANgY6h1RhVFegFPWDzLOE8opkIJAZi85';
$con = mysqli_connect($host, $username, $password, $db);
if(!$con) {
	die("Connection failed");
}

$sql = "SELECT * FROM user_sessions WHERE token = '{$token}'";
$res = mysqli_query($con, $sql);

if(mysqli_num_rows($res) > 0) {
	$data = [];
	while($row = mysqli_fetch_assoc($res)) {
		$q = "SELECT * FROM users WHERE id = {$row['user_id']}";
		$r = mysqli_query($con, $q);
		if(mysqli_num_rows($r) > 0) {
			while($d = mysqli_fetch_assoc($r)) {
				// echo json_encode($d);
				$date = date("Y-m-d H:i:s");
				$i = $d['registration_type'] == 'individual' ? $d['profile_image'] : $d['company_logo'];
				$image = file_get_contents('../uploads/' . $i);
				$base64_img = 'data:image/'.pathinfo('../uploads/' . $i, PATHINFO_EXTENSION).';base64,' . base64_encode($image);
				$data = ["profile_image" => $base64_img, "first_name" => $d['first_name'], "last_name" => $d['last_name']];
				echo json_encode($data);

			}
		}
	}
}
else {
	echo json_encode(false);
}
?>