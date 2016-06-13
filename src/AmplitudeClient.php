<?php
namespace Amplitude;

use GuzzleHttp\Client;

/**
 * Default Amplitude client implementation
 */
class AmplitudeClient implements AmplitudeClientInterface
{

    /** @var string */
    const AMPLITUDE_URL = 'https://api.amplitude.com/httpapi';

    /**
     * @var string
     */
    protected $apiKey = '';

    /**
     * @var Client|null
     */
    protected $client = null;

    /**
     * AmplitudeClient constructor.
     * @param null|string $apiKey
     */
    public function __construct($apiKey = null)
    {
        if (null !== $apiKey) {
            $this->setApiKey($apiKey);
        }

        if (is_null($apiKey) && $key = getenv('AMPLITUDE_API_KEY')) {
            $this->setApiKey($key);
        }
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param Message\Event $event
     * @return Message\Response
     */
    public function track(Message\Event $event)
    {
        $this->getClient()->request('POST', null, array(
            'form_params' => $this->getPostBody($event)
        ));
    }

    /**
     * Get post body
     * @param Message\Event $event
     * @return array
     */
    protected function getPostBody(Message\Event $event)
    {
        return array(
            'api_key' => $this->apiKey,
            'event' => $event->format(),
        );
    }

    /**
     * Get client
     * @return Client
     */
    protected function getClient()
    {
        if (null === $this->client) {
            $this->client = new Client(array('base_uri'=>self::AMPLITUDE_URL));
        }
        return $this->client;
    }
}
