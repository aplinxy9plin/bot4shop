<?php 
if (!isset($_REQUEST)) { 
  return; 
} 
$confirmation_token = '092162c6'; 
$token = '163608d580b0289d0720de01f816901b583e09a584a772bc2113f947b280cfa9e0cebb9802e92aeabf331'; 
$data = json_decode(file_get_contents('php://input')); 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса... 
  case 'confirmation': 
    //...отправляем строку для подтверждения 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case 'message_new': 
    $user_id = $data->object->user_id; 
    $body = $data->object->body;
    $message = "";
    $data1 = $data->object->attachments;
    $data2 = json_decode($data1);
    $message = $data2->type;
    $message = $data1;
    $request_params = array( 
      'message' => $message, 
      'user_id' => $user_id, 
      'access_token' => $token, 
      'v' => '5.0' 
    );
$get_params = http_build_query($request_params); 
file_get_contents('https://api.vk.com/method/messages.send?'. $get_params); 
echo('ok'); 
break; 
}