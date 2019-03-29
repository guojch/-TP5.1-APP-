<?php

use think\facade\Env;

return [
    'dispatch_error_tmpl' => Env::get('app_path').'admin/view/public/error.tpl',
    'dispatch_success_tmpl' => Env::get('app_path').'admin/view/public/success.tpl',
];