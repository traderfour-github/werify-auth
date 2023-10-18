<?php

namespace App\Console\Commands\Stub;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StubBase extends Command
{
    protected $signature = 'app:base-stub';

    public function generateStubAndSave($stub_path, $args, $save_path)
    {
        $content = File::get($stub_path);
        foreach ($args as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }
        // touch($save_path);
        File::put($save_path, $content);
    }
}
