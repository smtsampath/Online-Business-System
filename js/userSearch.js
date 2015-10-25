String.prototype.trim = function() {
        a = this.replace(/^\s+/, '');
        return a.replace(/\s+$/, '');
    };

	function hasWhiteSpace(s) {
		return s.indexOf(' ') >= 0;
	}
			
	function isUsernameValid(username){ 
		if(hasWhiteSpace(username)){  
			return false;
		} else{
			return true;	
		}
	}
			
	function isEmailHasValidFormat(s) {
		var emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
		return emailRegexStr.test(s) ;
	}
	
	function isTPNumberValid(tpNumber){ 
		var phoneRegex = /^\d{10}$/ ;
		 
		if (tpNumber.match(phoneRegex)  ) { 
			return true;
		} else { 
			return false;
		}
 
	}
	 
	function isSearchTermValid(searchTerm){
		clearResults();
		searchOption  = document.getElementById("searchOptions").value;
		if(searchTerm != ""){
			if(searchOption == "Username"){
				if(isUsernameValid(searchTerm)){
					 document.getElementById("searchFieldValidateMsg").innerHTML="<font color=green>Valid</font>";
					 return true;	
				}else{
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=red>Remove white spaces in username</font>";
					return false;	
				}
			}else if(searchOption == "Email"){
				if(isEmailHasValidFormat(searchTerm)){
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=green>Valid</font>";
					return true;
				}else{
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=red>Invalid</font>";
					return false;	
				}
			}else if(searchOption == "Contact Number"){
				if(isTPNumberValid(searchTerm)){
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=green>Valid</font>";
					return true;
				}else{
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=red>Invalid</font>";
					return false;	
				}	
			}else if(searchOption == "Gender"){
				if(searchTerm == "Male" || searchTerm == "Female" ){
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=green>Valid</font>";
					return true;
				}else{
					document.getElementById("searchFieldValidateMsg").innerHTML="<font color=red>Type Male or Female to search by gender</font>";		
					return false;	
				}
			}else{
				document.getElementById("searchFieldValidateMsg").innerHTML="<font color=green>Valid</font>";
				return true;		
			}
		}else{
			document.getElementById("searchFieldValidateMsg").innerHTML="<font color=red>Search field is required</font>";
			return false;	
		}
	}
	
    function validateSearchForm(){
        searchTxt  = document.getElementById("searchField").value;
        if(isSearchTermValid(searchTxt)){
            return true;
        }else{
            
            return false;
        }
	
    }
	
	function clearResults(){ 
		document.getElementById("searchFieldMsg").innerHTML="";
	}