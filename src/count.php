<?php
	
	include 'config.php';

	if (isset($_POST['username']) && isset($_POST['group'])) {
		if ((empty($_POST['username'])) or ($_POST['username'] == "null")) {
			$msg = "Введите никнейм";
			echoData("error", $msg); 
		} else if ((is_null($_POST['group'])) or ($_POST['group'] == 1) or ($_POST['group'] == "null")) {
			$msg = "Выберите группу";
			echoData("error", $msg); 
		} else {

		$name = $_POST['username'];
		$group = $_POST['group'];

		$sur = "no";

		$surcharge = surcharge($name);
		$price = $config['group'][$group]['price'];

		if($surcharge && $config['group'][$group]['surcharge'])
		    $price = intval($price - $surcharge);
		}

		if ($surcharge && $config['group'][$group]['surcharge'])
			$sur = "yes";

		if ($price > 0) {
			echoData("success", $price, $sur);
		} else {
			echoData("error", "Выберите привилегию выше");
		}
	} else {
		header('Location: /');
	}

	function echoData($status, $msg, $sur = "no") {
		$result = array (
			"status" => $status,
			"msg" => $msg,
			"sur" => $sur
		); 	
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
		die();
	}

	function surcharge($name) {

		include 'config.php';

		$db = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_base']);
 
        $uuid = $db->query("SELECT `name` FROM `permissions` WHERE `value` = '".trim(strip_tags($name))."' AND `type` = '1'")->fetch_object();
        $group = $db->query("SELECT * FROM `permissions_inheritance` WHERE `child` = '".$uuid->name."' ORDER BY `id` DESC LIMIT 1")->fetch_object();
 
        if(!$group)
            return false;

        return $config['group'][$group->parent]['price'];

	}
?>
