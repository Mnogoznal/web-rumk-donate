<?php 

 include 'config.php';
    
  if(isset($_REQUEST['success']))
    $msg['success'] = 'Вы успешно купили привилегию!';

  if (isset($_REQUEST['error'])) 
    $msg['error'] = 'Вы отказались от оплаты или произошла ошибка!';

  if (isset($_POST['buy'])){

    $name = trim(strip_tags($_POST['username']));
    $group = trim(strip_tags($_POST['group']));

    if(!empty($name)){
      if(!empty($group)){

        include 'payment.class.php';
        $pay = new payment();

        $surcharge = $pay->surcharge($name);
        $price = $config['group'][$group]['price'];

        if($surcharge && $config['group'][$group]['surcharge'])
          $price = intval($price - $surcharge);

        header('Location: '.$pay->pay_form($price, $name, $group));

      } else $msg['error'] = 'Вы не выбрали группу!';
    } else $msg['error'] = 'Укажите ваш никнейм!';
  }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<title>WishPlay - Покупка привилегий</title>
	<meta charset="UTF-8">
	<meta name="author" content="RightClue">
	<meta name="description" content="Авто-донат сайт для Minecraft-сервера WishPlay">
	<meta name="viewport" content="initial-scale=1.0, width=device-width">
	<link rel="icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Raleway:400,700,800&amp;subsetting=all' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,800,700,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="static/jquery.fancybox.min.css">
	<link rel="stylesheet" type="text/css" href="static/style.css">
	<style>
		#banner {padding-top: 90px; padding-bottom: 70px; position: relative;  background: #1a1a1a; background-image: url(static/bg-<?=rand(1, 2)?>.jpg); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-attachment: fixed;}
	</style>
</head>
	<body>
    <div id="banner" class="bg-blur">
		<div id="header">
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Меню</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand text-logo" href="#">WishPlay</a>
					</div>
					<div class="navigation navbar-collapse collapse">
						<ul class="nav navbar-nav menu-right">
							<li><a href="#" data-fancybox data-src="#priv">Возможности привилегий</a></li>
							<li><a href="https://vk.com/topic-77511235_34719179" target="_blank">Отзывы</a></li>
							<li><a href="https://vk.com/topic-77511235_35332069" target="_blank">Правила</a></li>
							<li><a href="#" data-fancybox data-src="#contacts">Контакты</a></li>
							<li><a href="https://vk.com/wishplay" target="_blank" style="margin-right: 20px">Группа ВК</a></li>
							<?php
				              $array = file_get_contents('online.php');
				              $res = json_decode($array);
				              $online = $res['online'];
				              $record = $res['record'];
				            ?>
				            <li><a onclick='prompt("Скопируйте IP и вставьте в Ваш клиент", "mc.wishplay.me")' class="online">Онлайн: <?=$online?></a></li>
				            <li><a onclick='prompt("Скопируйте IP и вставьте в Ваш клиент", "mc.wishplay.me")' class="record">Рекорд: <?=$record?></a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="banner-content">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-5 col-sm-6">
						<div class="banner-form" style="text-align: center;">
							<div class="form-title">
								<h2>Покупка доната</h2>
							</div>
							<div class="form-body">
								<p>Введите ник, выберите привилегию и нажмите "Купить/Доплатить"</p>
					            <?php if ( ! empty ( $msg['error'] ) ) : ?>
					              <div class="alert alert-dismissible alert-danger" style="border-radius: 5px;">
					                <?=$msg['error']?>
					              </div>
					            <?php endif; ?>
					            <?php if ( ! empty ( $msg['success'] ) ) : ?>
					              <div class="alert alert-dismissible alert-success" style="border-radius: 5px;">
					                <?=$msg['success']?>
					              </div>
					            <?php endif;?>
								<form id="banner-form" method="POST">
									<input id="username" name="username" type="text" class="form-control" placeholder="Игровой ник">
									<select id="group" name="group" class="form-control">
							           	<option val='1' disabled selected="">Выберите привилегию</option>
							            <?php foreach ($config['group'] as $al => $value) : ?>
							             	<option value="<?=$al?>"><?=str_replace('[0]', $value['price'], $value['viewname'])?></option>
							          	<?php endforeach; ?>
							        </select>
									<button id="buyBtn" type="submit" name="buy" class="btn btn-default btn-submit">Купить/Доплатить</button>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-md-offset-1" id="text-block">
						<h1><span>Мы</span> сделали покупку легкой для каждого покупателя</h1>
						<p>В сегодняшний век технологий, любой школьник может оплатить себе необходимую для него вещь в интернете. Наш сайт, как и другие, не отстает от данной возможности, и мы предоставляем Вам автоматическую покупку необходимой донат привилегии в онлайн режиме. Специально для этого подключено более 10 видов оплаты, чтобы люди с России, Украины, Беларуси и других стран могли в пару кликов оплатить какую-то необходимую услугу, попробуйте и Вы сделать это, ведь это не так сложно, как кажется!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<section id="how-it-works" class="section bg-blue-pattern white-text">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="headline">
						<h2>Почему лучше играть на WishPlay?</h2>
						<p>Кратко о плюсах нашего сервера.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<ul class="steps-list">
						<li>
							<span>1</span>
							<h4>Стабильность</h4>
							<p>Наши сервера находятся в лучих ДЦ мира, что обеспечивает стабильную работу сервера без лагов, вылетов и с минимальном пингом</p>
						</li>
						<li>
							<span>2</span>
							<h4>Качество</h4>
							<p>Разработкой сервера занимаются опытные администраторы, которые знают свою работу на отлично.</p>
						</li>
						<li>
							<span>3</span>
							<h4>Регулярные обновления</h4>
							<p>Команда проекта трудится не покладая рук, постоянно выпуская обновления, чтобы игра на сервере была интересной и комфортной</p>
						</li>
						<li>
							<span>4</span>
							<h4>Высокий онлайн</h4>
							<p>Мы не скупимся на рекламу, поэтому можем похвастаться нашим онлайном</p>
						</li>
						<li>
							<span>5</span>
							<h4>Дешевый донат</h4>
							<p>Наши цены на донат совсмем низкие, при этом Вы получаете отличные возможности! Только взгляните!</p>
						</li>
					</ul>					
				</div>
				<div class="col-md-7">
					<div class="video-container">
						<iframe width="560" height="315" src="https://www.youtube.com/embed/m2B6TcahwfU" frameborder="0" allowfullscreen></iframe>
					</div>
				</div>	
			</div>
		</div>
	</section>
	<section class="site-footer">
	    <div id="siteFooterTop" class="site-footer-top-section">
	      <div class="container">
	        <div class="site-footer-top-row row">
	          <div class="site-footer-top-col col-sm-8 col-sm-offset-2">
	            <h1 class="section-title">Понравился сервер? Голосуй и получай монетки! <a href="http://minecraftrating.ru/" class="mr-vote-server" data-server-id="31496"><span id="mr-vote-title"><img src="http://minecraftrating.ru/templates/theme/images/logo.png" alt="" /></span><span id="mr-vote-counter"><u></u><i></i></span></a><script type="text/javascript" src="http://minecraftrating.ru/widgets_api/vote/vote_widget.js?v=10"></script></h1>
	            <h1 class="section-title">Не забывайте про нашу группу <a href="http://vk.com/wishplay" target="_blank"><b>ВКонтакте</b></a></h1>
	          </div>
	        </div>
	      </div>
	    </div>

	    <div id="siteFooterBottom" class="site-footer-bottom-section">
	      <div class="container">
	        <div class="site-footer-bottom-border"></div>
	        <div class="row">
	          <div class="site-footer-bottom-left-col col-md-6">

	            <div class="site-footer-bottom-info">
	              <ul>
	                <li><a href="https://vk.com/topic-77511235_35332069" target="_blank">Правила</a></li>
	                <li><a href="#" data-fancybox data-src="#priv">Возможности привилегий</a></li>
	                <li><a href="http://vk.com/right_clue" target="_blank">Разработчик</a></li>
	              </ul>
	            </div>
	          </div>

	          <div class="site-footer-bottom-right-col col-md-6">
	            <div class="site-footer-bottom-copyright">WishPlay © 2017</div>
	          </div>
	        </div>
	      </div>
	    </div>
  	</section>
	<div class="col-md-3 modal" id="priv">
		<h2>Возможности привилегий</h2>
    <br>
    					<style>
								.modal-body p {
									margin-bottom: 0px;
								}
								.service-title {
									margin-top:15px;
									margin-bottom: 15px;
								}
						</style>

				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Флай - 5 рублей</h4>
				            </div>
				            <div class="modal-body">
				             Включить режим полета <b>/fly</b><br>
				             Можно строить столбы, ловушки<br>
                             Префикс [Флай]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Вип - 10 рублей</h4>
				            </div>				            
				            <div class="modal-body">
				             Включить режим полета <b>/fly</b><br>
                             Утоление голода <b>/feed</b><br>
                             Игнорирование игрока (ЧС) <b>ignore</b><br>
                             Возвращение на предыдущую локацию <b>/back</b><br>
                             Запуск фейерверка <b>/fw</b><br>
                             Возможность заходить на полный сервер<br>
							 Размер привата: <b>25 000</b> блоков<br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Вип]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Премиум - 20 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Вылечить себя <b>/heal</b><br>
                             Одевать предметы на голову <b>/hat</b><br>
                             Заблокировать телепертацию к себе/себя <b>/tptoggle</b><br>
                             Виртуальный верстак <b>/workbench</b><br>
                             Множестово точек дома <b>/sethome</b><br>
                             Смена пола <b>/marrygender</b><br>
                             Набор Премиума <b>/kits</b><br>
                             Сохранение <b>вещей и опыта</b> при смерти<br>
							 Размер привата: <b>50 000</b> блоков<br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Премиум]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Креатив - 30 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Включить креатив <b>/gm 1</b><br>
                             Отключить креатив <b>/gm 0</b><br>
                             Очистить инвентарь <b>/ci</b><br>
                             Получить любую голову <b>/skull</b><br>
                             База декоративных блоков <b>/hdb</b><br>
							 Размер привата: <b>75 000</b> блоков<br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Креатив]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Элита - 50 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Открыть виртуальный эндер-сундук <b>/ec</b><br>
                             Включить радужную броню <b>/rainbow</b><br>
                             Выдать себе опыт <b>/exp</b><br>
                             Включить бессмертие <b>/god</b><br>
                             Чинить оружие и броню <b>/fix</b><br>
                             Телепортироваться на верхушку <b>/top</b><br>
                             Супер-прыжок <b>/jump</b><br>
                             Набор Элиты <b>/kits</b><br>
                             Нет <b>задержки</b> в чате<br>
							 Размер привата: <b>100 000</b> блоков<br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Элита]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Модер - 90 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Тепепортироваться к игроку <b>/tp</b><br>
                             Посмотреть игроков поблизости <b>/near</b><br>
                             Включить невидимку <b>/v</b><br>
                             Узнать координаты игрока <b>/getpos</b><br>
                             Телепортироваться на координаты <b>/tppos</b><br>
                             Cоздать варп <b>/setwarp</b><br>
                             Запустить огненный шар <b>/fireball</b><br>
                             Набор Модера <b>/kits</b><br>
							 Размер привата: <b>125 000</b> блоков<br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Модер]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Админ - 150 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Открыть инвентарь игрока <b>/invsee</b><br>
                             Ударить игрока молнией <b>/strike</b><br>
                             Изменить погоду <b>/weather</b><br>
                             Изменить время <b>/time</b><br>
                             Информация о сервере <b>/gc</b><br>
                             Скрытие своего префикса <b>/prefix</b><br>
                             Редактировать книгу <b>/book</b><br>
                             Набор Админа <b>/kits</b><br>  
                             Кол-во приватов: <b>2 штуки</b><br>
							 Размер привата: <b>150 000</b> блоков<br>							 
                             Можно писать <b>КАПСОМ</b> в чате<br>
                             Можно писать <b>цветными буквами</b> в чате<br>
                             Буст монеток <b>1.2х</b><br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Админ]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Ст.Админ - 280 рублей</h4>
				            </div>
				            <div class="modal-body">
                             Сделать объявление всему серверу <b>/ann</b><br>
                             Открыть эндер-сундук игрока <b>/endersee</b><br>
                             Узнать IP-адрес игрока <b>/seen</b><br>
                             Узнать реальное имя игрока <b>/realname</b><br>
                             Дать мут игроку <b>/tempmute</b><br>
                             Снять мут с игрока <b>/unmute</b><br>
                             Снять бан с игрока <b>/unban</b><br>
                             Утолить голод другу <b>/feed</b><br>
                             Вылечить друга <b>/heal</b><br>
                             Зачарование на любые уровни <b>/enchant</b><br>
                             Починка всех инструментов, брони <b>/fix all</b><br>
                             Запрос на тп к себе <b>/tpahere</b><br>
                             Кол-во приватов: <b>3 штуки</b><br>
							 Размер привата: <b>175 000</b> блоков<br>
                             Возможность использовать <b>ЧИТЫ</b><br>
                             Буст монеток <b>1.4х</b><br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Ст.Админ]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Гл.Админ - 470 рублей</h4>
				            </div>
				            <div class="modal-body">
							 Создать клан <b>/clan</b><br>
                             Кикнуть игрока <b>/kick</b></br>
                             Забанить игрока <b>/tempban</b><br>
                             Узнать всю информацию о игроке <b>/whois</b><br>
                             Заполнить выделенную область блоками <b>//set</b><br>
                             Узнать ID предмета <b>/dura</b><br>
                             Отменить действие в редакторе мира <b>//undo</b><br>
                             Повторить действие в редакторе мира <b>//redo</b><br>
                             Выдать опыт Другу <b>/exp</b><br>
                             Поджечь игрока <b>/burn</b><br>
                             Изменить ник в чате <b>/nick</b><br>
                             Превратить предметы в блоки <b>/compact</b><br>
                             Кол-во приватов: <b>4 штуки</b><br>
							 Размер привата: <b>200 000</b> блоков<br>
                             Вечный <b>иммунитет</b> от бана/кика/мута<br>
                             Буст монеток <b>1.6х</b><br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Гл.Админ]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Создатель - 950 рублей</h4>
				            </div>
				            <div class="modal-body">
				             80% всех команд сервера<br>
                             Заменить в области блоки <b>//replace</b><br>
                             Создать стены <b>//walls</b><br>
                             Телепортировать игрока к себе <b>/tphere</b><br>
                             Включить флай другу <b>/fly</b><br>
                             Стрельнуть котятами <b>/kittycannon</b><br>
                             Включить отталкивание <b>/kb</b><br>
                             Полный доступ к флагам <b>/rg flag</b><br>
                             Информация о регионе <b>/rg info</b><br>
                             Кол-во приватов: <b>5 штук</b><br>
							 Размер привата: <b>500 000</b> блоков<br>
                             Можно общаться с <b>владельцами</b> сервера напрямую<br>
                             По запросу мы можем <b>бесплатно</b> изменить префикс<br>
                             Увеличен лимит <b>WorldEdit</b> в 2 раза<br>
                             Буст монеток <b>1.8х</b><br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Создатель]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Основатель - 1860 рублей</h4>
				            </div>
				            <div class="modal-body">
				             90% всех команд сервера<br>
                             Убить игрока <b>/kill</b><br>
                             Читать чужие сообщения <b>/socialspy</b><br>
                             Обход запрета телепортации <b>/tpo</b><br>
                             Создать пирамиду <b>//sphere</b>, <b>//hsphere</b><br>
                             Убрать воду/лаву в радиусе <b>//drain</b><br>
                             70% на доступ к <b>Essentials</b><br>
                             Доступ к <b>админ-панели</b><br>
                             Неограниченный </b>приват</b>(10 шт. по 1 млн. блоков)<br>
                             Владелец сервера <b>добавит</b> Вас <b>в друзья</b> в ВК</b><br>
                             Буст монеток <b>2.0х</b><br>
                             + Возможности всех предыдущих групп<br>
                             Префикс [Основатель]
				            </div>
				            
				            <div class="modal-header" style="    height: 30px;">
				                <h4 class="service-title" style="margin-top: -13px;">Владелец - 7500 рублей</h4>
				            </div>
				            <div class="modal-body">
				             99% всех команд сервера<br>
                             Вам доступны ко <b>ВСЕ</b> команды сервера<br>
                             С Вас сняты <b>ВСЕ</b> задержки на команды<br>
                             У Вас нет <b>НИКАКИХ</b> лимитов и ограниченый<br>
                             Вы имеете доступ ко <b>ВСЕМ</b> приватам<br>
                             - и еще много других возможностей...<br>
                             Префикс [Владелец]
	</div>
	<div class="col-md-3 modal" id="contacts">
		<h2>Контакты</h2>
		<a href="https://vk.com/im?sel=-77511235">Техническая поддержка</a><br>
		<a href="https://vk.com/egor.chernous">Администратор ВКонтакте</a><br>
		<a href="mailto:wishplaysp@yandex.ru">wishplaysp@yandex.ru</a><br>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="static/jquery.fancybox.min.js"></script>
	<script type="text/javascript">
		
		$(window).scroll(function(){	
			"use strict";	
			var scroll = $(window).scrollTop();
			if( scroll > 60 ){		
				$(".navbar").addClass("scroll-fixed-navbar");				
			} else {
				$(".navbar").removeClass("scroll-fixed-navbar");
			}
		});

		function show() {
			$.ajax({
				url: 'online.php',
				type: 'POST',
				async: !0,
                cache: !1,
				error: function() {
					$('.online').html('Онлайн: E1');
					$('.record').html('Рекорд: E1');
				},
				success: function(data) {
					res = JSON.parse(data);
					$('.online').html('Онлайн: ' + res.online);
					$('.record').html('Рекорд: ' + res.record);
				}
			});
		};

		$(document).ready(function() {

			show();
			setInterval(show, 3000);

			$('#username').on('input', function() {
				$("#buyBtn").attr("disabled", 1);
		        $("#buyBtn").html('Загрузка....');
				recount();
			});
			$('#group').change(function() {
				$("#buyBtn").attr("disabled", 1);
		        $("#buyBtn").html('Загрузка....');
				recount();
			});

			function recount() {
				username = $("#username").val();
				group = $("#group").val();
				dt = "username=" + username + "&group=" + group;
				setTimeout(function() {
					$.ajax({
						url: 'count.php',
						type: 'POST',
						data: dt,
						async: !0,
	                	cache: !1,
						error: function() {
							$("#buyBtn").html('Ошибка. Обновите страницу');
						},
						success: function(data) {
							res = JSON.parse(data);
							if (res.status == "success") {
								$("#buyBtn").removeAttr("disabled");
								if (res.sur == "yes")
									$('#buyBtn').html("Доплатить " + res.msg + " руб.");
								else
									$("#buyBtn").html("Купить за " + res.msg + " руб.");
							} else {
								$("#buyBtn").html(res.msg);
							}
						}
					});
				}, 1e3);
			};
		});
	</script>
</body>
</html>
