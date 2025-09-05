<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = ['debug', 'info', 'warn', 'error'];
        $level = $this->faker->randomElement($levels);
        
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

        $additionalData = [];
        
        // Add level-specific additional data
        switch ($level) {
            case 'error':
                $additionalData = [
                    'error_code' => $this->faker->randomElement(['E001', 'E002', 'E003', 'DB_CONNECTION_FAILED']),
                    'retry_count' => $this->faker->numberBetween(0, 3),
                ];
                break;
            case 'info':
                $additionalData = [
                    'duration_ms' => $this->faker->numberBetween(50, 2000),
                    'status_code' => $this->faker->randomElement([200, 201, 204]),
                ];
                break;
            case 'warn':
                $additionalData = [
                    'threshold_exceeded' => $this->faker->boolean(),
                    'current_value' => $this->faker->numberBetween(70, 95),
                ];
                break;
        }

        return [
            'message' => $this->faker->randomElement($messages[$level]),
            'level' => $level,
            'timestamp' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'stack' => $level === 'error' ? $this->generateStackTrace() : null,
            'source' => $this->faker->randomElement($sources),
            'user_id' => $this->faker->optional(0.7)->numberBetween(1, 10),
            'url' => $this->faker->randomElement($urls),
            'user_agent' => $this->faker->randomElement($userAgents),
            'session_id' => $this->faker->uuid(),
            'additional_data' => !empty($additionalData) ? $additionalData : null,
        ];
    }

    /**
     * Generate a realistic stack trace for error logs
     */
    private function generateStackTrace(): string
    {
        $traces = [
            "#0 /var/www/app/Http/Controllers/AuthController.php(45): App\Services\AuthService->authenticate()\n#1 /var/www/vendor/laravel/framework/src/Illuminate/Routing/Controller.php(54): App\Http\Controllers\AuthController->login()\n#2 /var/www/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php(45): call_user_func_array()",
            "#0 /var/www/app/Models/User.php(123): Illuminate\Database\Connection->select()\n#1 /var/www/app/Http/Controllers/UserController.php(67): App\Models\User->findOrFail()\n#2 /var/www/vendor/laravel/framework/src/Illuminate/Foundation/Http/Kernel.php(176): App\Http\Controllers\UserController->show()",
            "#0 /var/www/app/Services/PaymentService.php(89): GuzzleHttp\Client->post()\n#1 /var/www/app/Http/Controllers/PaymentController.php(34): App\Services\PaymentService->processPayment()\n#2 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(167): App\Http\Controllers\PaymentController->store()",
        ];
        
        return $this->faker->randomElement($traces);
    }
}
