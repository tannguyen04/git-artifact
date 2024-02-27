<?php

namespace DrevOps\Robo\Tests\Unit;

use DrevOps\Robo\ArtifactTrait;
use DrevOps\Robo\Tests\AbstractTestCase;

/**
 * Class AbstractUnitTestCase.
 */
abstract class AbstractUnitTestCase extends AbstractTestCase
{

    /**
     * Mock of the class.
     *
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForTrait(ArtifactTrait::class);
        $this->callProtectedMethod($this->mock, 'fsSetRootDir', [$this->fixtureDir]);
    }
}
