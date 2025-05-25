<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerError;
use App\Http\Requests\AdvogadosRequest;
use App\Http\Requests\ProdutoRequest;
use App\Models\Produto;

use App\Interfaces\CrudInterface;
use App\Models\ProdutoVariante;
use App\Models\ProdutoVarianteEstoque;
use App\Service\FileStore;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * @group Produto
*/
class ProdutoController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Produto();
    }

    public function store(Request $request, ?FormRequest $validationClass = null): CrudInterface|JsonResponse
    {
        DB::beginTransaction();
        try {
            $adminsRequest = $request instanceof ProdutoRequest
                ? $request
                : app(ProdutoRequest::class);
            parent::store($adminsRequest, $adminsRequest);
            DB::commit();
            return response()->json([
                "code" => 201,
                "message" => "Produto criado com sucesso"
            ],201);
        }catch (\Exception $e){
            DB::rollBack();
            return InternalServerError::create($e);
        }
    }

    public function update(Request $request): CrudInterface|JsonResponse{
        DB::beginTransaction();
        try {
            $produto = parent::update($request);
            if(request()->has('qtd')) $produto->produtos_estoques()->update([
                'qtd' => floatval(request()->get('qtd')),
            ]);
            if (request()->has('variantes')) {
                $variantes = request()->get('variantes');
                foreach ($variantes as $i => $variante) {
                    $imagemInputName = "variantes.$i.imagem";
                    Log::info("requestFile",[request()->hasFile($imagemInputName)]);
                    $data = [
                        'produto_id' => $produto->id,
                        'nome' => $variante["nome"],
                        'preco' => $variante["preco"]
                    ];
                    if (request()->hasFile($imagemInputName)) {
                        $file = request()->file($imagemInputName);
                        $filename = $file->getClientOriginalName();
                        $path = FileStore::store(
                            'produtos/' . $produto->uuid . '/produto-variantes/',
                            $file,
                            $filename
                        );
                        if(strlen($path) > 0){
                            $data['imagem'] = $path;
                        }
                    }
                    $produto_variante_comparable = [];
                    if (isset($variante["id"])) {
                        $produto_variante_comparable["id"] = $variante["id"];
                    }
                    $produtoVariante = ProdutoVariante::updateOrCreate(
                        $produto_variante_comparable,
                        $data
                    );
                    ProdutoVarianteEstoque::updateOrCreate([
                        'produto_variante_id' => $produtoVariante->id,
                    ], [
                        'qtd' => $variante["qtd"]
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Produto atualizado com sucesso"
            ],200);
        }catch (\Exception $e){
            DB::rollBack();
            return InternalServerError::create($e);
        }
    }
}
