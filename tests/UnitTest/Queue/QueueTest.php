<?php

namespace PHPds\UnitTest\Queue;

use PHPds\Queue\Queue;
use PHPdt\DataType\IntDataType;
use PHPds\UnitTest\DataProvider\DataProviderTrait;

class QueueTest extends \PHPUnit_Framework_TestCase
{
    use DataProviderTrait;

    /**
     * @dataProvider typedDataProvider
     * @param $item
     */
    public function testQueueEnqueue($item)
    {
        $queue = new Queue($item['type']);
        foreach ($item['data'] as $data) {
            $queue->enqueue($data);
        }
        $this->assertCount(count($item['data']), $queue);
    }

    /**
     * @dataProvider typedDataProvider
     * @param $item
     */
    public function testQueuePeek($item)
    {
        $data = null;
        $queue = new Queue($item['type']);
        foreach ($item['data'] as $data) {
            $queue->enqueue($data);
        }
        $this->assertSame($queue->peek(), reset($item['data']));
        $this->assertCount(count($item['data']), $queue);
    }

    public function testQueueDequeue()
    {
        $queue = new Queue(IntDataType::class);
        $item1 = $queue->enqueue(1);
        $item2 = $queue->enqueue(2);
        $queue->enqueue(3);
        $item = $queue->dequeue();
        $this->assertSame($item1, $item);
        $this->assertSame($item2, $queue->peek());
        $this->assertCount(2, $queue);
    }

    /**
     * @dataProvider typedDataProvider
     * @param $item
     */
    public function testQueueHas($item)
    {
        $queue = new Queue($item['type']);
        foreach ($item['data'] as $data) {
            $queue->enqueue($data);
        }
        $element = $item['data'][count($item['data']) >> 1];
        $this->assertTrue($queue->has($element));
        $this->assertFalse($queue->has($item['miss']));
    }

    public function testQueueCountEmpty()
    {
        $queue = new Queue(IntDataType::class);
        $this->assertCount(0, $queue);
    }

    public function testQueueCountNonEmpty()
    {
        $queue = new Queue(IntDataType::class);
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->enqueue(3);
        $this->assertCount(3, $queue);
    }

    public function testQueueDecreaseToEmpty()
    {
        $queue = new Queue(IntDataType::class);
        $queue->enqueue(1);
        $queue->enqueue(2);
        $queue->dequeue();
        $queue->dequeue();
        $this->assertCount(0, $queue);
    }
}
