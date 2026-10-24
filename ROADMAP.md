# Roadmapa — Rejestr pracowników XYZ

Ten plik jest planem pracy nad projektem. Odhaczaj zadania dopiero po ich samodzielnym wykonaniu i sprawdzeniu.

> Uwaga: aplikacja ma obecnie moduł `Book`. Jest to dobry CRUD do ćwiczeń, ale docelowo projekt powinien dotyczyć pracowników, ewidencji godzin i komentarzy.

## Docelowy zakres

### Role użytkowników

- `admin` — zarządza kontami, rolami, wszystkimi wpisami godzin i komentarzami.
- `supervisor` — rejestruje oraz poprawia godziny pracy, komentuje wpisy.
- `employee` — widzi własną historię pracy i dodaje komentarze do własnych dni.

### Główna zasada biznesowa

Jeden pracownik może mieć tylko jeden wpis godzin dla konkretnej daty. Wpis można później edytować, ale nie wolno tworzyć duplikatów.

## Milestone 0 — przygotowanie i decyzje

Cel: ustalić zakres przed rozpoczęciem implementacji.

- [ ] Utwórz osobną gałąź Git, np. `feature/worker-registry`.
- [ ] Przyjmij, że pracownik jest użytkownikiem z rolą `employee`.
- [ ] Ustal trzy role: `admin`, `supervisor`, `employee`.
- [ ] Zdecyduj, czy supervisor widzi wszystkich pracowników, czy wyłącznie podległych. Na początek może widzieć wszystkich.
- [ ] Gdy zaczniesz właściwy moduł, odłóż lub usuń trasy, widoki i model `Book`.
- [ ] Zapisz `projekt-opis.md` w kodowaniu UTF-8 (obecnie znaki diakrytyczne są wyświetlane nieprawidłowo).

**Gotowe, gdy:** masz ustalony prosty zakres MVP i nazwy ról.

## Milestone 1 — baza danych

Cel: zaprojektować dane aplikacji.

### Użytkownicy

- [ ] Rozbuduj istniejącą tabelę `users` o kolumnę `role` z wartością domyślną `employee`.
- [ ] Opcjonalnie dodaj `is_active`, aby administrator mógł blokować konto bez jego usuwania.
- [ ] Dostosuj model `User` (`fillable`, casty, relacje).

### Ewidencja godzin: tabela `work_entries`

- [ ] Utwórz migrację oraz model `WorkEntry`.
- [ ] Dodaj `user_id` — pracownik, którego dotyczy wpis.
- [ ] Dodaj `work_date` — data pracy.
- [ ] Dodaj `hours` — liczba godzin, np. `decimal(5,2)`.
- [ ] Dodaj `created_by` — użytkownik/przełożony tworzący wpis.
- [ ] Dodaj `timestamps`.
- [ ] Dodaj unikalny indeks dla `user_id` i `work_date`.

### Komentarze: tabela `work_entry_comments`

- [ ] Utwórz migrację oraz model `WorkEntryComment`.
- [ ] Dodaj `work_entry_id`.
- [ ] Dodaj `user_id` — autora komentarza.
- [ ] Dodaj `content` — treść komentarza.
- [ ] Dodaj `timestamps`.

### Relacje Eloquent

- [ ] `User hasMany WorkEntry`.
- [ ] `WorkEntry belongsTo User` jako pracownik.
- [ ] `WorkEntry belongsTo User` jako autor wpisu (`created_by`).
- [ ] `WorkEntry hasMany WorkEntryComment`.
- [ ] `WorkEntryComment belongsTo User`.
- [ ] `WorkEntryComment belongsTo WorkEntry`.

**Gotowe, gdy:** wykonujesz migracje od zera i możesz utworzyć poprawne testowe dane.

## Milestone 2 — uwierzytelnianie i role

Cel: spełnić wymagania dotyczące logowania i uprawnień.

- [ ] Sprawdź rejestrację, logowanie, wylogowanie i reset hasła.
- [ ] Upewnij się, że hasła są hashowane przez Laravel, nigdy zapisane zwykłym tekstem.
- [ ] Dodaj obsługę pola `role` do modelu `User`.
- [ ] Stwórz middleware dla ról, np. `role:admin` oraz `role:admin,supervisor`.
- [ ] Po zalogowaniu kieruj użytkownika na dashboard odpowiedni dla jego roli.
- [ ] Zabezpiecz trasy po stronie serwera, nie tylko przez ukrywanie linków w menu.

**Gotowe, gdy:** pracownik nie może wejść do panelu administratora po ręcznym wpisaniu adresu URL.

## Milestone 3 — panel administratora (CRUD użytkowników)

Cel: zrealizować obowiązkowy CRUD użytkowników.

- [ ] Lista użytkowników.
- [ ] Wyszukiwanie po imieniu lub adresie e-mail.
- [ ] Widok szczegółów użytkownika.
- [ ] Tworzenie konta pracownika albo supervisora.
- [ ] Edycja imienia, e-maila, roli i statusu konta.
- [ ] Zmiana/reset hasła bez wyświetlania starego hasła.
- [ ] Usuwanie lub — bezpieczniej — dezaktywacja konta.

Walidacja:

- [ ] Imię jest wymagane.
- [ ] E-mail jest wymagany, poprawny i unikalny.
- [ ] Hasło jest wymagane przy tworzeniu, bezpieczne i potwierdzone.
- [ ] Rola może przyjąć wyłącznie dozwoloną wartość.

**Gotowe, gdy:** administrator wykona pełne CRUD kont użytkowników.

## Milestone 4 — rejestrowanie godzin

Cel: supervisor rejestruje czas pracy pracownika.

- [ ] Stwórz formularz: pracownik, data, liczba godzin.
- [ ] Dodaj listę wpisów.
- [ ] Dodaj filtrowanie po pracowniku, miesiącu i dacie.
- [ ] Dodaj edycję wpisu.
- [ ] Dodaj usuwanie wpisu z potwierdzeniem.
- [ ] Dodaj komunikaty sukcesu i błędów.

Walidacja wpisu:

- [ ] Pracownik istnieje i ma rolę `employee`.
- [ ] Data jest prawidłowa.
- [ ] Godziny są liczbą z zakresem, np. `0.25–24`.
- [ ] Nie można utworzyć duplikatu dla pracownika i daty.
- [ ] Osoba bez odpowiedniej roli nie może dodawać, edytować ani usuwać wpisu.

**Gotowe, gdy:** supervisor dodaje i aktualizuje wpisy godzin dla pracowników.

## Milestone 5 — historia pracy pracownika

Cel: pracownik widzi własną ewidencję.

- [ ] Dodaj stronę „Moje godziny”.
- [ ] Wyświetl tabelę: data, dzień tygodnia, liczba godzin i komentarze.
- [ ] Dodaj wybór miesiąca oraz roku.
- [ ] Wyświetl sumę godzin w wybranym miesiącu.
- [ ] Opcjonalnie pokaż liczbę przepracowanych dni.
- [ ] Upewnij się, że pracownik widzi tylko własne dane.
- [ ] Administrator może zobaczyć historię każdego pracownika.

**Gotowe, gdy:** użytkownik `employee` widzi historię własnych dni i godzin w miesiącu.

## Milestone 6 — komentarze do wpisów godzin

Cel: komunikacja na temat konkretnego dnia pracy.

- [ ] Wyświetl komentarze pod wpisem godzin.
- [ ] Pozwól pracownikowi komentować własny wpis.
- [ ] Pozwól supervisorowi i administratorowi komentować każdy wpis.
- [ ] Pozwól autorowi edytować lub usunąć własny komentarz.
- [ ] Pozwól administratorowi moderować wszystkie komentarze.
- [ ] Waliduj treść: wymagana, np. maksimum 1000 znaków.
- [ ] Pokaż autora oraz datę utworzenia komentarza.

**Gotowe, gdy:** pracownik, supervisor i administrator mogą komentować wpisy zgodnie ze swoimi uprawnieniami.

## Milestone 7 — bezpieczeństwo i jakość kodu

Cel: przygotować aplikację na obronę i uniknąć podstawowych błędów.

- [ ] Używaj Eloquent albo Query Buildera z parametrami.
- [ ] Nie składaj ręcznie zapytań SQL z danymi użytkownika.
- [ ] Zamiast `DB::insert()` używaj modeli Eloquent, np. `WorkEntry::create()`.
- [ ] Stwórz osobne klasy `FormRequest` do użytkowników, wpisów godzin i komentarzy.
- [ ] Stwórz Policies dla `WorkEntry` oraz `WorkEntryComment`.
- [ ] Dodaj `@csrf` do każdego formularza.
- [ ] Dla formularzy edycji/usuwania stosuj `@method('PUT')` i `@method('DELETE')`.
- [ ] Sprawdzaj uprawnienia po stronie serwera; nie ufaj ukrytym polom formularza.
- [ ] Dodaj paginację do większych list.
- [ ] Ujednolić komunikaty walidacyjne oraz komunikaty sukcesu.
- [ ] Dodaj podstawowe testy funkcjonalne autoryzacji i walidacji.

**Gotowe, gdy:** uprawnienia są wymuszane na serwerze, a błędne dane nie trafiają do bazy.

## Milestone 8 — funkcje na lepszą ocenę

Cel: spełnić dodatkowe kryteria z opisu projektu.

- [ ] Włącz weryfikację e-maila przez `MustVerifyEmail`.
- [ ] Zabezpiecz wybrane trasy middlewarem `verified`.
- [ ] Skonfiguruj lokalną wysyłkę e-maili, np. Mailpit albo `log` driver.
- [ ] Jeśli dodasz telefon, waliduj go wyrażeniem regularnym.
- [ ] Opcjonalnie: administrator zatwierdza konto przed aktywacją.
- [ ] Opcjonalnie: eksport miesięcznego raportu do CSV/PDF.
- [ ] Opcjonalnie: sortowanie i zaawansowane filtrowanie tabel.
- [ ] Opcjonalnie: przypisanie pracowników do konkretnych supervisorów.

**Gotowe, gdy:** działa weryfikacja e-maila i przynajmniej jedna wartościowa funkcja dodatkowa.

## Milestone 9 — interfejs

Cel: aplikacja jest spójna i czytelna.

- [ ] Stwórz jeden wspólny layout Blade.
- [ ] Zależnie od roli pokazuj inne menu.
- [ ] Dodaj dashboard z najważniejszymi informacjami.
- [ ] Ujednolić tabele, formularze i przyciski.
- [ ] Dodaj potwierdzenia usuwania.
- [ ] Dodaj puste stany, np. „Brak wpisów w tym miesiącu”.
- [ ] Sprawdź podstawową responsywność.
- [ ] Zachowaj jeden język interfejsu — najlepiej polski.

## Milestone 10 — dane demonstracyjne, testy i obrona

Cel: projekt daje się uruchomić i zaprezentować od zera.

- [ ] Stwórz seedery: admin, supervisor i 2–3 pracowników.
- [ ] Dodaj przykładowe wpisy godzin z kilku miesięcy.
- [ ] Dodaj przykładowe komentarze.
- [ ] Przetestuj scenariusz dla każdej roli.
- [ ] Przetestuj błędne formularze i odmowę dostępu.
- [ ] Uruchom projekt od czystej bazy przez `php artisan migrate:fresh --seed`.
- [ ] Uzupełnij README: instalacja, `.env`, migracje, seedery i uruchomienie Vite.
- [ ] Przygotuj demonstrację: logowanie → panel admina → utworzenie pracownika → wpis godzin → widok pracownika → komentarz.
- [ ] Przećwicz prostą zmianę bez Internetu: reguły walidacji, kolumny tabeli, trasy, widoku Blade albo migracji.

## Kolejność pracy

1. Baza danych.
2. Role i autoryzacja.
3. CRUD użytkowników.
4. Rejestrowanie godzin.
5. Historia pracownika.
6. Komentarze.
7. Bezpieczeństwo i testy.
8. E-mail oraz funkcje dodatkowe.
9. Interfejs, seedery i przygotowanie do obrony.

Nie zaczynaj od wyglądu. Najpierw upewnij się, że cały przepływ biznesowy działa poprawnie.

## Aktualny stan projektu (24 października 2026)

- [x] Dodano kolumnę `role` do migracji tworzącej tabelę `users`.
- [x] Wygenerowano szkielet `WorkEntry`: model, migrację i kontroler resource.
- [x] Wygenerowano szkielet `WorkEntryComment`: model, migrację i kontroler resource.
- [ ] Uzupełnij kolumny i ograniczenia w obu nowych migracjach.
- [ ] Uzupełnij `$fillable`, casty i relacje w modelach `User`, `WorkEntry` oraz `WorkEntryComment`.
- [ ] Wykonaj migracje dopiero po uzupełnieniu ich schematu.

Szczegółowe wyjaśnienie tych kroków znajduje się w `my-questions.md`.
