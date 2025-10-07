<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', User::ROLE_CUSTOMER)->paginate(10);
        return view('owner.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        $customer->load('orders');
        return view('owner.customers.show', compact('customer'));
    }

    public function create()
    {
        return view('owner.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'province' => $request->province,
            'city' => $request->city,
            'district' => $request->district,
            'role' => User::ROLE_CUSTOMER,
        ]);

        return redirect()->route('owner.customers.index')->with('success', 'Customer berhasil ditambahkan');
    }

    public function edit(User $customer)
    {
        return view('owner.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'address' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
        ]);

        $customer->update($request->only([
            'name', 'email', 'address', 'phone_number', 'province', 'city', 'district'
        ]));

        return redirect()->route('owner.customers.index')->with('success', 'Customer berhasil diperbarui');
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('owner.customers.index')->with('success', 'Customer berhasil dihapus');
    }
}







