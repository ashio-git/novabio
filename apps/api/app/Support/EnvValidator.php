<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class EnvValidator
{
    public static function validate(): void
    {
        $rules = [
            'APP_NAME' => 'required|string',
            'APP_ENV' => 'required|in:local,staging,production',
            'APP_KEY' => 'required|string|min:32',
            'APP_URL' => 'required|url',
            
            'DB_CONNECTION' => 'required|in:pgsql',
            'DB_HOST' => 'required|string',
            'DB_PORT' => 'required|integer',
            'DB_DATABASE' => 'required|string',
            'DB_USERNAME' => 'required|string',
            'DB_PASSWORD' => 'required|string',
            
            'REDIS_HOST' => 'required|string',
            'REDIS_PORT' => 'required|integer',
            
            'QUEUE_CONNECTION' => 'required|in:redis,sync',
            
            'MERCADOPAGO_PUBLIC_KEY' => 'nullable|string',
            'MERCADOPAGO_ACCESS_TOKEN' => 'nullable|string',
            'MERCADOPAGO_WEBHOOK_SECRET' => 'nullable|string',
            
            'MAIL_MAILER' => 'required|string',
            'MAIL_FROM_ADDRESS' => 'required|email',
            
            'MEILISEARCH_HOST' => 'nullable|url',
            
            'MINIO_ENDPOINT' => 'nullable|url',
            'MINIO_BUCKET' => 'nullable|string',
        ];

        $data = [];
        foreach (array_keys($rules) as $key) {
            $data[$key] = env($key);
        }

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            echo "\n❌ Invalid environment configuration:\n";
            foreach ($validator->errors()->all() as $error) {
                echo "  - $error\n";
            }
            echo "\nPlease check your .env file against .env.example\n\n";
            exit(1);
        }
    }
}
