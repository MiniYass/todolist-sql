function createCookie(name, value, days) { 
    let expires; 
      
    if (days) { 
        let date = new Date(); 
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); 
        expires = "; expires=" + date.toGMTString(); 
    } 
    else { 
        expires = ""; 
    }    
        document.cookie = escape(name) + "=" +  
        escape(value) + expires + "; path=/"; 
}   

function checkArchi(idPhp){
    let idJs=idPhp;
    let checkToarch = document.getElementById(`${idPhp}`);

    if (checkToarch.checked === true){
       
        $(document).ready(function () { 
            createCookie("idone", idJs, "1"); 
        });     
    }
    window.location='/todo/gotodone.php';
}

function checkAfr(idPhp){
    let idJs=idPhp;
    let checkTofr= document.getElementById(`${idPhp}`);

    if (checkTofr.checked === false){
        $(document).ready(function () { 
            createCookie("idoit", idJs, "1"); 
        }); 
    
    }
    window.location='/todo/gotodoit.php'; 
}
document.getElementById("addDone").style.display="none";