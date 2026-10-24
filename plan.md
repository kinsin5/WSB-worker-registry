1. w jaki sposob dostosowac model? - [ ] Dostosuj model `User` (`fillable`, casty, relacje).
2. Utworzylem model za pomoca php artisan make:model  WorkEntry -mcr
    ### Ewidencja godzin: tabela `work_entries`

    - [ ] Utwórz migrację oraz model `WorkEntry`.
    - [ ] Dodaj `user_id` — pracownik, którego dotyczy wpis.
    - [ ] Dodaj `work_date` — data pracy.
    - [ ] Dodaj `hours` — liczba godzin, np. `decimal(5,2)`.
    - [ ] Dodaj `created_by` — użytkownik/przełożony tworzący wpis.
    - [ ] Dodaj `timestamps`.
    - [ ] Dodaj unikalny indeks dla `user_id` i `work_date`.

Gdzie mam dodac te rzeczy normalnie bym dodal tylko migracji ten schemat danych ale wydaje mi sie ze powinnen rowniez umiescic je w modelu

3. To samo pytanie dla WorkEntryComment

I co to znaczy?

W jaki sposob mam zrobic te rzeczy?

---

# Odpowiedzi

## 1. Jak dostosować model `User`?

Model nie tworzy kolumn w bazie — za to odpowiada **migracja**. Model opisuje natomiast, jak Laravel może pracować z danymi i relacjami.

Masz już kolumnę `role` w migracji `users`. Następny krok to model `app/Models/User.php`.

### `fillable`

Do tablicy `$fillable` dodaj `role`:

```php
protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];
```

`$fillable` jest listą pól, które mogą być masowo zapisywane np. przez `User::create($validated)`. Nie dodawaj do formularza publicznej rejestracji pola `role`; nowy użytkownik powinien otrzymać domyślną rolę `employee` z migracji. Rolę zmienia wyłącznie administrator.

### `casts`

Obecne casty są wystarczające. `password => hashed` sprawia, że Laravel zahashuje hasło podczas przypisania do modelu. Gdy w przyszłości dodasz `is_active`, dopisz:

```php
'is_active' => 'boolean',
```

### Relacje

Dodaj import na początku pliku:

```php
use App\Models\WorkEntry;
use App\Models\WorkEntryComment;
```

Następnie, wewnątrz klasy `User`, dodaj metody:

```php
public function workEntries()
{
    return $this->hasMany(WorkEntry::class, 'user_id');
}

public function createdWorkEntries()
{
    return $this->hasMany(WorkEntry::class, 'created_by');
}

public function workEntryComments()
{
    return $this->hasMany(WorkEntryComment::class);
}
```

Znaczenie:

- `workEntries()` — godziny, które należą do pracownika;
- `createdWorkEntries()` — godziny, które ten użytkownik wpisał jako supervisor/admin;
- `workEntryComments()` — komentarze napisane przez użytkownika.

Nie wprowadzaj tych metod, dopóki modele `WorkEntry` i `WorkEntryComment` nie istnieją — u Ciebie już istnieją, więc możesz je dodać po uzupełnieniu migracji.

## 2. Gdzie dodać pola dla `WorkEntry`?

Podział odpowiedzialności jest taki:

| Miejsce | Co umieszczasz |
| --- | --- |
| Migracja | Kolumny, typy danych, klucze obce, indeksy i ograniczenia bazy. |
| Model | `$fillable`, `$casts` oraz relacje Eloquent. |
| Kontroler/FormRequest | Walidację danych z formularza oraz zapis rekordu. |
| Blade view | Formularz i wyświetlanie danych. |

`php artisan make:model WorkEntry -mcr` zrobiło dokładnie to, co trzeba na start: model, migrację i kontroler resource. Teraz uzupełniasz każdy z tych plików.

### A. Migracja `create_work_entries_table`

W metodzie `up()` dodaj pola **zamiast obecnego samego `id()` i `timestamps()`**:

```php
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->date('work_date');
$table->decimal('hours', 5, 2);
$table->foreignId('created_by')->constrained('users')->restrictOnDelete();
$table->timestamps();

$table->unique(['user_id', 'work_date']);
```

Znaczenie:

- `user_id` wskazuje pracownika, którego dotyczy wpis;
- `created_by` wskazuje osobę, która wpisała godziny;
- `constrained()` tworzy klucz obcy do tabeli `users`;
- `unique(['user_id', 'work_date'])` blokuje dwa wpisy dla tego samego pracownika i dnia;
- `decimal(5, 2)` pozwala np. na `8.00`, `7.50` albo maksymalnie `999.99`.

`timestamps()` dodajesz **tylko w migracji**, nie do modelu. Tworzy ono kolumny `created_at` i `updated_at`, a Eloquent obsługuje je automatycznie.

### B. Model `app/Models/WorkEntry.php`

Dodaj importy:

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
```

W klasie ustaw pola, casty i relacje:

```php
protected $fillable = [
    'user_id',
    'work_date',
    'hours',
    'created_by',
];

protected function casts(): array
{
    return [
        'work_date' => 'date',
        'hours' => 'decimal:2',
    ];
}

public function employee(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}

public function creator(): BelongsTo
{
    return $this->belongsTo(User::class, 'created_by');
}

public function comments(): HasMany
{
    return $this->hasMany(WorkEntryComment::class);
}
```

Nie musisz importować `User` i `WorkEntryComment`, ponieważ są w tym samym namespace `App\Models`.

### C. Kontroler

Kontroler `WorkEntryController` jest na razie pustym szkieletem. Dopiero w milestone 4 dodasz w metodzie `store()` walidację, np. daty i godzin, a potem utworzysz rekord. `created_by` nie powinno pochodzić z formularza — ustawisz je po stronie serwera na ID zalogowanego użytkownika.

## 3. To samo dla `WorkEntryComment`

Tak samo: migracja przechowuje dane, model opisuje relacje, a kontroler później waliduje i zapisuje formularz.

### A. Migracja `create_work_entry_comments_table`

W metodzie `up()` wpisz:

```php
$table->id();
$table->foreignId('work_entry_id')->constrained()->cascadeOnDelete();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->text('content');
$table->timestamps();
```

Usunięcie wpisu godzin usunie jego komentarze. Komentarz ma autora (`user_id`) i należy do konkretnego wpisu (`work_entry_id`).

### B. Model `app/Models/WorkEntryComment.php`

Dodaj import:

```php
use Illuminate\Database\Eloquent\Relations\BelongsTo;
```

W klasie dodaj:

```php
protected $fillable = [
    'work_entry_id',
    'user_id',
    'content',
];

public function workEntry(): BelongsTo
{
    return $this->belongsTo(WorkEntry::class);
}

public function author(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}
```

W kontrolerze `user_id` również ustawisz po stronie serwera z zalogowanego użytkownika, a nie z ukrytego pola formularza.

## Ważne: migracje już wykonane a zmiana pliku migracji

Jeżeli **nie uruchomiłeś jeszcze** `php artisan migrate`, możesz bezpiecznie edytować dwie nowe migracje, a potem uruchomić:

```powershell
php artisan migrate
```

Jeżeli migracje były już uruchomione, sama edycja starego pliku migracji **nie zmieni tabeli w bazie**. W środowisku lokalnym, bez ważnych danych, możesz użyć:

```powershell
php artisan migrate:fresh
```

To usuwa wszystkie tabele i tworzy je od nowa, więc nie używaj tej komendy na danych, których nie chcesz stracić. Alternatywą jest utworzenie nowej migracji dodającej brakujące kolumny.

## Kolejny mały krok

1. Uzupełnij obie migracje.
2. Uzupełnij oba modele i relacje w `User`.
3. Wykonaj migracje.
4. Dopiero potem przejdź do tras, formularzy i metod kontrolerów.

