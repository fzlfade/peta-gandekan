<?php

use App\Models\User;
use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows authenticated user to delete a warga record', function () {
    $user = User::factory()->create();
    $warga = Warga::factory()->create();

    $response = $this->actingAs($user)->delete(route('admin.destroy', $warga));

    $response->assertRedirect(route('admin.index'));
    $this->assertDatabaseMissing('wargas', [
        'id' => $warga->id,
    ]);
});
