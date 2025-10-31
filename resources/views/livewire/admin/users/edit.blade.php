<x-layouts.app title="Edit User">
    <div class="p-6 max-w-lg">
        <h1 class="text-lg font-semibold mb-4">Edit User</h1>
        @php $u = \App\Models\User::findOrFail(request()->route('user')); @endphp
        <form method="POST" action="{{ url('/admin/users/'.request()->route('user')) }}" class="space-y-3">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" value="{{ $u->name }}" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input name="email" type="email" value="{{ $u->email }}" class="input-3d w-full" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">New Password</label>
                    <input name="password" type="password" class="input-3d w-full" />
                </div>
                <div>
                    <label class="block text-sm mb-1">Confirm</label>
                    <input name="password_confirmation" type="password" class="input-3d w-full" />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Role</label>
                <select name="role" class="select-3d w-full">
                    <option value="user" @selected(($u->role ?? 'user')==='user')>User</option>
                    <option value="admin" @selected(($u->role ?? 'user')==='admin')>Admin</option>
                </select>
            </div>
            <button class="btn-3d-success">Update</button>
        </form>
    </div>
</x-layouts.app>
