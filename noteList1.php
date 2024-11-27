<?php

    session_start();
	if (!isset($_SESSION["user_id"])) {
		header("Location: login1.php");
		exit();
	} else {
		$user_id = $_SESSION["user_id"];//I am getting user_id, screenName, avatar from login page
        $screenName = $_SESSION["screenName"];
        $avatar = $_SESSION["avatar"];
        $c="";
        $o="";
        $ownd="";
        $i=0;
        $error="";
		// load the database and get the orders for this user
		$db = new mysqli("localhost","kpp190","P@t2001K@ush","kpp190");
	  	if ($db->connect_error) {
	  		die ("Connection failed: " . $db->connect_error);
		}
        
        if(isset( $_GET["note_id"]))//Just checking that note_id is available. If I am not using this isset to note_id then that gives me error of "undefined array"
        {
            $note_id = $_GET["note_id"];//I always get note id but for some reason I didn't get which is impossible I will assign this "" to the note_id so that I will not get any weird error of undefined array
        }
        else {
            $note_id = ""; 
        }
        $owner="owner";//just storing "owner" string and "contributor" so that I will not get any error of in mentioning this query in mysql. 
        $contributor="contributor";

        $q= "SELECT Notes.note_id, Notes.title, Roles.role_id, Users.screenName, Notes.created_dt, Notes.last_edit_dt,Roles.role   
                FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)   
                WHERE Roles.user_id ='$user_id'  AND (Roles.role = 'owner' OR Roles.role = 'contributor')
                ORDER BY Notes.created_dt DESC;";

        /*

        --> By above query I only get the screenName of current user in every row. I cannot get the owner name of the particular note if the 
                current user has contributor role in it.
        
        --> This were the queries I was trying but some worked and some didn't.

       1)--> SELECT Notes.note_id, Notes.title, Roles.role_id, Notes.created_dt,Roles.role   
                FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)   
                WHERE Roles.user_id =7  AND (Roles.role = 'owner' OR Roles.role = 'contributor')
                AND Notes.created_dt > "2022-04-09 13:25:58";

        2)--> 
        
        $q2= "SELECT Notes.note_id,Roles.role_id, Notes.title, COUNT(Contributions.c_id) as contribution_count,Users.screenName, Notes.created_dt, Notes.last_edit_dt,Roles.role   
                FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)
                LEFT JOIN Contributions ON (Notes.note_id = Contributions.note_id)   
                WHERE Roles.user_id =5  AND (Roles.role = 'owner' OR Roles.role = 'contributor')
                GROUP BY Notes.note_id;";
        $q= "SELECT Notes.note_id, Roles.role_id, Notes.title, Users.screenName, Notes.created_dt, Notes.last_edit_dt,Roles.role   
                FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)   
                WHERE Roles.user_id = 5  AND (Roles.role = 'owner' OR Roles.role = 'contributor');";

        $q= "SELECT Notes.note_id, Roles.role_id, Notes.title, Users.screenName, Notes.created_dt, Notes.last_edit_dt,Roles.role   
                FROM Roles LEFT JOIN Notes ON (Roles.note_id = Notes.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)   
                WHERE Roles.user_id = 5  AND (Roles.role = "owner" OR Roles.role = "contributor");";
        
        $q4 = "SELECT Roles.role,Users.screenName FROM Roles LEFT JOIN Users ON (Roles.user_id = Users.user_id) WHERE Roles.note_id = 2 AND Roles.role="owner";"
                
                
        */
        $r = $db->query($q);

        if($r == true)
        {
            
        }
        else {
            $r = "";
            
        }


        
        
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Note List Page</title>
  
  <script src="https://kit.fontawesome.com/fbe599c56d.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="assi-3.css"/>
  
</head> 
  <body class="container">
    <div class="title">
        <div class="titlebar">
            <p class ="Back"><a href="login1.php">&#x3c;Back</a></p>
            <p class="profilePicture">Logged in as: <?=$screenName?>   <img src =<?=$avatar?> class="ava"/><p><a href="logout.php">logout</a></p></p>         

            <p class="search"><input type="text" name="search" placeholder="Search here"/><button type="submit">Search</button></p>
          
            <p class ="delete"><a  href="#">Delete &#8855;</a></p>
            <p class ="add"><a href="createNote1.php?user_id=<?=$user_id?>">Add &#43;</a></p>
        </div>
    </div>

       
           <div class="contain2">
           <p class="err php"><?=$error?></p>
                <div class="container2">
                    <div class="no">Role:</div>
                    <div class="title1">Title</div>
                    <div class="author">Creator</div>
                    <div class="date">Created on:</div>
                    <div class="edited">Last edited on:</div>
                    <div class="nof">Number Of contribution</div>
                                       
                </div>

                <div class="contain2"><div id="ajaj"></div></div>

                

                <?php
                //Here I am counting total number of notes that user has access to with "i". And I am printing title, created_dt and role from the 
                $i= 0;                      // $q query through this while loop.
                    while($row = $r->fetch_assoc()) {
                        $n_id = $row["note_id"]
                        
                     
                ?>
                <?php
                    $i++;//counter to count total number of notes.class="number"
                ?>

                <div class="container2">
                <div class="no"><?=$row["role"]?></div>
                    <div class="title1"><?=$row["title"]?></div>
                    
                   <?php
                   //This query will give me the correct owner name and image of the particular note. I write this query because I cannot get correct owner name and img url from the above query which is mentioned in the hints of for assignment 5.
                    $o="SELECT Roles.role,Users.screenName, Users.avatar FROM Roles LEFT JOIN Users ON (Roles.user_id = Users.user_id) WHERE Roles.note_id = '$n_id' AND Roles.role='owner';";
                    $ownd=$db->query($o);
                    $ownd1=$ownd->fetch_assoc();
                   ?>
                    <div class="author"><?=$ownd1["screenName"]?>   <img src =<?=$ownd1["avatar"]?>  class="a2v"/></div>
                    <div class="date"><?=$row["created_dt"]?></div>
                    <?php
                    //Through this query I will count the number of contributions and last_edit_dt to this particular note. Because As you see this will return only one row. So when I merge this query to the upper one I got very huge weird query that's why I write three different queries.
                    //And I don't think that there is a limitation mentioned in the assignment requirements.So If you cut marks on this assignment please mention that 
                    //What is problem in my assignment and what will be the solution of that one. 
                         $c = "SELECT Notes.note_id,MAX(Contributions.save_dt) as last_edit_dt, COUNT(Contributions.c_id) as contribution_count
                         FROM Notes LEFT JOIN Contributions ON (Notes.note_id = Contributions.note_id)
                         WHERE Notes.note_id = '$n_id';";
                        $count = $db->query($c);
                        $count1 = $count->fetch_assoc();
                        
                        
                    ?>
                     
                    <div class="edited"><?=$count1["last_edit_dt"]?></div>                    
                    <div class="nof"><?=$count1["contribution_count"]?></div>
                    <div class="va"><a  href="viewcon1.php?note_id=<?=$row["note_id"]?>&role_id=<?=$row["role_id"]?>">View/Contribute.  </a>
                        <?php
                        //Here if the current user is the role of the owner then I will give access to the access/revoke page to his/her particular note
                        //that he/she is the owner. If he/she is the contributor then just wirte that "You don't have access."
                            if($row["role"] == "owner"){
                        ?>
                        <a class="access" href="revoke.php?note_id=<?=$row["note_id"]?>&role_id=<?=$row["role_id"]?>">Access/Revoke.</a>
                        <?php
                            }
                            else {                           
                        ?>
                        <a class="noaccess" href="">Don't have an access.</a>
                        <?php
                            }
                        
                        ?>
                    </div>
                </div>
                <br/>
                <br/>

                <?php
                  }//End of while loop and close the database.
                    $db->close();
            
                ?>
            <script type="text/javascript" src="ajaxx.js"></script> 
            <!--<script type="text/javascript" src="a1jax.js"></script>-->
                
            </div>    

    <div class="bottom"><p class="textColour">&copy; 2022 K.P. All rights reserved.</p></div>
   
   
        
           
     
       
</body>
 
</html>