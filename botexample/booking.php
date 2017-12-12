<?php 

if (!isset($_REQUEST)) { 
  return; 
} 

//Строка для подтверждения адреса сервера из настроек Callback API 
$confirmation_token = "07c4c35b"; 

//Ключ доступа сообщества 
$token = "22599e3edd058eb179fa0bb13a9603b7ffb8b0723deb208468aee384397c6be78e5c3879843bdf17ae931"; 

//Получаем и декодируем уведомление 
$data = json_decode(file_get_contents("php://input")); 

//Проверяем, что находится в поле "type" 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса... 
  case "confirmation": 
    //...отправляем строку для подтверждения 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case "message_new": 
    //...получаем id его автора 
    $user_id = $data->object->user_id; 
    // получаем текст сообщения
    $body = $data->object->body;
    //затем с помощью users.get получаем данные об авторе 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 
    //и извлекаем из ответа его имя 
    $user_name = $user_info->response[0]->first_name;
    // Коннектимся к базе
    $mysqli = new mysqli("localhost","id1939899_top4ek","q2w3e4r5","id1939899_top4ek");
    $mysqli->set_charset("utf8");
    // Проверка на наличие в бд пользователя
    $res = $mysqli->query("SELECT `user_id` FROM `orderTable` WHERE user_id = $user_id");
    $count = mysqli_num_rows($res);
    if($count == 0){
      $createUser = $mysqli->query("INSERT INTO `orderTable`(`id`, `user_id`, `username`) VALUES (NULL, '$user_id', '$user_name')");
      $message = "Здравствуйте, что у вас случилось?";
    }
    // Получаем статус и работаем с ним
    //$status = checkStatus($mysqli,$user_id); 
    // Получаем статус и работаем с ним
    $status = checkStatus($mysqli,$user_id);
    switch ($status) {
      case "0":
        $message = "Здравствуйте, хотите забронировать стол?<br>Да - 1<br>Нет - 2";
        $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 1 WHERE `user_id` = $user_id");
        break;
      case "1":
        if($body == "1" or $body == "Да" or $body == "да"){
          $message = "Отлично, напишите время брони.";
          $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 2 WHERE `user_id` = $user_id");
        }elseif ($body == "2" or $body == "Нет" or $body == "нет") {
          $message = "Очень жаль :(<br>Будем ждать вас :)"; 
        }else{
          $message = "Хотите забронировать стол?<br>Да - 1<br>Нет - 2";
        }
        break;
      case "2":
        if($body == "0"){
          $message = "Очень жаль :(<br>Будем ждать вас :)"; 
          $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 0 WHERE `user_id` = $user_id");
        }else{
          $message = "забронировать стол на {$body}?<br>Да - 1<br>Нет - 2";
          $sql = $mysqli->query("UPDATE `orderTable` SET `timeRow` = '$body', `status`= 3 WHERE `user_id` = $user_id");
        }
        break;
      case "3":
        if($body == "1" or $body == "Да" or $body == "да"){
          $message = "Сколько будет человек? Напишите число.<br>Изменить время - 0"; 
          $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 4 WHERE `user_id` = $user_id");
        }else{
          $message = "Напишите время брони.<br>Отменить бронь - 0";
          $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 2 WHERE `user_id` = $user_id");          
        }
        break;
      case "4":
        if(is_numeric($body)){
          if($body == "0"){
            $message = "Напишите время брони.<br>Отменить бронь - 0";
            $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 2 WHERE `user_id` = $user_id");          
          }else{
            $sql = $mysqli->query("UPDATE `orderTable` SET `count` = $body, `status`= 5 WHERE `user_id` = $user_id");
            $row = finalCheck($mysqli,$user_id);
            $message = "Стол в ".$row["timeRow"]." на ".$row["count"]." гостей.<br>Да - 1<br>Нет - 2";
          }
        }else{
          $message = "Напишите корректное число.";
        }
        break;
      case "5":
        if($body == "1" or $body == "Да" or $body == "да"){
          $message = "Спасибо за бронь. Ждем вас :)";
        }elseif ($body == "2" or $body == "Нет" or $body == "нет"){
          $message = "Сколько будет человек? Напишите число.<br>Изменить время - 0"; 
          $sql = $mysqli->query("UPDATE `orderTable` SET `status`= 4 WHERE `user_id` = $user_id");
        }
        break;
      default:
        # code...
        break;
    }
    //$message = checkStatus($mysqli,$user_id);
//С помощью messages.send отправляем ответное сообщение 
    $request_params = array( 
      "message" => $message, 
      "user_id" => $user_id, 
      "access_token" => $token, 
      "v" => "5.0" 
    ); 

$get_params = http_build_query($request_params); 

file_get_contents("https://api.vk.com/method/messages.send?". $get_params); 

//Возвращаем "ok" серверу Callback API 

echo("ok"); 

break; 

} 
// Проверка статуса
function checkStatus($mysqli,$user_id){
  $sql = $mysqli->query("SELECT user_id, status FROM `orderTable`");
  if($sql->num_rows > 0) {
      while($row = $sql->fetch_assoc()) {
        if($row["user_id"] == $user_id){
          return $row["status"];
        }
      }
  }
}
// Здесь функция финальной проверки
function finalCheck($mysqli,$user_id){
  $sql = $mysqli->query("SELECT `user_id`, `username`, `timeRow`, `count` FROM `orderTable`");
  if($sql->num_rows > 0) {
      while($row = $sql->fetch_assoc()) {
        if($row["user_id"] == $user_id){
          return $row;
        }
      }
  }
}