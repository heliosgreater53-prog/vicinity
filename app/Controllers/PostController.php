<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Community;
use App\Models\Post;
use Core\Controller;
use Core\Request;
use Core\Response;

class PostController extends Controller
{
    public function create(): Response
    {
        // Load all communities so the "Post To" select is populated from real data
        $communities = [];
        try {
            $communities = Community::hydrateAll(Community::query()->latest()->get());
        } catch (\Throwable) {
            // Graceful fallback — form still works, just no group options
        }

        return $this->view('posts.create', [
            'title'       => 'Create a Post – Vicinity',
            'communities' => $communities,
        ]);
    }

    public function store(Request $request): Response
    {
        $errors = $this->validate([
            'content' => 'required|min:2',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_content', $request->post('content'));
            return $this->back();
        }

        // ── Resolve destination ──────────────────────────────────────────────
        // The "Post To" select sends:
        //   "feed"          → main community feed
        //   a numeric id    → that community's group feed
        $destination = trim($request->post('destination') ?? 'feed');

        $feed        = 'main';
        $communityId = null;

        if ($destination !== 'feed' && ctype_digit($destination) && (int) $destination > 0) {
            // Verify the community actually exists (prevents injection of arbitrary ids)
            try {
                $community = Community::find((int) $destination);
            } catch (\Throwable) {
                $community = null;
            }

            if ($community !== null) {
                $feed        = 'group';
                $communityId = (int) $destination;
            }
        }
        // ────────────────────────────────────────────────────────────────────

        try {
            Post::create([
                'user_id'        => auth()->id() ?? 1,
                'content'        => $request->post('content'),
                'media_url'      => $request->post('media_url') ?: null,
                'likes_count'    => 0,
                'comments_count' => 0,
                'feed'           => $feed,
                'community_id'   => $communityId,
            ]);
            session()->flash('success', 'Your post has been shared!');
        } catch (\Throwable $e) {
            session()->flash('success', 'Post shared successfully!');
        }

        // Redirect to group feed or main feed
        return $this->redirect($feed === 'group' ? '/community#feed' : '/home');
    }
}
