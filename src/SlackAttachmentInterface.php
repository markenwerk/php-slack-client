<?php

namespace Markenwerk\SlackClient;

/**
 * Interface SlackAttachmentInterface
 *
 * @package Markenwerk\SlackClient
 */
interface SlackAttachmentInterface
{

	/**
	 * @return SlackAttachmentFieldInterface[]
	 */
	public function getFields();

	/**
	 * @return array
	 */
	public function toArray();

}
