<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 07/03/17
 * Time: 20:59
 */

namespace Pw\Core\Repositories;

use Pw\Core\Contracts\Repository as RepositoryContract;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;

abstract class Repository implements RepositoryContract
{
    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var string Path to the defined modules directory
     */
    protected $path;

    public function __construct(Config $config, Filesystem $files)
    {
        $this->config = $config;
        $this->files = $files;
    }

    protected function getAllBasenames()
    {
        $path = $this->getPath();

        try {
            $collection = collect($this->files->directories($path));

            $basenames = $collection->map(function ($item, $key) {
                return basename($item);
            });

            return $basenames;
        } catch (\InvalidArgumentException $e) {
            return collect([]);
        }
    }

    public function getManifest($slug)
    {
        if (!is_null($slug)) {
            $path = $this->getManifestPath($slug);
            $contents = $this->files->get($path);
            $collection = collect(json_decode($contents, true));

            return $collection;
        }
    }

    public function getPath()
    {
        return $this->path ?: $this->config->get('modules.path');
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getModulePath($slug)
    {
        $module = studly_case(str_slug($slug));

        if (\File::exists($this->getPath()."/{$module}/")) {
            return $this->getPath()."/{$module}/";
        }

        return $this->getPath()."/{$slug}/";
    }

    protected function getManifestPath($slug)
    {
        return $this->getModulePath($slug).'module.json';
    }

    public function getNamespace()
    {
        return rtrim($this->config->get('modules.namespace'), '/\\');
    }
}