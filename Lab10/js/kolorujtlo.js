// Zmienna globalna wskazująca, czy obliczenia zostały wykonane
var computed = false;

// Zmienna globalna kontrolująca wprowadzenie kropki dziesiętnej
var decimal = 0;

// Funkcja przeprowadza konwersję jednostek na podstawie wybranych opcji.
function convert(entryform, from, to) {
    var convertfrom = from.selectedIndex; // Indeks wybranej jednostki wejściowej
    var convertto = to.selectedIndex;     // Indeks wybranej jednostki wyjściowej
    // Obliczenie wartości wyjściowej
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

// Funkcja dodaje znak do wartości wejściowej oraz przeprowadza automatyczną konwersję jednostek.
function addChar(input, character) {
    if ((character == "." && decimal == "0") || character != ".") {
        // Dodanie znaku do pola wejściowego
        input.value == "" || input.value == "0" ? input.value = character : input.value += character;
        // Automatyczna konwersja jednostek
        convert(input.form, input.form.measure1, input.form.measure2);
        computed = true;

        // Ustawienie flagi kropki dziesiętnej
        if (character == ".") {
            decimal = 1;
        }
    }
}

// Funkcja otwiera nowe okno przeglądarki.
function openVothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

// Funkcja resetuje wartości wejściowe i wyjściowe formularza oraz flagę dziesiętnej.
function clear(form) {
    form.input.value = 0;    // Ustawienie wartości wejściowej na 0
    form.display.value = 0;  // Ustawienie wartości wyjściowej na 0
    decimal = 0;             // Reset flagi dziesiętnej
}

// Funkcja zmienia kolor tła strony.
function changeBackground(hexNumber) {
    document.body.style.backgroundColor = hexNumber; // Zastosowanie koloru tła
}

// Funkcja zmienia kolor tła przycisku.
function changeColor(button, color) {
    button.style.backgroundColor = color; // Zastosowanie nowego koloru tła
}
