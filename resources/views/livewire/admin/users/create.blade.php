<x-layouts.app title="Create User">
    <div class="p-6 max-w-lg">
        <h1 class="text-lg font-semibold mb-4">Create User</h1>
        <form method="POST" action="{{ url('/admin/users') }}" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="input-3d w-full" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input name="email" type="email" class="input-3d w-full" required />
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm mb-1">Password</label>
                    <input name="password" type="password" class="input-3d w-full" required />
                </div>
                <div>
                    <label class="block text-sm mb-1">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="input-3d w-full" required />
                </div>
            </div>
            <div>
                <label class="block text-sm mb-1">Role</label>
                <select name="role" class="select-3d w-full">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button class="btn-3d-success">Save</button>
        </form>
    </div>
</x-layouts.app>
