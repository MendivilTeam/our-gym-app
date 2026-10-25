<?php

namespace Tests\Unit\Workout\Domain;

use OurGym\Workout\Domain\InvalidWorkout;
use OurGym\Workout\Domain\Title;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class TitleTest extends TestCase
{
    #[Test]
    public function givenTextCreatesTitle(): void
    {
        $this->assertSame('Push day', (new Title('Push day'))->value);
    }

    #[Test]
    public function givenOnlyWhitespaceThrowsInvalidWorkout(): void
    {
        $this->expectException(InvalidWorkout::class);

        new Title('   ');
    }
}
