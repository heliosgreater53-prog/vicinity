<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Business;
use Core\Controller;
use Core\Request;
use Core\Response;

class BusinessController extends Controller
{
    public function index(Request $request): Response
    {
        $category = $request->get('category');
        $search   = $request->get('q');
        $businesses = [];

        try {
            $query = Business::query();
            if ($category && $category !== 'All') {
                $query->where('category', $category);
            }
            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }
            $rows = $query->latest()->get();
            $businesses = Business::hydrateAll($rows);

            if (empty($businesses) && empty($category) && empty($search)) {
                $seedFile = dirname(__DIR__, 2) . '/database/seed.php';
                if (file_exists($seedFile)) {
                    require_once $seedFile;
                    $businesses = Business::hydrateAll(Business::query()->latest()->get());
                }
            }
        } catch (\Throwable $e) {
            // graceful fallback
        }

        return $this->view('business.index', [
            'title'      => 'Local Businesses – Vicinity',
            'businesses' => $businesses,
            'category'   => $category,
            'search'     => $search,
        ]);
    }

    public function detail(Request $request, string|int $id): Response
    {
        $business = null;
        try {
            $business = Business::find((int) $id);
        } catch (\Throwable $e) {
            // ignore
        }

        if (!$business) {
            session()->flash('error', 'The requested business listing was not found.');
            return $this->redirect('/businesses');
        }

        return $this->view('business.detail', [
            'title'    => $business->name . ' – Vicinity',
            'business' => $business,
        ]);
    }

    public function create(): Response
    {
        return $this->view('business.list', [
            'title' => 'Register a Business – Vicinity',
        ]);
    }

    public function store(Request $request): Response
    {
        $errors = $this->validate([
            'name'     => 'required|min:2|max:150',
            'category' => 'required',
            'address'  => 'required',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_name', $request->post('name'));
            session()->flash('_old_category', $request->post('category'));
            session()->flash('_old_address', $request->post('address'));
            return $this->back();
        }

        try {
            $business = Business::create([
                'user_id'       => auth()->id() ?? 1,
                'name'          => $request->post('name'),
                'category'      => $request->post('category'),
                'address'       => $request->post('address'),
                'phone'         => $request->post('phone'),
                'email'         => $request->post('email'),
                'website'       => $request->post('website'),
                'description'   => $request->post('description'),
                'image'         => $request->post('image') ?: 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?auto=format&fit=crop&w=600&q=80',
                'rating'        => 5.0,
                'reviews_count' => 0,
                'price_range'   => $request->post('price_range') ?: '₦₦ • Moderate',
                'status'        => 'Open Now',
                'opening_hours' => $request->post('opening_hours') ?: '8AM - 8PM',
            ]);

            session()->flash('success', 'Your business has been successfully registered!');
            return $this->redirect('/businesses/' . $business->id);
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed to register business: ' . $e->getMessage());
            return $this->back();
        }
    }
}
