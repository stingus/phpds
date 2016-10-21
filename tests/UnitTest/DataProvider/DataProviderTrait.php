<?php

namespace PHPds\UnitTest\DataProvider;

use PHPds\UnitTest\Dummy\DummyClass;
use PHPdt\DataType\ArrayDataType;
use PHPdt\DataType\BoolDataType;
use PHPdt\DataType\DoubleDataType;
use PHPdt\DataType\IntDataType;
use PHPdt\DataType\StringDataType;

trait DataProviderTrait
{
    public function typedDataProvider()
    {
        return [
            [
                [
                    'type' => IntDataType::class,
                    'data' => [-1, 0, 1],
                    'miss' => 2
                ]
            ],
            [
                [
                    'type' => DoubleDataType::class,
                    'data' => [-1.0, -.1, 0.0, 0.1, 1.0],
                    'miss' => 2.0
                ]
            ],
            [
                [
                    'type' => StringDataType::class,
                    'data' => ['a', 'A', '!', '#', '$', '.', '\'', '"', '/'],
                    'miss' => 'z'
                ]
            ],
            [
                [
                    'type' => BoolDataType::class,
                    'data' => [true, false],
                    'miss' => null
                ]
            ],
            [
                [
                    'type' => ArrayDataType::class,
                    'data' => [[1, 2, 3], ['a', 'b', 'c']],
                    'miss' => [1, 2]
                ]
            ],
            [
                [
                    'type' => DummyClass::class,
                    'data' => [new DummyClass(), new DummyClass()],
                    'miss' => new DummyClass()
                ]
            ]
        ];
    }
}
