<?php

declare(strict_types = 1);

namespace DrevOps\Robo\Tests;

use DrevOps\Robo\Tests\Traits\CommandTrait;
use DrevOps\Robo\Tests\Traits\MockTrait;
use DrevOps\Robo\Tests\Traits\ReflectionTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AbstractTestCase.
 *
 * Abstract test class used by all types of tests.
 */
abstract class AbstractTestCase extends TestCase
{

    use CommandTrait {
        CommandTrait::setUp as protected commandTraitSetUp;
        CommandTrait::tearDown as protected commandTraitTearDown;
        CommandTrait::runRoboCommand as public commandRunRoboCommand;
    }

    use ReflectionTrait;
    use MockTrait;

    /**
     * File system.
     *
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * Fixture directory.
     *
     * @var string
     */
    protected $fixtureDir;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->fs = new Filesystem();

        $this->fixtureDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'robo_git_artifact';
        $this->fs->mkdir($this->fixtureDir);

        $this->commandTraitSetUp(
            $this->fixtureDir.DIRECTORY_SEPARATOR.'git_src',
            $this->fixtureDir.DIRECTORY_SEPARATOR.'git_remote',
            $this->isDebug()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        $this->commandTraitTearDown();

        if ($this->fs->exists($this->fixtureDir)) {
            $this->fs->remove($this->fixtureDir);
        }
    }

    /**
     * Check if testing framework was ran with --debug option.
     *
     * @return bool
     *   TRUE if is in debug mode, FALSE otherwise.
     */
    protected function isDebug(): bool
    {
        return in_array('--debug', $_SERVER['argv'], true);
    }
}
