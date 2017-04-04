<?php
/**
 * Created by PhpStorm.
 * User: purwadi
 * Date: 07/03/17
 * Time: 20:03
 */

namespace Pw\Core;

use Pw\Core\Contracts\Repository;
use Pw\Core\Providers\GeneratorServiceProvider;
use Pw\Core\Providers\ConsoleServiceProvider;
use Pw\Core\Providers\RepositoryServiceProvider;
use Pw\Core\Providers\HelperServiceProvider;

use Pw\Core\Helpers\CoreHelper;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * @var bool Indicates if loading of the provider is deferred.
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/modules.php' => config_path('modules.php'),
        ], 'config');

        $this->app['modules']->register();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/modules.php', 'modules'
        );

        include __DIR__.'/Routes/Route.php';

        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(GeneratorServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(HelperServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Providers
        |--------------------------------------------------------------------------
        */
        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Zizaco\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */
        $loader = AliasLoader::getInstance();

        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);

        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);

        // For Core Code Generation
        $loader->alias('CodeGenerator', \Pw\Core\Helpers\CodeGenerator::class);

        // For Core Form Helper
        $loader->alias('CoreFormMaker', \Pw\Core\Helpers\CoreFormMaker::class);

        // For Core Helper
        $loader->alias('CoreHelper', \Pw\Core\Helpers\CoreHelper::class);

        // Core Crud Model
        $loader->alias('Crud', \Pw\Core\Models\Crud::class);

        // For Core Configuration Model
        $loader->alias('CoreConfigs', \Pw\Core\Models\CoreConfigs::class);

        // For Entrust
        $loader->alias('Entrust', \Zizaco\Entrust\EntrustFacade::class);
        $loader->alias('role', \Zizaco\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Zizaco\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Zizaco\Entrust\Middleware\EntrustAbility::class);

        /*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        // CoreForm Input Maker
        Blade::directive('core_input', function($expression) {
            if(CoreHelper::laravel_ver() == 5.4) {
                $expression = "(".$expression.")";
            }
            return "<?php echo CoreFormMaker::input$expression; ?>";
        });

        // CoreForm Form Maker
        Blade::directive('core_form', function($expression) {
            if(CoreHelper::laravel_ver() == 5.4) {
                $expression = "(".$expression.")";
            }
            return "<?php echo CoreFormMaker::form$expression; ?>";
        });

        // CoreForm Maker - Display Values
        Blade::directive('core_display', function($expression) {
            if(CoreHelper::laravel_ver() == 5.4) {
                $expression = "(".$expression.")";
            }
            return "<?php echo CoreFormMaker::display$expression; ?>";
        });

        // CoreForm Maker - Check Whether User has Crud Access
        Blade::directive('core_access', function($expression) {
            if(CoreHelper::laravel_ver() == 5.4) {
                $expression = "(".$expression.")";
            }
            return "<?php if(CoreFormMaker::core_access$expression) { ?>";
        });
        Blade::directive('endcore_access', function($expression) {
            return "<?php } ?>";
        });

        // CoreForm Maker - Check Whether User has Crud Field Access
        Blade::directive('core_field_access', function($expression) {
            if(CoreHelper::laravel_ver() == 5.4) {
                $expression = "(".$expression.")";
            }
            return "<?php if(CoreFormMaker::core_field_access$expression) { ?>";
        });
        Blade::directive('endcore_field_access', function($expression) {
            return "<?php } ?>";
        });

        $this->app->singleton('modules', function ($app) {
            $repository = $app->make(Repository::class);

            return new Modules($app, $repository);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string
     */
    public function provides()
    {
        return ['modules'];
    }

    public static function compiles()
    {
        $modules = app()->make('modules')->all();
        $files = [];

        foreach ($modules as $module) {
            $serviceProvider = module_class($module['slug'], 'Providers\\ModuleServiceProvider');

            if (class_exists($serviceProvider)) {
                $files = array_merge($files, forward_static_call([$serviceProvider, 'compiles']));
            }
        }

        return array_map('realpath', $files);
    }
}
