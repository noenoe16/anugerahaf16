<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('visiting dashboard updates last_seen_at', function () {
    $user = User::factory()->create([
        'last_seen_at' => null,
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertSuccessful();

    $user->refresh();

    expect($user->last_seen_at)->not()->toBeNull();
});
