var formV = document.getElementById("formValidation");

formV.addEventListener("submit",check2SignUp, false);
formV.addEventListener("submit", check2Login, false);


var email2 = document.getElementById("email");
email2.addEventListener("blur", vEmail, false);


var pswd2 = document.getElementById("pswd");
pswd2.addEventListener("blur", vPswd, false);

var cpswd2 = document.getElementById("cpswd");
cpswd2.addEventListener("blur", vCPswd, false);

var uname2 = document.getElementById("uname");
uname2.addEventListener("blur", vUsername, false);

var profile2 = document.getElementById("fileToUpload");
profile2.addEventListener("blur", vProfilePic, false);



function vEmail(e)
{
  var email = e.currentTarget;
  checkEmail(email);
}
function checkEmail (e)
{
    
   // var x = e.currentTarget;
    var email = e.value;
    //var regex_email = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var regex_email = /^[\w.]+@uregina.ca$/i;
    var msg_email = document.getElementById("msg_email");
    msg_email.innerHTML  = "";   
    var textNode;
    valid = true;
    
   // var htmlNode;
    if (email == null || email == "") {
        textNode = document.createTextNode("*Email address empty.");
        msg_email.appendChild(textNode);
        valid = false;
       // e.preventDefault();
        
      } 
      else if (regex_email.test(email) == false) {
        textNode = document.createTextNode("*Email address wrong format. example: username@uregina.ca");
        msg_email.appendChild(textNode);
        valid = false;
       // e.preventDefault();
        
      }
      else if(email.length > 60) {
        textNode = document.createTextNode("*Email address too long. Maximum is 60 characters.");
        msg_email.appendChild(textNode);
        valid = false;
        //e.preventDefault();
        
      }
      
      return valid;
      
      
}

function vPswd(e)
{
  var pswd = e.currentTarget;
  checkPswd(pswd);
}

function checkPswd(e)
{
   // var x = ;
    var pswd = e.value; 
    var regex_pswd  = /^(\S*)(?=.*[\W])(?=.*[a-zA-Z0-9])(\S*)?$/;
    //var regex_pswd = /[\W]  
    var msg_pswd = document.getElementById("msg_pswd");  
    msg_pswd.innerHTML  = "";     
    var textNode;
    valid = true;

  //var htmlNode;

    if (pswd == null || pswd == "") {
      textNode = document.createTextNode("\n*Password is empty.");
      msg_pswd.appendChild(textNode);
      return false;
      //e.preventDefault();
  
    }
    else if(regex_pswd.test(pswd) == false){
      textNode = document.createTextNode("*Password is invalid. It must contain letters and atleast one Non-character.");
      msg_pswd.appendChild(textNode);
      valid = false;
     // e.preventDefault();
    }
    else if(pswd.length<6){ 
      textNode = document.createTextNode("*Password is invalid. Minimum length for password is 6 characters.");
      msg_pswd.appendChild(textNode);
      valid = false;
      //e.preventDefault();
    }
    return valid;
    
}

function check2Login(e)
{
  
  console.log("hiii");
  var email4 = document.getElementById("email");
  var pswd4 = document.getElementById("pswd");
  if(checkEmail(email4) && checkPswd(pswd4))
  {
    console.log("Noo error");
  }
  else{
    e.preventDefault();
  }

}

function vCPswd(e)
{
  var pswdr = e.currentTarget;
  checkCPswd(pswdr);
}

function checkCPswd(e)
{
  var password = document.getElementById("pswd");
  pswd = password.value;
    var pswdr = e.value;
    
    
    var valid = true;
    var msg_pswdr = document.getElementById("msg_pswdr");
    msg_pswdr.innerHTML = "";
    var textNode;
    if (pswdr == null || pswdr == "") {
        textNode = document.createTextNode("*Confirm Password is empty.");
        msg_pswdr.appendChild(textNode);
        valid = false;
    
      }
      else if(pswd != pswdr){
        textNode = document.createTextNode("*Confirm Password characters and Password characters have to be exact same values!.");
        msg_pswdr.appendChild(textNode);
        valid = false;
      }
      return valid;
}


function vUsername(e)
{
  var uname = e.currentTarget;
  checkUname(uname);
}

function checkUname(e)
{
    
    var uname = e.value; 
    var regex_uname = /^[a-zA-Z0-9]+$/;
    var msg_uname = document.getElementById("msg_uname");
    msg_uname.innerHTML = "";
    var textNode;
    var valid = true;
  
  //var valid = true; 
  //Username
  if (uname == null || uname == "") {
    textNode = document.createTextNode("*Username is empty.");
    msg_uname.appendChild(textNode);
    valid = false;

  }
  else if(regex_uname.test(uname) == false){
    textNode = document.createTextNode("*Username is invalid. Be sure it does not contain strange symbols or have extra spaces anyhere.");
    msg_uname.appendChild(textNode);
    valid = false;
  }
  else if(uname.length>40){ 
    textNode = document.createTextNode("*Username is invalid. Max length for username is 40 characters.");
    msg_uname.appendChild(textNode);
    valid = false;
  }

 return valid;

}



function vProfilePic(e)
{
  var profile = e.currentTarget;
  checkProfilePic(profile);
}

function checkProfilePic(e)
{    
    
    var profile =e.value;
    //var profile = e.currentTarget.value;
    var msg_profile = document.getElementById("msg_profile");
    msg_profile.innerHTML="";
    var textNode;
    var valid = true;
    
   
   
    var r = /[^\\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/;
  
  if(profile != '')
    {
        
        if(r.test(profile) == false)
        {
          textNode = document.createTextNode("*The selected file might not be picture or image.");
          msg_profile.appendChild(textNode);
          valid = false;
        }
        else
        {
        textNode = document.createTextNode("*correct File.");
          msg_profile.appendChild(textNode);
          valid = true;
        } 
    }
    else 
    {
        textNode = document.createTextNode("*You have not selected any picture as your profile.");
        msg_profile.appendChild(textNode);
        valid = false;
    }

    return valid;
}


function check2SignUp(e)
{
  
  console.log("hiii");
  var email4 = document.getElementById("email");
  var pswd4 = document.getElementById("pswd");
  var cpswd1 = document.getElementById("cpswd");
  var uname1 = document.getElementById("uname");
  var profile1 = document.getElementById("fileToUpload");
  if(checkEmail(email4) && checkPswd(pswd4) && checkCPswd(cpswd1) && checkUname(uname1) && checkProfilePic(profile1))
  {
    console.log("Noo error");
  }
  else{
    e.preventDefault();
  }

}

function vNote(e)
{
  var note = e.currentTarget;
  checkNote(note);
}

function checkNote (e)
{
    
   // var x = e.currentTarget;
    var note = e.value;
    var msg_noteName = document.getElementById("msg_noteName");
    msg_noteName.innerHTML  = "";   
    var textNode;
    var valid = true;
    //var htmlNode;
    if (note == null || note == "") {
        textNode = document.createTextNode("*Title is empty.");
        msg_noteName.appendChild(textNode);
        valid = false;
        
      }      
      else if (note.length > 264) {
        textNode = document.createTextNode("*You cannot write more than 264 characters.");
        msg_noteName.appendChild(textNode);
        valid = false;
        
      }

      return valid;
      
}

function check2Note(e)
{
  
  console.log("Note");
  var note4 = document.getElementById("note");
  
  if(checkNote(note4))
  {
    console.log("Noo error");
  }
  else{
    e.preventDefault();
  }

}



function counter1 (e)
{
    
    var x = e.currentTarget;
    var chars = x[0].value.length;

    if(x[0].className == "counter2")
    {
        var maxChars = 1500;
    }
    else
    {
        var maxChars = 256;
    }
    var remain = maxChars-chars;
    var totalChars = document.getElementById("totalChars");
    totalChars.innerHTML = "";
    var remainingChars = document.getElementById("remainingChars");
    remainingChars.innerHTML = "";
    var textNode;
    var textNode2;
    

    textNode = document.createTextNode("Total Number of Characters for title: " + chars);
    totalChars.appendChild(textNode);
    
    
   
    textNode2 = document.createTextNode("Remaining Number of Characters for title: " + remain);
    
    remainingChars.appendChild(textNode2);
    
    
      
}



function counter2 (e)
{
    
    //var x = e.currentTarget.value;
    var chars = e.currentTarget.value.length;

    
        var maxChars = 1500;
    
        //var maxChars = 256;
    
    var remain = maxChars-chars;
    var totalChars = document.getElementById("totalChars");
    totalChars.innerHTML = "";
    var remainingChars = document.getElementById("remainingChars");
    remainingChars.innerHTML = "";
    var textNode;
    var textNode2;
    

    textNode = document.createTextNode("Total Number of Characters for title: " + chars);
    totalChars.appendChild(textNode);
    
    
   
    textNode2 = document.createTextNode("Remaining Number of Characters for title: " + remain);
    
    remainingChars.appendChild(textNode2);
    
    
      
}

function vCon(e)
{
  var con = e.currentTarget;
  checkCon(con);
}


function checkCon(e)
{
    
    
    var contr = e.value;
    
    var msg_contribute = document.getElementById("msg_contribute");
    msg_contribute.innerHTML  = "";   
    var textNode;
    var valid = true;
    //var htmlNode;
    if (contr == null || contr == "") {
        textNode = document.createTextNode("*You must do some contribution .");
        msg_contribute.appendChild(textNode);
        valid = false;
        
      }      
      else if (contr.length > 1500) {
        textNode = document.createTextNode("*You cannot write more than 1500 characters.");
        msg_contribute.appendChild(textNode);
        valid = false;
        
      }
     return valid;
      
}


function check2Con(e)
{
  
  console.log("Con Page");
  var con4 = document.getElementById("contribution");
  
  if(checkCon(con4))
  {
    console.log("Noo error");
  }
  else{
    e.preventDefault();
  }

}




function ResetForm(event) {
  
    var elements = event.currentTarget;
    elements[0].value="";
    elements[1].value="";
    elements[2].value="";
    elements[3].value="";
    elements[4].value="";  
    
    var msg_email = document.getElementById("msg_email");
    var msg_pswd = document.getElementById("msg_pswd");
    var msg_pswdr = document.getElementById("msg_pswdr");
    var msg_uname = document.getElementById("msg_uname");
    var msg_noteName = document.getElementById("msg_noteName");
    var msg_contribute = document.getElementById("msg_contribute");
    var totalChars = document.getElementById("totalChars");
    totalChars.innerHTML = "";
    var remainingChars = document.getElementById("remainingChars");
    remainingChars.innerHTML = "";

    msg_email.innerHTML  = "";   
    msg_pswd.innerHTML  = "";
    msg_pswdr.innerHTML="";
    msg_uname.innerHTML = "";
    msg_noteName.innerHTML  = "";   
    msg_contribute.innerHTML  = "";   
    var display_info = document.getElementById("display_info");
    display_info.innerHTML = "";
  
     
    
   
  }



  