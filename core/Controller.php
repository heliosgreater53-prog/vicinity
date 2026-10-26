<?php

declare(strict_types=1);

namespace Core;

/**
 * Controller – base controller class providing convenience helpers.
 */
abstract class Controller
{
    /**
     * Render a view file with layout and data.
     */
    protected function view(string $template, array $data = []): Response
    {
        return view($template, $data);
    }

    /**
     * Return a JSON response.
     */
    protected function json(mixed $data, int $status = 200, array $headers = []): Response
    {
        return json($data, $status, $headers);
    }

    /**
     * Return a redirect response.
     */
    protected function redirect(string $url, int $status = 302): Response
    {
        return redirect($url, $status);
    }

    /**
     * Redirect back to previous page.
     */
    protected function back(): Response
    {
        return back();
    }

    /**
     * Validate current request input against rules.
     *
     * @param array<string, string|array> $rules
     * @return array<string, string[]> Empty if passes, errors if fails
     */
    protected function validate(array $rules): array
    {
        return request()->validate($rules);
    }
}
