<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerError;
use App\Interfaces\CrudInterface;
use App\Mail\PedidoFeitoMail;
use App\Models\Coupon;
use App\Models\Pedido;
use App\Models\PedidosItem;
use App\Models\Produto;
use App\Models\ProdutoVariante;
use App\Service\PedidoService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new ProdutoVariante();
    }

    public function store(Request $request, ?FormRequest $validationClass = null): CrudInterface|JsonResponse
    {
        DB::beginTransaction();
        try{
            $collect = collect($request->get('produtos'));
            $total = $collect->reduce(function ($carry, $item) {
                return $carry + ($item['quantidade'] * $item['preco']);
            });
            $frete = PedidoService::calcularFrete($total);

            if ($total != $request->total) {
                throw new \InvalidArgumentException("Valores não conferem", 500);
            }
            if ($frete != $request->frete) {
                throw new \InvalidArgumentException("Valores não conferem", 500);
            }
            $pedido = Pedido::create([
                "uuid" => Str::uuid(),
                'total' => $total,
                'desconto' => $request->desconto,
                'frete' => $frete,
                'email' => $request->email,
                'cep' => $request->cep,
                'estado' => $request->estado,
                'cidade' => $request->cidade,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'rua' => $request->rua
            ]);
            $collect->each(function ($data) use ($pedido) {
                if (isset($data['variante_id'])){
                    $produtoVariante = ProdutoVariante::query()->find($data['variante_id']);
                    $produtoVariante->decrementarEstoque($data['quantidade']);
                    PedidosItem::query()->create([
                        'pedido_id' => $pedido->id,
                        'produto_id' => $data['produto_id'],
                        'produto_variante_id' => $data['variante_id'],
                        'preco' => $data['preco'],
                        'qtd' => $data['quantidade']
                    ]);
                }
                if (!isset($data['variante_id'])) {
                    $produto = Produto::query()->find($data['produto_id']);
                    $produto->decrementarEstoque($data['quantidade']);
                    PedidosItem::query()->create([
                        'pedido_id' => $pedido->id,
                        'produto_id' => $data['produto_id'],
                        'produto_variante_id' => null,
                        'preco' => $data['preco'],
                        'qtd' => $data['quantidade']
                    ]);
                }
            });
            DB::commit();
            Mail::to($pedido->email)->send(new PedidoFeitoMail($pedido->id));
            return response()->json([
                "code" => 201,
                "message" => "Pedido realizado com sucesso"
            ]);
        }catch (\Exception|\InvalidArgumentException $e){
            DB::rollBack();
            return InternalServerError::create($e);
        }
    }

    public function aplicarDesconto(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $cupom = Coupon::where('code', $request->code)->first();
        if (!$cupom || !$cupom->isValid($request->subtotal)) {
            return response()->json(['erro' => 'Cupom inválido ou expirado'], 422);
        }


        return response()->json([
            'sucesso' => true,
            'desconto' => $cupom->discount_percent,
            'min' => $cupom->min_cart_value
        ]);
    }

    public function webhook(Request $request)
    {
        DB::beginTransaction();
        try{
            $request->validate([
                'id' => 'required|integer',
                'status' => 'required|string',
            ]);
            $pedido = Pedido::query()->find($request->id);
            if(!isset($pedido)){
                throw new \InvalidArgumentException("Pedido não encontrado", 500);
            }
            switch ($request->status) {
                case 'CANCELADO':
                    $pedido->delete();
                    break;
                default:
                    $pedido->status = $request->status;
                    $pedido->save();
            }
            DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Pedido atualizado com sucesso"
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            return InternalServerError::create($e);
        }
    }

    public function sendMail(Request $request): void
    {
        Mail::to('teste@mailtrap.io')->send(new PedidoFeitoMail(8));
    }
}
