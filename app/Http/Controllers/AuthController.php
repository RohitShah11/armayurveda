<?php

namespace App\Http\Controllers;

use App\Models\MemberProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return Auth::check() ? redirect()->route('dashboard') : view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
        $remember = $request->boolean('remember');

        if (Auth::attempt([$field => $login, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.signup');
    }

    public function lookupSponsor(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|string|max:255',
        ]);

        $memberId = strtoupper(trim($validated['member_id']));
        $sponsor = User::query()
            ->where('member_id', $memberId)
            ->first(['member_id', 'name']);

        if (! $sponsor) {
            return response()->json([
                'available' => false,
                'message' => 'Sponsor is not available.',
            ], 404);
        }

        return response()->json([
            'available' => true,
            'member_id' => $sponsor->member_id,
            'name' => $sponsor->name,
        ]);
    }

    public function register(Request $request)
    {
        $sponsorId = strtoupper(trim((string) $request->input('sponsor_id')));
        $request->merge([
            'sponsor_id' => $sponsorId !== '' ? $sponsorId : null,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users,mobile',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'sponsor_id' => 'nullable|string|exists:users,member_id',
        ], [
            'sponsor_id.exists' => 'Sponsor is not available.',
        ]);

        $user = DB::transaction(function () use ($request) {
            $lastMemberNumber = User::query()
                ->lockForUpdate()
                ->where('member_id', 'like', 'ARM%')
                ->get(['member_id'])
                ->map(fn ($user) => (int) substr($user->member_id, 3))
                ->max() ?? 1000;

            $user = User::create([
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'sponsor_id' => $request->sponsor_id,
                'status' => 'Active',
                'member_id' => 'ARM'.str_pad($lastMemberNumber + 1, 4, '0', STR_PAD_LEFT),
            ]);

            MemberProfile::create([
                'user_id' => $user->id,
                'state' => $request->state,
                'city' => $request->city,
                'pin_code' => $request->pin_code,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Welcome to ARM Ayurveda!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
