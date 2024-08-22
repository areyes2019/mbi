function showAlert() {
    var message = "Accions realizada con exito";
    var alertElement = document.getElementById('customAlert');
    alertElement.innerText = message; // Cambiar el texto del alert
    alertElement.style.bottom = '20px'; // Mueve el alert hacia arriba
    alertElement.style.opacity = '1'; // Hace el alert visible

    setTimeout(function() {
      alertElement.style.bottom = '-100px'; // Mueve el alert hacia abajo
      alertElement.style.opacity = '0'; // Oculta el alert
    }, 4000);
}