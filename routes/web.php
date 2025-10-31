<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'lastseen'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::view('users', 'livewire.admin.users.index')->name('users.index');
    Route::view('users/create', 'livewire.admin.users.create')->name('users.create');
    Route::view('users/{user}/edit', 'livewire.admin.users.edit')->name('users.edit');

    // Buildings CRUD
    Route::view('buildings', 'livewire.admin.buildings.index')->name('buildings.index');
    Route::view('buildings/create', 'livewire.admin.buildings.create')->name('buildings.create');
    Route::view('buildings/{building}/edit', 'livewire.admin.buildings.edit')->name('buildings.edit');

    // Rooms & CCTVs (stubs)
    Route::view('rooms', 'livewire.admin.rooms.index')->name('rooms.index');
    Route::view('rooms/create', 'livewire.admin.rooms.create')->name('rooms.create');
    Route::view('rooms/{room}/edit', 'livewire.admin.rooms.edit')->name('rooms.edit');
    Route::view('cctvs', 'livewire.admin.cctvs.index')->name('cctvs.index');
    Route::view('cctvs/create', 'livewire.admin.cctvs.create')->name('cctvs.create');
    Route::view('cctvs/{cctv}/edit', 'livewire.admin.cctvs.edit')->name('cctvs.edit');

    Route::view('maps', 'livewire.admin.maps.index')->name('maps.index');
    Route::view('maps/create', 'livewire.admin.maps.create')->name('maps.create');
    Route::view('maps/edit', 'livewire.admin.maps.edit')->name('maps.edit');

    Route::view('locations', 'livewire.admin.locations.index')->name('locations.index');
    Route::view('locations/create', 'livewire.admin.locations.create')->name('locations.create');
    Route::view('locations/edit', 'livewire.admin.locations.edit')->name('locations.edit');
    Route::post('locations', function () {
        request()->validate([
            'type' => ['required', 'in:building,room'],
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'building_id' => ['nullable', 'exists:buildings,id'],
        ]);
        if (request('type') === 'room') {
            \App\Models\Room::create([
                'building_id' => request('building_id'),
                'name' => request('name'),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
            ]);
        } else {
            \App\Models\Building::create([
                'name' => request('name'),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
            ]);
        }

        return redirect()->route('admin.maps.index');
    })->name('locations.store');
    Route::put('locations', function () {
        request()->validate([
            'type' => ['required', 'in:building,room'],
            'id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'building_id' => ['nullable', 'exists:buildings,id'],
        ]);
        if (request('type') === 'room') {
            $r = \App\Models\Room::findOrFail(request('id'));
            $r->update([
                'building_id' => request('building_id'),
                'name' => request('name'),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
            ]);
        } else {
            $b = \App\Models\Building::findOrFail(request('id'));
            $b->update([
                'name' => request('name'),
                'latitude' => request('latitude'),
                'longitude' => request('longitude'),
            ]);
        }

        return redirect()->route('admin.maps.index');
    })->name('locations.update');

    Route::view('contacts', 'livewire.admin.contacts.index')->name('contacts.index');
    Route::view('contacts/create', 'livewire.admin.contacts.create')->name('contacts.create');
    Route::view('contacts/{contact}/edit', 'livewire.admin.contacts.edit')->name('contacts.edit');

    Route::view('notifications', 'livewire.admin.notifications')->name('notifications');
    Route::view('messages', 'livewire.admin.messages')->name('messages');
    Route::post('messages', function () {
        request()->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:2000'],
        ]);
        $msg = \App\Models\Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => request('receiver_id'),
            'content' => request('content'),
        ]);
        $receiver = \App\Models\User::find(request('receiver_id'));
        if ($receiver) {
            $receiver->notify(new \App\Notifications\NewMessageNotification);
        }

        return back();
    })->name('messages.store');
    // Exports
    Route::get('export/buildings', [\App\Http\Controllers\ExportController::class, 'buildings'])->name('export.buildings');
    Route::get('export/rooms', [\App\Http\Controllers\ExportController::class, 'rooms'])->name('export.rooms');
    Route::get('export/cctvs', [\App\Http\Controllers\ExportController::class, 'cctvs'])->name('export.cctvs');
    Route::get('export/users', [\App\Http\Controllers\ExportController::class, 'users'])->name('export.users');
    Route::get('export/users/online', [\App\Http\Controllers\ExportController::class, 'usersOnline'])->name('export.users.online');
    Route::get('export/users/offline', [\App\Http\Controllers\ExportController::class, 'usersOffline'])->name('export.users.offline');

    // Basic handlers for buildings create/update
    Route::post('buildings', function () {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
        ]);
        \App\Models\Building::create(request()->only('name', 'code', 'latitude', 'longitude', 'address'));

        return redirect()->route('admin.buildings.index');
    })->name('buildings.store');

    Route::put('buildings/{building}', function ($building) {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
        ]);
        $b = \App\Models\Building::findOrFail($building);
        $b->update(request()->only('name', 'code', 'latitude', 'longitude', 'address'));

        return redirect()->route('admin.buildings.index');
    })->name('buildings.update');
    Route::delete('buildings/{building}', function ($building) {
        $b = \App\Models\Building::findOrFail($building);
        $b->delete();

        return redirect()->route('admin.buildings.index');
    })->name('buildings.destroy');

    // Users handlers
    Route::post('users', function () {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,user'],
        ]);
        \App\Models\User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'role' => request('role'),
        ]);

        return redirect()->route('admin.users.index');
    })->name('users.store');

    Route::put('users/{user}', function ($user) {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user],
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        $u = \App\Models\User::findOrFail($user);
        $data = request()->only('name', 'email', 'role');
        if (filled(request('password'))) {
            $data['password'] = bcrypt(request('password'));
        }
        $u->update($data);

        return redirect()->route('admin.users.index');
    })->name('users.update');
    Route::delete('users/{user}', function ($user) {
        $u = \App\Models\User::findOrFail($user);
        $u->delete();

        return redirect()->route('admin.users.index');
    })->name('users.destroy');

    // Rooms handlers
    Route::post('rooms', function () {
        request()->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);
        \App\Models\Room::create(request()->only('building_id', 'name', 'code', 'latitude', 'longitude'));

        return redirect()->route('admin.rooms.index');
    })->name('rooms.store');

    Route::put('rooms/{room}', function ($room) {
        request()->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);
        $r = \App\Models\Room::findOrFail($room);
        $r->update(request()->only('building_id', 'name', 'code', 'latitude', 'longitude'));

        return redirect()->route('admin.rooms.index');
    })->name('rooms.update');
    Route::delete('rooms/{room}', function ($room) {
        $r = \App\Models\Room::findOrFail($room);
        $r->delete();

        return redirect()->route('admin.rooms.index');
    })->name('rooms.destroy');

    // CCTVs handlers
    Route::post('cctvs', function () {
        request()->validate([
            'building_id' => ['nullable', 'exists:buildings,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline,maintenance'],
            'location_note' => ['nullable', 'string'],
        ]);
        \App\Models\Cctv::create(request()->only('building_id', 'room_id', 'name', 'ip_address', 'status', 'location_note'));

        return redirect()->route('admin.cctvs.index');
    })->name('cctvs.store');

    Route::put('cctvs/{cctv}', function ($cctv) {
        request()->validate([
            'building_id' => ['nullable', 'exists:buildings,id'],
            'room_id' => ['nullable', 'exists:rooms,id'],
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline,maintenance'],
            'location_note' => ['nullable', 'string'],
        ]);
        $c = \App\Models\Cctv::findOrFail($cctv);
        $c->update(request()->only('building_id', 'room_id', 'name', 'ip_address', 'status', 'location_note'));

        return redirect()->route('admin.cctvs.index');
    })->name('cctvs.update');
    Route::delete('cctvs/{cctv}', function ($cctv) {
        $c = \App\Models\Cctv::findOrFail($cctv);
        $c->delete();

        return redirect()->route('admin.cctvs.index');
    })->name('cctvs.destroy');

    // Contacts handlers
    Route::post('contacts', function () {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);
        \App\Models\Contact::create(request()->only('name', 'email', 'phone', 'whatsapp', 'address'));

        return redirect()->route('admin.contacts.index');
    })->name('contacts.store');

    Route::put('contacts/{contact}', function ($contact) {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
        ]);
        $c = \App\Models\Contact::findOrFail($contact);
        $c->update(request()->only('name', 'email', 'phone', 'whatsapp', 'address'));

        return redirect()->route('admin.contacts.index');
    })->name('contacts.update');

    Route::delete('contacts/{contact}', function ($contact) {
        $c = \App\Models\Contact::findOrFail($contact);
        $c->delete();

        return redirect()->route('admin.contacts.index');
    })->name('contacts.destroy');
});

Route::middleware(['auth', 'role:user,admin'])->name('user.')->prefix('user')->group(function () {
    Route::view('maps', 'livewire.user.maps')->name('maps');
    Route::view('locations', 'livewire.user.locations')->name('locations');
    Route::view('rooms', 'livewire.user.rooms.index')->name('rooms');
    Route::get('locations/{building}', function (\App\Models\Building $building) {
        return view('livewire.user.building', compact('building'));
    })->name('locations.building');
    Route::get('locations/{building}/rooms/{room}', function (\App\Models\Building $building, \App\Models\Room $room) {
        abort_if($room->building_id !== $building->id, 404);

        return redirect()->route('user.cctv.index', ['room' => $room->id]);
    })->name('locations.room');
    Route::view('contacts', 'livewire.user.contacts')->name('contacts');
    Route::view('notifications', 'livewire.user.notifications')->name('notifications');
    Route::view('messages', 'livewire.user.messages')->name('messages');
    Route::view('cctv', 'livewire.user.cctv.index')->name('cctv.index');
    Route::get('cctv/{id}', function ($id) {
        return view('livewire.user.cctv.show-stream', compact('id'));
    })->name('cctv.show');
    Route::post('messages', function () {
        request()->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'content' => ['required', 'string', 'max:2000'],
        ]);
        $msg = \App\Models\Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => request('receiver_id'),
            'content' => request('content'),
        ]);
        $receiver = \App\Models\User::find(request('receiver_id'));
        if ($receiver) {
            $receiver->notify(new \App\Notifications\NewMessageNotification);
        }

        return back();
    })->name('user.messages.store');

    // Export routes for users (mirrors admin exports)
    Route::get('export/buildings', [\App\Http\Controllers\ExportController::class, 'buildings'])->name('export.buildings');
    Route::get('export/rooms', [\App\Http\Controllers\ExportController::class, 'rooms'])->name('export.rooms');
    Route::get('export/cctvs', [\App\Http\Controllers\ExportController::class, 'cctvs'])->name('export.cctvs');
    Route::get('export/users', [\App\Http\Controllers\ExportController::class, 'users'])->name('export.users');
    Route::get('export/users-online', [\App\Http\Controllers\ExportController::class, 'usersOnline'])->name('export.users.online');
    Route::get('export/users-offline', [\App\Http\Controllers\ExportController::class, 'usersOffline'])->name('export.users.offline');
});

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('cctvs', function () {
        return \App\Models\Cctv::select('id', 'name', 'status', 'building_id', 'room_id', 'ip_address')
            ->with(['room:id,building_id,name,latitude,longitude', 'building:id,name,latitude,longitude'])
            ->get()
            ->map(function ($c) {
                $lat = optional($c->room)->latitude ?? optional($c->building)->latitude;
                $lng = optional($c->room)->longitude ?? optional($c->building)->longitude;

                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'status' => $c->status,
                    'lat' => $lat,
                    'lng' => $lng,
                    'ip' => $c->ip_address,
                    'building_id' => $c->building_id ?? optional($c->room)->building_id,
                    'room_id' => $c->room_id,
                    'building_name' => optional($c->building)->name,
                    'room_name' => optional($c->room)->name,
                ];
            });
    })->name('api.cctvs');

    Route::get('buildings', function () {
        return \App\Models\Building::select('id', 'name', 'latitude as lat', 'longitude as lng')
            ->orderBy('name')
            ->get();
    })->name('api.buildings');

    Route::get('thread', function () {
        $uid = request('user_id');
        abort_unless($uid, 400);
        $me = auth()->id();
        $items = \App\Models\Message::with('sender')
            ->where(function ($q) use ($me, $uid) {
                $q->where('sender_id', $me)->where('receiver_id', $uid);
            })->orWhere(function ($q) use ($me, $uid) {
                $q->where('sender_id', $uid)->where('receiver_id', $me);
            })
            ->orderBy('created_at')
            ->get()
            ->map(function ($m) use ($me) {
                return [
                    'id' => $m->id,
                    'sender' => $m->sender?->name,
                    'content' => $m->content,
                    'direction' => $m->sender_id == $me ? 'out' : 'in',
                    'created_at' => $m->created_at?->toDateTimeString(),
                ];
            });

        return $items;
    })->name('api.thread');

    Route::get('notifications', function () {
        $items = auth()->user()->notifications()->latest()->limit(20)->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => data_get($n->data, 'title', 'Notification'),
                'body' => data_get($n->data, 'body', ''),
                'read_at' => $n->read_at,
                'created_at' => $n->created_at?->toDateTimeString(),
            ];
        });

        return $items;
    })->name('api.notifications');

    // API v1 - index/show endpoints
    Route::prefix('v1')->group(function () {
        // Buildings
        Route::get('buildings', function () {
            return \App\Models\Building::query()
                ->select('id', 'name', 'code', 'latitude as lat', 'longitude as lng', 'address')
                ->orderBy('name')
                ->get();
        })->name('api.v1.buildings.index');

        Route::get('buildings/{id}', function ($id) {
            $b = \App\Models\Building::query()->findOrFail($id);

            return [
                'id' => $b->id,
                'name' => $b->name,
                'code' => $b->code,
                'lat' => $b->latitude,
                'lng' => $b->longitude,
                'address' => $b->address,
                'rooms' => $b->rooms()->select('id', 'name', 'code', 'latitude as lat', 'longitude as lng')->orderBy('name')->get(),
            ];
        })->name('api.v1.buildings.show');

        // Rooms
        Route::get('rooms', function () {
            return \App\Models\Room::query()
                ->with(['building:id,name'])
                ->select('id', 'building_id', 'name', 'code', 'latitude as lat', 'longitude as lng')
                ->orderBy('name')
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'name' => $r->name,
                        'code' => $r->code,
                        'lat' => $r->lat,
                        'lng' => $r->lng,
                        'building' => [
                            'id' => $r->building_id,
                            'name' => $r->building?->name,
                        ],
                    ];
                });
        })->name('api.v1.rooms.index');

        Route::get('rooms/{id}', function ($id) {
            $r = \App\Models\Room::with('building:id,name')->findOrFail($id);

            return [
                'id' => $r->id,
                'name' => $r->name,
                'code' => $r->code,
                'lat' => $r->latitude,
                'lng' => $r->longitude,
                'building' => [
                    'id' => $r->building_id,
                    'name' => $r->building?->name,
                ],
                'cctvs' => $r->cctvs()->select('id', 'name', 'status', 'ip_address')->orderBy('name')->get(),
            ];
        })->name('api.v1.rooms.show');

        // CCTVs
        Route::get('cctvs', function () {
            return \App\Models\Cctv::query()
                ->with(['room:id,building_id,name', 'building:id,name'])
                ->select('id', 'name', 'status', 'building_id', 'room_id', 'ip_address')
                ->orderBy('name')
                ->get()
                ->map(function ($c) {
                    return [
                        'id' => $c->id,
                        'name' => $c->name,
                        'status' => $c->status,
                        'ip' => $c->ip_address,
                        'building' => ['id' => $c->building_id, 'name' => $c->building?->name],
                        'room' => ['id' => $c->room_id, 'name' => $c->room?->name],
                    ];
                });
        })->name('api.v1.cctvs.index');

        Route::get('cctvs/{id}', function ($id) {
            $c = \App\Models\Cctv::with(['room:id,name,building_id', 'building:id,name'])->findOrFail($id);

            return [
                'id' => $c->id,
                'name' => $c->name,
                'status' => $c->status,
                'ip' => $c->ip_address,
                'building' => ['id' => $c->building_id, 'name' => $c->building?->name],
                'room' => ['id' => $c->room_id, 'name' => $c->room?->name],
            ];
        })->name('api.v1.cctvs.show');

        // Contacts
        Route::get('contacts', function () {
            return \App\Models\Contact::query()
                ->select('id', 'name', 'email', 'phone', 'whatsapp', 'address')
                ->orderBy('name')
                ->get();
        })->name('api.v1.contacts.index');

        Route::get('contacts/{id}', function ($id) {
            $c = \App\Models\Contact::findOrFail($id);

            return [
                'id' => $c->id,
                'name' => $c->name,
                'email' => $c->email,
                'phone' => $c->phone,
                'whatsapp' => $c->whatsapp,
                'address' => $c->address,
            ];
        })->name('api.v1.contacts.show');
    });
});

require __DIR__.'/auth.php';
