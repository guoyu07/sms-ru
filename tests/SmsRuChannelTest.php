<?php

namespace NotificationChannel\SmscRu\Tests;

use Mockery;
use Orchestra\Testbench\TestCase;
use Illuminate\Notifications\Notification;
use NotificationChannels\SmsRu\SmsRuApi;
use NotificationChannels\SmsRu\SmsRuChannel;
use NotificationChannels\SmsRu\SmsRuMessage;

class SmsRuChannelTest extends TestCase
{
    /**
     * @var SmsRuApi
     */
    private $smsc;

    /**
     * @var SmsRuMessage
     */
    private $message;

    /**
     * @var SmsRuChannel
     */
    private $channel;

    /**
     * @var Notification
     */
    private $notification;

    public function setUp()
    {
        parent::setUp();

        $this->smsc = Mockery::mock(SmsRuApi::class);
        $this->channel = new SmsRuChannel($this->smsc);
        $this->message = Mockery::mock(SmsRuMessage::class);
        $this->notification = Mockery::mock(Notification::class);
    }

    public function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $notifiable = new Notifiable;

        $data = [
            'text'     => 'hello',
        ];

        $this->message->shouldReceive('toArray')->andReturn($data);
        $this->smsc->shouldReceive('send')->with('+1234567890', $data);
        $this->notification->shouldReceive('toSmsRu')->with($notifiable)->andReturn($this->message);


        $this->channel->send($notifiable, $this->notification);
    }

    /** @test */
    public function it_does_not_send_a_message_when_notifiable_does_not_have_route_notification()
    {
        $this->notification->shouldReceive('toSmsRu')->never();
        $this->channel->send(new NotifiableWithoutRouteNotificationForSmsru, $this->notification);
    }
}

class Notifiable
{
    public function routeNotificationFor()
    {
        return '+1234567890';
    }
}

class NotifiableWithoutRouteNotificationForSmsru extends Notifiable
{
    public function routeNotificationFor()
    {
        return false;
    }
}
