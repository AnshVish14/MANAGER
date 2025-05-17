function logout() {
    var confirmlogout = confirm("Are you sure you want to logout?");
    if (confirmlogout){
        sessionStorage.clear();
        window.location.href = "\IMP.html";
    }
    else{
        window.location.href = "\a1.html";
    }
}