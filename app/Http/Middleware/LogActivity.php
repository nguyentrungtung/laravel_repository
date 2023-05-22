<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Before the request is executed
        $response = $next($request);
        // After the request is executed
        // Check if the request is for creating or updating a post
        if ($request->isMethod('put') || $request->isMethod('post')) {
            $url = $request->url();
            $method = $request->method();
            if (strpos($url, '/demo') !== false) {
                $log = new Log();
                $log->name = Auth::user()->name;
                $log->email = Auth::user()->email;
                $log->ip = $request->ip();
                $log->browser = $request->userAgent();
                $log->module = 'Demo';
                $log->method = $method;
                $log->data = json_encode($request->all());
               if($method === "POST"){
                $log->action = 'Tạo mới';
               };
               if($method === 'PUT' || $method === 'PATCH'){
                $log->action = 'Chỉnh sửa';
               };
               if($method === "DELETE"){
                $log->action = 'Xoá';
               };
               $log->save();
            }
            //
        }

        return $response;
    }
}
