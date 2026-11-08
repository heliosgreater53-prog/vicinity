<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\Request;
use Core\Response;
use Core\Session;

class AuthController extends Controller
{
    public function login(): Response
    {
        return $this->view('auth.login', [
            'title' => 'Sign In – Vicinity'
        ]);
    }

    public function attemptLogin(Request $request): Response
    {
        $errors = $this->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_email', $request->post('email'));
            return $this->back();
        }

        $email    = (string) $request->post('email');
        $password = (string) $request->post('password');

        if (!auth()->attempt($email, $password)) {
            session()->flash('error', 'Invalid email or password.');
            session()->flash('_old_email', $email);
            return $this->back();
        }

        session()->flash('success', 'Welcome back!');
        $intended = session()->get('_intended_url', '/home');
        session()->forget('_intended_url');

        return $this->redirect($intended);
    }

    public function signup(): Response
    {
        return $this->view('auth.signup', [
            'title' => 'Create an Account – Vicinity'
        ]);
    }

    public function register(Request $request): Response
    {
        $errors = $this->validate([
            'name'     => 'required|min:2|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_name', $request->post('name'));
            session()->flash('_old_email', $request->post('email'));
            return $this->back();
        }

        $user = User::create([
            'name'     => $request->post('name'),
            'email'    => $request->post('email'),
            'password' => password_hash((string) $request->post('password'), PASSWORD_BCRYPT),
        ]);

        auth()->login($user);
        session()->flash('success', 'Welcome to Vicinity! Your account has been created.');

        return $this->redirect('/home');
    }

    public function logout(): Response
    {
        auth()->logout();
        session()->flash('success', 'You have been logged out.');
        return $this->redirect('/login');
    }
}
