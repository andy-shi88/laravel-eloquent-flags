<?php

use AndyShi88\LaravelEloquentFlags\Tests\TestSupport\TestModel;

beforeEach(function() {
    $this->testModel = new TestModel();
});

it('should return same list if value is not 0', function() {
    $this->testModel->flag_a = ['a', 'b', 'd'];
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertEquals(['a', 'b', 'd'], $this->testModel->flag_a);
});

it('should return empty list if value is not 0 - 2', function() {
    $this->testModel->flag_a = ['a', 'b', 'f'];
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertEquals(['a', 'b', 'f'], $this->testModel->flag_a);
});

it('should return null if value is null', function() {
    $this->testModel->flag_a = null;
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertNull($this->testModel->flag_a);
    $this->assertEquals(0, $this->testModel->getRawOriginal('flag_a'));
});

it('should return empty list if value is empty', function() {
    $this->testModel->flag_a = [];
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertCount(0, $this->testModel->flag_a);
    $this->assertEquals(0, $this->testModel->getRawOriginal('flag_a'));
});

it('should be able to handle multiple flags', function() {
    $this->testModel->flag_a = [];
    $this->testModel->flag_b = ['1', '3'];
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertCount(0, $this->testModel->flag_a);
    $this->assertCount(2, $this->testModel->flag_b);
    $this->assertEquals(0, $this->testModel->getRawOriginal('flag_a'));
    $this->assertEquals(5, $this->testModel->getRawOriginal('flag_b'));
    $this->assertEquals(['1', '3'], $this->testModel->flag_b);
});

it('should be able to handle multiple flags | another being null', function() {
    $this->testModel->flag_a = null;
    $this->testModel->flag_b = ['1', '3'];
    $this->testModel->save();
    $this->testModel->fresh();
    $this->assertCount(2, $this->testModel->flag_b);
    $this->assertNull($this->testModel->flag_a);
    $this->assertEquals(5, $this->testModel->getRawOriginal('flag_b'));
    $this->assertEquals(['1', '3'], $this->testModel->flag_b);
});
