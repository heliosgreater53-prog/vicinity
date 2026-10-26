<?php

declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use Core\Request;
use Core\Response;

class PageController extends Controller
{
    public function about(Request $request): Response
    {
        return $this->view('pages.about', [
            'title' => 'About Vicinity – Hyperlocal Community Platform',
        ]);
    }

    public function landing(Request $request): Response
    {
        return $this->view('pages.landing', [
            'title' => 'Vicinity – Connect With Your Local Neighborhood',
        ]);
    }
}
