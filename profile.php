<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Личный кабинет</title>
	<meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css"><link rel="stylesheet" href="./css/font-awesome.min.css">
    
    <link rel="stylesheet" type="text/css" href="css/materialForm.css">
	
    <script src="./js/jquery-2.1.0.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script src="./js/blocs.min.js"></script>
</head>
<body style="background-color: #ededf0;" onload="<?php  
include("bd.php");
$login = $_SESSION['login'];
$result = $mysqli->query("SELECT * FROM users WHERE login='$login'");
$myrow = mysqli_fetch_array($result);
if ($myrow['tour'] == '0') {
echo "$('#myModal').modal('show')";
$sql = $mysqli->query("UPDATE `users` SET `tour` = '228' WHERE `login` = '$login'");  
}
?>">
<?php include('module/navbar.php'); ?>
<div id="mySidenav" class="sidenav">
	<center><img width="70%" src="img/user.png"></center><br>
	<center><h2 style="color: black"><?php if(empty($_SESSION['login']) or empty($_SESSION['id'])){echo "<script>location.href='index.php'</script>";}else{echo $_SESSION['login'];}?></h2></center>
	<a href="#">Главная</a>
	<a href="#">Статистика</a>
	<a href="#">Боты</a>
	<a href="#">Настройки</a>
</div>	
<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="botForm">
				<div class="contra" style="margin-top: 50px">
				  <div class="card"></div>
				  <div class="card">
				    <h1 class="title">Создай бота</h1>
				    <div class="input-contra">
					    <div class="switch-button"><span class="active"></span>
						  <button class="switch-button-case left active-case" id="zakaz"><p>Заказ товара</p></button>
						  <button class="switch-button-case right">Бронь стола</button>
						</div><br>
				    </div>
				      <div class="input-contra">
				        <input type="#{type}" id="token" required="required"/>
				        <label for="#{label}">ТОКЕН</label>
				        <div class="bar"></div>
				      </div>
				      <div class="input-contra">
				        <input type="text" id="code" required="required"/>
				        <label for="#{label}">Код подтверждения</label>
				        <div class="bar"></div>
				      </div>
				      <div class="input-contra">
				        <input type="text" id="link" required="required"/>
				        <label for="#{label}">Ссылка на группу</label>
				        <div class="bar"></div>
				      </div>
				      <div class="button-contra">
				        <button onclick="create1()"><span>Создать</span></button>
				      </div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" style="margin-top: 5%;" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 700px;">
            <div class="modal-body">
                <div class="row" style="width: 800px;">
                	<div class="tour"><br>
                		<div id="0">
                			<div class="pagex">
                				<h4><b>Перейдите в группу и выберите пункт меню управление сообществом.</b></h4>
                				<img width="750px" src="img/tour0.png">
                			</div>
                		</div>
                		<div id="1" style="display: none;">
							<div class="pagex">
                				<h4><b>Включите сообщения сообщества, по желанию напишите приветствие.</b></h4><img width="750px" src="img/tour1.png">
                			</div>
                		</div>
                		<div id="2" style="display: none;">
							<div class="pagex">
                				<h4><b>Создайте ключ сообщества(токен) и выберите второй пункт меню "Доступ к сообщениям сообщества</b></h4><img width="750px" src="img/tour2.png">
                			</div>
                		</div>
                		<div id="3" style="display: none;">
							<div class="pagex">
                				<h4><b>Код подтверждения находится в настройках Callback API(c3eeeee7)</b></h4><img width="750px" src="img/tour3.png">
                			</div>
                		</div>
                		<div id="4" style="display: none;">
							<div class="pagex">
                				<h4><b>Отметьте входящие и исходящие сообщения во вкладке типы событий</b></h4><img width="750px" src="img/tour4.png">
                			</div>
                		</div>
                		<div id="5" style="display: none;">
							<div class="pagex">
                				<h4><b>Ссылка на сообщество находится в адресной строке.</b></h4><img width="750px" src="img/tour5.png">
                			</div>
                		</div>
                		<button style="margin-bottom: 40px;display: none;" onclick="backTip()" id="backBtn" class="btn btn-lg btn-primary">Назад</button>
                		<button style="margin-bottom: 40px;" onclick="nextTip()" id="nextBtn" class="btn btn-lg btn-warning">Далее</button>
                	</div>
                </div>
                </div>
                </div>
</div>
<script type="text/javascript">
function create1(){
	if($("#zakaz").hasClass("active-case")){
		var botType = 'zakaz';
	}else{
		var botType = 'bron';
	}
	var token = document.getElementById('token').value;
	var code = document.getElementById('code').value;
	var link = document.getElementById('link').value;
	if(token !== '' && code !== '' && link !== ''){
		$.ajax({
		    url: "createBot.php",
		    type: "POST",
		    data: {
		        "botType": botType,
		        "link": link,
		        "token": token,
		        "code": code,
		    },
		})
		.done(function(data, textStatus, jqXHR) {
		    console.log("HTTP Request Succeeded: " + jqXHR.status);
		    console.log(data);
		})
		.fail(function(jqXHR, textStatus, errorThrown) {
		    console.log("HTTP Request Failed");
		})
		.always(function() {
		    /* ... */
		});
	}
}
var t = 0;
function nextTip(){
	document.getElementById('nextBtn').style.marginLeft = '40px';
	t++;
	document.getElementById('backBtn').style.display = 'inline';
	document.getElementById(t).style.display = 'block';
	document.getElementById(t-1).style.display = 'none';
	if(t == 5){
		document.getElementById('nextBtn').innerHTML = 'Закрыть';
		document.getElementById('nextBtn').setAttribute("onClick","$('#myModal').modal('hide')");		
	}
}
function backTip(){
	t--;
	document.getElementById(t+1).style.display = 'none';
	document.getElementById(t).style.display = 'block';
	if(t == 0){
		document.getElementById('backBtn').style.display = 'none';
		document.getElementById('nextBtn').style.marginLeft = '0px';
	}
		document.getElementById('nextBtn').innerHTML = 'Далее';
		document.getElementById('nextBtn').setAttribute("onClick","nextTip()");		
}
'use strict';

var switchButton      = document.querySelector('.switch-button');
var switchBtnRight      = document.querySelector('.switch-button-case.right');
var switchBtnLeft       = document.querySelector('.switch-button-case.left');
var activeSwitch      = document.querySelector('.active');
activeSwitch.style.borderBottomRightRadius		= '0px';
activeSwitch.style.borderTopRightRadius		= '0px';
function switchLeft(){
  switchBtnRight.classList.remove('active-case');
  switchBtnLeft.classList.add('active-case');
  activeSwitch.style.left             = '0%';
  activeSwitch.style.borderTopRightRadius		= '0px';
  activeSwitch.style.borderBottomRightRadius		= '0px';
  activeSwitch.style.borderTopLeftRadius		= '10px';
  activeSwitch.style.borderBottomLeftRadius		= '10px';
}

function switchRight(){
  switchBtnRight.classList.add('active-case');
  switchBtnLeft.classList.remove('active-case');
  activeSwitch.style.left             = '50%';
  activeSwitch.style.borderTopRightRadius		= '10px';
  activeSwitch.style.borderBottomRightRadius		= '10px';
  activeSwitch.style.borderTopLeftRadius		= '0px';
  activeSwitch.style.borderBottomLeftRadius		= '0px';
}

switchBtnLeft.addEventListener('click', function(){
  switchLeft();
}, false);

switchBtnRight.addEventListener('click', function(){
  switchRight();
}, false); 
</script>
</body>
</html>
