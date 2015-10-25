 	String.prototype.trim = function() {
        a = this.replace(/^\s+/, '');
        return a.replace(/\s+$/, '');
    };

    function hasWhiteSpace(s) {
        return s.indexOf(' ') >= 0;
    }
 
    function isFNameValid(fname){
        if( fname  == ""){
            document.getElementById("fnameMsg").innerHTML="<font color=red>First name is required</font>";
            return false;
        }else{
            document.getElementById("fnameMsg").innerHTML="<font color=green>Valid</font>";
            return true;
        }
 
    }
    function isLNameValid(lname){
	
        if( lname  == ""){
            document.getElementById("lnameMsg").innerHTML="<font color=red>Last name is required</font>";
            return false;
        }else{
            document.getElementById("lnameMsg").innerHTML="<font color=green>Valid</font>";
            return true;
        }
	 
    } 
			
	function isAddress1Valid(address1){
	
		if( address1  == ""){
			document.getElementById("address1Msg").innerHTML="<font color=red>Address line 1 is required</font>";
			return false;
		}else{
			document.getElementById("address1Msg").innerHTML="<font color=green>Valid</font>";
			return true;
		}
	 
	} 
	
   function isTPNumberValid(tpNumber){ 
        var phoneRegex = /^\d{10}$/ ;
        if(tpNumber != ""){
            if (tpNumber.match(phoneRegex)  ) {
                document.getElementById("tpNumberMsg").innerHTML="<font color=green>Valid</font>";
                return true;
            } else {
                document.getElementById("tpNumberMsg").innerHTML="<font color=red>Invalid contact number</font>";
                return false;
            }
        } else {
            return true;
        }
    } 
			 
    function validateUpdateProfileForm(){
        firstname = document.getElementById("firstname").value;
        lastname = document.getElementById("lastname").value;
        contactnumber = document.getElementById("contactnumber").value;
		address1 = document.getElementById("address1").value;
		
        if( isTPNumberValid(contactnumber) && isLNameValid(lastname) && isFNameValid(firstname)&& isAddress1Valid(address1) ){
            return true;
        }else{
            return false;
        }

    }

    function clearProfileDetailsResponseMsg(){
        document.getElementById("updateProfileResponseMsg").innerHTML="";
    }

    function isCurrentPWValid(pw){  
		clearChangePasswordResponseMsg();
        if(pw == ""){
            document.getElementById("currentPWMsg").innerHTML="<font color=red>Password is required</font>";
            return false;
        }else{
            if(pw.length > 5){
                document.getElementById("currentPWMsg").innerHTML="<font color=green>Valid</font>";
                return true;
            }else{
                document.getElementById("currentPWMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                return false;
            }
        }
    }
	
    function isNewPWValid(pw){
        clearChangePasswordResponseMsg();
        passwordConf = document.getElementById("confirmpassword").value;
        if(pw == ""){
            document.getElementById("newPWMsg").innerHTML="<font color=red>Password is required</font>";
            return false;
        }else{
            if(pw.length > 5){
                document.getElementById("newPWMsg").innerHTML="<font color=green>Valid</font>";
                if(pw == passwordConf ){
                    document.getElementById("confirmNewPWMsg").innerHTML="<font color=green>Valid</font>";
                }
                return true;
            }else{
                document.getElementById("newPWMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                return false;
            }
        }
    }

   function isConfirmPWValid(confPW){
        clearChangePasswordResponseMsg();
        password = document.getElementById("newPassword").value;
        if(confPW == ""){
            document.getElementById("confirmNewPWMsg").innerHTML="<font color=red>Password confimation is required</font>";
            return false;
        }else{
            if(confPW.length > 5){
                if(confPW == password){
                    document.getElementById("confirmNewPWMsg").innerHTML="<font color=green>Valid</font>";
                    return true;
                }else{
                    document.getElementById("confirmNewPWMsg").innerHTML="<font color=red>Password confimation is not identical</font>";
                    return false;
                }
			
            }else{
                document.getElementById("confirmNewPWMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                return false;
            }
        }
    }

	function changePasswordValidateForm(){
        currentPassword = document.getElementById("currentPassword").value;
        newPassword= document.getElementById("newPassword").value;
        newPasswordConfirmation = document.getElementById("confirmpassword").value;
	
        if(isCurrentPWValid(currentPassword ) && isNewPWValid(newPassword ) && isConfirmPWValid(newPasswordConfirmation)){
            return true;
        }else {
            return false;
        }
    } 	
	
    function clearChangePasswordResponseMsg(){
		if(document.getElementById("updatePasswordResponseMsg") !=  null){
			document.getElementById("updatePasswordResponseMsg").innerHTML = ""; 
		} 
    }

 