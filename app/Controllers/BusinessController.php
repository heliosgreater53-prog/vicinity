<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Business;
use App\Models\BusinessProduct;
use App\Models\BusinessService;
use Core\Controller;
use Core\Request;
use Core\Response;

class BusinessController extends Controller
{
    // ── Upload configuration ──────────────────────────────────────────────────

    /** Allowed MIME types for image uploads */
    private const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /** Max file size in bytes (2 MB) */
    private const MAX_SIZE = 2 * 1024 * 1024;

    /** Public-relative path for uploaded business images */
    private const UPLOAD_DIR = 'uploads/businesses';

    // ── Actions ───────────────────────────────────────────────────────────────

    public function index(Request $request): Response
    {
        $category   = $request->get('category');
        $search     = $request->get('q');
        $businesses = [];
        $dbError    = null;

        try {
            $query = Business::query();
            if ($category && $category !== 'All') {
                $query->where('category', $category);
            }
            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            }
            $businesses = Business::hydrateAll($query->latest()->get());
        } catch (\Throwable $e) {
            $dbError = $e->getMessage();
        }

        return $this->view('business.index', [
            'title'      => 'Local Businesses – Vicinity',
            'businesses' => $businesses,
            'category'   => $category,
            'search'     => $search,
            'dbError'    => $dbError,
        ]);
    }

    public function detail(Request $request, string|int $id): Response
    {
        $business = null;
        $products = [];
        $services = [];

        try {
            $business = Business::find((int) $id);
            if ($business) {
                $products = $business->products();
                $services = $business->businessServices();
            }
        } catch (\Throwable) {
            // ignore DB errors; view handles missing data gracefully
        }

        if (!$business) {
            session()->flash('error', 'The requested business listing was not found.');
            return $this->redirect('/businesses');
        }

        return $this->view('business.detail', [
            'title'    => $business->name . ' – Vicinity',
            'business' => $business,
            'products' => $products,
            'services' => $services,
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
        $userId = auth()->id();
        if (!$userId) {
            session()->flash('error', 'You must be logged in to register a business.');
            return $this->redirect('/login');
        }

        // ── Validation (required core fields only) ─────────────────────────
        $errors = $this->validate([
            'name'     => 'required|min:2|max:150',
            'category' => 'required',
            'address'  => 'required',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            foreach (['name','category','address','description','phone','email',
                      'website','opening_hours','price_range'] as $f) {
                session()->flash('_old_' . $f, $request->post($f));
            }
            return $this->back();
        }

        // ── Handle image uploads ────────────────────────────────────────────
        $logoPath      = $this->handleUpload('logo',         $userId);
        $coverPath     = $this->handleUpload('cover_image',  $userId);

        // ── Persist the Business record ─────────────────────────────────────
        try {
            $business = Business::create([
                'user_id'       => $userId,
                'name'          => $request->post('name'),
                'category'      => $request->post('category'),
                'address'       => $request->post('address'),
                'phone'         => $request->post('phone')         ?: null,
                'email'         => $request->post('email')         ?: null,
                'website'       => $request->post('website')       ?: null,
                'description'   => $request->post('description')   ?: null,
                'logo'          => $logoPath,
                'cover_image'   => $coverPath,
                // `image` mirrors cover for card thumbnails on the directory page
                'image'         => $coverPath,
                'rating'        => 5.0,
                'reviews_count' => 0,
                'price_range'   => $request->post('price_range')   ?: '₦₦ • Moderate',
                'status'        => 'Open Now',
                'opening_hours' => $request->post('opening_hours') ?: '8AM - 8PM',
            ]);
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed to register business: ' . $e->getMessage());
            return $this->back();
        }

        // ── Persist Products (optional) ─────────────────────────────────────
        $rawProducts = $request->post('products');
        if (is_array($rawProducts)) {
            foreach ($rawProducts as $item) {
                $pName = trim((string) ($item['name'] ?? ''));
                if ($pName === '') {
                    continue;
                }
                try {
                    BusinessProduct::create([
                        'business_id' => $business->id,
                        'name'        => $pName,
                        'description' => trim((string) ($item['description'] ?? '')) ?: null,
                        'price'       => trim((string) ($item['price']       ?? '')) ?: null,
                    ]);
                } catch (\Throwable) {
                    // Non-fatal: skip invalid row
                }
            }
        }

        // ── Persist Services (optional) ─────────────────────────────────────
        $rawServices = $request->post('services');
        if (is_array($rawServices)) {
            foreach ($rawServices as $item) {
                $sName = trim((string) ($item['name'] ?? ''));
                if ($sName === '') {
                    continue;
                }
                try {
                    BusinessService::create([
                        'business_id' => $business->id,
                        'name'        => $sName,
                        'description' => trim((string) ($item['description'] ?? '')) ?: null,
                        'icon'        => trim((string) ($item['icon']        ?? '')) ?: 'fa-circle-check',
                    ]);
                } catch (\Throwable) {
                    // Non-fatal: skip invalid row
                }
            }
        }

        session()->flash('success', 'Your business has been successfully registered!');
        return $this->redirect('/businesses/' . $business->id);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    /**
     * Handle a single image file upload from $_FILES.
     *
     * Returns the public-relative URL path on success (e.g. "/uploads/businesses/abc.jpg"),
     * or null if no file was uploaded or validation fails.
     */
    private function handleUpload(string $field, int $userId): ?string
    {
        if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $file  = $_FILES[$field];
        $error = $file['error'] ?? UPLOAD_ERR_NO_FILE;

        if ($error !== UPLOAD_ERR_OK) {
            return null; // silently skip — form validation handles required-ness
        }

        // Size guard
        if ($file['size'] > self::MAX_SIZE) {
            session()->flash('error', "The {$field} file is too large. Maximum size is 2 MB.");
            return null;
        }

        // MIME type guard (read actual bytes, not trusting browser MIME)
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::ALLOWED_MIME, true)) {
            session()->flash('error', "The {$field} file must be a JPG, PNG, GIF, or WebP image.");
            return null;
        }

        // Derive extension from actual MIME
        $ext = match($mime) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            default      => 'jpg',
        };

        // Build a unique filename
        $filename   = $field . '_' . $userId . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $uploadRoot = dirname(__DIR__, 2) . '/public/' . self::UPLOAD_DIR;
        $destPath   = $uploadRoot . '/' . $filename;

        if (!is_dir($uploadRoot)) {
            mkdir($uploadRoot, 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            return null;
        }

        // Return root-relative URL the app can use with asset()
        return '/' . self::UPLOAD_DIR . '/' . $filename;
    }
}
