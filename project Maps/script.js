
// script.js
var successMessage = document.querySelector('.success-message');
if (successMessage) {
    setTimeout(function() {
        successMessage.classList.add('show');
    }, 100);
}

function getGeolocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocatie wordt niet ondersteund door deze browser.");
    }
}

function showPosition(position) {
    document.getElementById("breedtegraad").value = position.coords.latitude;
    document.getElementById("lengtegraad").value = position.coords.longitude;

    document.getElementById("locatie-melding").innerHTML = "Locatie succesvol gedeeld!";
    document.getElementById("locatie-melding").style.color = "green";
}

function showError(error) {
    var errorMessage = "Er is een fout opgetreden bij het verkrijgen van de locatie: ";
    switch (error.code) {
        case error.PERMISSION_DENIED:
            errorMessage += "Gebruiker heeft de locatie-toestemming geweigerd.";
            break;
        case error.POSITION_UNAVAILABLE:
            errorMessage += "Locatie-informatie is niet beschikbaar.";
            break;
        case error.TIMEOUT:
            errorMessage += "Het verkrijgen van locatie-informatie duurde te lang.";
            break;
        case error.UNKNOWN_ERROR:
            errorMessage += "Er is een onbekende fout opgetreden.";
            break;
    }
    alert(errorMessage);
}

