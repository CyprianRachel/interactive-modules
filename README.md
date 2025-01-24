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
  "color": "orange",
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

### Instrukcja uruchamiania

1. Sklonuj repozytorium:
   ```bash
   git clone https://github.com/CyprianRachel/interactive-modules.git
   cd interactive-modules
   ```

2. Utwórz plik `.env` z konfiguracją bazy danych:
   ```bash
   cp .env.example .env
   ```

   Upewnij się, że plik `.env` zawiera poprawne dane do logowania do bazy danych:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=laravel_db
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=laravel
   DB_PASSWORD=secret
   ```

3. Uruchom kontenery Dockera:
   ```bash
   docker-compose up -d
   ```

4. Zainstaluj zależności Composer:
   ```bash
   docker-compose exec app composer install
   ```

5. Wygeneruj klucz aplikacji:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. Wykonaj migracje bazy danych:
   ```bash
   docker-compose exec app php artisan migrate
   ```

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
       background-color: orange;
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

1. **Testowanie POST /modules**:
   - W Thunder Client utwórz nowe zapytanie typu POST.
   - Ustaw URL na: `http://localhost:8080/modules`.
   - W sekcji Body ustaw format JSON i wprowadź przykładowe dane:
     ```json
     {
       "width": 300,
       "height": 200,
       "color": "orange",
       "link": "https://appverk.com/"
     }
     ```
   - Sprawdź odpowiedź JSON z ID nowo utworzonego modułu.

2. **Testowanie GET /modules/{id}/download**:
   - W Thunder Client utwórz nowe zapytanie typu GET.
   - Ustaw URL na: `http://localhost:8080/modules/1/download` (gdzie `1` to ID modułu).
   - Pobierz plik ZIP i sprawdź jego zawartość.

---

