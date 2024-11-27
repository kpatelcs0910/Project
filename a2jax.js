console.log("a2jax.js loaded");
document.getElementById("submit").addEventListener("click", getUsernameList);
document.getElementById("reset").addEventListener("click", clear);
var n = note_id;
var r = role_id;
console.log(n);
console.log(r);
console.log("contributions is loaded");


function getUsernameList(event) {
    console.log ("start getUsernameList");
    var contributions = document.getElementById("contribution").value;
    console.log(contributions);
	var xhr=new XMLHttpRequest();

	xhr.onreadystatechange=function() {
  		if (xhr.readyState==4 && xhr.status==200) {
    		//document.getElementById("usernames").innerHTML=xhr.responseText;
            console.log("response: "+xhr.responseText);
    		var result = JSON.parse(xhr.responseText);
    		//document.getElementById("usernames").innerHTML = "";
    		for (var i = 0; i < result.users.length; i++) {
				var divtag = document.createElement("div");
				var count = document.getElementById("numberofcontribution");

				count.innerHTML = "Number of Contributions: " + result.count[i].contribution_count;

				divtag.innerHTML = "<div class='contributorprofilepicture'><p class='profilePicture'>" + result.users[i].screenName + 
									"   <img src ='" + result.users[i].avatar +"' class='a2v'/></p></div><div class='contributorname'>Role: "
									+ result.users[i].role + "</div><div class='addedondate'>Added on this Date/time :  " + result.users[i].save_dt +
									"</div><div class='contributorcontribution'><p>Contibution:&emsp; " + result.users[i].contribution + "</p></div>";

				divtag.className="container3";
				document.getElementById("ajaj2").appendChild(divtag);
    			//var ptag =document.getElementById("usernames");
    			//ptag.innerHTML = responseObj.users[i].contribution;
    			//ptag.className="user";
    			//ptag.addEventListener("click", clickSuggestion);
    			//document.getElementById("usernames").appendChild(ptag);
				/*
				<div class="contributorprofilepicture"><p class="profilePicture"><?=$row["screenName"]?>   <img src =<?=$row["avatar"]?>  class="a2v"/></p></div>
            <div class="contributorname">Role: <?=$row["role"]?></div>
            <div class="addedondate">Added on this Date/time :  <?=$row["save_dt"]?></div>
            <div class="contributorcontribution"><p>Contibution:&emsp; <?=$contribution1?></p>
            </div>
				*/
			}
    	}
  	}
	xhr.open("GET","a2jax.php?contri=" + encodeURIComponent(contributions) + "&note_id=" +encodeURIComponent(n) + "&role_id=" +encodeURIComponent(r),true);
	xhr.send();
    console.log ("end update votes");
}


function clear() {
	document.getElementById("contribution").value = "";
}