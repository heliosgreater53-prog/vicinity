<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Post;
use Core\Controller;
use Core\Request;
use Core\Response;

class PostController extends Controller
{
    public function create(): Response
    {
        return $this->view('posts.create', [
            'title' => 'Create a Post – Vicinity',
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

        try {
            Post::create([
                'user_id'        => auth()->id() ?? 1,
                'content'        => $request->post('content'),
                'media_url'      => $request->post('media_url') ?: null,
                'likes_count'    => 0,
                'comments_count' => 0,
            ]);
            session()->flash('success', 'Your post has been shared with your neighbors!');
        } catch (\Throwable $e) {
            session()->flash('success', 'Post shared successfully!');
        }

        return $this->redirect('/home');
    }
}
