<?php
  if(isset($_POST["submitted"]) && $_POST["submitted"])
  {
    $username = trim($_POST["email"]);
    $password = trim($_POST["pswd"]);

    if(strlen($username) > 0 && strlen($password) > 0)
    {
      $db = new mysqli("localhost","kpp190","P@t2001K@ush","kpp190");
      if($db->connect_error)
      {
        die ("Connection failed: " . $db->connect_error);
      }

      $q = "SELECT user_id, avatar, screenName, email FROM Users WHERE email = '$username' AND password = '$password';";
      $result = $db->query($q);

      if($row = $result->fetch_assoc())
      {
        // login successful
        session_start();
				$_SESSION["user_id"] = $row["user_id"];
        $_SESSION["avatar"] = $row["avatar"];
        $_SESSION["screenName"] = $row["screenName"];
          
          header("Location: noteList1.php");
          $db->close();
				  exit();
      }
      else 
      {
        // login unsuccessful
				$error = ("The username/password combination was incorrect.");
				$db->close();
      }

    }
    else 
    {
      $error = ("You must enter a non-blank username/password combination to login.");
    }


  }
  else 
  {
    $error = "";
  }




?>





<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Login Page</title>
  <script src="https://kit.fontawesome.com/fbe599c56d.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="assi-3.css" />
	<!--<script type="text/javascript" src="j-13.js"> </script>-->
  

</head>

<body class="container">

  <div class="title">
    <p><i class="far fa-clipboard fa-5x">Notes</i></p>
    <p class="err php"><?=$error?></p>
  </div>

  <div class="loginbox">
    <!--<img src="http://www.webdev.cs.uregina.ca/~kpp190/cs215A-1/av.png#" alt="Notes" class="av"/>-->
    <h1 class="textColour">Login Here</h1>

	
	  <form id="formValidation" method="post" action="login1.php">				
		<input type="hidden" name="submitted" value="1"/>   	
			<p class="textColour">Email</p>
			<p><input type="text" id="email" name="email" placeholder="username@uregina.ca"/></p>
      <p><label id="msg_email" class="err_msg"></label></p>
      <p><br/></p>
      

      <p><br/></p>
      <p class="textColour">Password</p>
      <p><input type="password" id="pswd" name="pswd" placeholder="Enter your password" /></p>
      <p><label id="msg_pswd" class="err_msg"></label></p>
      <p><br/></p>
      
      <p><br/></p>
		  <p><button type="submit">Login</button></p>
      <p><br/><br/></p>
		  <p><button type="reset">Reset</button></p>
      <p><br/></p>

	  </form>

	  <script type="text/javascript" src="a2.js"></script>

	  <div id="display_info"></div>

	  <p><br/></p>

	  <p class="textColour"> Don't have an account?<a href="signup1.php">Sign Up</a></p>

  </div>


</body>

</html>
