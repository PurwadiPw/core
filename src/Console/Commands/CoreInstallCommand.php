<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 12/03/17
 * Time: 8:45
 */

namespace Pw\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Pw\Core\Helpers\CoreHelper;
use Eloquent;
use DB;

class CoreInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'core:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menginstall Core Package. Generate seluruh struktur untuk /admin';

    protected $from;
    protected $to;

    var $modelsInstalled = ["User", "Role", "Permission", "Employee", "Department", "Upload", "Organization", "Backup"];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        try{
            $this->info('Memulai instalasi Core...');

            //$from = base_path('vendor/pw/core/src/Installs');
            $from = base_path('packages/pw/core/src/Installs');
            $to = base_path();

            $this->info('dari: '.$from." ke: ".$to);
            $this->line("\nPengaturan Database:");
            if ($this->confirm('Apakah anda ingin mengatur konfigurasi database di file .env ?')){
                $this->line("Pengaturan Database dimulai....");

                $db_data = [];

                if (CoreHelper::laravel_ver() == 5.4){
                    $db_data['host'] = $this->ask('Database Host', '127.0.0.1');
                    $db_data['port'] = $this->ask('Database Port', '3306');
                }
                $db_data['db'] = $this->ask('Database Name', 'laravel-core');
                $db_data['dbuser'] = $this->ask('Database User', 'root');
                $dbpass = $this->ask('Database Password', false);

                if ($dbpass != FALSE){
                    $db_data['dbpass'] = $dbpass;
                }else{
                    $db_data['dbpass'] = '';
                }

                $default_db_conn = env('DB_CONNECTION', 'mysql');

                if(CoreHelper::laravel_ver() == 5.4) {
                    config(['database.connections.'.$default_db_conn.'.host' => $db_data['host']]);
                    config(['database.connections.'.$default_db_conn.'.port' => $db_data['port']]);
                    CoreHelper::setenv("DB_HOST", $db_data['host']);
                    CoreHelper::setenv("DB_PORT", $db_data['port']);
                }

                config(['database.connections.'.$default_db_conn.'.database' => $db_data['db']]);
                config(['database.connections.'.$default_db_conn.'.username' => $db_data['dbuser']]);
                config(['database.connections.'.$default_db_conn.'.password' => $db_data['dbpass']]);
                CoreHelper::setenv("DB_DATABASE", $db_data['db']);
                CoreHelper::setenv("DB_USERNAME", $db_data['dbuser']);
                CoreHelper::setenv("DB_PASSWORD", $db_data['dbpass']);
            }

            if(env('CACHE_DRIVER') != "array") {
                config(['cache.default' => 'array']);
                CoreHelper::setenv("CACHE_DRIVER", "array");
            }

            if ($this->confirm("Proses ini mungkin akan merubah/menambahkan beberapa file berikut ke project anda:"
                ."\n\n\t routes/web.php"
                ."\n\t app/User.php"
                ."\n\t config/auth.php"
                ."\n\t database/migrations/2014_10_12_000000_create_users_table.php"
                ."\n\t gulpfile.js"
                ."\n\n Silahkan backup file tersebut atau menggunakan git. Apakah anda ingin melanjutkan?", true)) {

                // Controllers
                $this->line("\n".'Menggenerate Controllers...');
                $this->copyFolder($from."/app/Controllers/Auth", $to."/app/Http/Controllers/Auth");
                
                // Delete Redundant Controllers
                if(CoreHelper::laravel_ver() == 5.4) {
                    if (file_exists($to."/app/Http/Controllers/Auth/PasswordController.php")){
                        unlink($to."/app/Http/Controllers/Auth/PasswordController.php");
                    }
                    if (file_exists($to."/app/Http/Controllers/Auth/AuthController.php")){
                        unlink($to."/app/Http/Controllers/Auth/AuthController.php");
                    }
                } else {
                    unlink($to."/app/Http/Controllers/Auth/ForgotPasswordController.php");
                    unlink($to."/app/Http/Controllers/Auth/LoginController.php");
                    unlink($to."/app/Http/Controllers/Auth/RegisterController.php");
                    unlink($to."/app/Http/Controllers/Auth/ResetPasswordController.php");
                }
                $this->replaceFolder($from."/app/Controllers/Core", $to."/app/Http/Controllers/Core");
                if(CoreHelper::laravel_ver() == 5.4) {
                    $this->copyFile($from."/app/Controllers/Controller.5.4.php", $to."/app/Http/Controllers/Controller.php");
                } else {
                    $this->copyFile($from."/app/Controllers/Controller.php", $to."/app/Http/Controllers/Controller.php");
                }
                $this->copyFile($from."/app/Controllers/HomeController.php", $to."/app/Http/Controllers/HomeController.php");

                // Middleware
                if(CoreHelper::laravel_ver() == 5.4) {
                    $this->copyFile($from."/app/Middleware/RedirectIfAuthenticated.php", $to."/app/Http/Middleware/RedirectIfAuthenticated.php");
                }

                // Config
                $this->line('Menggenerate Config...');
                $this->copyFile($from."/config/core.php", $to."/config/core.php");
                if (file_exists($to.'/config/auth.php')){
                    unlink($to.'/config/auth.php');
                }
                $this->copyFile($from."/config/auth.php", $to."/config/auth.php");

                // Models
                $this->line('Menggenerate Models...');
                if(!file_exists($to."/app/Models")) {
                    $this->info("mkdir: (".$to."/app/Models)");
                    mkdir($to."/app/Models");
                }
                foreach($this->modelsInstalled as $model) {
                    if (file_exists($to.'/app/User.php')){
                        unlink($to.'/app/User.php');
                    }
                    if($model == "User") {
                        if(CoreHelper::laravel_ver() == 5.4) {
                            $this->copyFile($from."/app/Models/".$model."5.4.php", $to."/app/Models/".$model.".php");
                        } else {
                            $this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
                        }
                    } else if($model == "Role" || $model == "Permission") {
                        $this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
                    } else {
                        $this->copyFile($from."/app/Models/".$model.".php", $to."/app/Models/".$model.".php");
                    }
                }

                // Menggenerate Uploads / Thumbnails folders di /storage
                $this->line('Menggenerate Uploads / Thumbnails folder...');
                if(!file_exists($to."/storage/uploads")) {
                    $this->info("mkdir: (".$to."/storage/uploads)");
                    mkdir($to."/storage/uploads");
                }
                if(!file_exists($to."/storage/thumbnails")) {
                    $this->info("mkdir: (".$to."/storage/thumbnails)");
                    mkdir($to."/storage/thumbnails");
                }

                // themes
                $this->line('Menggenerate Tema Default...');
                if(!file_exists($to."/public/themes")) {
                    $this->info("mkdir: (".$to."/public/themes)");
                    mkdir($to."/public/themes");
                }
                $this->replaceFolder($from."/themes/default", $to."/public/themes/default");

                // Ngecek CACHE_DRIVER apakah array atau bukan
                // Ini diperlukan untuk Zizaco/Entrust
                // https://github.com/Zizaco/entrust/issues/468
                $driver_type = env('CACHE_DRIVER');
                if($driver_type != "array") {
                    throw new Exception("Mohon set Cache Driver ke array di .env (Diperlukan untuk Zizaco/Entrust) dan jalankan kembali core:install"
                        ."\n\n\tCACHE_DRIVER=array\n\n", 1);
                }

                // Migrations
                $this->line('Menggenerate migrations...');
                $this->copyFolder($from."/migrations", $to."/database/migrations");

                $this->line('Mengcopy seeds...');
                $this->copyFile($from."/seeds/DatabaseSeeder.php", $to."/database/seeds/DatabaseSeeder.php");

                // Ngecek database
                $this->line('Memeriksa konektivitas database...');
                DB::connection()->reconnect();

                // Menjalankan migrations...
                $this->line('Menjalankan migrations...');
                $this->call('clear-compiled');
                $this->call('cache:clear');
                $composer_path = "composer";
                if(PHP_OS == "Darwin") {
                    $composer_path = "/usr/bin/composer.phar";
                } else if(PHP_OS == "Linux") {
                    $composer_path = "/usr/bin/composer";
                } else if(PHP_OS == "Windows") {
                    $composer_path = "composer";
                }
                $this->info(exec($composer_path.' dump-autoload'));

                $this->call('migrate:refresh');
                $this->call('db:seed');
                $this->call('vendor:publish', ['--provider' => 'Spatie\Backup\BackupServiceProvider']);

                // Edit config/database.php untuk konfigurasi Spatie Backup
                if(CoreHelper::getLineWithString('config/database.php', "dump_command_path") == -1) {
                    $newDBConfig = "            'driver' => 'mysql',\n"
                        ."            'dump_command_path' => '/opt/lampp/bin', // only the path, so without 'mysqldump' or 'pg_dump'\n"
                        ."            'dump_command_timeout' => 60 * 5, // 5 minute timeout\n"
                        ."            'dump_using_single_transaction' => true, // perform dump using a single transaction\n";

                    $envfile =  $this->openFile('config/database.php');
                    $mysqldriverline = CoreHelper::getLineWithString('config/database.php', "'driver' => 'mysql'");
                    $envfile = str_replace($mysqldriverline, $newDBConfig, $envfile);
                    file_put_contents('config/database.php', $envfile);
                }

                // Routes
                $this->line('Menambahkan routes...');
                if(CoreHelper::laravel_ver() == 5.4) {
                    if(CoreHelper::getLineWithString($to."/routes/web.php", "require __DIR__.'/admin.php';") == -1) {
                        $this->appendFile($from."/app/routes.php", $to."/routes/web.php");
                    }
                    $this->copyFile($from."/app/admin_routes.php", $to."/routes/admin.php");
                } else {
                    if(CoreHelper::getLineWithString($to."/app/Http/routes.php", "require __DIR__.'/admin.php';") == -1) {
                        $this->appendFile($from."/app/routes.php", $to."/app/Http/routes.php");
                    }
                    $this->copyFile($from."/app/admin_routes.php", $to."/app/Http/admin.php");
                }

                // Tests
                $this->line('Menggenerate tests...');
                $this->copyFolder($from."/tests", $to."/tests");
                if(CoreHelper::laravel_ver() == 5.4) {
                    unlink($to.'/tests/TestCase.php');
                    //rename($to.'/tests/TestCase5.4.php', $to.'/tests/TestCase.php');
                } else {
                    unlink($to.'/tests/TestCase5.4.php');
                }

                // Membuat Super Admin User
                $user = \App\Models\User::where('context_id', "1")->first();
                if(!isset($user['id'])) {

                    $this->line('Membuat Super Admin User...');

                    $data = [];
                    $data['name']     = $this->ask('Super Admin name', 'Super Admin');
                    $data['email']    = $this->ask('Super Admin email', 'admin@example.com');
                    $data['password'] = bcrypt($this->secret('Super Admin password'));
                    $data['context_id']  = "1";
                    $data['type']  = "Employee";
                    $user = \App\Models\User::create($data);

                    // TODO: This is Not Standard. Need to find alternative
                    Eloquent::unguard();

                    \App\Models\Employee::create([
                        'name' => $data['name'],
                        'designation' => "Super Admin",
                        'mobile' => "8888888888",
                        'mobile2' => "",
                        'email' => $data['email'],
                        'gender' => 'Male',
                        'dept' => "1",
                        'city' => "Bandung",
                        'address' => "Cimahi, Bandung",
                        'about' => "Tentang user / biography",
                        'date_birth' => date("Y-m-d"),
                        'date_hire' => date("Y-m-d"),
                        'date_left' => date("Y-m-d"),
                        'salary_cur' => 0,
                    ]);

                    $this->info("Super Admin User '".$data['name']."' berhasil dibuat. ");
                } else {
                    $this->info("Super Admin User '".$user['name']."' sudah ada. ");
                }
                $role = \App\Models\Role::whereName('SUPER_ADMIN')->first();
                $user->attachRole($role);
                $this->info("\nCore berhasil di install.");
                $this->info("Sekarang anda bisa login lewat yourdomain.com/".config('core.adminRoute')." !!!\n");
            }else{
                $this->error("Instalasi dibatalkan. Coba lagi setelah anda backup / git. Terimakasih...");
            }
        }catch (Exception $e){
            $msg = $e->getMessage();
            if (strpos($msg, 'SQLSTATE') !== false) {
                throw new Exception("CoreInstall: Database tidak konek. Konek database (.env) dan jalankan kembali 'core:install'.\n".$msg, 1);
            } else {
                $this->error("CoreInstall::handle exception: ".$e);
                throw new Exception("CoreInstall::handle Unable to install : ".$msg, 1);
            }
        }
    }

    private function openFile($from) {
        $md = file_get_contents($from);
        return $md;
    }

    private function writeFile($from, $to) {
        $md = file_get_contents($from);
        file_put_contents($to, $md);
    }

    private function copyFolder($from, $to) {
        // $this->info("copyFolder: ($from, $to)");
        CoreHelper::recurse_copy($from, $to);
    }

    private function replaceFolder($from, $to) {
        // $this->info("replaceFolder: ($from, $to)");
        if(file_exists($to)) {
            CoreHelper::recurse_delete($to);
        }
        CoreHelper::recurse_copy($from, $to);
    }

    private function copyFile($from, $to) {
        // $this->info("copyFile: ($from, $to)");
        if(!file_exists(dirname($to))) {
            $this->info("mkdir: (".dirname($to).")");
            mkdir(dirname($to));
        }
        copy($from, $to);
    }

    private function appendFile($from, $to) {
        // $this->info("appendFile: ($from, $to)");

        $md = file_get_contents($from);

        file_put_contents($to, $md, FILE_APPEND);
    }

    // TODO:Method ini belum jalan
    private function fileContains($filePath, $text) {
        $fileData = file_get_contents($filePath);
        if (strpos($fileData, $text) === false ) {
            return true;
        } else {
            return false;
        }
    }
}


