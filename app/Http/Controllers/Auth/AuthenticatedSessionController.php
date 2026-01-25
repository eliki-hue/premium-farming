<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email or username is required',
            'password.required' => 'Password is required',
        ]);

        try {
            $djangoUrl = config('services.django.url');
            
            // Call Django login API
            $response = Http::withOptions(['verify' => false])
                ->asForm()
                ->post($djangoUrl . '/api/auth/login/', [
                    'username' => $request->email, // Django uses 'username' field
                    'password' => $request->password,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                // Django sets HttpOnly cookies automatically
                // But we can also manually set them for better control
                if (isset($data['access']) && isset($data['refresh'])) {
                    // Create response to attach cookies
                    $redirectUrl = session('intended', route('products.index'));
                    session()->forget('intended');
                    
                    return redirect($redirectUrl)
                        ->with('success', 'Welcome back!')
                        ->withCookie(cookie('access_token', $data['access'], 10080, '/', null, false, true)) // 7 days, HttpOnly
                        ->withCookie(cookie('refresh_token', $data['refresh'], 10080, '/', null, false, true));
                }
                
                // If Django sets cookies via Set-Cookie header, just redirect
                $redirectUrl = session('intended', route('products.index'));
                session()->forget('intended');
                
                return redirect($redirectUrl)->with('success', 'Welcome back!');
            }
            
            // Login failed - handle specific error messages
            $errorMessage = 'Invalid credentials. Please check your email and password.';
            
            if ($response->status() === 401) {
                $errorMessage = 'Invalid email or password.';
            } elseif ($response->status() === 429) {
                $errorMessage = 'Too many login attempts. Please try again later.';
            }
            
            return back()->withErrors([
                'email' => $errorMessage,
            ])->withInput($request->only('email'));
            
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage(), [
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'email' => 'Unable to connect to authentication server. Please try again later.',
            ])->withInput($request->only('email'));
        }
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please provide a valid email address',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
        ]);

        try {
            $djangoUrl = config('services.django.url');
            
            // Prepare registration data for Django
            $registrationData = [
                'username' => $request->email, // Use email as username
                'email' => $request->email,
                'password' => $request->password,
                'first_name' => $request->name,
                'last_name' => $request->last_name ?? '',
            ];
            
            // Call Django registration API
            $response = Http::withOptions(['verify' => false])
                ->asForm()
                ->post($djangoUrl . '/api/auth/register/', $registrationData);

            if ($response->successful()) {
                $data = $response->json();
                
                // Check if auto-login is enabled (tokens returned)
                if (isset($data['access']) && isset($data['refresh'])) {
                    // Auto-login after registration
                    return redirect()->route('products.index')
                        ->with('success', 'Registration successful! Welcome to Premium Farming Feeds.')
                        ->withCookie(cookie('access_token', $data['access'], 10080, '/', null, false, true))
                        ->withCookie(cookie('refresh_token', $data['refresh'], 10080, '/', null, false, true));
                }
                
                // Registration successful, redirect to login
                return redirect()->route('login')
                    ->with('success', 'Registration successful! Please log in with your credentials.');
            }
            
            // Registration failed - parse Django error responses
            $errors = $response->json();
            $errorMessages = [];
            
            // Handle common Django validation errors
            if (isset($errors['username'])) {
                $errorMessages['email'] = is_array($errors['username']) 
                    ? $errors['username'][0] 
                    : 'This email is already registered.';
            }
            
            if (isset($errors['email'])) {
                $errorMessages['email'] = is_array($errors['email']) 
                    ? $errors['email'][0] 
                    : 'Invalid email address.';
            }
            
            if (isset($errors['password'])) {
                $errorMessages['password'] = is_array($errors['password']) 
                    ? $errors['password'][0] 
                    : 'Password does not meet requirements.';
            }
            
            // If we have specific errors, show them
            if (!empty($errorMessages)) {
                return back()->withErrors($errorMessages)->withInput();
            }
            
            // Generic error fallback
            $genericError = 'Registration failed. ';
            if (isset($errors['detail'])) {
                $genericError .= $errors['detail'];
            } elseif (isset($errors['message'])) {
                $genericError .= $errors['message'];
            } else {
                $genericError .= 'Please check your information and try again.';
            }
            
            return back()->withErrors(['email' => $genericError])->withInput();
            
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage(), [
                'email' => $request->email,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->withErrors([
                'email' => 'Unable to complete registration. Please try again later.',
            ])->withInput();
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        try {
            $djangoUrl = config('services.django.url');
            $djangoHost = parse_url($djangoUrl, PHP_URL_HOST);

            // Call Django logout API to invalidate tokens
            Http::withOptions(['verify' => false])
                ->withCookies($request->cookies->all(), $djangoHost)
                ->post($djangoUrl . '/api/auth/logout/');
                
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            // Continue with logout even if Django API call fails
        }
        
        // Clear Laravel session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear auth cookies
        return redirect('/login')
            ->with('success', 'You have been logged out successfully.')
            ->withCookie(cookie()->forget('access_token'))
            ->withCookie(cookie()->forget('refresh_token'))
            ->withCookie(cookie()->forget('user_data'));
    }

    /**
     * Destroy session (alias for logout)
     */
    public function destroy(Request $request)
    {
        return $this->logout($request);
    }
}