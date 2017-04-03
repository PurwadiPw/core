PW Core
===================

Ini adalah package core pembantu untuk mempercepat dan mempermudah development aplikasi.

Installation
------------------
Mulailah dengan menginstal package melalui Composer.

```
composer require pw/core
```

Jika proses diatas sudah selesai, tambahkan class Service Provider dan Facade ke project anda pada file `config/app.php`

#### Service Provider

```php
Pw\Core\CoreServiceProvider::class,
Pw\Core\ThemesServiceProvider::class,
```

#### Facade

```php
'Module' => Pw\Core\Facades\Module::class,
'Theme' => Pw\Core\Facades\Theme::class,
```

Itu dia core siap di pakai, silahkan seruput sejenak kopi anda dan mulailah berkreasi.
