<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Business;
use App\Models\Event;
use App\Models\Post;
use Core\Controller;
use Core\Request;
use Core\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = [];
        $events = [];
        $businesses = [];

        try {
            $posts = Post::query()->latest()->limit(10)->get();
            $events = Event::query()->latest('event_date')->limit(3)->get();
            $businesses = Business::query()->latest()->limit(4)->get();
        } catch (\Throwable $e) {
            // Database not yet configured or connection offline - views handle sample data gracefully
        }

        return $this->view('home.index', [
            'title'      => 'Vicinity – Local Feed',
            'posts'      => $posts,
            'events'     => $events,
            'businesses' => $businesses,
        ]);
    }
}
