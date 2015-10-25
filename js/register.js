String.prototype.trim = function() {
                a = this.replace(/^\s+/, '');
                return a.replace(/\s+$/, '');
            };

 
            function getHTTPObject(){
 
                if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
 
                else if (window.XMLHttpRequest) return new XMLHttpRequest();
 
                else {
 
                    alert("Browser does not support AJAX.");
 
                    return null;
 
                }
            }
            function hasWhiteSpace(s) {
                return s.indexOf(' ') >= 0;
            }

            function isEmailHasValidFormat(s) {
                var emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailRegexStr.test(s) ;
            }

            function isUsernameValid(username){ 
                if( username  == ""){
                    document.getElementById("usernameMsg").innerHTML="<font color=red>Username is required</font>"; 
                }else{
                    if(hasWhiteSpace(username)){
                        document.getElementById("usernameMsg").innerHTML="<font color=red>Remove white spaces in username</font>"; 
                    }else{
                        xmlhttp = getHTTPObject() ;
                        xmlhttp.onreadystatechange=function(){
                            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                                document.getElementById("usernameMsg").innerHTML=xmlhttp.responseText;
                            }
                        }
                        xmlhttp.open("GET","username-"+username,true);
                        xmlhttp.send();
                    } 
                }
            }

            function isEmailValid(email){  
                if( email  == ""){
                    document.getElementById("emailMsg").innerHTML="<font color=red>Email is required</font>"; 
                }else{  
                    if (!isEmailHasValidFormat(email)) {
                        document.getElementById("emailMsg").innerHTML="<font color=red>Invalid</font>"; 
                    }else{
                        xmlhttp = getHTTPObject() ;
                        xmlhttp.onreadystatechange=function(){
                            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                                document.getElementById("emailMsg").innerHTML=xmlhttp.responseText; 
                            }
                        }
                        xmlhttp.open("GET","email-"+email,true);
                        xmlhttp.send(); 
                    }
                }
 
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
			
			function isGenderComboValid(gender){
										
                if( gender  == "Select gender"){
                    document.getElementById("genderMsg").innerHTML="<font color=red>Gender is required</font>";
                    return false;
                }else{
                    document.getElementById("genderMsg").innerHTML="<font color=green>Valid</font>";
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
			
			function isCountriesComboValid(country){
	
                if( country  == "Select a country"){
                    document.getElementById("countryMsg").innerHTML="<font color=red>Country is required</font>";
                    return false;
                }else{
                    document.getElementById("countryMsg").innerHTML="<font color=green>Valid</font>";
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
                        document.getElementById("tpNumberMsg").innerHTML="<font color=red>Invalid</font>";
                        return false;
                    }
                } else {
                    document.getElementById("tpNumberMsg").innerHTML="";
                    return true;
                }
            }
            function isPWValid(pw){
                passwordConf = document.getElementById("confirmpassword").value;
                if(pw == ""){
                    document.getElementById("pwMsg").innerHTML="<font color=red>Password is required</font>";
                    return false;
                }else{
                    if(pw.length > 5){
                        document.getElementById("pwMsg").innerHTML="<font color=green>Valid</font>";
                        if(pw == passwordConf){
                            document.getElementById("confirmPWMsg").innerHTML="<font color=green>Valid</font>";
                        }
                        return true;
                    }else{
                        document.getElementById("pwMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                        return false;
                    }
                }
            }
            function isConfirmPWValid(confPW){
                password = document.getElementById("password").value;
                if(confPW == ""){
                    document.getElementById("confirmPWMsg").innerHTML="<font color=red>Password confimation is required</font>";
                    return false;
                }else{
                    if(confPW.length > 5){
                        if(confPW == password){
                            document.getElementById("confirmPWMsg").innerHTML="<font color=green>Valid</font>";
                            return true;
                        }else{
                            document.getElementById("confirmPWMsg").innerHTML="<font color=red>Password confimation is not identical</font>";
                            return false;
                        }
			
                    }else{
                        document.getElementById("confirmPWMsg").innerHTML="<font color=red>Should be more than 5 characters</font>";
                        return false;
                    }
                }
            }

            function validateForm(){
                username = document.getElementById("username").value;
                email = document.getElementById("email").value;
                firstname = document.getElementById("firstname").value;
                lastname = document.getElementById("lastname").value;
				gender = document.getElementById("gender").value;
				address1 = document.getElementById("address1").value;
				country = document.getElementById("country").value;
                contactnumber = document.getElementById("contactnumber").value;
                password = document.getElementById("password").value;
                confirmpassword = document.getElementById("confirmpassword").value;
	
                if(isConfirmPWValid(confirmpassword) && isPWValid(password) && isTPNumberValid(contactnumber) && isLNameValid(lastname) && isFNameValid(firstname) && username != "" && !hasWhiteSpace(username) && email != "" && isEmailHasValidFormat(email)&& isGenderComboValid(gender)&& isAddress1Valid(address1)&& isCountriesComboValid(country)){
                     
                    isUsernameValid(username);
                    isEmailValid(email); 
                    return true;
	  
                } else{
                    return false;
                }
            }

            function clearResponseText (){
                document.getElementById("signUpResponseMsg").innerHTML="";
            }