window.addEventListener("load", function(){
    let rightS = document.getElementById("right");
    const newImg = document.createElement("img");
    newImg.src = "../images/heroClinic.png";
    newImg.id = "rightPic";
    newImg.className = "heroClinicImg";
    document.getElementById("right").insertBefore(newImg, rightS.firstChild);
});