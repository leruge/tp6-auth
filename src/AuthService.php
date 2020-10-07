<?php


namespace leruge;

use leruge\command\Publish;
use think\Service;

class AuthService extends Service
{
    public function boot()
    {
        $this->commands([
            'auth:publish' => Publish::class
        ]);
    }
}