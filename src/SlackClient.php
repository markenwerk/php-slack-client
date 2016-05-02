<?php

namespace SlackClient;

use BasicHttpClient\Request\Message\Body\Body;
use BasicHttpClient\Request\Message\Header\Header;
use BasicHttpClient\Request\Message\Message;
use BasicHttpClient\Request\Request;
use BasicHttpClient\Request\Transport\HttpsTransport;
use CommonException\ApiException\UnexpectedResponseException;
use CommonException\NetworkException\ConnectionTimeoutException;
use CommonException\NetworkException\CurlException;
use CommonException\ParserException\StringifyException;
use Url\Url;

/**
 * Class SlackClient
 *
 * @package SlackClient
 */
class SlackClient
{

	/**
	 * @var string
	 */
	private $subdomainName;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var string
	 */
	private $channel = '#general';

	/**
	 * @var string
	 */
	private $username = 'PHP Slack Client';

	/**
	 * @return string
	 */
	public function getSubdomainName()
	{
		return $this->subdomainName;
	}

	/**
	 * @param string $subdomainName
	 * @return $this
	 */
	public function setSubdomainName($subdomainName)
	{
		if (!is_string($subdomainName)) {
			$argumentType = (is_object($subdomainName)) ? get_class($subdomainName) : gettype($subdomainName);
			throw new \InvalidArgumentException('Expected the subdomain name as string. Got ' . $argumentType);
		}
		$this->subdomainName = $subdomainName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param string $token
	 * @return $this
	 */
	public function setToken($token)
	{
		if (!is_string($token)) {
			$argumentType = (is_object($token)) ? get_class($token) : gettype($token);
			throw new \InvalidArgumentException('Expected the token as string. Got ' . $argumentType);
		}
		$this->token = $token;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getChannel()
	{
		return $this->channel;
	}

	/**
	 * @param string $channel
	 * @return $this
	 */
	public function setChannel($channel)
	{
		if (!is_string($channel)) {
			$argumentType = (is_object($channel)) ? get_class($channel) : gettype($channel);
			throw new \InvalidArgumentException('Expected the channel name as string. Got ' . $argumentType);
		}
		if (mb_substr($channel, 0, 1) != '#') {
			throw new \InvalidArgumentException('The channel name is invalid. It has to start with "#".');
		}
		$this->channel = $channel;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return $this
	 */
	public function setUsername($username)
	{
		if (!is_string($username)) {
			$argumentType = (is_object($username)) ? get_class($username) : gettype($username);
			throw new \InvalidArgumentException('Expected the username as string. Got ' . $argumentType);
		}
		$this->username = $username;
		return $this;
	}

	/**
	 * @param SlackMessageInterface $slackMessage
	 * @return $this
	 */
	public function post(SlackMessageInterface $slackMessage)
	{
		$payload = array(
			'channel' => $this->getChannel(),
			'username' => $this->getUsername(),
			'text' => $slackMessage->getText(),
			'unfurl_links' => $slackMessage->getUnfurlLinks(),
			'unfurl_media' => $slackMessage->getUnfurlMedia(),
		);
		if (!is_null($slackMessage->getIconUrl())) {
			$payload['icon_url'] = $slackMessage->getIconUrl();
		}
		if ($slackMessage->hasAttachments()) {
			foreach ($slackMessage->getAttachments() as $attachment) {
				if (!isset($payload['attachments'])) {
					$payload['attachments'] = array();
				}
				$payload['attachments'][] = $attachment->toArray();
			}
		}
		$endpoint = 'https://' . $this->getSubdomainName() . '.slack.com/services/hooks/incoming-webhook?token='
			. $this->getToken();
		$this->performRequest($endpoint, $payload);
		return $this;
	}

	/**
	 * @param $endpoint
	 * @param array $payload
	 * @throws StringifyException
	 * @throws UnexpectedResponseException
	 * @throws ConnectionTimeoutException
	 * @throws CurlException
	 */
	protected function performRequest($endpoint, array $payload)
	{
		$requestBody = @json_encode($payload);
		if ($requestBody === false) {
			throw new StringifyException('Building payload failed.');
		}
		$message = new Message();
		$message
			->addHeader(new Header('Content-Type', array('application/json')))
			->addHeader(new Header('Accept', array('application/json')))
			->setBody(new Body($requestBody));
		$request = new Request();
		$response = $request
			->setTransport(new HttpsTransport())
			->setUrl(new Url($endpoint))
			->setMethod(Request::REQUEST_METHOD_POST)
			->setMessage($message)
			->perform()
			->getResponse();
		if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
			throw new UnexpectedResponseException(
				'Slack API responded unexpected with HTTP status ' . (string)$response->getStatusText()
			);
		}
	}

}
