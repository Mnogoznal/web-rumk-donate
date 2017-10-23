<?php

$ip = "mc.wishplay.me"; // IP сервера

$result = file_get_contents("http://mcapi.ca/query/{$ip}/info");

$online = json_decode($result, true)["players"]["online"];

$record = file_get_contents('record.txt');
if($record < $online){ file_put_contents("record.txt", $online); }

$data = array(
	"online" => $online,
	"record" => $record
);

echo json_encode($data);
