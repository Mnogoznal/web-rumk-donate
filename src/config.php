<?php

$config = array (

	'unitpay' => array(
		'id' => '91031', // Цифры публичного ключа до '-'
		'project_id' => '91031-df3a3',
		'key' => 'e7f8b2e978a84daef0c164366dedc66f',
	),

	'message' => array (
		'success' => 'Получилось!',
		'fail' => 'Провал!'
	),

	'group' => array (

		'fly' => array (
			'viewname' => 'Флай - [0] рублей',
			'price' => 5,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'vip' => array (
			'viewname' => 'Вип - [0] рублей',
			'price' => 10,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'premium' => array (
			'viewname' => 'Премиум - [0] рублей',
			'price' => 20,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'creative' => array (
			'viewname' => 'Креатив - [0] рублей',
			'price' => 30,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'elite' => array (
			'viewname' => 'Элита - [0] рублей',
			'price' => 50,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'moder' => array (
			'viewname' => 'Модер - [0] рублей',
			'price' => 90,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'admin' => array (
			'viewname' => 'Админ - [0] рублей',
			'price' => 150,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'stadmin' => array (
			'viewname' => 'Ст.Админ - [0] рублей',
			'price' => 280,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'gladmin' => array (
			'viewname' => 'Гл.Админ - [0] рублей',
			'price' => 470,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'sozdatel' => array (
			'viewname' => 'Создатель - [0] рублей',
			'price' => 950,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'osnova' => array (
			'viewname' => 'Основатель - [0] рублей',
			'price' => 1860,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'vladelets' => array (
			'viewname' => 'Владелец - [0] рублей',
			'price' => 7500,
			'cmd' => 'pex user <user> group set <group>',
			'surcharge' => true
		),
		'case5' => array (
			'viewname' => 'Ключ к кейсу с донатом (5 шт.) - [0] рублей',
			'price' => 20,
			'cmd' => 'dc givekey case1 <user> 5',
			'surcharge' => false
		),
		'case10' => array (
			'viewname' => 'Ключ к кейсу с донатом (10 шт.) - [0] рублей',
			'price' => 35,
			'cmd' => 'dc givekey case1 <user> 10',
			'surcharge' => false
		),
		'case30' => array (
			'viewname' => 'Ключ к кейсу с донатом (30 шт.) - [0] рублей',
			'price' => 100,
			'cmd' => 'dc givekey case1 <user> 30',
			'surcharge' => false
		),
		'case50' => array (
			'viewname' => 'Ключ к кейсу с донатом (50 шт.) - [0] рублей',
			'price' => 200,
			'cmd' => 'dc givekey case1 <user> 50',
			'surcharge' => false
		),
		'case100' => array (
			'viewname' => 'Ключ к кейсу с донатом (100 шт.) - [0] рублей',
			'price' => 320,
			'cmd' => 'dc givekey case1 <user> 100',
			'surcharge' => false
		),
		'money1' => array (
			'viewname' => '50 000 монеток - [0] рублей',
			'price' => 5,
			'cmd' => 'money add <user> 50000',
			'surcharge' => false
		),
		'money2' => array (
			'viewname' => '100 000 монеток - [0] рублей',
			'price' => 10,
			'cmd' => 'money add <user> 100000',
			'surcharge' => false
		),
		'money3' => array (
			'viewname' => '500 000 монеток - [0] рублей',
			'price' => 40,
			'cmd' => 'money add <user> 500000',
			'surcharge' => false
		),
		'money4' => array (
			'viewname' => '1 000 000 монеток - [0] рублей',
			'price' => 70,
			'cmd' => 'money add <user> 1000000',
			'surcharge' => false
		),
		'money5' => array (
			'viewname' => '5 000 000 монеток - [0] рублей',
			'price' => 300,
			'cmd' => 'money add <user> 5000000',
			'surcharge' => false
		),
		'unban' => array (
			'viewname' => 'Разбан - [0] рублей',
			'price' => 20,
			'cmd' => 'unban <user>',
			'surcharge' => false
		),
	),

	'ip_server' => '127.0.0.1',
	'port_server' => '10013',
	'rcon_pass' => 'Kokoshka',

	'db_host' => '127.0.0.1',
	'db_user' => 'root',
	'db_pass' => 'kokok0',
	'db_base' => 'Pex',

);
