<?php

namespace WebEd\Base\Core\Http\Controllers;

use Illuminate\Routing\Controller;

class ResolveSlug extends Controller
{
    public function index($slug = null)
    {
        dd($slug);
    }
}
