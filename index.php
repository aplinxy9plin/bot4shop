<?php session_start(); ?>
<!doctype html>
<html>
<head>
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
    <title>BOT4SHOP</title>

    
<!-- Google Analytics -->
 
<!-- Google Analytics END -->
    
</head>
<body>
<center><div id="snackbar">Hello World!</div></center>
<!--Navbar Start-->
<div class="navbar">
  <!--Left Link-->
  <!--Logo-->
  <a class="left" style="margin-left: 5%; width: 152px; border-radius: 10px" class="navbar-brand" href=""><img width="200px" src="img/logo.png" alt="logo"></a>
  <!--Links-->
    
    <a href="#" style="color: black" class="rightx"><h3 style="display: inline;"><b>Контакты</b></h3></a>  
    <a onclick="dialog()" style="color: black" class="rightx"><h3 style="display: inline;"><b>О нас</b></h3></a>
    <a onclick="<?php
	    // Проверяем, пусты ли переменные логина и id пользователя
	    if (empty($_SESSION['login']) or empty($_SESSION['id']))
	    {
	    // Если пусты, то мы не выводим ссылку
	    echo "$('#myModal').modal('show');$('.contra').stop().removeClass('active');";
	    }
	    else
	    {
	    echo "window.location.href='profile.php'";
	    }
    ?>" style="color: black" class="rightx"><h3 style="display: inline;"><b><?php
	    // Проверяем, пусты ли переменные логина и id пользователя
	    if (empty($_SESSION['login']) or empty($_SESSION['id']))
	    {
	    // Если пусты, то мы не выводим ссылку
	    echo "Вход";
	    }
	    else
	    {
	    echo "Личный кабинет";
	    }
    ?></b></h3></a>
</div>
<!--End Navbar-->
<!-- Main container -->
<div class="page-container">

<!-- bloc-0 -->
<div class="bloc bloc-fill-screen bgc-white l-bloc " id="bloc-0">

	<div class="video-bg-container">
		<img src="img/yellow.png">
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<h2 class="mg-md" style="color: black; /*text-shadow: white 1px 1px 0, white -1px -1px 0, 
                 white -1px 1px 0, white 1px -1px 0;*/ font-size: 4.4em">
					<b>СОЗДАЙ БОТА</b>
				</h2>
				<h3 class="text-left mg-lg mount-italy-hero-text-sub-s tc-black">
					<b>С нами это просто</b>
				</h3><a onclick="$('#myModal').modal('show');$('.contra').stop().addClass('active');" class="btn btn-wire btn-rd btn-xl" style="color: black">Зарегистрироваться</a>
			</div>
			<div class="col-sm-7">
				<div class="center-block blocsapp-device blocsapp-device-mb blocsapp-device-mbp">
					<img src="img/gif.gif" class="img-responsive" />
				</div>
			</div>
		</div>
	</div>
	<div class="container fill-bloc-bottom-edge">
		<div class="row">
			<div class="col-sm-12">
				<a id="scroll-hero" class="blocs-hero-btn-dwn" href="#"><span class="fa fa-chevron-down"></span></a>
			</div>
		</div>
	</div>
</div>
</div>
<!-- bloc-0 END -->

<!-- bloc-1 -->
<div class="bloc bloc-fill-screen bgc-white l-bloc " id="bloc-1">
	<div class="video-bg-container">
		<img src="img/yellow.png">
	</div>
	<div class="container">
		<div class="row">
			<h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</h4>
		</div>
	</div>
</div>
<!-- bloc-1 END -->

<!-- ScrollToTop Button -->
<a class="bloc-button btn btn-d scrollToTop" onclick="scrollToTarget('1')"><span class="fa fa-chevron-up"></span></a>
<!-- ScrollToTop Button END-->

<!-- Main container END -->


<div class="modal fade" style="margin-top: 5%;" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 300px;">
            <div class="modal-body">
                <div class="row" style="width: 500px">
<div class="contra" style="right: 15%">
  <div class="card"></div>
  <div class="card">
    <h1 class="title">Вход</h1>
      <div class="input-contra">
        <input type="#{type}" id="login" required="required"/>
        <label for="#{label}">Логин</label>
        <div class="bar"></div>
      </div>
      <div class="input-contra">
        <input type="password" id="password" required="required"/>
        <label for="#{label}">Пароль</label>
        <div class="bar"></div>
      </div>
      <div class="button-contra">
        <button onclick="login()"><span>Вход</span></button>
      </div>
      <div class="footer"><a href="#">Забыли пароль?</a></div>
  </div>
  <div class="card alt">
    <div class="toggle"></div>
    <h1 class="title">Регистрация
      <div class="close"></div>
    </h1>
      <div class="input-contra">
        <input type="#{type}" id="loginReg" required="required"/>
        <label for="#{label}">Логин</label>
        <div class="bar"></div>
      </div>
      <div class="input-contra">
        <input type="password" id="passwordReg" required="required"/>
        <label for="#{label}">Пароль</label>
        <div class="bar"></div>
      </div>
      <div class="input-contra">
        <input type="password" id="repeatPasswordReg" required="required"/>
        <label for="#{label}">Подтверждение пароля</label>
        <div class="bar"></div>
      </div>
      <div class="button-contra">
        <button onclick="loginCheck()"><span>Зарегистрироваться</span></button>
      </div>
  </div>
</div>
<script type="text/javascript">
$('.toggle').on('click', function() {
  $('.contra').stop().addClass('active');
});

$('.close').on('click', function() {
  $('.contra').stop().removeClass('active');
});
function dialog() {
    var x = document.getElementById("snackbar")

    x.className = "show";

    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
function loginCheck(){
	var login = document.getElementById('loginReg').value;
	var password = document.getElementById('passwordReg').value;
	var password1 = document.getElementById('repeatPasswordReg').value;
	if(password !== password1){
		document.getElementById('snackbar').innerHTML = 'Пароли не совпадают!';
    	dialog();	
    }else{
		if(login !== "" && password !== "" && password1 !== ""){
				$.ajax({
				    url: "reg.php",
				    type: "POST",
				    data: {
				        "login": login,
				        "password": password,
				    },	
				})
				.done(function(data, textStatus, jqXHR) {
				    console.log("HTTP Request Succeeded: " + jqXHR.status);
				    //alert(data);
					$('#myModal').modal('hide');
					//document.getElementByID("snackbar").innerHTML="<p>уже давно не бла бла бла</p>";
				    console.log(data);
				    document.getElementById('snackbar').innerHTML = data;
    				dialog();
				})
				.fail(function(jqXHR, textStatus, errorThrown) {
				    console.log("HTTP Request Failed");
				})
				.always(function() {
				    /* ... */
				});
		}
	}	
}
</script>
<script type="text/javascript">
	function login(){
		var login = document.getElementById('login').value;
		var password = document.getElementById('password').value;
			if(login !== "" && password !== ""){
					$.ajax({
					    url: "loginCheck.php",
					    type: "POST",
					    data: {
					        "login": login,
					        "password": password,
					    },
					})
					.done(function(data, textStatus, jqXHR) {
					    console.log("HTTP Request Succeeded: " + jqXHR.status);
					    //alert(data);
						$('#myModal').modal('hide');
						//document.getElementByID("snackbar").innerHTML="<p>уже давно не бла бла бла</p>";
					    console.log(data);
					    if(data == 'ok'){
					    	document.getElementById('snackbar').innerHTML = 'Перенаправление...';
	    					window.location.href = "profile.php";
					    }else{
					    	document.getElementById('snackbar').innerHTML = data;
					    }
	    				dialog();
					})
					.fail(function(jqXHR, textStatus, errorThrown) {
					    console.log("HTTP Request Failed");
					})
					.always(function() {
					    /* ... */
					});
			}
	}
</script>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
