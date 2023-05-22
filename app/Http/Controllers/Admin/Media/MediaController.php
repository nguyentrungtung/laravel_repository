<?php


namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Services\Production\FileServices;
use Exception;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        if(\Auth::user()->hasPermissionTo('view media')) {
            return view('admin.media.index');
        } else {
            \App::abort(403);
        }
    }
}
