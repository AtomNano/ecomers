@extends('layouts.admin.app')

@section('title', 'Manajemen Pelanggan - Grosir Berkat Ibu')
@section('page-title', 'Manajemen Pelanggan')
@section('page-description', 'Kelola data pelanggan dan grup pelanggan')

@section('content')
<!-- Header Actions -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
        <h2 class="text-2xl font-bold text-neutral-900">Daftar Pelanggan</h2>
        <p class="text-neutral-600">Kelola data pelanggan dan grup pelanggan</p>
    </div>
    <div class="flex space-x-3">
        <button onclick="openCreateCustomerModal()" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Pelanggan
        </button>
    </div>
</div>

<!-- Filters -->
<div class="card p-4 mb-6">
    <form method="GET" action="{{ route('owner.customers.index') }}" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari nama, email, atau telepon..."
                class="input-field"
            >
        </div>
        <div class="min-w-48">
            <select name="group" class="input-field">
                <option value="">Semua Grup</option>
                @foreach($customerGroups as $group)
                <option value="{{ $group->id }}" {{ request('group') == $group->id ? 'selected' : '' }}>
                    {{ $group->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="min-w-32">
            <select name="status" class="input-field">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn-outline">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Filter
        </button>
        @if(request()->hasAny(['search', 'group', 'status']))
        <a href="{{ route('owner.customers.index') }}" class="btn-outline">
            Hapus Filter
        </a>
        @endif
    </form>
</div>

<!-- Customers Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Pelanggan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Kontak
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Grup
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Total Belanja
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Pesanan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Bergabung
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @forelse($customers as $customer)
                <tr class="hover:bg-neutral-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                    <span class="text-primary-600 font-medium text-sm">{{ substr($customer->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-neutral-900">{{ $customer->name }}</div>
                                <div class="text-sm text-neutral-500">ID: {{ $customer->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-neutral-900">{{ $customer->email }}</div>
                        <div class="text-sm text-neutral-500">{{ $customer->phone_number }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($customer->customerGroup)
                        <span class="badge-primary">{{ $customer->customerGroup->name }}</span>
                        @else
                        <span class="text-sm text-neutral-500">Umum</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-neutral-900">Rp {{ number_format($customer->total_spent ?? 0) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-neutral-900">{{ $customer->orders_count ?? 0 }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        {{ $customer->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <button 
                                onclick="openEditCustomerModal({{ $customer->id }})"
                                class="text-primary-600 hover:text-primary-900 transition-colors"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button 
                                onclick="if(admin.confirmDelete('Apakah Anda yakin ingin menghapus pelanggan ini?')) { document.getElementById('delete-form-{{ $customer->id }}').submit(); }"
                                class="text-red-600 hover:text-red-900 transition-colors"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            
                            <!-- Delete Form -->
                            <form id="delete-form-{{ $customer->id }}" 
                                  action="{{ route('owner.customers.destroy', $customer) }}" 
                                  method="POST" 
                                  class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <svg class="h-12 w-12 text-neutral-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-neutral-900 mb-2">Tidak ada pelanggan ditemukan</h3>
                        <p class="text-neutral-500">Belum ada pelanggan yang terdaftar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($customers->hasPages())
    <div class="px-6 py-4 border-t border-neutral-200">
        {{ $customers->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Create/Edit Customer Modal -->
<div id="customerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" x-data="customerModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6" @click.away="close()">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-neutral-900" x-text="isEdit ? 'Edit Pelanggan' : 'Tambah Pelanggan'"></h3>
                <button @click="close()" class="text-neutral-400 hover:text-neutral-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form :action="isEdit ? `/owner/customers/${customerId}` : '{{ route('owner.customers.store') }}'" method="POST">
                @csrf
                <div x-show="isEdit" x-transition>
                    @method('PUT')
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Nama *</label>
                        <input 
                            type="text" 
                            name="name" 
                            x-model="form.name"
                            class="input-field"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            x-model="form.email"
                            class="input-field"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Telepon</label>
                        <input 
                            type="text" 
                            name="phone_number" 
                            x-model="form.phone_number"
                            class="input-field"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Grup Pelanggan</label>
                        <select name="customer_group_id" x-model="form.customer_group_id" class="input-field">
                            <option value="">Pilih Grup</option>
                            @foreach($customerGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Alamat</label>
                        <textarea 
                            name="address" 
                            x-model="form.address"
                            rows="3"
                            class="input-field"
                        ></textarea>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6">
                    <button type="submit" class="btn-primary flex-1">
                        <span x-text="isEdit ? 'Update' : 'Simpan'"></span>
                    </button>
                    <button type="button" @click="close()" class="btn-outline flex-1">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function customerModal() {
    return {
        isEdit: false,
        customerId: null,
        form: {
            name: '',
            email: '',
            phone_number: '',
            customer_group_id: '',
            address: ''
        },

        open(isEdit = false, customerId = null) {
            this.isEdit = isEdit;
            this.customerId = customerId;
            
            if (isEdit && customerId) {
                // Load customer data
                this.loadCustomerData(customerId);
            } else {
                this.resetForm();
            }
            
            document.getElementById('customerModal').classList.remove('hidden');
        },

        close() {
            document.getElementById('customerModal').classList.add('hidden');
            this.resetForm();
        },

        resetForm() {
            this.form = {
                name: '',
                email: '',
                phone_number: '',
                customer_group_id: '',
                address: ''
            };
        },

        loadCustomerData(customerId) {
            // This would typically fetch data via AJAX
            // For now, we'll just reset the form
            this.resetForm();
        }
    }
}

function openCreateCustomerModal() {
    window.customerModal.open(false);
}

function openEditCustomerModal(customerId) {
    window.customerModal.open(true, customerId);
}

// Initialize modal
document.addEventListener('alpine:init', () => {
    window.customerModal = Alpine.reactive(customerModal());
});
</script>
@endsection
