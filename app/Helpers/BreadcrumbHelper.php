<?php

namespace App\Helpers;

class BreadcrumbHelper
{
    public static function generate($breadcrumbs)
    {
        return view('admin.partials.breadcrumbs', compact('breadcrumbs'));
    }
}
