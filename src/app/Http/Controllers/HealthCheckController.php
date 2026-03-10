<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\HealthcheckLog;

class HealthCheckController extends Controller
{
    public function index(Request $request)
    {
        $dbStatus = false;
        $cacheStatus = false;

        try {
            DB::connection()->getPdo();
            $dbStatus = true;
        } catch (\Exception $e) {
            $dbStatus = false;
        }

        try {
            Cache::store('redis')->put('health', 'ok', 10);
            $cacheStatus = Cache::store('redis')->get('health') === 'ok';
        } catch (\Throwable $e) {
            $cacheStatus = false;
        }
        
        try {
            HealthcheckLog::create([
                'owner' => $request->header('X-Owner')
            ]);
        } catch (\Exception $e) {
        }

        $statusCode = ($dbStatus && $cacheStatus) ? 200 : 500;

        return response()->json([
            'db' => $dbStatus,
            'cache' => $cacheStatus
        ], $statusCode);
    }
}
