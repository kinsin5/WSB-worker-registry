- PHP >= 8.2.12 with the `zip` extension enabled
- npm >= 10.9.2
- Composer >= 2.10.3
- Git



### installing after git clone
```ps
git clone https://github.com/kinsin5/WSB-worker-registry.git
cd WSB-worker-registry
composer install
npm install
copy .env.example .env
php artisan key:generate
```

### Running it

php artisan serve

### Errors

#### php ZIP

### Enable the PHP ZIP extension (XAMPP on Windows)

Composer uses the PHP CLI configuration shown in its error output. Open that
`php.ini` file, find `;extension=zip`, and remove the leading semicolon so it
reads `extension=zip`. Save the file, then open a new terminal and verify that
the CLI has loaded ZIP:

```powershell
php -m | findstr /i zip