    String.prototype.trim = function() {
        a = this.replace(/^\s+/, '');
        return a.replace(/\s+$/, '');
    };

    function hasWhiteSpace(s) {
        return s.indexOf(' ') >= 0;
    }
    function isUsernameValid(username){
 
        if( username  == ""){
            document.getElementById("usernameMsg").innerHTML="<font color=red>Username is required</font>";
            return false;
        }else{
	
            if(hasWhiteSpace(username)){
                document.getElementById("usernameMsg").innerHTML="<font color=red>Remove white spaces in username</font>";
                return false;
            }else{
                return true;
            }
		
        }
    }

    function isPWValid(pw){
	
        passwordConf = document.getElementById("password").value;
        if(pw == ""){
            document.getElementById("pwMsg").innerHTML="<font color=red>Password is required</font>";
            return false;
        }else{
            if(pw.length > 5){
                clearPWResponseText();
                return true;
            }else{
                document.getElementById("pwMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                return false;
            }
        }
    }

    function validateForm(){
        username = document.getElementById("username").value;
        password = document.getElementById("password").value;
	
        if(isUsernameValid(username) && isPWValid(password) ){
            return true;
        } else{
            return false;
        }
    }

    function clearUernameResponseText (){
        document.getElementById("usernameMsg").innerHTML="";
        document.getElementById("signInResponseMsg").innerHTML="";
    }

    function clearPWResponseText (){
        document.getElementById("pwMsg").innerHTML="";
        document.getElementById("signInResponseMsg").innerHTML="";
    }