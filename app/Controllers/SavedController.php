<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\SavedItem;
use Core\Controller;
use Core\Request;
use Core\Response;

class SavedController extends Controller
{
    public function index(Request $request): Response
    {
        $savedItems = [];
        try {
            $savedItems = SavedItem::hydrateAll(SavedItem::query()->where('user_id', auth()->id() ?? 1)->latest()->get());
        } catch (\Throwable $e) {
            // graceful fallback
        }

        return $this->view('saved.index', [
            'title'      => 'Saved Items – Vicinity',
            'savedItems' => $savedItems,
        ]);
    }
}
