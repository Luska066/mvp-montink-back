<?php

namespace App\Exceptions;

use Dotenv\Parser\Value;

class InternalServerError
{
    public static function codes()
    {
        return [
            "500" => "Erro Interno no servidor!",
            "404" => "Rota nao encontrada!",
            "400" => "Requisicao invalida!",
            "401" => "Nao autorizado!",
            "403" => "Acesso proibido!",
            "405" => "Metodo HTTP nao permitido!",
            "422" => "Requisicao invalida!",
            "429" => "Muitas requisicoes!",
            "502" => "Erro ao processar a requisicao!",
            "503" => "Servico temporariamente indisponivel!",
            "504" => "Tempo de resposta do servidor esgotado!",
        ];
    }

    public static function create(\Exception|\Throwable|\ValueError $exception)
    {

        return response()->json([
            'status' => $exception->getCode() ?? 500,
            'success' => false,
            'message' => self::codes()[$exception?->status ?? $exception->getCode()] ?? "Erro Interno no servidor!",
            'error' => $exception->getMessage(),
        ], $exception->getCode() ?? 500);
    }

    public static function throw(\Exception|\Throwable|\ValueError $exception)
    {
        throw new \Exception($exception->getMessage(), $exception->getCode());
    }

}
