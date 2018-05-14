<?php 
/*
	WebHook - принимает запросы БОТа, формирует ответ и передаёт обратно Telegram, после чего Telegram отдаёт ответ пользователю. Делается это с помощью команды curl в терминале
	Method 
		$WebHook->Set($url);
		
		Активировать WebHook  по ссылке 
		https://api.telegram.org/bot569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw/setwebhook   		Удалить 
		Обязателен SSL сертификат. Проверьте тут https://www.ssllabs.com/ssltest/   Если выдаёт рейтинг ниже А может не функционировать 
	
	Помогли
		https://www.youtube.com/watch?v=_L6nFhFkzLo
	
	
	
	Url https://lukoshko.online/bot/telegram/secret-webhooks/AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA
*/	
	// @lukoshko 571351365:AAHsz4WrQzBtbay6Zc1CxBZpEGVKculM65w
	// @ProheNetBot
	$botToken = "569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw";	https://github.com/SergeySviridov/php.git
	$chatId=268436752;	//  HomePC 
	$chatId=422981923;	//	$Doogee
	
	$text='Тестовое сообщение';

	// Начать чат 
	// Извлечь ID чата со мной  https://api.telegram.org/bot569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw/getUpdates		//  
	
//	echo file_get_contents('https://api.telegram.org/bot'.$botToken.'/getUpdates');

/*
$token = $botToken;
$bot = new \TelegramBot\Api\Client($token);
// команда для start
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// команда для помощи
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - вывод справки';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->run();
exit;
*/

	Class WebHook{
		private $Token='569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw';
		public function Activity($x){
			if(isset($_SERVER['HTTP_REFERER'])){													// Рефералы 
				$urlRef=$_SERVER['HTTP_REFERER']; 													// Откуда запрос ?
				$_SESSION['urlRef']=$urlRef; 														// Сохранить в сессию, может понадобится :)
				$ipRef = $_SERVER['REMOTE_ADDR']; 													// ip запроса
				file_put_contents(SERVER.'/Message/Telegram/dao.tel', $_SERVER['HTTP_REFERER'] );
			}
			
		}
		
		public function Set(){
			$url='https://api.telegram.org/bot569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw/setwebhook?url=https://lukoshko.online/bot/telegram/secret-webhooks/AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA';
			header('location:'.$url);
		}
		
		public function RegCertificate(){
			
			function regHandler($cert, $token, $murl){
				$url = "https://api.telegram.org/bot" . $token . "/setWebhook";
				$ch = curl_init();
				$optArray = array(
					CURLOPT_URL => $url,
					CURLOPT_POST => true,
					CURLOPT_SAFE_UPLOAD => false,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POSTFIELDS => array('url' => $murl, 'certificate' => '@' . realpath($cert))
				);
				curl_setopt_array($ch, $optArray);

				$result = curl_exec($ch);
				echo "<pre>";
				print_r($result);
				echo "</pre>";
				curl_close($ch);
			}
			 
			$token = $this->Token;
			$path = '/lukoshko.pem';
			$handlerurl = 'https://lukoshko.online/bot/telegram/secret-webhooks/AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA'; // ИЗМЕНИТЕ ССЫЛКУ
			regHandler($path, $token, $handlerurl);
		}	
		
		
		
 
	}
	$WebHook=new WebHook;
//	$WebHook->Activity($x);
//	$WebHook->RegCertificate();
	$WebHook->Set();
	exit;
// Способ-1  GET параметрами 
	$param=array(
		'chat_id'=> $chatId,
		'text'=> $text
	);
	$url='https://api.telegram.org/bot'.$botToken.'/sendMessage?'.http_build_query($param);
	file_get_contents($url);
	

// Способ-2  Curl 
	$Peremenaya='https://api.telegram.org/bot'.$botToken.'/sendMessage?disable_web_page_preview=true&chat_id='.$chatId.'&text=Нам написали тикет скорее отвечайте';
	$ch = curl_init();								// создание нового ресурса cURL
	curl_setopt($ch, CURLOPT_URL, "$Peremenaya");	// установка URL и других необходимых параметров
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);	// а это что бы на страницу не выводилось
	curl_setopt($ch, CURLOPT_HEADER, 0);			// это в справочнике прочтете
	curl_exec($ch);									// загрузка страницы и выдача её браузеру другими словами при открытии страницы где вы этот скрипт сделаете автоматически отправится сообщение в заданный вами телеграм чат.
	curl_close($ch);								// завершение сеанса и освобождение ресурсов
	exit;

/*
	set_time_limit(0);

    // Установка токена
    $botToken = "569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw";
    $website = "https://api.telegram.org/bot".$botToken;

    // Получаем запрос от Telegram 
    $content = file_get_contents("php://input");
    $update = json_decode($content, TRUE);
    $message = $update["message"];

    // Получаем внутренний номер чата Telegram и команду, введённую пользователем в   чате 
    $chatId = $message["chat"]["id"];
    $text = $message["text"];

    // Пример обработки команды /start
    if ($text == '/start') {
        $welcomemessage = 'Welcome!!! Check IP/Email for spam giving "check IP/Email" command';
        file_get_contents($website."/sendmessage?chat_id=".$chatId."&text=".$welcomemessage);    	 // Отправляем сформированное сообщение обратно в Telegram пользователю   
    } 
	
/*
	Class WebHook{
		private $Token='569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw';
		public function Activity($x){
			file_put_contents(SERVER.'/Message/Telegram/dao.tel', '*' );
		}
		
		public function Set($x){
			$url='https://api.telegram.org/bot569418321:AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA-Rw/setwebhook?url=https://lukoshko.online/bot/telegram/secret-webhooks/AAHUpVyk0Gex6myrTDqjpXKuTtGMrWfA';
			header('location:'.$url);
		}
	}
	$WebHook=new WebHook;
	$WebHook->Activity($x);
	

	$data = json_decode(file_get_contents('php://input')); 
	$data->{'message'}->{'text'}; // вернет текст сообщения боту
	$data->{'message'}->{'chat'}->{'id'}; // вернет ID отправителя
*/		

	// 	curl -d "url=https://example.com/telegramwaiter.php" https://api.telegram.org/botYOUR_T
