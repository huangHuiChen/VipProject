<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Storage;

class JsonConfig
{
    // 讀取 JSON 文件中的指定 key 值
    public static function getDynamicConfig($key)
    {
        $data = json_decode(Storage::get('setting.json'), true);
        return $data[$key] ?? null;
    }

    // 寫入 JSON 文件中的指定 key 值
    public static function setDynamicConfig($key, $value)
    {
        $data = json_decode(Storage::get('setting.json'), true);
        $data[$key] = $value;
        Storage::put('setting.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
