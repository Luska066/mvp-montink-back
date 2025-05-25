<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateControllersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:controllers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar controllers automaticamente';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function contentFile(string $controllerName, string $modelName): string
    {
        $content = '<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\\' . $modelName . ';

use App\Interfaces\CrudInterface;
/**
 * @group ' . $modelName . '
*/
class ' . $controllerName . ' extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new ' . $modelName . '();
    }
}';

        return $content;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = __DIR__ . '/../../Models';
        $pathController = __DIR__ . '/../../Http/Controllers/';
        $diretorio = dir($path);
        echo "Lista de Arquivos do diretório";
        while ($file = $diretorio->read()) {
            if (stristr($file, '.php')) {
                $modelName = explode('.', $file)[0];
                $controllerName = $modelName . 'Controller';
                $controllerFile = $this->contentFile($controllerName, $modelName);
                $controllerFullPath = $pathController . $controllerName . '.php';
                if (!file_exists($controllerFullPath)) {
                    file_put_contents($controllerFullPath, $controllerFile);
                }
                echo "\n" . $file;
            }
        }
        $diretorio->close();

        return 0;
    }
}
