<!--Navbar Start-->
<div class="navbar" style="opacity: 1;">
  <!--Left Link-->
  <!--Logo-->
  <a class="leftx" style="margin-left: 2%; width: 152px; border-radius: 10px" class="navbar-brand" href=""><img width="200px" src="img/logo.png" alt="logo"></a>
  <!--Links-->
  <form id="form" method="POST">
  	<input type="hidden" name="quit" value="123">
    <a onclick="document.getElementById('form').submit();" style="color: black; margin-right: 30px;" class="rightx"><h3 style="display: inline;"><b>Выйти</b></h3></a>  
  </form>
  <?php
	if(isset($_POST['quit'])){
		$_SESSION['login'] = NULL;
		echo "<script>location.href='index.php'</script>";
	}  
  ?>
</div>
<!--End Navbar-->