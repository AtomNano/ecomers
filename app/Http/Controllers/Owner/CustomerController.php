<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')
            ->with(['customerGroup', 'orders'])
            ->withCount('orders')
            ->withSum('orders as total_spent', 'total_price');

        // Search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $request->search . '%');
            });
        }

        // Group filter
        if ($request->filled('group')) {
            $query->where('customer_group_id', $request->group);
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereHas('orders');
            } elseif ($request->status === 'inactive') {
                $query->whereDoesntHave('orders');
            }
        }

        $customers = $query->latest()->paginate(15);
        $customerGroups = CustomerGroup::all();

        return view('owner.customers.index', compact('customers', 'customerGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'customer_group_id' => 'nullable|exists:customer_groups,id',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'), // Default password
            'phone_number' => $request->phone_number,
            'customer_group_id' => $request->customer_group_id,
            'address' => $request->address,
            'role' => 'customer',
        ]);

        return redirect()->route('owner.customers.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function update(Request $request, User $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:20',
            'customer_group_id' => 'nullable|exists:customer_groups,id',
            'address' => 'nullable|string',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'customer_group_id' => $request->customer_group_id,
            'address' => $request->address,
        ]);

        return redirect()->route('owner.customers.index')->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            return redirect()->back()->with('error', 'User bukan pelanggan');
        }

        $customer->delete();
        return redirect()->route('owner.customers.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}