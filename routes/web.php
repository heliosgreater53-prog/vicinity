<?php

declare(strict_types=1);

/** @var Core\Router $router */

use App\Controllers\AuthController;
use App\Controllers\BusinessController;
use App\Controllers\CommunityController;
use App\Controllers\EventController;
use App\Controllers\GroupController;
use App\Controllers\HomeController;
use App\Controllers\NotificationController;
use App\Controllers\PageController;
use App\Controllers\PostController;
use App\Controllers\SavedController;
use App\Controllers\SettingsController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\GuestMiddleware;

// -----------------------------------------------------------------------------
// Public & Informational
// -----------------------------------------------------------------------------
$router->get('/', [PageController::class, 'landing'])->name('landing');
$router->get('/welcome', [PageController::class, 'landing']);
$router->get('/about', [PageController::class, 'about'])->name('about');

// -----------------------------------------------------------------------------
// Home Feed (authenticated)
// -----------------------------------------------------------------------------
$router->get('/home', [HomeController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('home');

// -----------------------------------------------------------------------------
// Authentication
// -----------------------------------------------------------------------------
$router->get('/login', [AuthController::class, 'login'])
    ->middleware('GuestMiddleware')
    ->name('login');

$router->post('/login', [AuthController::class, 'attemptLogin'])
    ->middleware('CsrfMiddleware');

$router->get('/signup', [AuthController::class, 'signup'])
    ->middleware('GuestMiddleware')
    ->name('signup');

$router->post('/signup', [AuthController::class, 'register'])
    ->middleware('CsrfMiddleware');

$router->get('/logout', [AuthController::class, 'logout'])->name('logout');
$router->post('/logout', [AuthController::class, 'logout']);

// -----------------------------------------------------------------------------
// Businesses
// -----------------------------------------------------------------------------
$router->get('/businesses', [BusinessController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('businesses.index');
$router->get('/businesses/create', [BusinessController::class, 'create'])
    ->middleware('AuthMiddleware')
    ->name('businesses.create');
$router->post('/businesses', [BusinessController::class, 'store'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware')
    ->name('businesses.store');
$router->get('/businesses/:id', [BusinessController::class, 'detail'])
    ->middleware('AuthMiddleware')
    ->name('businesses.detail');

// -----------------------------------------------------------------------------
// Group API (JSON) – literal-path routes MUST come before /:id wildcard
// -----------------------------------------------------------------------------
$router->get('/api/groups/mine', [GroupController::class, 'mine'])
    ->middleware('AuthMiddleware');
$router->post('/api/groups/heartbeat', [GroupController::class, 'heartbeat'])
    ->middleware('AuthMiddleware');
$router->get('/api/groups/:id', [GroupController::class, 'show'])
    ->middleware('AuthMiddleware');
$router->get('/api/groups/:id/members', [GroupController::class, 'members'])
    ->middleware('AuthMiddleware');
$router->get('/api/groups/:id/messages', [GroupController::class, 'messages'])
    ->middleware('AuthMiddleware');
$router->post('/api/groups/:id/messages', [GroupController::class, 'sendMessage'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware');

// -----------------------------------------------------------------------------
// Communities / Neighborhood Groups
// -----------------------------------------------------------------------------
$router->get('/community', [CommunityController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('community.index');
$router->get('/community/create', [CommunityController::class, 'create'])
    ->middleware('AuthMiddleware')
    ->name('community.create');
$router->post('/community', [CommunityController::class, 'store'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware')
    ->name('community.store');

// -----------------------------------------------------------------------------
// Events
// -----------------------------------------------------------------------------
$router->get('/events', [EventController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('events.index');
$router->get('/events/create', [EventController::class, 'create'])
    ->middleware('AuthMiddleware')
    ->name('events.create');
$router->post('/events', [EventController::class, 'store'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware')
    ->name('events.store');

// -----------------------------------------------------------------------------
// Posts
// -----------------------------------------------------------------------------
$router->get('/posts/create', [PostController::class, 'create'])
    ->middleware('AuthMiddleware')
    ->name('posts.create');
$router->post('/posts', [PostController::class, 'store'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware')
    ->name('posts.store');

// -----------------------------------------------------------------------------
// User Profile, Saved & Notifications
// -----------------------------------------------------------------------------
$router->get('/saved', [SavedController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('saved.index');
$router->get('/settings', [SettingsController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('settings.index');
$router->post('/settings', [SettingsController::class, 'update'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware')
    ->name('settings.update');

$router->get('/notifications', [NotificationController::class, 'index'])
    ->middleware('AuthMiddleware')
    ->name('notifications.index');
$router->post('/notifications/read-all', [NotificationController::class, 'markAllRead'])
    ->middleware('AuthMiddleware')
    ->middleware('CsrfMiddleware');
