<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request; 
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = ShortUrl::with(['company', 'user'])
            ->latest();

        if ($user->role === 'Admin') {
            $query->where('company_id', $user->company_id);
        } elseif ($user->role === 'Member') {
            $query->where('user_id', $user->id);
        } elseif ($user->role !== 'SuperAdmin') {
            abort(403);
        }

        $shortUrls = $query->paginate(10);

        return view('short-urls.index', compact('shortUrls'));
    }

    public function create()
    {
        abort_unless(
            in_array(auth()->user()->role, ['Admin', 'Member'], true),
            403
        );

        return view('short-urls.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        abort_unless(
            in_array($user->role, ['Admin', 'Member'], true),
            403
        );

        if (!$user->company_id) {
            abort(403, 'Your account is not assigned to a company.');
        }

        $data = $request->validate([
            'original_url' => [
                'required',
                'url',
                'max:2048',
            ],
        ]);

        do {
            $shortCode = Str::random(7);
        } while (ShortUrl::where('short_code', $shortCode)->exists());

        $shortUrl = ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'original_url' => $data['original_url'],
            'short_code' => $shortCode,
        ]);

        return redirect()
            ->route('short-urls.index')
            ->with('success', 'Short URL created successfully.')
            ->with('created_url', route('short-urls.redirect', [
                'shortCode' => $shortUrl->short_code,
            ]));
    }

    public function redirect(string $shortCode)
    {
        $shortUrl = ShortUrl::where('short_code', $shortCode)
            ->firstOrFail();

        $shortUrl->increment('clicks');

        return redirect()->away($shortUrl->original_url);
    }
}