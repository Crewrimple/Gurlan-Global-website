<?php

test('the default locale home page renders successfully', function () {
    $response = $this->get('/ru');

    $response->assertOk()
        ->assertSee('Ключевые показатели');
});
