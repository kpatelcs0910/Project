<?php
    session_start();
	if (!isset($_SESSION["user_id"])) {
		header("Location: login1.php");
		exit();
	} 
    else 
    {
        //I have already given role to each user except the owner to "none". And this is done when the user is creating the note. So in the create note page.
        $user_id = $_SESSION["user_id"];//I am getting user_id, screenName, avatar from login page
        $screenName = $_SESSION["screenName"];
        $avatar = $_SESSION["avatar"];
        $note_id = $_GET["note_id"];//Here I am taking note_id and role_id from the Note list page in the URL through get method.
        $role_id = $_GET["role_id"];
        $error="";

        $db = new mysqli("localhost", "kpp190", "P@t2001K@ush", "kpp190");
        if ($db->connect_error) 
        {            
          die ("Connection failed: " . $db->connect_error);
        }

        if(isset($_POST["sub"])){//So if the submit button is entered then and then only roles will be updated to the selected users.

            if(isset($_POST["submitted"]) && $_POST["submitted"])//if the input hidden type is 1 that means the same if the form is submitted then it will update the roles.
            {
                //Here I am updating the role of the user that has none to contributor.
                if(isset($_POST["access"])){
                    $access=$_POST["access"];
                    foreach ($access as $ua_id) {
                        //echo $ua_id;
                        $a="UPDATE Roles SET role='contributor' WHERE user_id='$ua_id' AND note_id = '$note_id';";            
                        $a1=$db->query($a);
                        
                        $u="UPDATE Notes SET last_edit_dt = NOW() WHERE note_id = '$note_id';";            
                        $u1=$db->query($u);
                        if($u1 == true)
                        {

                        }
                        else
                        {
                            $error=("Query Update date is not working");
                        }
                      
                       
                    }
                }
                //Here I am updating the role of the user that has contributor to none means revoking the role.
                if(isset($_POST["revoke"])){
                    $revoke=$_POST["revoke"];
                
                    foreach ($revoke as $ur_id) {
                        //echo $ur_id;

                        $re="UPDATE Roles SET role='none' WHERE user_id='$ur_id' AND note_id = '$note_id';";
            
                        $re1=$db->query($re);
                    }
                }
                
                //And if the user hasn't selected any checkbox and press the button then this error will be poped up.
                if(!isset($_POST["revoke"]) && !isset($_POST["access"])){
                    $error=("Pleaase Select atleast one checkbox");
                }
                


            }
            else {
                $error="";
            }
        }



        if(isset($note_id))
        {   //Just taking the basic note information of this particular note.
            $q = "SELECT title, created_dt FROM Notes WHERE note_id = '$note_id';";
            $r = $db->query($q);
            $row = $r->fetch_assoc();
        }

        //So here I am fetching users that has only "none" in the role
        $q2 = " SELECT Users.screenName, Users.user_id ,Users.avatar ,Roles.role 
                FROM Roles LEFT JOIN Notes ON(Roles.note_id = Notes.note_id) 
                LEFT JOIN Users ON (Roles.user_id = Users.user_id) 
                WHERE Notes.note_id = '$note_id' AND Roles.role = 'none';";
        $r2=$db->query($q2);
        //So here I am fetching users that has only "contributor" in the role
        $c3 = " SELECT Users.screenName, Users.user_id ,Users.avatar ,Roles.role 
                FROM Roles LEFT JOIN Notes ON(Roles.note_id = Notes.note_id) 
                LEFT JOIN Users ON (Roles.user_id = Users.user_id) 
                WHERE Notes.note_id = '$note_id' AND Roles.role = 'contributor';";
        $cr3=$db->query($c3);
        /*
        --> What I am basically doing is dynamically print the user seperate that has "contributor" role and "none" role. 
        So that I can easily change role from "none" to "contributor" and vice versa by storing same role type users in same array. So I need
        to store the values of checkboxes in two variables.
        */
       if($cr3==true)
       {
           //echo "true";
       }
       else {
           $error =("Something wrong ");
       }

        
    }
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Grant/Revoke Access Page</title>
  <script src="https://kit.fontawesome.com/fbe599c56d.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="assi-3.css"/>
</head> 
  <body class="container">
    <div class="title">
        <div class="titlebar">
            <p><a class ="Back" href="noteList1.php">&#x3c;Back</a></p> 
            <p class="profilePicture">Logged in as: <?=$screenName?>   <img src =<?=$avatar?> class="ava"/><p><a href="logout.php">logout</a></p></p> 
            <p class="notetitle">Note Title : <?=$row["title"]?></p>
            <p class ="date1">Created on Date/Time: <?=$row["created_dt"]?></p>                    
            <p class="slectall"><a href="#">Select All</a></p>            
        </div>
    </div>


    <div class="contain2">
    <p class="err php"><?=$error?></p>
                <div class="container2">
                    <div class="no">Give Access to the following users  listed below (if any):</div>                   
                    <div class="title1">Please select checkbox to give the role to the given user:</div>
                    <div class="author">Name and Image of the user</div>
                    <div class="date">Role: </div>                                       
                </div> 

   
            <form method="post" action="revoke.php?note_id=<?=$note_id?>&role_id=<?=$role_id?>">
            <input type="hidden" name="submitted" value="1"/>

    <?php
    //So here is the list of users that has role "none" and waiting to get "contributor" role.
    //So here I am passing user_id into the value of each checkboxes. So that I can update their roles through user_id.
        while($row2 = $r2->fetch_assoc()) {
            $u_id=$row2["user_id"];
    ?>
                <div class="container2">                   
                    <div class="title1"><input type="checkbox" name="access[]" value="<?=$row2["user_id"]?>"></div>
                    <div class="author"><?=$row2["screenName"]?>   <img src =<?=$row2["avatar"]?>  class="a2v"/></div>
                    <div class="date"><?=$row2["role"]?></div>                                       
                </div>
      <!-- <div class="container4">
            <span><input type="checkbox" name="access[]" value="</span></span>
            
        </div>-->

    <?php
        }//end of the first while loop.
        
    ?>
                <div class="container2">
                    <div class="no">Revoke Access to the following users listed below (if any):</div>                   
                    <div class="title1">Please select checkbox to give the role to the given user:</div>
                    <div class="author">Name and Image of the user</div>
                    <div class="date">Role: </div>                                       
                </div> 
        
<?php
//So here is the list of users that has role "contributor" and waiting to get "none" role.
        while($row3 = $cr3->fetch_assoc()) {
            //$u_id=$row2["user_id"];
    ?>
                <div class="container2">                   
                    <div class="title1"><input type="checkbox" name="revoke[]" value="<?=$row3["user_id"]?>"></div>
                    <div class="author"><?=$row3["screenName"]?>   <img src =<?=$row3["avatar"]?>  class="a2v"/></div>
                    <div class="date"><?=$row3["role"]?></div>                                       
                </div>
      <!-- <div class="container4">
            <span><input type="checkbox" name="access[]" value="</span></span>
            
        </div>-->

    <?php
        }//end of 2nd while loop and closing the database connection.
        $db->close();
    ?>
       
        
        

    </div>
    
    <div class="bottom">
        <!--<a href="#"><p><input type="submit" name="submit1" value="Submit"/></p></a>-->
        
            <p><button type="submit" name="sub">Give Access</button></p>
        </form>
        
    </div>
   
   
        
          
     
    
</body>
 
</html>