<?php
   $validate = true;
	// load the database and verify the username/password
	$db = mysqli_connect("localhost", "kpp190", "P@t2001K@ush", "kpp190");
	if (!$db) {
		exit ();
	}
	
	if (!isset($_GET['contri'])) {
		$contri = "";

	} else {
		$contri = $_GET['contri'];
        //echo json_encode($email);
	}

    if (!isset($_GET['note_id'])) {
		$note_id = "";

	} else {
		$note_id = $_GET['note_id'];
        
	}

    if (!isset($_GET['role_id'])) {
		$role_id = "";

	} else {
		$role_id = $_GET['role_id'];
       
        //echo json_encode($role_id);
	}

    if(strlen($contri)>0)
    {
          

          if($contri == null || $contri == "" || strlen($contri)>1500)
          {
            $validate = false;
          }

          if($validate == true)
          {
            $q2 = "INSERT INTO Contributions(contribution, note_id, role_id, save_dt) VALUES('$contri','$note_id','$role_id',NOW());";
            $r2 = $db->query($q2);
            
            $u="UPDATE Notes SET last_edit_dt = NOW() WHERE note_id = '$note_id';";            
            $u1=$db->query($u);
            if($u1 == true)
            {
                
            }
            else
            {
              $error=("Query Update date is not working");
            }

            $q3 = "SELECT Contributions.contribution, Contributions.save_dt,
                    Roles.role,
                    Users.screenName, Users.avatar
                    FROM Contributions LEFT JOIN Roles ON (Contributions.role_id = Roles.role_id)
                    LEFT JOIN Users ON (Roles.user_id = Users.user_id)
                    WHERE Contributions.note_id = '$note_id' AND (Roles.role='owner' OR Roles.role='contributor')
                    ORDER BY save_dt DESC LIMIT 1;";
                $r3 = $db->query($q3);
                $json = array("users" => array(), "count" => array());
                if($r3 == true)
                {
                  while($row = $r3->fetch_assoc())
                  {
                    $json["users"][] = $row;
                  }
                               
                
                }
                else 
                {
                  $r = "";
                  print("[]");
                }


                $c = "SELECT COUNT(Contributions.c_id) as contribution_count
                         FROM Notes LEFT JOIN Contributions ON (Notes.note_id = Contributions.note_id)
                         WHERE Notes.note_id = '$note_id';";
                        $count = $db->query($c);
                        $count1 = $count->fetch_assoc();
                        $json["count"][] = $count1;

                        print json_encode($json);
                          
                  $db->close(); 

                



          }
          else {
            echo "error";
          }

            
    }
    else 
    {
      $error = ("One or more input fields are empty");
    }
      
      
      

	/*$query = "select note_id from Notes where note_id = '$note_id'";

	if ($result = mysqli_query ($db, $query)) {
	  $json = array("users" => array());
	  while ($row = mysqli_fetch_assoc($result)) {
	    $json["users"][] = $row;
	  } 
	  print json_encode($json);
	  mysqli_free_result($result);
    SELECT Contributions.contribution, Contributions.save_dt,
                Roles.role,
                Users.screenName, Users.avatar
                FROM Contributions LEFT JOIN Roles ON (Contributions.role_id = Roles.role_id)
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)
                WHERE Contributions.note_id = 282 AND (Roles.role='owner' OR Roles.role='contributor')
                AND Contributions.role_id = 2991;

      SELECT Contributions.contribution, Contributions.save_dt,
      Roles.role,
      Users.screenName, Users.avatar
      FROM Contributions LEFT JOIN Roles ON (Contributions.role_id = Roles.role_id)
      LEFT JOIN Users ON (Roles.user_id = Users.user_id)
      WHERE Contributions.note_id = 282 AND (Roles.role='owner' OR Roles.role='contributor')
      ORDER BY save_dt ASC LIMIT 1;
	}*/
	
	
?>


