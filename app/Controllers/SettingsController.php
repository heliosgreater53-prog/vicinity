<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\Request;
use Core\Response;

class SettingsController extends Controller
{
    public function index(Request $request): Response
    {
        $user = auth()->user() ?? (new User([
            'id'       => 1,
            'name'     => 'Alex Rivers',
            'email'    => 'alex@vicinity.local',
            'bio'      => 'Local explorer living downtown.',
            'location' => 'Downtown Portland',
        ]));

        return $this->view('settings.index', [
            'title' => 'Account Settings – Vicinity',
            'user'  => $user,
        ]);
    }

    public function update(Request $request): Response
    {
        $errors = $this->validate([
            'name'  => 'required|min:2|max:100',
            'email' => 'required|email',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            return $this->back();
        }

        /** @var User|null $user */
        $user = auth()->user();
        if ($user) {
            $user->update([
                'name'     => $request->post('name'),
                'email'    => $request->post('email'),
                'bio'      => $request->post('bio'),
                'location' => $request->post('location'),
            ]);
        }

        session()->flash('success', 'Your profile settings have been updated.');
        return $this->back();
    }
}
