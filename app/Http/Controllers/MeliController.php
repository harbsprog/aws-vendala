<?php

namespace App\Http\Controllers;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;
use Illuminate\Http\Request;

class MeliController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function sendSQS(Request $request)
    {
        $client = SqsClient::factory([
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY'),
                'secret' => env('AWS_SECRET_KEY')
            ],
            'region' => 'us-east-1',
            'version' => '2012-11-05'
        ]);

        $params = [
            'MessageAttributes' => [
                "titulo" => [
                    'DataType' => "String",
                    'StringValue' => $request->titulo
                ],
                "categoria" => [
                    'DataType' => "String",
                    'StringValue' => $request->categoria
                ],
                "preco" => [
                    'DataType' => "Number",
                    'StringValue' => $request->preco
                ],
                "quantidade" => [
                    'DataType' => "Number",
                    'StringValue' => $request->quantidade
                ],
                "descricao" => [
                    'DataType' => "String",
                    'StringValue' => $request->descricao
                ],
                "fotos" => [
                    'DataType' => "String",
                    'StringValue' => json_encode($request->fotos)
                ],
                "token" => [
                    'DataType' => "String",
                    'StringValue' => $request->token
                ]
            ],
            'MessageBody' => "Graziani Imports Blau Blau",
            'QueueUrl' => env('SQS_QUEUE')
        ];

        try {
            $result = $client->sendMessage($params);
        } catch (AwsException $e) {
            // output error message if fails
            // error_log($e->getMessage());
        }
    }
}
