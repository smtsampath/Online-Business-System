    String.prototype.trim = function() {
        a = this.replace(/^\s+/, '');
        return a.replace(/\s+$/, '');
    };

    function clearMsg(){
        document.getElementById("projectDescriptionMsg").innerHTML="";
        document.getElementById("projectUploadMsg").innerHTML="";
		document.getElementById("projectTitleMsg").innerHTML="";
    }

    function isProjectTitleValid(title){
        if(title == ""){
            document.getElementById("projectTitleMsg").innerHTML="<font color=red>Title is required</font>";
            return false;
        }else{
            if(title.length > 10){
                document.getElementById("projectTitleMsg").innerHTML="<font color=green>Valid</font>";
                return true;
            }else{
                document.getElementById("projectTitleMsg").innerHTML="<font color=red>Title should have atleast 10 characters</font>";
                return false;
            }
        }
    }

    function isProjectDescriptionValid(description){
        if(description == ""){
            document.getElementById("projectDescriptionMsg").innerHTML="<font color=red>Description is required</font>";
            return false;
        }else{
            if(description.length > 50){
                document.getElementById("projectDescriptionMsg").innerHTML="<font color=green>Valid</font>";
                return true;
            }else{
                document.getElementById("projectDescriptionMsg").innerHTML="<font color=red>Description should have atleast 50 characters</font>";
                return false;
            }
        }
    }

    function validateForm(){
        projectTitle = document.getElementById("projectTitle").value;
	 	projectDescription = document.getElementById("projectDescription").value;
        if(isProjectTitleValid(projectTitle) && isProjectDescriptionValid(projectDescription)){
            return true;
        }else{
            return false;
        }
    }
	
	function ConfirmDelete() {
	  var confm = window.confirm("Are you sure want to delete this file !");
	   
	  if(confm == true) {
		 
		return true;
	  } else {
		  return false;
	  }
	}