<?php

namespace App\Http\Controllers;

use App\Exceptions\InternalServerError;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Requests\CuponRequest;
use App\Http\Requests\ProdutoRequest;
use App\Models\Coupon;

use App\Interfaces\CrudInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * @group Coupon
*/
class CouponController extends Controller
{
    public CrudInterface $model;

    public function __construct()
    {
        $this->model = new Coupon();
    }

    public function store(Request $request, ?FormRequest $validationClass = null): CrudInterface|JsonResponse
    {
        DB::beginTransaction();
        try {
            $adminsRequest = $request instanceof CouponRequest
                ? $request
                : app(CouponRequest::class);
            parent::store($adminsRequest, $adminsRequest);
            DB::commit();
            return response()->json([
               "code" => 201,
               "message" => "Cupom Criado com sucesso"
            ]);
        }catch (Exception $e){
            DB::rollBack();
            return InternalServerError::create($e);
        }
    }
}
