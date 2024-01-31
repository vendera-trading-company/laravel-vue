<?php

namespace VenderaTradingCompany\LaravelVue\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelVueProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('vue', function (mixed $object) {
            return "<?php echo VenderaTradingCompany\PHPActions\Action::run(VenderaTradingCompany\LaravelVue\Actions\Vue\VueObject::class, ['object' => {$object}])->getData('object') ?>";
        });
    }
}
