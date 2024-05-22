function verificarAcceso(){
    //obtener el usuario y la contraseña ingresados por el usuario
    let usuario=document.getElementById("usuario").value;
    let contrasena=document.getElementById("contrasena").value;

    //verificar las credenciales
    if(usuario === "Castolo"&& contrasena === "1432"){
        document.getElementById("resultado").textContent="¡Bienvenido! Has iniciado sesión correctamente";
        //redirigir al uruario a otra pagina si ha iniciado sesión correctamente
        window.location.href="index.html";
    }else{
        document.getElementById("resultado").textContent="Credenciales incorrectas. por favor, intenta de nuevo";
    }
}