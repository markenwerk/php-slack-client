<?php

namespace SlackClient;

/**
 * Interface SlackAttachmentInterface
 *
 * @package SlackClient
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
