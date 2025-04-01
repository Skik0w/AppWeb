// Funkcja pobiera i wyświetla bieżącą datę w formacie MM/DD/YY.
function gettheDate() {
    var Todays = new Date(); // Obiekt z aktualną datą
    var TheDate = "" + (Todays.getMonth() + 1) + "/" + Todays.getDate() + "/" + (Todays.getYear() - 100);
    document.getElementById("data").innerHTML = TheDate; // Wyświetlenie daty w elemencie o ID "data"
}

// Zmienna do przechowywania identyfikatora timera
var timerID = null;

// Flaga wskazująca, czy zegar działa
var timerRunning = false;

// Funkcja zatrzymuje zegar, jeśli jest uruchomiony.
function stopclock() {
    if (timerRunning) {
        clearTimeout(timerID); // Wyczyszczenie bieżącego timera
    }
    timerRunning = false; // Aktualizacja flagi
}

// Funkcja uruchamia zegar, wyświetla datę i godzinę oraz inicjuje zmianę koloru.
function startclock() {
    stopclock(); // Zatrzymanie ewentualnie działającego zegara
    gettheDate(); // Wyświetlenie bieżącej daty
    showtime(); // Rozpoczęcie wyświetlania godziny
    changeTimeColor(); // Inicjalizacja zmiany koloru
}

// Funkcja wyświetla bieżący czas w formacie hh:mm:ss AM/PM i aktualizuje go co sekundę.
function showtime() {
    var now = new Date(); // Obiekt z aktualnym czasem
    var hours = now.getHours(); // Bieżąca godzina
    var minutes = now.getMinutes(); // Bieżąca minuta
    var seconds = now.getSeconds(); // Bieżąca sekunda

    // Formatowanie godziny do 12-godzinnego formatu
    var timeValue = "" + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ":0" : ":") + minutes;
    timeValue += ((seconds < 10) ? ":0" : ":") + seconds;
    timeValue += (hours >= 12) ? " P.M." : " A.M.";

    // Wyświetlenie czasu w elemencie o ID "zegarek"
    document.getElementById("zegarek").innerHTML = timeValue;

    // Ustawienie timera do aktualizacji czasu
    timerID = setTimeout("showtime()", 1000);
    timerRunning = true; // Flaga wskazująca, że zegar działa
}

// Funkcja zmienia kolor tekstu wyświetlającego datę i czas na losowy co sekundę.
function changeTimeColor() {
    var colors = ['#deb887', '#FFFF00', '#000000', '#FFFFFF', '#00FF00', '#0000FF', '#FF8000', '#c0c0c0', '#FF0000'];
    var randomColor = colors[Math.floor(Math.random() * colors.length)]; // Losowy wybór koloru

    // Zastosowanie losowego koloru do elementów "data" i "zegarek"
    document.getElementById("data").style.color = randomColor;
    document.getElementById("zegarek").style.color = randomColor;

    // Ustawienie timera do ponownej zmiany koloru
    setTimeout(changeTimeColor, 1000);
}
