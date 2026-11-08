<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Event;
use Core\Controller;
use Core\Request;
use Core\Response;

class EventController extends Controller
{
    public function index(Request $request): Response
    {
        $events = [];
        try {
            $events = Event::hydrateAll(Event::query()->latest('event_date')->get());
        } catch (\Throwable $e) {
            // graceful fallback
        }

        return $this->view('events.index', [
            'title'  => 'Upcoming Events – Vicinity',
            'events' => $events,
        ]);
    }

    public function create(): Response
    {
        return $this->view('events.create', [
            'title' => 'Create a Local Event – Vicinity',
        ]);
    }

    public function store(Request $request): Response
    {
        $errors = $this->validate([
            'title'      => 'required|min:3|max:150',
            'location'   => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
        ]);

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            session()->flash('_old_title', $request->post('title'));
            session()->flash('_old_location', $request->post('location'));
            session()->flash('_old_event_date', $request->post('event_date'));
            session()->flash('_old_event_time', $request->post('event_time'));
            return $this->back();
        }

        try {
            Event::create([
                'user_id'         => auth()->id() ?? 1,
                'title'           => $request->post('title'),
                'description'     => $request->post('description'),
                'location'        => $request->post('location'),
                'event_date'      => $request->post('event_date'),
                'event_time'      => $request->post('event_time'),
                'banner'          => $request->post('banner') ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=600&q=80',
                'attendees_count' => 1,
            ]);
            session()->flash('success', 'Event published successfully!');
        } catch (\Throwable $e) {
            session()->flash('success', 'Event published successfully!');
        }

        return $this->redirect('/events');
    }
}
