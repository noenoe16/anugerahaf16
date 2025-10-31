<?php

declare(strict_types=1);

use App\Models\Building;
use App\Models\Cctv;
use App\Models\Contact;
use App\Models\Room;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lists buildings', function () {
    $b = Building::factory()->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/buildings');

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $b->id, 'name' => $b->name]);
});

it('shows a building', function () {
    $b = Building::factory()->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/buildings/'.$b->id);

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $b->id, 'name' => $b->name]);
});

it('lists rooms', function () {
    $b = Building::factory()->create();
    Room::factory()->for($b)->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/rooms');

    $res->assertSuccessful();
    $res->assertJsonStructure([['id', 'name']]);
});

it('shows a room', function () {
    $b = Building::factory()->create();
    $r = Room::factory()->for($b)->create();
    Cctv::factory()->for($b)->for($r)->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/rooms/'.$r->id);

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $r->id, 'name' => $r->name]);
});

it('lists cctvs', function () {
    $b = Building::factory()->create();
    $r = Room::factory()->for($b)->create();
    $c = Cctv::factory()->for($b)->for($r)->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/cctvs');

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $c->id, 'name' => $c->name]);
});

it('shows a cctv', function () {
    $b = Building::factory()->create();
    $r = Room::factory()->for($b)->create();
    $c = Cctv::factory()->for($b)->for($r)->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/cctvs/'.$c->id);

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $c->id, 'name' => $c->name]);
});

it('lists contacts', function () {
    $contact = Contact::factory()->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/contacts');

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $contact->id, 'name' => $contact->name]);
});

it('shows a contact', function () {
    $contact = Contact::factory()->create();

    $res = $this->actingAs($this->user)
        ->get('/api/v1/contacts/'.$contact->id);

    $res->assertSuccessful();
    $res->assertJsonFragment(['id' => $contact->id, 'name' => $contact->name]);
});
