<?php

namespace NotificationChannels\SmsRu\Test;

use Orchestra\Testbench\TestCase;
use NotificationChannels\SmsRu\SmsRuMessage;

class SmsRuMessageTest extends TestCase
{
    /** @test */
    public function it_can_accept_a_content_when_constructing_a_message()
    {
        $message = new SmsRuMessage('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_accept_a_content_when_creating_a_message()
    {
        $message = SmsRuMessage::create('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_set_the_content()
    {
        $message = (new SmsRuMessage())->content('hello');

        $this->assertEquals('hello', $message->content);
    }

    /** @test */
    public function it_can_set_the_from()
    {
        $message = (new SmsRuMessage())->from('John_Doe');

        $this->assertEquals('John_Doe', $message->from);
    }

    /** @test */
    public function it_can_convert_self_to_array()
    {
        $message = (new SmsRuMessage())->content('hello')->from('John_Doe');

        $params = $message->toArray();

        $this->assertArraySubset($params, [
            'sender'  => 'John_Doe',
            'text'     => 'hello',
        ]);
    }
}
