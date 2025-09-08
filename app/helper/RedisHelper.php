<?php
// RedisHelper.php
namespace AppHelper;
use Illuminate\Support\Facades\Redis;

class RedisHelper
{
    public static function getCacheData(string $cacheKey)
    {
        return Redis::command('get', [$cacheKey]);
    }

    public static function setCacheData(string $cacheKey, string $data)
    {
        return Redis::command('set', [$cacheKey, $data]);
    }

    public static function expireCacheData(string $cacheKey)
    {
        return Redis::command('expire', [$cacheKey, 60]);
    }
    public static function deleteCacheData(string $data)
    {
        Redis::command('del', [$data]);
    }
}