<?php

use Helpers\Hooks;

Hooks::addHook('routes', 'Modules\Authentifier\Controllers\Authentifier@routes');
Hooks::addHook('routes', 'Modules\Authentifier\Controllers\Login@routes');
Hooks::addHook('routes', 'Modules\Authentifier\Controllers\Register@routes');
Hooks::addHook('routes', 'Modules\Authentifier\Controllers\Profile@routes');
