<?php

declare(strict_types=1);

namespace tests\core;

use core\View;
use PHPUnit\Framework\TestCase;

final class ViewTest extends TestCase
{
    private ?View $view = null;

    public function test_view_file_can_be_loaded(): void
    {
        $this->view = view('welcome', [
            'var1' => 'Page1',
            'var2' => 'Page1',
        ]
        );
    }
}
