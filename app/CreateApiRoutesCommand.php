<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateApiRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generate-api-routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria as rotas via api automaticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $routes = file_get_contents(base_path('routes/api.php'));
        // pegar todas as controllers
        $controllers = array_map(function ($file) {
            return str_replace('.php', '', $file);
        }, array_diff(scandir(app_path('Http/Controllers/API')), ['.', '..']));
        // criar as rotas
        $routes = preg_replace('/\/\/ CRUD:START(.*)\/\/ CRUD:END/s', '', $routes);
        $routes .= "\n// CRUD:START\n";
        foreach ($controllers as $controller) {
            $controllerName = str_replace('.php', '', $controller);
            $modelName = str_replace('Controller', '', $controllerName);
            $routes .= "Route::apiResource('" . Str::snake($modelName, '-') . "', " . $controllerName . "::class);\n";
        }
        $routes .= "// CRUD:END\n";

        //carrega os use
        $use = "use Illuminate\Support\Facades\Route;\n";
        $controllerNameSpace = "use App\Http\Controllers\\";
        foreach ($controllers as $controller) {
            $use .= $controllerNameSpace . $controller . ";\n";
        }
        $use = substr($use, 0, -2) . ";\n";
        $routes = str_replace("use Illuminate\Support\Facades\Route;\n", $use, $routes);


        file_put_contents(base_path('routes/api.php'), $routes);
    }
}
