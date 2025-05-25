<?php

namespace App\Observers;

use App\Models\Produto;
use App\Models\ProdutosEstoque;
use App\Models\ProdutoVariante;
use App\Models\ProdutoVarianteEstoque;
use App\Service\FileStore;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Str;

class ProdutoObserver
{
    public function creating(Produto $produto): void
    {
        $produto->uuid = Str::uuid();
        if (request()->hasFile('imagem')) {
            $file = request()->file('imagem');
            $directory = 'produtos/' . $produto->uuid . '/';
            $fileName = $file->getClientOriginalName();
            $produto->imagem = FileStore::store($directory, $file, $fileName);
        }
    }

    /**
     * Handle the Produto "created" event.
     */
    public function created(Produto $produto): void
    {

        $produto->produtos_estoques()->create([
            'produto_id' => $produto->id,
            'qtd' => floatval(request()->qtd),
        ]);
        if (request()->has('variantes')) {
            $variantes = request()->get('variantes');
            foreach ($variantes as $i => $variante) {
                $imagemInputName = "variantes.$i.imagem";
                if (!request()->hasFile($imagemInputName)) {
                    throw new \InvalidArgumentException("Imagem da variante é obrigatória");
                }
                $file = request()->file($imagemInputName);
                $filename = $file->getClientOriginalName();
                $directory = 'produtos/' . $produto->uuid . '/produto-variantes/';
                $path = FileStore::store($directory, $file, $filename);
                $produtoVariante = $produto->produto_variantes()->create([
                    'imagem' => $path ?? '',
                    'nome' => $variante["nome"],
                    'preco' => $variante["preco"]
                ]);
                ProdutoVarianteEstoque::create([
                    'produto_variante_id' => $produtoVariante->id,
                    'qtd' => $variante["qtd"]
                ]);
            }
        }
    }

    /**
     * Handle the Produto "updated" event.
     */
    public function updating(Produto $produto): void
    {
        $produto->nome = request()->get('nome');
        $produto->preco = request()->get('preco');
        $produto->active = request()->get('active');
        if (request()->hasFile('imagem')) {
            FileStore::delete($produto->imagem);
            $file = request()->file('imagem');
            $directory = 'produtos/' . $produto->uuid . '/';
            $fileName = $file->getClientOriginalName();
            $produto->imagem = FileStore::store($directory, $file, $fileName);
        }
    }

    public function updated(Produto $produto): void
    {
    }

    /**
     * Handle the Produto "deleted" event.
     */
    public function deleted(Produto $produto): void
    {
        //
    }

    /**
     * Handle the Produto "restored" event.
     */
    public function restored(Produto $produto): void
    {
        //
    }

    /**
     * Handle the Produto "force deleted" event.
     */
    public function forceDeleted(Produto $produto): void
    {
        //
    }
}
