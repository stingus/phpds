<?php

namespace PHPds\UnitTest\Dummy;

use PHPdt\DataType\DataTypeInterface;
use PHPdt\DataType\ObjectValidationTrait;

class DummyClass implements DataTypeInterface
{
    use ObjectValidationTrait;
}
