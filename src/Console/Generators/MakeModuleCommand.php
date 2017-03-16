<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 08/03/17
 * Time: 10:50
 */

namespace Pw\Core\Console\Generators;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Pw\Core\Modules;
use Symfony\Component\Console\Helper\ProgressBar;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module
        {slug : Slug module}
        {--Q|quick : Cara cepat tanpa harus mengikuti langkah-langkah dari make:module dan menggunakan default value}';

    protected $description = 'Membuat Module baru';

    protected $module;

    protected $files;

    protected $container;

    public function __construct(Filesystem $files, Modules $module)
    {
        parent::__construct();

        $this->files  = $files;
        $this->module = $module;
    }

    public function fire()
    {
        $this->container['slug']        = str_slug($this->argument('slug'));
        $this->container['name']        = studly_case($this->container['slug']);
        $this->container['version']     = '1.0';
        $this->container['description'] = 'Ini adalah deskripsi dari module ' . $this->container['name'];

        if ($this->option('quick')) {
            $this->container['basename']  = studly_case($this->container['slug']);
            $this->container['namespace'] = config('modules.namespace') . $this->container['basename'];
            return $this->generate();
        }

        $this->displayHeader('intro');

        $this->stepOne();
    }

    public function stepOne()
    {
        $this->displayHeader('step-01');

        $this->container['name']        = $this->ask('Masukkan nama module: ', $this->container['name']);
        $this->container['slug']        = $this->ask('Masukkan slug module: ', $this->container['slug']);
        $this->container['version']     = $this->ask('Masukkan versi module: ', $this->container['version']);
        $this->container['description'] = $this->ask('Masukkan deskripsi module: ', $this->container['description']);
        $this->container['basename']    = studly_case($this->container['slug']);
        $this->container['namespace']   = config('modules.namespace') . $this->container['basename'];

        $this->comment('Anda telah memberikan informasi module sebagai berikut: ');
        $this->comment('Nama                             : ' . $this->container['name']);
        $this->comment('Slug                             : ' . $this->container['slug']);
        $this->comment('Versi                            : ' . $this->container['version']);
        $this->comment('Deskripsi                        : ' . $this->container['description']);
        $this->comment('Basename (Otomatis di generate)  : ' . $this->container['basename']);
        $this->comment('Namespace (Otomatis di generate) : ' . $this->container['namespace']);

        if ($this->confirm('Jika informasi module telah sesuai, silahkan ')) {
            $this->comment('Okee, itu semua yang kami butuhkan sudah anda berikan.');
            $this->comment('Sekarang, seruputlah sejenak kopi anda sambil menunggu generate module selesai.');

            $this->generate();
        } else {
            return $this->stepOne();
        }

        return true;
    }

    protected function displayHeader($file = '', $level = 'info')
    {
        $stub = $this->files->get(__DIR__ . '/../../../resources/stubs/console/' . $file . '.stub');
        return $this->$level($stub);
    }

    protected function generate()
    {
        $steps = [
            'Menggenerate Module...' => 'generateModule',
            'Mengoptimasi Module...' => 'optimizeModules',
        ];

        $progress = new ProgressBar($this->output, count($steps));
        $progress->start();

        foreach ($steps as $meesage => $function) {
            $progress->setMessage($meesage);

            $this->$function();

            $progress->advance();
        }

        $progress->finish();

        event($this->container['slug'] . '.module.made');

        $this->info("\nModule telah berhasil di generate.!!");
    }

    protected function generateModule()
    {
        if (!$this->files->isDirectory(module_path())) {
            $this->files->makeDirectory(module_path());
        }

        $pathMap   = config('modules.pathMap');
        $directory = module_path(null, $this->container['basename']);
        $source    = __DIR__ . '/../../../resources/stubs/module';

        $this->files->makeDirectory($directory);

        $sourceFiles = $this->files->allFiles($source, true);

        if (!empty($pathMap)) {
            $search  = array_keys($pathMap);
            $replace = array_values($pathMap);
        }

        foreach ($sourceFiles as $file) {
            $contents = $this->replacePlaceholders($file->getContents());
            $subPath  = $file->getRelativePathname();

            if (!empty($pathMap)) {
                $subPath = str_replace($search, $replace, $subPath);
            }

            $filePath = $directory . '/' . $subPath;
            $dir      = dirname($filePath);

            if (!$this->files->isDirectory($dir)) {
                $this->files->makeDirectory($dir, 0755, true);
            }

            $this->files->put($filePath, $contents);
        }
    }

    protected function optimizeModules()
    {
        return $this->callSilent('module:optimize');
    }

    protected function replacePlaceholders($contents)
    {
        $find = [
            'DummyBasename',
            'DummyNamespace',
            'DummyName',
            'DummySlug',
            'DummyVersion',
            'DummyDescription',
        ];

        $replace = [
            $this->container['basename'],
            $this->container['namespace'],
            $this->container['name'],
            $this->container['slug'],
            $this->container['version'],
            $this->container['description'],
        ];

        return str_replace($find, $replace, $contents);
    }

}
