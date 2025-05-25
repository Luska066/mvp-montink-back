<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CreateRequestsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:create-requests {model?} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all requests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');

        if ($modelName) {
            $this->generateRequestForModel($modelName);
        } else {
            $this->generateRequestsForAllModels();
        }
    }

    protected function generateRequestForModel($modelName)
    {
        $modelClass = "App\\Models\\" . $modelName;

        if (!class_exists($modelClass)) {
            $this->error("Model {$modelName} does not exist.");
            return;
        }

        $model = new $modelClass;
        $fillable = $model->getFillable();
        $table = $model->getTable();

        $requestClassName = $modelName . "Request";
        $requestPath = app_path("Http/Requests/{$requestClassName}.php");

        // Verifica se o arquivo já existe
        if (File::exists($requestPath) && !$this->option('force')) {
            $this->error("Form Request {$requestClassName} already exists. Use --force to overwrite.");
            return;
        }

        // Cria o conteúdo do Form Request
        $requestContent = $this->generateRequestContent($requestClassName, $fillable, $table);
        File::put($requestPath, $requestContent);
        $this->info("Form Request {$requestClassName} created successfully.");
    }

    protected function generateRequestsForAllModels()
    {
        $models = glob(app_path('Models/*.php'));

        foreach ($models as $modelFile) {
            $modelName = basename($modelFile, '.php');
            $this->generateRequestForModel($modelName);
        }
    }

    protected function generateRequestContent($requestClassName, $fillable, $table)
    {
        $rules = [];
        foreach ($fillable as $field) {
            $columnType = Schema::getConnection()->getSchemaBuilder()->getColumnType($table, $field);
            $rules[$field] = $this->getValidationRule($columnType);
        }

        $rulesString = var_export($rules, true);

        return "<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class {$requestClassName} extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return {$rulesString};
    }
}
";
    }

    protected function getValidationRule($columnType)
    {
        switch ($columnType) {
            case 'string':
                return 'required|string|max:255'; // Ajuste o tamanho conforme necessário
            case 'integer':
                return 'required|integer';
            case 'boolean':
                return 'required|boolean';
            case 'date':
                return 'required|date';
            case 'datetime':
                return 'required|date_format:Y-m-d H:i:s';
            case 'float':
                return 'required|numeric';
            case 'text':
                return 'nullable|string'; // Textos longos podem ser opcionais
            default:
                return 'required|string'; // Regra padrão
        }
    }
}
