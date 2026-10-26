<?php

declare(strict_types=1);

namespace Core;

use App\Models\User;

/**
 * Auth – authentication manager.
 */
class Auth
{
    private ?User $cachedUser = null;

    public function __construct(
        protected Session $session
    ) {
    }

    /**
     * Check if a user is currently logged in.
     */
    public function check(): bool
    {
        return $this->id() !== null;
    }

    /**
     * Check if current visitor is a guest.
     */
    public function guest(): bool
    {
        return !$this->check();
    }

    /**
     * Get the authenticated user ID.
     */
    public function id(): ?int
    {
        $id = $this->session->get('user_id');
        return $id !== null ? (int) $id : null;
    }

    /**
     * Get the currently authenticated User model instance.
     */
    public function user(): ?User
    {
        if ($this->cachedUser !== null) {
            return $this->cachedUser;
        }

        $id = $this->id();
        if ($id === null) {
            return null;
        }

        /** @var User|null $user */
        $user = User::find($id);
        $this->cachedUser = $user;

        return $user;
    }

    /**
     * Attempt login with credentials.
     */
    public function attempt(string $email, string $password): bool
    {
        /** @var User|null $user */
        $user = User::where('email', $email)->first();

        if ($user === null) {
            return false;
        }

        if (!password_verify($password, (string) $user->password)) {
            return false;
        }

        $this->login($user);
        return true;
    }

    /**
     * Log in a given User model instance.
     */
    public function login(User $user): void
    {
        $this->session->regenerate(true);
        $this->session->set('user_id', $user->id);
        $this->cachedUser = $user;
    }

    /**
     * Log out the current user and flush session.
     */
    public function logout(): void
    {
        $this->session->forget('user_id');
        $this->session->regenerate(true);
        $this->cachedUser = null;
    }
}
