<?php
    

    // connect to the database
    session_start();
if (!isset($_SESSION["user_id"])) {
		  header("Location: login1.php");
		  exit();
}
else 
{
    $user_id = $_SESSION["user_id"];
    $db = new mysqli("localhost","kpp190","P@t2001K@ush","kpp190");
    if ($db->connect_error) {
    die ("Connection failed: " . $db->connect_error);
    }
    // check to see if anyone has voted since the page was loaded
    // covert the timestamp into the MySQL date format
    $votedSince = date('Y-m-d H:i:s', $_GET["lastdt"]/1000);

    $q= "SELECT Notes.note_id, Notes.title, Roles.role_id, Users.screenName, Notes.created_dt, Notes.last_edit_dt,Roles.role   
                FROM Notes LEFT JOIN Roles ON (Notes.note_id = Roles.note_id)   
                LEFT JOIN Users ON (Roles.user_id = Users.user_id)   
                WHERE Roles.user_id ='$user_id'  AND (Roles.role = 'owner' OR Roles.role = 'contributor')
                AND Notes.last_edit_dt > '$votedSince'";

    $r = $db->query($q);
    $json = array("notes" => array(),"users" => array(),"count" => array());
    if($r == true)
    {
      while($row = $r->fetch_assoc()) 
      {
        $n_id = $row["note_id"];
        $o="SELECT Roles.role,Users.screenName, Users.avatar FROM Roles LEFT JOIN Users ON (Roles.user_id = Users.user_id) WHERE Roles.note_id = '$n_id' AND Roles.role='owner';";
        $ownd=$db->query($o);
        $ownd1=$ownd->fetch_assoc();
        
        $c = "SELECT Notes.note_id,MAX(Contributions.save_dt) as last_edit_dt, COUNT(Contributions.c_id) as contribution_count
        FROM Notes LEFT JOIN Contributions ON (Notes.note_id = Contributions.note_id)
        WHERE Notes.note_id = '$n_id';";
        $count = $db->query($c);
        $count1 = $count->fetch_assoc();

        $json["notes"][] = $row;
        $json["users"][] = $ownd1;
        $json["count"][] = $count1;
        
      }
      print json_encode($json);
      //mysqli_free_result($row);
      //mysqli_free_result($ownd1);
      //mysqli_free_result($count1);
      //$row->mysqli_free_result();
    }
    else {
    $r = "";
    print("[]");
    }
    $db->close(); 
    /*
    if ($result = $db->query($q)) 
    {
      $json = array("users" => array());
      while ($row =$result->fetch_assoc()) {
        $json["users"][] = $row;
      } 
      print json_encode($json);
      mysqli_free_result($result);
    }
    else{
      print("[]");
    } 
    mysqli_close($db); */   
}

   

?>