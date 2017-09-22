<?php

namespace Illuminate\View\Middleware;

use Illuminate\Support\ViewErrorBag;

class ShareErrorsFromSession extends ShareMessagesFromSession
{
    /**
     * Session variable name.
     *
     * @var string
     */
    protected $sessionKey = 'errors';

    /**
     * Value used if the session key is empty.
     * @return mixed
     */
    protected function defaultValue(){
        return new ViewErrorBag;
    }
}
