<?php

namespace Meadow;

use Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;
use Meadow\Console\Commands\MeadowBootcampCommand;
use Meadow\Console\Commands\MeadowInstallCommand;
use Meadow\View\Components\Accordion;
use Meadow\View\Components\Alert;
use Meadow\View\Components\Avatar;
use Meadow\View\Components\Badge;
use Meadow\View\Components\Breadcrumbs;
use Meadow\View\Components\Button;
use Meadow\View\Components\Calendar;
use Meadow\View\Components\Card;
use Meadow\View\Components\Carousel;
use Meadow\View\Components\Chart;
use Meadow\View\Components\Checkbox;
use Meadow\View\Components\Choices;
use Meadow\View\Components\ChoicesOffline;
use Meadow\View\Components\Code;
use Meadow\View\Components\Collapse;
use Meadow\View\Components\Colorpicker;
use Meadow\View\Components\DatePicker;
use Meadow\View\Components\DateTime;
use Meadow\View\Components\Diff;
use Meadow\View\Components\Drawer;
use Meadow\View\Components\Dropdown;
use Meadow\View\Components\Editor;
use Meadow\View\Components\Errors;
use Meadow\View\Components\File;
use Meadow\View\Components\Form;
use Meadow\View\Components\Group;
use Meadow\View\Components\Header;
use Meadow\View\Components\Hr;
use Meadow\View\Components\Icon;
use Meadow\View\Components\ImageGallery;
use Meadow\View\Components\ImageLibrary;
use Meadow\View\Components\Input;
use Meadow\View\Components\Kbd;
use Meadow\View\Components\ListItem;
use Meadow\View\Components\Loading;
use Meadow\View\Components\Main;
use Meadow\View\Components\Markdown;
use Meadow\View\Components\Menu;
use Meadow\View\Components\MenuItem;
use Meadow\View\Components\MenuSeparator;
use Meadow\View\Components\MenuSub;
use Meadow\View\Components\MenuTitle;
use Meadow\View\Components\Modal;
use Meadow\View\Components\Nav;
use Meadow\View\Components\Pagination;
use Meadow\View\Components\Password;
use Meadow\View\Components\Pin;
use Meadow\View\Components\Popover;
use Meadow\View\Components\Progress;
use Meadow\View\Components\ProgressRadial;
use Meadow\View\Components\Radio;
use Meadow\View\Components\Range;
use Meadow\View\Components\Rating;
use Meadow\View\Components\Select;
use Meadow\View\Components\SelectGroup;
use Meadow\View\Components\Signature;
use Meadow\View\Components\Spotlight;
use Meadow\View\Components\Stat;
use Meadow\View\Components\Step;
use Meadow\View\Components\Steps;
use Meadow\View\Components\Swap;
use Meadow\View\Components\Tab;
use Meadow\View\Components\Table;
use Meadow\View\Components\Tabs;
use Meadow\View\Components\Tags;
use Meadow\View\Components\Textarea;
use Meadow\View\Components\ThemeToggle;
use Meadow\View\Components\TimelineItem;
use Meadow\View\Components\Toast;
use Meadow\View\Components\Toggle;

class MeadowServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        $this->registerComponents();
        $this->registerBladeDirectives();

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function registerComponents()
    {
        // Just rename <x-icon> provided by BladeUI Icons to <x-svg> to not collide with ours
        Blade::component('BladeUI\Icons\Components\Icon', 'svg');

        // No matter if components has custom prefix or not,
        // we also register below alias to avoid naming collision,
        // because they are used inside some Meadow's components itself.
        Blade::component('meadow-button', Button::class);
        Blade::component('meadow-card', Card::class);
        Blade::component('meadow-badge', Badge::class);
        Blade::component('meadow-icon', Icon::class);
        Blade::component('meadow-input', Input::class);
        Blade::component('meadow-list-item', ListItem::class);
        Blade::component('meadow-modal', Modal::class);
        Blade::component('meadow-menu', Menu::class);
        Blade::component('meadow-menu-item', MenuItem::class);
        Blade::component('meadow-header', Header::class);
        Blade::component('meadow-pagination', Pagination::class);
        Blade::component('meadow-popover', Popover::class);

        $prefix = config('meadow.prefix');

        // Blade
        Blade::component($prefix . 'accordion', Accordion::class);
        Blade::component($prefix . 'alert', Alert::class);
        Blade::component($prefix . 'avatar', Avatar::class);
        Blade::component($prefix . 'badge', Badge::class);
        Blade::component($prefix . 'breadcrumbs', Breadcrumbs::class);
        Blade::component($prefix . 'button', Button::class);
        Blade::component($prefix . 'calendar', Calendar::class);
        Blade::component($prefix . 'card', Card::class);
        Blade::component($prefix . 'chart', Chart::class);
        Blade::component($prefix . 'checkbox', Checkbox::class);
        Blade::component($prefix . 'choices', Choices::class);
        Blade::component($prefix . 'choices-offline', ChoicesOffline::class);
        Blade::component($prefix . 'code', Code::class);
        Blade::component($prefix . 'collapse', Collapse::class);
        Blade::component($prefix . 'colorpicker', Colorpicker::class);
        Blade::component($prefix . 'datepicker', DatePicker::class);
        Blade::component($prefix . 'datetime', DateTime::class);
        Blade::component($prefix . 'diff', Diff::class);
        Blade::component($prefix . 'drawer', Drawer::class);
        Blade::component($prefix . 'dropdown', Dropdown::class);
        Blade::component($prefix . 'editor', Editor::class);
        Blade::component($prefix . 'errors', Errors::class);
        Blade::component($prefix . 'file', File::class);
        Blade::component($prefix . 'form', Form::class);
        Blade::component($prefix . 'select-group', SelectGroup::class);
        Blade::component($prefix . 'header', Header::class);
        Blade::component($prefix . 'hr', Hr::class);
        Blade::component($prefix . 'icon', Icon::class);
        Blade::component($prefix . 'image-gallery', ImageGallery::class);
        Blade::component($prefix . 'image-library', ImageLibrary::class);
        Blade::component($prefix . 'input', Input::class);
        Blade::component($prefix . 'kbd', Kbd::class);
        Blade::component($prefix . 'list-item', ListItem::class);
        Blade::component($prefix . 'loading', Loading::class);
        Blade::component($prefix . 'markdown', Markdown::class);
        Blade::component($prefix . 'modal', Modal::class);
        Blade::component($prefix . 'menu', Menu::class);
        Blade::component($prefix . 'menu-item', MenuItem::class);
        Blade::component($prefix . 'menu-separator', MenuSeparator::class);
        Blade::component($prefix . 'menu-sub', MenuSub::class);
        Blade::component($prefix . 'menu-title', MenuTitle::class);
        Blade::component($prefix . 'main', Main::class);
        Blade::component($prefix . 'nav', Nav::class);
        Blade::component($prefix . 'pagination', Pagination::class);
        Blade::component($prefix . 'password', Password::class);
        Blade::component($prefix . 'pin', Pin::class);
        Blade::component($prefix . 'popover', Popover::class);
        Blade::component($prefix . 'progress', Progress::class);
        Blade::component($prefix . 'progress-radial', ProgressRadial::class);
        Blade::component($prefix . 'radio', Radio::class);
        Blade::component($prefix . 'group', Group::class);
        Blade::component($prefix . 'range', Range::class);
        Blade::component($prefix . 'rating', Rating::class);
        Blade::component($prefix . 'select', Select::class);
        Blade::component($prefix . 'signature', Signature::class);
        Blade::component($prefix . 'spotlight', Spotlight::class);
        Blade::component($prefix . 'stat', Stat::class);
        Blade::component($prefix . 'steps', Steps::class);
        Blade::component($prefix . 'step', Step::class);
        Blade::component($prefix . 'swap', Swap::class);
        Blade::component($prefix . 'table', Table::class);
        Blade::component($prefix . 'tab', Tab::class);
        Blade::component($prefix . 'tabs', Tabs::class);
        Blade::component($prefix . 'tags', Tags::class);
        Blade::component($prefix . 'textarea', Textarea::class);
        Blade::component($prefix . 'timeline-item', TimelineItem::class);
        Blade::component($prefix . 'theme-toggle', ThemeToggle::class);
        Blade::component($prefix . 'toast', Toast::class);
        Blade::component($prefix . 'toggle', Toggle::class);
        Blade::component($prefix . 'carousel', Carousel::class);
    }

    public function registerBladeDirectives(): void
    {
        $this->registerScopeDirective();
    }

    public function registerScopeDirective(): void
    {
        /**
         * All credits from this blade directive goes to Konrad Kalemba.
         * Just copied and modified for my very specific use case.
         *
         * https://github.com/konradkalemba/blade-components-scoped-slots
         */
        Blade::directive('scope', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            [$name, $functionArguments] = $directiveArguments;

            // Build function "uses" to inject extra external variables
            $uses = Arr::except(array_flip($directiveArguments), [$name, $functionArguments]);
            $uses = array_flip($uses);
            array_push($uses, '$__env');
            array_push($uses, '$__bladeCompiler');
            $uses = implode(',', $uses);

            /**
             *  Slot names can`t contains dot , eg: `user.city`.
             *  So we convert `user.city` to `user___city`
             *
             *  Later, on component it will be replaced back.
             */
            $name = str_replace('.', '___', $name);

            return "<?php \$__bladeCompiler = \$__bladeCompiler ?? null; \$loop = null; \$__env->slot({$name}, function({$functionArguments}) use ({$uses}) { \$loop = (object) \$__env->getLoopStack()[0] ?>";
        });

        Blade::directive('endscope', function () {
            return '<?php }); ?>';
        });
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/meadow.php', 'meadow');

        // Register the service the package provides.
        $this->app->singleton('meadow', function ($app) {
            return new Meadow();
        });

        $this->runInitialLibOnArtisanServe();
    }

    protected function runInitialLibOnArtisanServe(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $argv = $_SERVER['argv'] ?? [];

        if (($argv[1] ?? null) !== 'serve') {
            return;
        }

        $path = realpath(__DIR__ . '/../libs/index.js');

        if ($path === false || ! is_file($path)) {
            return;
        }

        $node = (new ExecutableFinder())->find('node');

        if ($node === null) {
            return;
        }

        (new Process([$node, $path], dirname($path)))->run(function (string $type, string $buffer): void {
            fwrite($type === Process::ERR ? STDERR : STDOUT, $buffer);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['meadow'];
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/meadow.php' => config_path('meadow.php'),
        ], 'meadow.config');

        $this->commands([MeadowInstallCommand::class, MeadowBootcampCommand::class]);
    }
}
