<?php

namespace Illuminate\View\Middleware;

use Closure;
use Illuminate\Support\MultiMessageBag;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class ShareMessagesFromSession
{
    /**
     * The view factory implementation.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $view;

    /**
     * Session variable name.
     *
     * @var string
     */
    protected $sessionKey;

    /**
     * View variable name.
     * @var string
     */
    protected $viewKey;

    /**
     * Create a new error binder instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $viewKey = $this->viewKey ?: $this->sessionKey;

        // If the current session has a "$this->sessionKey" variable bound to it, we will share
        // its value with all view instances so the views can easily access statuses
        // without having to bind. An empty bag is set when there aren't statuses.
        $this->view->share(
            $viewKey, $request->session()->get($this->sessionKey) ?: $this->defaultValue()
        );

        // Putting the statuses in the view for every view allows the developer to just
        // assume that some statuses are always available, which is convenient since
        // they don't have to continually run checks for the presence of statuses.

        return $next($request);
    }

    /**
     * Value used if the session key is empty.
     * @return mixed
     */
    protected function defaultValue(){
        return new MultiMessageBag;
    }
}
