function showButtonSubmit(){
    let chkbx = document.getElementById("confirmCheckbox");
    let btn = document.getElementById("submitInfo");
  
    if(chkbx.checked){
        btn.disabled =false;
    }else{
        btn.disabled =true;
    }
}

document.getElementById('timeServiceForm').addEventListener('submit', function(e) {
    var confirmation = confirm('Are you sure? Do you want to submit this form?');
    if (!confirmation) {
      e.preventDefault();
    }
});
