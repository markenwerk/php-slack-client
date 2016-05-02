<?php

namespace Project;

require_once('vendor/autoload.php');

use SlackClient\SlackAttachment;
use SlackClient\SlackAttachmentField;
use SlackClient\SlackClient;
use SlackClient\SlackMessage;

$client = new SlackClient();
$client
	->setSubdomainName('markenwerk')
	->setToken('')
	->setUsername('PHP SlackClient')
	->setChannel('#log');

$message = new SlackMessage();
$message
	->setText('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
	->setIconUrl('https://avatars2.githubusercontent.com/u/5921253?v=3&s=200')
	->setUnfurlLinks(true)
	->setUnfurlMedia(true);

$attachment = new SlackAttachment();
$attachment
	->setText('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
	->setPretext('A basic Slack client library.')
	->setFallback('A basic Slack client library providing simple posting to Slack channels using the webhook API.')
	->setColor(SlackAttachment::COLOR_WARNING);

$shortAttachmentField = new SlackAttachmentField();
$shortAttachmentField
	->setTitle('Short field')
	->setValue('Some chars')
	->setShort(true);

$anotherShortAttachmentField = new SlackAttachmentField();
$anotherShortAttachmentField
	->setTitle('Short field')
	->setValue('Some chars')
	->setShort(true);

$attachmentField = new SlackAttachmentField();
$attachmentField
	->setTitle('Regular field')
	->setValue('Some more chars')
	->setShort(false);

$anotherAttachmentField = new SlackAttachmentField();
$anotherAttachmentField
	->setTitle('Regular field')
	->setValue('Some more chars')
	->setShort(false);

$attachment
	->addField($shortAttachmentField)
	->addField($anotherShortAttachmentField)
	->addField($attachmentField)
	->addField($anotherAttachmentField);

$message->addAttachment($attachment);

$client->post($message);
