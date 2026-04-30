<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
   public function index(Request $request)
{
    $djangoUrl = config('services.django.url');
    $endpoint = $djangoUrl . '/api/auth/me/';

    try {
        $token = $request->cookie('django_token');
        $http = Http::withOptions([
            'verify' => false,
            'timeout' => 15,
        ]);

        if ($token) {
            $http = $http->withToken($token);
        }

        $response = $http->get($endpoint);
        $userData = $response->successful() ? $response->json() : null;
    } catch (\Throwable $e) {
        Log::error('Error fetching profile from Django', ['msg' => $e->getMessage()]);
        $userData = null;
    }

    return view('profile', [
        'userData' => $userData,
    ]);
}

    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
