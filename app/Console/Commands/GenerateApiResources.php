<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class GenerateApiResources extends Command
{
    protected $signature = 'generate:api-resources';
    protected $description = 'Generate API Resources for all models';

    public function handle()
    {
        $modelPath = app_path('Models');
        $resourcePath = app_path('Http/Resources');

        // Verifica se o diretório de models existe
        if (!File::exists($modelPath)) {
            $this->error("O diretório de models não existe: {$modelPath}");
            return;
        }

        // Obtém todas as classes de model
        $models = File::allFiles($modelPath);

        foreach ($models as $model) {
            $modelName = $model->getFilenameWithoutExtension();
            $resourceName = $modelName . 'Resource';
            $resourceFilePath = "{$resourcePath}/{$resourceName}.php";

            // Verifica se o recurso já existe
            if (File::exists($resourceFilePath)) {
                $this->info("Recurso {$resourceName} já existe.");
                continue;
            }

            // Cria o conteúdo do resource
            $this->createResource($resourceName, $modelName, $resourceFilePath);
            $this->info("Recurso {$resourceName} gerado com sucesso.");
        }
    }

    protected function createResource($resourceName, $modelName, $resourceFilePath)
    {
        // Obtém os campos da tabela correspondente à model
        $tableName = Str::snake($modelName); // Converte o nome da model para snake_case
        $fields = Schema::getColumnListing($tableName);

        // Gera o conteúdo do resource
        $fieldsArray = implode(",\n            ", array_map(fn($field) => "'$field' => \$this->$field", $fields));

        $content = <<<EOD
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class {$resourceName} extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return array
     */
    public function toArray(\$request)
    {
        return [
            $fieldsArray
        ];
    }
}
EOD;

        // Cria o arquivo do resource
        File::put($resourceFilePath, $content);
    }
}
