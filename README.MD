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
Pw\Core\TranslatableServiceProvider::class,
```

#### Facade

```php
'Module' => Pw\Core\Facades\Module::class,
'Theme' => Pw\Core\Facades\Theme::class,
```

Tambahkan juga middleware pada file `app/Http/Kernel.php`

#### Middleware

```php
protected $middlewareGroups = [
    'web' => [
        ...
        \Pw\Core\Middleware\Language::class,
    ],
];
```

Setelah menambahkan `Service Provider`, `Facade`, dan juga `Middleware` jalankan script.

#### Publish Vendor Files

```
php artisan vendor:publish
```

Jika sudah sudah berhasil mem-publish file vendor, silahkan ubah namespace model Role dan Permission pada file `config/entrust.php`.

#### Config

```php
'role' => 'App\Role',
'permission' => 'App\Permission',
``` 
menjadi

```php
'role' => 'App\Models\Role',
'permission' => 'App\Models\Permission',
``` 

Dan juga silahkan sesuaikan pengaturan yang lainnya.

Jika selesai langkah diatas, selanjutnya install core. Eksekusi script dibawah dan ikuti langkah.

#### Install Core

```
php artisan core:install
```

Itu dia core siap di pakai, silahkan seruput sejenak kopi anda dan mulailah berkreasi.
