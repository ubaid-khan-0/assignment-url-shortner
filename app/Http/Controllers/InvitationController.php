<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InvitationController extends Controller
{
    public function createCompanyAdmin()
    {
        return view('invitations.superadmin-create');
    }

    public function storeCompanyAdmin(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        $company = null;
        $invitation = null;

        DB::transaction(function () use ($data, &$company, &$invitation) {
            $company = Company::create([
                'name' => $data['company_name'],
                'slug' => Str::slug($data['company_name'])
                    . '-' . Str::lower(Str::random(6)),
            ]);

            $invitation = Invitation::create([
                'company_id' => $company->id,
                'invited_by' => Auth::id(),
                'email' => $data['email'],
                'role' => 'Admin',
                'token' => Str::random(64),
                'expires_at' => now()->addDays(7),
            ]);
        });

        return redirect()
            ->route('superadmin.invitations.create')
            ->with('invitation_url', route(
                'invitations.accept',
                ['token' => $invitation->token]
            ))
            ->with('success', 'Company created and Admin invitation generated.');
    }

    public function createCompanyInvitation()
    {
        return view('invitations.admin-create');
    }

    public function storeCompanyInvitation(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['Admin', 'Member'])],
        ]);

        $invitation = Invitation::create([
            'company_id' => Auth::user()->company_id,
            'invited_by' => Auth::id(),
            'email' => $data['email'],
            'role' => $data['role'],
            'token' => Str::random(64),
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()
            ->route('admin.invitations.create')
            ->with('invitation_url', route(
                'invitations.accept',
                ['token' => $invitation->token]
            ))
            ->with('success', 'Invitation generated successfully.');
    }

    public function acceptForm(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->accepted_at || $invitation->expires_at->isPast()) {
            abort(410, 'This invitation has expired or has already been used.');
        }

        if (User::where('email', $invitation->email)->exists()) {
            abort(409, 'An account already exists for this invitation email.');
        }

        return view('invitations.accept', compact('invitation'));
    }

    public function accept(Request $request, string $token)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($data, $token) {
            $invitation = Invitation::where('token', $token)
                ->lockForUpdate()
                ->firstOrFail();

            if ($invitation->accepted_at || $invitation->expires_at->isPast()) {
                abort(410, 'This invitation has expired or has already been used.');
            }

            if (User::where('email', $invitation->email)->exists()) {
                abort(409, 'An account already exists for this invitation email.');
            }

            $user = User::create([
                'company_id' => $invitation->company_id,
                'name' => $data['name'],
                'email' => $invitation->email,
                'password' => Hash::make($data['password']),
                'role' => $invitation->role,
            ]);

            $invitation->update([
                'accepted_at' => now(),
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}