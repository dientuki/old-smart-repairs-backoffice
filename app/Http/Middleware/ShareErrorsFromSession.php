<?php

namespace App\Http\Middleware;

use Closure;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Middleware\ShareErrorsFromSession as Middleware;

class ShareErrorsFromSession extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $errors = $request->session()->get('errors');
        // If the current session has an "errors" variable bound to it, we will share
        // its value with all view instances so the views can easily access errors
        // without having to bind. An empty bag is set when there aren't errors.
        $this->view->share('errors', $errors? : new ViewErrorBag);

        if ($errors != null) {
            Alert::error(__('error.in-forms'));
        }

        // Putting the errors in the view for every view allows the developer to just
        // assume that some errors are always available, which is convenient since
        // they don't have to continually run checks for the presence of errors.

        return $next($request);
    }
}
