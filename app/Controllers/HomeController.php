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
            // Only show posts destined for the main community feed
            $posts      = Post::hydrateAll(Post::where('feed', 'main')->latest()->limit(20)->get());
            $events     = Event::hydrateAll(Event::query()->latest('event_date')->limit(3)->get());
            $businesses = Business::hydrateAll(Business::query()->latest()->limit(4)->get());
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
