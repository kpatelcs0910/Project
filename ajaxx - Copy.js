console.log ("AJAX code loaded");
// save the timestamp for when this page was loaded
var lastUpdate = Date.now();

console.log (lastUpdate);

setInterval (updateVotes, 90000); //600,000 ms = 600s = 10min

function updateVotes() {
    console.log ("start update votes");

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            updateVoteCounts(xhr.responseText);
            console.log(xhr.responseText);

        }
    }
    xhr.open("GET", "ajax.php?lastdt=" + encodeURIComponent(lastUpdate), true);
    xhr.send(null);

    console.log ("end update votes");
}
function updateVoteCounts(responseText) {
    // update the timestamp
    lastUpdate = Date.now();
            
    // parse the JSON object
    var result = JSON.parse(responseText);
    //document.getElementById("ajax").innerHTML = "";
    // iterate over the array of objects
    for (let i = 0; i < result.notes.length; i++){

        //console.log (result[i].vote_count);
        var divtag = document.createElement("div");
        var divtag2 = document.createElement("div");
        var brtag = document.createElement("br");
        var brtag2 = document.createElement("br");
        document.getElementById("ajaj").appendChild(brtag);
        document.getElementById("ajaj").appendChild(brtag2);
        //divtag.innerHTML = "<div class='no'>" + results.notes[i].role + "</div>";
        //divtag.innerHTML = "<br/></br/>";
        var owner = "owner";
        if(result.notes[i].role == owner)
        {
            divtag.innerHTML = "<div class='no' >" + result.notes[i].role + "</div><div class='title1' >" + result.notes[i].title + "</div><div class='author'>"
                            + result.users[i].screenName + "<img src ='"+result.users[i].avatar+"' class='a2v'/></div><div class='date'>"
                            + result.notes[i].created_dt + "</div><div class='edited'>" + result.count[i].last_edit_dt + "</div><div class='nof'>"
                            + result.count[i].contribution_count + "</div><div class='va'><a  href='viewcon1.php?note_id="
                            + result.notes[i].note_id +"&role_id="+ result.notes[i].role_id +"'>View/Contribute.  </a> <a class='access'  href='revoke.php?note_id="
                            + result.notes[i].note_id +"&role_id="+ result.notes[i].role_id +"'>Access/Revoke.  </a></div>";
        }
        else
        {
            divtag.innerHTML = "<div class='no' >" + result.notes[i].role + "</div><div class='title1' >" + result.notes[i].title + "</div><div class='author'>"
                            + result.users[i].screenName + "<img src ='"+result.users[i].avatar+"' class='a2v'/></div><div class='date'>"
                            + result.notes[i].created_dt + "</div><div class='edited'>" + result.count[i].last_edit_dt + "</div><div class='nof'>"
                            + result.count[i].contribution_count + "</div><div class='va'><a  href='viewcon1.php?note_id="
                            + result.notes[i].note_id +"&role_id="+ result.notes[i].role_id +"'>View/Contribute.  </a> <a class='noaccess' href=''>Don't have an access.</a>";
        }
        
                           /* if(result.notes[i].role == "owner")
                            {
                                divtag2.innerHTML ="<a  href='viewcon1.php?note_id="
                                + result.notes[i].note_id +"&role_id="+ result.notes[i].role_id +"'>View/Contribute.  </a></div>";
                                document.getElementById("container2").appendChild(divtag2);    
                            }
                            else
                            {
                                divtag2.innerHTML = "<a class='noaccess' href=''>Don't have an access.</a></div>";
                                document.getElementById("container2").appendChild(divtag2);  
                            }*/
        divtag.className="container2";
        document.getElementById("ajaj").appendChild(divtag);
        document.getElementById("ajaj").appendChild(brtag);
        document.getElementById("ajaj").appendChild(brtag2);
        /*
         <div class="no">Role:</div>
                    <div class="title1">Title</div>
                    <div class="author"><?=$ownd1["screenName"]?>   <img src =<?=$ownd1["avatar"]?>  class="a2v"/></div>
                    <div class="date">Created on:</div>
                    <div class="edited">Last edited on:</div>
                    <div class="nof">Number Of contribution</div>
        <div class="va"><a  href="viewcon1.php?note_id=<?=$row["note_id"]?>&role_id=<?=$row["role_id"]?>">View/Contribute.  </a>
        <a class="access" href="revoke.php?note_id=<?=$row["note_id"]?>&role_id=<?=$row["role_id"]?>">Access/Revoke.</a>
         <a class="noaccess" href="">Don't have an access.</a>
        if (voteCount) {
            voteCount.innerHTML ="note_id : " + result.notes[i].note_id;
        }*/
    }
}


/* event handler for casting the vote (click on vote buttons)
*/

/*function vote (e) {
    // get the id of the candidate that was voted for
    let voteButtonId = e.target.id;
    let voteIdArray = voteButtonId.split("_");
    let voteId = voteIdArray[2];
    //console.log (voteId);

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //console.log (xhr.responseText);

            // change the vote buttons for this position to vote counts

            // navigate to the div that encapsulates all of the candidates for a position (three levels up in the tree p, div, div)
            let candidates = e.target.parentElement.parentElement.parentElement;

            // loop through the childNodes of this <div class="position">
            for (let i = 0; i < candidates.childNodes.length; i++) {
                let child = candidates.childNodes[i];

                // differentiate between the <p> and the <div class="canididate"> tags
                if (child.className == "candidate") {
                    // navigate to the last child of this <div> which is the <p class="candidateVote">
                    let lastElement = child.lastElementChild;

                    // get the button and remove the event listener
                    let button = lastElement.firstElementChild;
                    button.removeEventListener("click", vote);

                    // get the id of this button
                    let thisButtonId = button.id.split("_")[2];

                    // set this id on the <p>, which is in lastElement
                    lastElement.id = "voteCount" + thisButtonId;

                    // remove the button itself by emptying the innerHTML
                    lastElement.innerHTML = "";
                }
            }

            // now that all of the buttons for the candidates in his position are removed, we can update the vote counts

            updateVoteCounts(xhr.responseText);
        }
    }

    xhr.open("GET", "castvote.php?candidate_id=" + encodeURIComponent(voteId), true);
    xhr.send(null);
}


/* register the event hander function to all of the the vote buttons


let buttons = document.getElementsByTagName("button");
for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener("click", vote);
}*/



