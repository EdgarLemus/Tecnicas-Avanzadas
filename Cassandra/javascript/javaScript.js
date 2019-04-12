function sendMsm(usuario) {
    var msj = document.getElementById("Mensaje").value;
   
    location.href = "http://localhost/tecnicas%20avanzadas/home.php?usuario="+usuario+ "&msj=" + msj;
}