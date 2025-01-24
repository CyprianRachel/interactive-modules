# Interactive Modules API

Interaktywne API oparte na Laravelu, zaprojektowane do definiowania i generowania wielokrotnego użytku komponentów HTML, CSS i JavaScript. Projekt wykorzystuje Dockera do konteneryzacji, co ułatwia jego uruchamianie i wdrażanie.

## Funkcjonalności

- **Definiowanie interaktywnych modułów** z opcjami personalizacji: wymiary, kolory, odnośniki (linki).
- **Generowanie modułów** w formie pliku ZIP zawierającego:
  - `index.html`: Struktura modułu.
  - `styles.css`: Style dostosowane do danych wejściowych.
  - `script.js`: JavaScript odpowiadający za interaktywne zachowanie.
- **Środowisko Docker** zapewniające prostą konfigurację i uruchamianie projektu.

---

## Endpointy

### 1. **POST /modules**
Tworzy nowy moduł i zapisuje jego definicję w bazie danych.

#### Przykładowe zapytanie:
```json
{
  "width": 300,
  "height": 200,
  "color": "yellow",
  "link": "https://appverk.com"
}
```

#### Przykładowa odpowiedź:
```json
{
  "id": 1
}
```

---

### 2. **GET /modules/{id}/download**
Pobiera plik ZIP zawierający `index.html`, `styles.css` i `script.js` dla danego modułu.

#### Przykład:
- **URL**: `http://localhost:8080/modules/1/download`
- Plik ZIP zawiera:
  ```
  module_1.zip
  ├── index.html
  ├── styles.css
  └── script.js
  ```

---

## Szybki start

### Wymagania wstępne
- Zainstalowany Docker i Docker Compose.
- Opcjonalnie: Composer (do lokalnego uruchamiania bez Dockera).

### Instrukcja uruchomienia

1. Sklonuj repozytorium:
   ```bash
   git clone https://github.com/CyprianRachel/interactive-modules.git
   cd interactive-modules
   ```

2. Uruchom kontenery Dockera:
   ```bash
   docker-compose up -d
   ```

3. Wykonaj migracje bazy danych:
   ```bash
   docker-compose exec app php artisan migrate
   ```

4. Uzyskaj dostęp do aplikacji:
   - Pobieranie modułów: `http://localhost:8080/api/modules/{id}/download`

---

## Stos technologiczny

- **Backend**: Laravel 11 (PHP 8.2)
- **Baza danych**: MySQL 8.0
- **Konteneryzacja**: Docker i Docker Compose
- **Frontend (pliki wygenerowane)**: HTML, CSS, JavaScript

---

## Struktura katalogów

```plaintext
interactive-modules/
├── app/                 # Logika aplikacji (Modele, Kontrolery)
├── database/            # Migracje i seedy
├── docker/              # Pliki konfiguracji Dockera
├── public/              # Pliki publiczne (index.php, assets)
├── resources/views/     # Szablony Blade dla modułów
├── routes/              # Definicje tras (web.php)
├── storage/             # Logi, pliki tymczasowe, cache
└── tests/               # Testy jednostkowe i funkcjonalne
```

---

## Zawartość przykładowego pliku ZIP

Po wywołaniu endpointu `/modules/{id}/download`, wygenerowany ZIP zawiera:

1. **index.html**
   ```html
   <!DOCTYPE html>
   <html>
   <head>
       <meta charset="utf-8">
       <title>Module 1</title>
       <link rel="stylesheet" href="styles.css">
   </head>
   <body>
       <div id="my-module">Kliknij mnie, aby przejść do: https://appverk.com/</div>
       <script src="script.js"></script>
   </body>
   </html>
   ```

2. **styles.css**
   ```css
   #my-module {
       width: 300px;
       height: 200px;
       background-color: yellow;
       display: flex;
       align-items: center;
       justify-content: center;
       cursor: pointer;
       color: #fff;
   }
   ```

3. **script.js**
   ```javascript
   document.addEventListener('DOMContentLoaded', function() {
       var moduleDiv = document.getElementById('my-module');
       moduleDiv.addEventListener('click', function() {
           window.open('https://appverk.com/', '_blank');
       });
   });
   ```

---

## Testowanie aplikacji

Do testowania API wykorzystano narzędzie **Thunder Client** wbudowane w VS Code. Poniżej znajdziesz przykładowy proces testowania:

1. **Testowanie POST /api/modules**:
   - W Thunder Client utwórz nowe zapytanie typu POST.
   - Ustaw URL na: `http://localhost:8080/api/modules`.
   - W sekcji Body ustaw format JSON i wprowadź przykładowe dane:
     ```json
     {
       "width": 300,
       "height": 200,
       "color": "blue",
       "link": "https://example.com"
     }
     ```
   - Sprawdź odpowiedź JSON z ID nowo utworzonego modułu.

2. **Testowanie GET /api/modules/{id}/download**:
   - W Thunder Client utwórz nowe zapytanie typu GET.
   - Ustaw URL na: `http://localhost:8080/api/modules/1/download` (gdzie `1` to ID modułu).
   - Pobierz plik ZIP i sprawdź jego zawartość.

---

## Propozycje ulepszeń

1. **Autoryzacja użytkowników**:
   Dodaj obsługę kont użytkowników i wymagaj autoryzacji do zarządzania modułami.

2. **Podgląd modułów**:
   Utwórz endpoint pozwalający na dynamiczny podgląd modułu w przeglądarce bez pobierania ZIP-a.

3. **Frontendowy dashboard**:
   Zbuduj prosty interfejs użytkownika (np. w Vue.js lub React) do zarządzania modułami.

4. **Obsługa tematów**:
   Dodaj wsparcie dla predefiniowanych tematów lub szablonów modułów.

5. **Automatyczne testy**:
   Napisz testy jednostkowe i funkcjonalne, aby zweryfikować poprawność działania endpointów i generowania ZIP.

---

## Jak wyróżnić się na tle innych kandydatów?

1. **Testy jednostkowe i funkcjonalne**:
   Dodaj testy, które sprawdzają działanie endpointów i poprawność generowanych plików ZIP.

2. **Czytelny kod**:
   Używaj komentarzy, czytelnych nazw zmiennych i funkcji, oraz podziel logikę na mniejsze, łatwiejsze do zarządzania części.

3. **Dokumentacja**:
   Przejrzysta dokumentacja (README.md) z instrukcjami instalacji, przykładami i opisem funkcjonalności zrobi wrażenie na rekruterach.

4. **Prezentacja wizualna**:
   Dodaj zrzuty ekranu lub GIF-y pokazujące działanie aplikacji (np. pobieranie ZIP-a, podgląd modułu).

5. **Dodatkowe funkcje**:
   Wdroż takie rzeczy, jak podgląd modułów w czasie rzeczywistym lub dynamiczne generowanie przykładowych szablonów.

---

Dzięki tym krokom Twój projekt będzie wyróżniał się profesjonalizmem i dopracowaniem! Powodzenia! 🚀




