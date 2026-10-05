<?php

use App\Models\Review;
use App\Models\User;

test('an authenticated user can add a review without an image', function () {
    $response = $this
        ->withoutMiddleware()
        ->actingAs(User::factory()->create())
        ->post(route('store.review'), [
            'name' => 'Jane Doe',
            'position' => 'Customer',
            'message' => 'Great service.',
        ]);

    $response->assertRedirect(route('all.review'));

    $this->assertDatabaseHas('reviews', [
        'name' => 'Jane Doe',
        'position' => 'Customer',
        'message' => 'Great service.',
        'image' => null,
    ]);
});
