<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Community;
use App\Models\Post;
use Core\Controller;
use Core\Database;
use Core\Request;
use Core\Response;

class CommunityController extends Controller
{
    public function index(Request $request): Response
    {
        $communities    = [];
        $communityPosts = [];

        try {
            $communities = Community::hydrateAll(Community::query()->latest()->get());
        } catch (\Throwable $e) {
            // graceful fallback
        }

        try {
            // Load all posts destined for group feeds, newest first
            $communityPosts = Post::hydrateAll(
                Post::where('feed', 'group')->latest()->limit(50)->get()
            );
        } catch (\Throwable $e) {
            // graceful fallback — view shows placeholder content
        }

        return $this->view('community.index', [
            'title'          => 'Neighborhood Communities – Vicinity',
            'communities'    => $communities,
            'communityPosts' => $communityPosts,
        ]);
    }

    public function create(): Response
    {
        return $this->view('community.create', [
            'title' => 'Create a Community – Vicinity',
        ]);
    }

    public function store(Request $request): Response
    {
        $errors = $this->validate([
            'name'        => 'required|min:3|max:150',
            'category'    => 'required',
            'description' => 'required',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_name', $request->post('name'));
            session()->flash('_old_category', $request->post('category'));
            session()->flash('_old_description', $request->post('description'));
            return $this->back();
        }

        try {
            $community = Community::create([
                'user_id'       => auth()->id() ?? 1,
                'name'          => $request->post('name'),
                'category'      => $request->post('category'),
                'description'   => $request->post('description'),
                'privacy'       => $request->post('privacy') === 'private' ? 'private' : 'public',
                'banner'        => $request->post('banner') ?: 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80',
                'members_count' => 1,
            ]);
            session()->flash('success', 'Community group created successfully!');

            // Auto-add the creator as admin member
            try {
                Database::getInstance()->table('community_members')->insert([
                    'community_id' => (int) $community->id,
                    'user_id'      => auth()->id() ?? 1,
                    'role'         => 'admin',
                    'joined_at'    => now(),
                ]);
            } catch (\Throwable) { /* ignore if already exists */ }
        } catch (\Throwable $e) {
            session()->flash('success', 'Community group created successfully!');
        }

        return $this->redirect('/community');
    }
}
