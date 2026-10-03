- PHP >= 8.2.12 with the `zip` extension enabled
- npm >= 10.9.2
- Composer >= 2.10.3
- Git

### Enable the PHP ZIP extension (XAMPP on Windows)

Composer uses the PHP CLI configuration shown in its error output. Open that
`php.ini` file, find `;extension=zip`, and remove the leading semicolon so it
reads `extension=zip`. Save the file, then open a new terminal and verify that
the CLI has loaded ZIP:

```powershell
php -m | findstr /i zip
```

Retry `composer create-project` after `zip` appears in the output.

### instaling
composer create-project --prefer-dist laravel/laravel:^12.* worker-registry