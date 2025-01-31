<?php

declare(strict_types=1);

use Daycode\Curtain\Tests\TestCase;

uses(TestCase::class)->in('Feature', 'Unit');

// Ensure Laravel plugin is loaded
uses()->group('feature')->in('Feature');
uses()->group('unit')->in('Unit');
