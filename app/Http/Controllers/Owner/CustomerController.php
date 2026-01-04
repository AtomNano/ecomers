<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')->paginate(15);
        return view('owner.customers.index', compact('customers'));
    }
    
    public function create()
    {
        return view('owner.customers.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => 'customer'
        ]);
        
        return redirect()->route('owner.customers.index')
                        ->with('success', 'Customer berhasil ditambahkan');
    }
    
    public function edit(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(403);
        }
        
        return view('owner.customers.edit', compact('customer'));
    }
    
    public function update(Request $request, User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $customer->id,
            'address' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed'
        ]);
        
        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        
        $customer->update($data);
        
        return redirect()->route('owner.customers.index')
                        ->with('success', 'Customer berhasil diperbarui');
    }
    
    public function destroy(User $customer)
    {
        if ($customer->role !== 'customer') {
            abort(403);
        }
        
        $customer->delete();
        
        return redirect()->route('owner.customers.index')
                        ->with('success', 'Customer berhasil dihapus');
    }
}
