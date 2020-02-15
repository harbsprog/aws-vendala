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
                    'StringValue' => $request->get('titulo')
                ],
                "categoria" => [
                    'DataType' => "String",
                    'StringValue' => $request->get('categoria')
                ],
                "preco" => [
                    'DataType' => "String",
                    'StringValue' => $request->get('preco')
                ],
                "quantidade" => [
                    'DataType' => "String",
                    'StringValue' => $request->get('quantidade')
                ],
                "descricao" => [
                    'DataType' => "String",
                    'StringValue' => $request->get('descricao')
                ],
                "fotos" => [
                    'DataType' => "String",
                    'StringValue' => json_encode($request->get('fotos'))
                ],
                "token" => [
                    'DataType' => "String",
                    'StringValue' => $request->get('token')
                ]
            ],
            'MessageBody' => "Graziani Imports Blau Blau",
            'QueueUrl' => env('SQS_QUEUE')
        ];

        try {
            for ($i = 0; $i < 50; $i++) {
                $result = $client->sendMessage($params);
                dump('DISPATCHED');
            }
            $result = $client->sendMessage($params);
            var_dump($result);
        } catch (AwsException $e) {
            // output error message if fails
            // error_log($e->getMessage());
        }
    }
}
