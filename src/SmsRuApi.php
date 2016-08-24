<?php

namespace NotificationChannels\SmsRu;

use DomainException;
use GuzzleHttp\Client as HttpClient;
use NotificationChannels\SmsRu\Exceptions\CouldNotSendNotification;

class SmsRuApi
{
    const FORMAT_JSON = 3;

    /** @var string */
    protected $apiUrl = 'http://sms.ru/sms/send';

    /** @var HttpClient */
    protected $httpClient;

    /** @var string */
    protected $apiId;

    /** @var string */
    protected $sender;

    public function __construct($apiId, $sender)
    {
        $this->apiId = $apiId;

        $this->sender = $sender;

        $this->httpClient = new HttpClient([
            'timeout' => 5,
            'connect_timeout' => 5,
        ]);
    }

    /**
     * @param  string  $recipient
     * @param  array   $params
     *
     * @return array
     *
     * @throws CouldNotSendNotification
     */
    public function send($recipient, $params)
    {
        $params = array_merge([
            'to' => $recipient,
            'api_id'    => $this->apiId,
            'from' => $this->sender,
        ], $params);

        try {
            $response = $this->httpClient->post($this->apiUrl, ['form_params' => $params]);
            $body = explode(PHP_EOL, $response->getBody()->getContents());
            if (count($body) > 0 && (int) $body[0] !== 100) {
                throw  new CouldNotSendNotification("Service responded with an error code: {$body[0]}");
            }

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
