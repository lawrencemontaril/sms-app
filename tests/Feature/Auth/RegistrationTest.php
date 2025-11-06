<?php

test('registration screen can\'t be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
});

test('new users can\'t register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(404);
});
