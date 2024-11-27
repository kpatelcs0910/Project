<?php
    session_start();
	if (!isset($_SESSION["user_id"])) {
		header("Location: login1.php");
		exit();
	} else {
    //Here after creation of note I will give all the users role  to "none". except the owner.
		$user_id = $_SESSION["user_id"];//I am getting user_id, screenName, avatar from login page
    $screenName = $_SESSION["screenName"];
    $avatar = $_SESSION["avatar"];
    $error="";
    $r7="";

    if(isset($_POST["submitted"]) && $_POST["submitted"])
    {
      $title = trim($_POST["note"]);

      if(strlen($title)>0)
      {
        // load the database and get the orders for this user
		    $db = new mysqli("localhost","kpp190","P@t2001K@ush","kpp190");
        if ($db->connect_error) 
        {
          die ("Connection failed: " . $db->connect_error);
        }
        
        $q = "INSERT INTO Notes(title, created_dt, last_edit_dt) VALUES('$title',NOW(),NOW());";

        $r1 = $db->query($q);
        $note_id = mysqli_insert_id($db);
        $owner = "owner";
        $none="none";

        
        

        /*$q2 = "SELECT MAX(note_id) as m_note_id FROM Notes;";
        //$r2 = $db->query($q3);
         if($r2 == true)
         {
          
            if($row = $r2->fetch_assoc())
            {
              $note_id = $row["m_note_id"];
            }
          }
          //print($note_id);
          
        */
        
        

        if($r1 == true)
        { 
          //Inserting current user role to "owner" to this particular note 
          $q2 = "INSERT INTO Roles(note_id,user_id,role) VALUES('$note_id','$user_id','$owner');";       
          $r2 = $db->query($q2);
          if($r2 == true)
          {

            $q6="SELECT user_id FROM Users WHERE user_id != '$user_id';";
            $r6=$db->query($q6);//get the user_id of all the users except the owner of the note.
           while($row6=$r6->fetch_assoc())
           {
            //Here after creation of note I will give all the users role  to "none". except the owner.
              $u_id=$row6["user_id"];
              $q7="INSERT INTO Roles(note_id,user_id,role) VALUES($note_id,$u_id,'none');";
            
              $r7=$db->query($q7);
           }

            header("Location: noteList1.php?note_id=$note_id");
            $db->close();
            exit();
          }
          else 
          {
            $error = ("error in querry2");
          } 
          
          
        }
        else {
          $error = ("error in querry");
        }
        


      }
      else {
        $error = ("One or more input fields are empty");
      }
    }


      
		
		    
        
	}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Create Note Page</title>
  <script src="https://kit.fontawesome.com/fbe599c56d.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="assi-3.css"/>
  <script type="text/javascript" src="a2.js"></script>
</head> 

  <body class="container">
    
    <div class="title">
        <div class="titlebar">
            <p><a class ="Back" href="noteList1.php">&#x3c;Back</a></p>
            <p class="profilePicture">Logged in as: <?=$screenName?>   <img src =<?=$avatar?> class="ava"/><p><a href="logout.php">logout</a></p></p>         
            
            <div class="addtitle"> </div>
                         
            <p class="add"><a href="#">Edit</a></p>            
        </div>
        <p class="err php"><?=$error?></p>
      
    
   
    
      <div class="bottom">
     
        
          <form id="formValidation" class="formValidation1" method ="post" action="createNote1.php">
            
          <input type="text" id="note" name="note" class="counter1" placeholder="Add the Title"/>
          <input type="hidden" name="submitted" value="1"/>
           <p><label id="msg_noteName" class="err_msg"></label></p></span><span id="totalChars">Total Number of Characters for title: 0</span><span id="remainingChars">Remaining Characters for title: 256 </span>

            <p><button type="submit">Submit</button></p>
        
        
            <p><button type="reset">Clear All</button></p>
            </form>
      </div>

        
        <script type="text/javascript" src="anote.js"></script>
      

	    <div id="display_info"></div>

    </div>     
    
</body>

 
</html>