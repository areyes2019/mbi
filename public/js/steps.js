let currentStep = 0;
const steps = document.querySelectorAll(".step");
const circles = document.querySelectorAll(".step-indicator .circle");

function showStep(step) {
    steps.forEach((s, index) => {
        s.classList.toggle("active", index === step);
    });
    circles.forEach((c, index) => {
        c.classList.toggle("active", index === step);
    });
    document.getElementById("prev-btn").disabled = step === 0;
    document.getElementById("next-btn").style.display = step === steps.length - 1 ? 'none' : 'inline-block';
    document.getElementById("submit-btn").style.display = step === steps.length - 1 ? 'inline-block' : 'none';

    if (step === steps.length - 1) {
        document.getElementById("resumen-nombre").textContent = document.getElementById("nombre").value;
        document.getElementById("resumen-apellido").textContent = document.getElementById("apellido").value;
        document.getElementById("resumen-email").textContent = document.getElementById("email").value;
        document.getElementById("resumen-telefono").textContent = document.getElementById("telefono").value;
    }
}

function changeStep(stepChange) {
    currentStep += stepChange;
    showStep(currentStep);
}

document.getElementById("multi-step-form").addEventListener("submit", function(event) {
    alert("Formulario enviado con éxito");
    event.preventDefault();
});

showStep(currentStep);