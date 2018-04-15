<?php

namespace FakeBetter\Tests\Providers;

use Faker\Generator;
use FakeBetter\Tests\TestCase;
use FakeBetter\Providers\Copy;
use Illuminate\Filesystem\Filesystem;
use FakeBetter\Laravel\Helpers;

class CopyTest extends TestCase
{
    /**
     * Instance of the Copy class.
     *
     * @var Copy
     */
    protected $copy;

    /**
     * Setup the test class.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $filesystem = new Filesystem();

        if (!$filesystem->exists(Helpers::projectCopyPath('blog/body'))) {
            $filesystem->makeDirectory(Helpers::projectCopyPath('blog/body'));
        }

        $filesystem->copy(__DIR__ . '/../data/blog-body-1.php', Helpers::projectCopyPath('blog/body/one.php'));

        $filesystem->copy(__DIR__ . '/../data/blog-body-2.php', Helpers::projectCopyPath('blog/body/two.php'));

        $filesystem->copy(__DIR__ . '/../data/titles.php', Helpers::projectCopyPath('blog/title.php'));

        $filesystem->copy(__DIR__ . '/../data/comments.php', Helpers::projectCopyPath('blog/comment.php'));

        $filesystem->copy(__DIR__ . '/../data/names.php', Helpers::projectCopyPath('name.php'));

        $this->copy = new Copy(new Generator());

        $this->copy->setCopyPath(Helpers::projectCopyPath());
    }

    /**
     * @test
     */
    public function copyCanGetItemFromProperty()
    {
        $names = require __DIR__ . '/../data/names.php';

        $this->assertContains($this->copy->name, $names);
    }

    /**
     * @test
     */
    public function copyCanGetItemFromMethod()
    {
        $names = require __DIR__ . '/../data/names.php';

        $this->assertContains($this->copy->name(), $names);
    }

    /**
     * @test
     */
    public function copyCanGetItemFromDotSeparatedPathToFile()
    {
        $expected = require __DIR__ . '/../data/blog-body-1.php';

        $this->assertEquals($expected, $this->copy->get('blog.body.one'));
    }

    /**
     * @test
     */
    public function copyCanGetItemFromDotSeparatedPathToArrayInFile()
    {
        $comments = require __DIR__ . '/../data/comments.php';

        $titles = $comments['title'];

        $this->assertContains($this->copy->get('blog.comment.title'), $titles);
    }
}
