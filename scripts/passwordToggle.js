document.getElementById("passImageLog").addEventListener("click", function(){
    let imgPass = document.getElementById("passImageLog");
    let passwordLog = document.getElementById("passwordLogin");
    if(passwordLog.type == "password"){
        passwordLog.type = "text";
        imgPass.src = "../images/showPass.png";
    }else{
        passwordLog.type = "password";
        imgPass.src = "../images/hidePass.png";
    }
});

document.getElementById("passImageReg").addEventListener("click", function(){
    let imgPass = document.getElementById("passImageReg");
    let passwordReg = document.getElementById("passReg");
    let passwordConfirmReg = document.getElementById("confirmPassReg");

    if(passwordReg.type == "password"){
        passwordReg.type = "text";
        passwordConfirmReg.type = "text";
        imgPass.src = "../images/showPass.png";
    }else{
        passwordReg.type = "password";
        passwordConfirmReg.type = "password";
        imgPass.src = "../images/hidePass.png";
    }
});