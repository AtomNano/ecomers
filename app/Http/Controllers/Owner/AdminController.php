<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('owner.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('owner.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
        ]);

        return redirect()->route('owner.admins.index')->with('success', 'Admin berhasil ditambahkan');
    }

    public function show(User $admin)
    {
        // Pastikan user adalah admin
        if ($admin->role !== 'admin') {
            abort(404);
        }

        return view('owner.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        // Pastikan user adalah admin
        if ($admin->role !== 'admin') {
            abort(404);
        }

        return view('owner.admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        // Pastikan user adalah admin
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'province' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('owner.admins.index')->with('success', 'Data admin berhasil diperbarui');
    }

    public function destroy(User $admin)
    {
        // Pastikan user adalah admin
        if ($admin->role !== 'admin') {
            abort(404);
        }

        // Jangan izinkan menghapus diri sendiri
        if ($admin->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $admin->delete();

        return redirect()->route('owner.admins.index')->with('success', 'Admin berhasil dihapus');
    }

    public function resetPassword(User $admin)
    {
        // Pastikan user adalah admin
        if ($admin->role !== 'admin') {
            abort(404);
        }

        // Generate password baru
        $newPassword = 'admin123'; // Password default
        $admin->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->back()->with('success', "Password admin berhasil direset. Password baru: {$newPassword}");
    }
}



