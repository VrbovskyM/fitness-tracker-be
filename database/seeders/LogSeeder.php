<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Log;
use Carbon\Carbon;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = ['debug', 'info', 'warn', 'error'];
        
        $messages = [
            'debug' => [
                'Database query executed successfully',
                'User session initiated', 
                'Cache hit for key: user_preferences',
                'API request processed',
                'Memory usage: 45MB',
            ],
            'info' => [
                'User logged in successfully',
                'Password reset email sent',
                'File uploaded successfully',
                'Payment processed',
                'User profile updated',
                'Workout completed',
                'Goal achieved',
            ],
            'warn' => [
                'High memory usage detected',
                'Slow database query detected',
                'Rate limit approaching for user',
                'Deprecated API endpoint used',
                'Large file upload detected',
            ],
            'error' => [
                'Failed to connect to database',
                'Authentication failed',
                'File upload failed',
                'Payment processing error',
                'API request timeout',
                'Invalid workout data submitted',
            ]
        ];

        $sources = [
            'AuthController',
            'WorkoutController', 
            'UserController',
            'PaymentService',
            'DatabaseService',
            'CacheService',
            'FileUploadService',
            'frontend',
            'mobile-app',
        ];

        $urls = [
            '/api/auth/login',
            '/api/workouts',
            '/api/user/profile',
            '/api/payments',
            '/dashboard',
            '/workouts/create',
            '/settings',
            '/api/logs',
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Android 11; Mobile; rv:89.0) Gecko/89.0 Firefox/89.0',
        ];

        $stackTraces = [
            "#0 /var/www/app/Http/Controllers/AuthController.php(45): App\\Services\\AuthService->authenticate()\n#1 /var/www/vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): App\\Http\\Controllers\\AuthController->login()",
            "#0 /var/www/app/Models/User.php(123): Illuminate\\Database\\Connection->select()\n#1 /var/www/app/Http/Controllers/UserController.php(67): App\\Models\\User->findOrFail()",
            "#0 /var/www/app/Services/PaymentService.php(89): GuzzleHttp\\Client->post()\n#1 /var/www/app/Http/Controllers/PaymentController.php(34): App\\Services\\PaymentService->processPayment()",
        ];

        // Create 500 log entries
        for ($i = 0; $i < 500; $i++) {
            $level = $levels[array_rand($levels)];
            $message = $messages[$level][array_rand($messages[$level])];
            
            $additionalData = [];
            
            // Add level-specific additional data
            switch ($level) {
                case 'error':
                    $additionalData = [
                        'error_code' => ['E001', 'E002', 'E003', 'DB_CONNECTION_FAILED'][array_rand(['E001', 'E002', 'E003', 'DB_CONNECTION_FAILED'])],
                        'retry_count' => rand(0, 3),
                    ];
                    break;
                case 'info':
                    $additionalData = [
                        'duration_ms' => rand(50, 2000),
                        'status_code' => [200, 201, 204][array_rand([200, 201, 204])],
                    ];
                    break;
                case 'warn':
                    $additionalData = [
                        'threshold_exceeded' => (bool)rand(0, 1),
                        'current_value' => rand(70, 95),
                    ];
                    break;
            }

            Log::create([
                'message' => $message,
                'level' => $level,
                'timestamp' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'stack' => $level === 'error' ? $stackTraces[array_rand($stackTraces)] : null,
                'source' => $sources[array_rand($sources)],
                'user_id' => rand(0, 10) > 3 ? (string)rand(1, 10) : null, // 70% chance of having a user_id
                'url' => $urls[array_rand($urls)],
                'user_agent' => $userAgents[array_rand($userAgents)],
                'session_id' => sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                ),
                'additional_data' => !empty($additionalData) ? $additionalData : null,
            ]);
        }

        $this->command->info('Created 500 log entries.');
    }
}
