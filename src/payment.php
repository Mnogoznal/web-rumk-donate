<?php

$ip = [
	'31.186.100.49',
	'178.132.203.105',
	'52.29.152.23',
	'52.19.56.234'
];

if(!in_array($_SERVER["REMOTE_ADDR"], $ip))
	die('Ко-ко-ко. Иди нахуй!');

include 'config.php';
include 'payment.class.php';

$pay = new payment();

if (isset($_REQUEST['method']) && isset($_REQUEST['params'])) {

	switch (strtolower($_REQUEST['method'])) {

		case "check" :
			echo $pay->up_sign($_REQUEST['method'], $_REQUEST['params']);
			break;

		case "pay" :
			$unit = $pay->up_sign($_REQUEST['method'], $_REQUEST['params'], $msg);

			$edit = json_decode($unit);

			if(isset($edit->error))
				die($unit);
			else
				echo($unit);
			
			$msg = $pay->pay($_REQUEST['params']['sum'], $_REQUEST['params']['account']);
			break;

		default :
			$pay->up_json_reply("Параметры не обнаружены!", $_REQUEST['params']);
			break;

	}

	exit();

}
