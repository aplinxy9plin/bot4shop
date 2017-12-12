<?php 

if (!isset($_REQUEST)) { 
  return; 
} 

//Строка для подтверждения адреса сервера из настроек Callback API 
$confirmation_token = '092162c6'; 

//Ключ доступа сообщества 
$token = '163608d580b0289d0720de01f816901b583e09a584a772bc2113f947b280cfa9e0cebb9802e92aeabf331'; 

//Получаем и декодируем уведомление 
$data = json_decode(file_get_contents('php://input')); 

//Проверяем, что находится в поле "type" 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса... 
  case 'confirmation': 
    //...отправляем строку для подтверждения 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case 'message_new': 
    // Время доставки
    $time = "45 минут";
    //...получаем id его автора 
    $user_id = $data->object->user_id; 
    // получаем текст сообщения
    $body = $data->object->body;
    //затем с помощью users.get получаем данные об авторе 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 
    //и извлекаем из ответа его имя 
    $user_name = $user_info->response[0]->first_name; 
    // Получаем название товара, описание и стоимость
    if($data->object->attachments[0]->link->title !== NULL){
      $title = $data->object->attachments[0]->link->title;
      $description = $data->object->attachments[0]->link->description;
      $price = $data->object->attachments[0]->link->product->price->text;
    }
    // Коннектимся к базе
    $mysqli = new mysqli("localhost","id1939899_top4ek","q2w3e4r5","id1939899_top4ek");
    $mysqli->set_charset("utf8");
    // Проверка на наличие в бд пользователя
    $res = $mysqli->query("SELECT `user_id` FROM `asd` WHERE user_id = $user_id");
    $count = mysqli_num_rows($res);
    if($count == 0){
      $createUser = $mysqli->query("INSERT INTO `asd`(`id`, `user_id`) VALUES (NULL,'$user_id')");
    }
    // Получаем статус и работаем с ним
    $status = checkStatus($mysqli,$user_id);
    // Проверка тайтл и дескришн
    if($title == NULL or $description == NULL){
      // Пусты
      switch ($status) {
        case '0':
          $message = "Привет, выбери товар в нашей группе и я помогу тебе заказать его :)";
          break;
        case '1':
          if($body == '0'){
            $message = "Очень жаль, будем ждать вас снова.";
          }else{
            $message = "Ваш адрес: {$body}?<br>Да - 1<br>Нет - 2";
            $sql = $mysqli->query("UPDATE `asd` SET `address` = '$body', `status`= 2 WHERE `user_id` = $user_id");  
          }        
          break;
        case '2':
          if($body == '1' or $body == 'Да' or $body == 'да'){
            $message = "Хорошо, выбери, пожалуйста способ оплаты<br>Наличные - 1<br>Карта - 2";
            $sql = $mysqli->query("UPDATE `asd` SET `status`= 3 WHERE `user_id` = $user_id");          
          }elseif ($body == '2' or $body == 'Нет' or $body == 'нет') {
            $message = "Введи адрес еще раз.<br>Отменить заказ - 0";
            $sql = $mysqli->query("UPDATE `asd` SET `status`= 1 WHERE `user_id` = $user_id");          
          }else{
            $message = "Выбери цифру, пожалуйста.";
          }
          break;
          case '3':
            if($body == '1' or $body == 'наличными' or $body == 'Наличными'){
              $sql = $mysqli->query("UPDATE `asd` SET `pay` = 'наличными', `status`= 4 WHERE `user_id` = $user_id"); 
              $row = finalCheck($mysqli,$user_id);
              $message = "Заказ для {$row['username']} {$row['product']} на адрес: {$row['address']}. Сумма заказа: {$row['price']}, оплата наличными.<br>Да - 1<br>Изменить заказ - 2";         
            }elseif ($body == '2' or $body == 'картой' or $body == 'Картой' or $body == 'карта' or $body == 'Карта') {
              $sql = $mysqli->query("UPDATE `asd` SET `pay` = 'картой', `status`= 4 WHERE `user_id` = $user_id"); 
              $row = finalCheck($mysqli,$user_id);
              $message = "Заказ для {$row['username']} {$row['product']} на адрес: {$row['address']}. Сумма заказа: {$row['price']}, оплата картой.<br>Да - 1<br>Изменить заказ - 2";         
            }else{
              $message = "Выбери цифру, пожалуйста.";
            }            
            break;
          case '4':
            if($body == '1' or $body == 'Да' or $body == 'да'){
              $message = "Спасибо, за заказ. Ожидайте в течение {$time}";
              date_default_timezone_set('Asia/Novosibirsk');
              $today = date("F j, Y, g:i a");
              $sql = $mysqli->query("UPDATE `asd` SET `time` = '$today', `status`= 5 WHERE `user_id` = $user_id"); 
            }elseif ($body == '2' or $body == 'Нет' or $body == 'нет') {
              $message = "Выбери нужный товар в группе.";
              $sql = $mysqli->query("UPDATE `asd` SET `status`= 0 WHERE `user_id` = $user_id");
            }
            break;
          case '5':
            $message = "Ваш заказ уже в пути :)";
            break;
        default:
          # code...
          break;
      }
    }else{
      // Пришел товар
      $message = "Привет, ты выбрал {$title}: {$description}, {$price} Напиши свой адрес доставки.";
      $product = "{$title}: {$description}";
      $sql = $mysqli->query("UPDATE `asd` SET `product` = '$product', `price` = '$price', `status`= 1 WHERE `user_id` = $user_id"); 
    }
//С помощью messages.send отправляем ответное сообщение 
    $request_params = array( 
      'message' => $message, 
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.0' 
    ); 

$get_params = http_build_query($request_params); 

file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 

//Возвращаем "ok" серверу Callback API 

echo('ok'); 

break; 

} 
// Проверка статуса
function checkStatus($mysqli,$user_id){
  $sql = $mysqli->query("SELECT user_id, status FROM `asd`");
  if($sql->num_rows > 0) {
      while($row = $sql->fetch_assoc()) {
        if($row['user_id'] == $user_id){
          return $row['status'];
        }
      }
  }
}
// Здесь функция финальной проверки
function finalCheck($mysqli,$user_id){
  $sql = $mysqli->query("SELECT `user_id`, `username`, `address`, `product`, `price` FROM `asd`");
  if($sql->num_rows > 0) {
      while($row = $sql->fetch_assoc()) {
        if($row['user_id'] == $user_id){
          return $row;
        }
      }
  }
}