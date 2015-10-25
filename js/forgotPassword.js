    String.prototype.trim = function() {
        a = this.replace(/^\s+/, '');
        return a.replace(/\s+$/, '');
    }; 
			
	function isEmailHasValidFormat(s) {
		var emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailRegexStr.test(s) ;
	}
			
	function isEmailValid(email){	
		clearResponseText();
		if( email  == ""){
			document.getElementById("emailMsg").innerHTML="<font color=red>Email is required</font>";
			return false;
		}else{
			if (!isEmailHasValidFormat(email)) {
				document.getElementById("emailMsg").innerHTML="<font color=red>Invalid email</font>";
				return false;
			}else{
				document.getElementById("emailMsg").innerHTML="<font color=green>Valid</font>";
				return true;
			}
		} 
	}
			
    function validateEmail(){
        emailTxt  = document.getElementById("email").value;
        if(isEmailValid(emailTxt)){ 
            return true; 
        }else{ 
            return false;
        } 
    }

	function clearResponseText (){
		document.getElementById("forgotPWMsg").innerHTML="";
	}