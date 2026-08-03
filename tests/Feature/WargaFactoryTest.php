<?php

use App\Models\Warga;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can create a warga using factory', function () {
    $warga = Warga::factory()->create();

    expect($warga)->toBeInstanceOf(Warga::class);
    expect($warga->nama_pemilik)->not->toBeEmpty();
    expect($warga->alamat)->toContain('Gandekan');
    expect($warga->latitude)->toBeBetween(-7.735, -7.728);
    expect($warga->longitude)->toBeBetween(110.337, 110.342);
});

it('can seed warga using database seeder', function () {
    $this->seed();

    expect(Warga::count())->toBe(20);
});
