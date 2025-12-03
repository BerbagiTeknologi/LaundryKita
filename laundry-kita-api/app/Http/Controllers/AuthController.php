<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt from the mobile client.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var User|null $user */
        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau kata sandi tidak sesuai.',
            ], 422);
        }

        return response()->json($this->issueTokenPayload($user));
    }

    /**
     * Show the web login page.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle web login (session-based) for the dashboard.
     */
    public function loginWeb(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ])->withInput($request->only('email'));
    }

    /**
     * Log out the current user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Register a brand-new user coming from the mobile client.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25', 'unique:users,phone'],
            'password' => ['required', 'string', Password::min(8)],
            'role' => ['nullable', 'in:pelanggan,pemilik'],
        ]);

        $role = $validated['role'] ?? 'pelanggan';
        $existing = User::where('email', $validated['email'])->get();
        $hasSameRole = $existing->contains(fn ($u) => $u->role === $role);
        $hasOtherRole = $existing->contains(fn ($u) => $u->role !== $role);

        if ($hasSameRole || $existing->count() > 1) {
            return response()->json([
                'message' => 'Email sudah digunakan.',
            ], 422);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json($this->issueTokenPayload($user), 201);
    }

    /**
     * Show the web register page.
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle web registration for the dashboard.
     */
    public function registerWeb(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:25', 'unique:users,phone'],
            'password' => ['required', 'string', Password::min(8)],
            'role' => ['required', 'in:pelanggan,pemilik'],
        ]);

        $role = $validated['role'];
        $existing = User::where('email', $validated['email'])->get();
        $hasSameRole = $existing->contains(fn ($u) => $u->role === $role);
        $hasOtherRole = $existing->contains(fn ($u) => $u->role !== $role);

        if ($hasSameRole || $existing->count() > 1) {
            return back()->withErrors(['email' => 'Email sudah digunakan.'])->withInput($request->except('password'));
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $role,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * Generate and persist a new API token, returning the payload expected by the client.
     */
    protected function issueTokenPayload(User $user): array
    {
        $plainToken = Str::random(60);

        $user->forceFill([
            'api_token' => hash('sha256', $plainToken),
        ])->save();

        return [
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
        ];
    }
}
