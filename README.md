# PHP Slack Client

[![Build Status](https://travis-ci.org/markenwerk/php-slack-client.svg?branch=master)](https://travis-ci.org/markenwerk/php-slack-client)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-slack-client/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-slack-client/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/5728e2a8a0ca35005083fb90/badge.svg)](https://www.versioneye.com/user/projects/5728e2a8a0ca35005083fb90)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/d4583d4b-5425-45d4-954d-8bcf5c30c9b1.svg)](https://insight.sensiolabs.com/projects/d4583d4b-5425-45d4-954d-8bcf5c30c9b1)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-slack-client/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-slack-client)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/slack-client/v/stable)](https://packagist.org/packages/markenwerk/slack-client)
[![Total Downloads](https://poser.pugx.org/markenwerk/slack-client/downloads)](https://packagist.org/packages/markenwerk/slack-client)
[![License](https://poser.pugx.org/markenwerk/slack-client/license)](https://packagist.org/packages/markenwerk/slack-client)

A basic Slack client library providing simple posting to Slack channels using the webhook API.

## Installation

```{json}
{
   	"require": {
        "markenwerk/slack-client": "~2.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

### Posting to a channel or member

The following example will post to a Slack channel or member looking like this: 

![Slack Example Post](example-post.png "Slack Example Post")

#### Setup the API client

```{php}
use Markenwerk\SlackClient\SlackClient;

$client = new SlackClient();
$client
	->setSubdomainName('markenwerk')
	->setToken('<YOUR_API_TOKEN>')
	->setUsername('PHP SlackClient');
```

#### Setup a Slack message with attachments

```{php}
use Markenwerk\SlackClient\SlackAttachment;
use Markenwerk\SlackClient\SlackAttachmentField;
use Markenwerk\SlackClient\SlackMessage;

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
```

#### Post to a channel

```{php}
$client->postToChannel('#channel', $message);
```

#### Post to a member

```{php}
$client->postToMember('@member', $message);
```

---

## Exception handling

PHP Basic HTTP Client provides different exceptions – also provided by the PHP Common Exceptions project – for proper handling.  
You can find more information about [PHP Common Exceptions at Github](https://github.com/markenwerk/php-common-exceptions).

### Exceptions to be expected

In general you should expect that any setter method could thrown an `\InvalidArgumentException`. The following exceptions could get thrown while using PHP Slack Client.

- `Markenwerk\CommonException\ParserException\StringifyException` on posting to Slack
- `Markenwerk\CommonException\NetworkException\UnexpectedResponseException` on posting to Slack
- `Markenwerk\CommonException\NetworkException\ConnectionTimeoutException` on posting to Slack
- `Markenwerk\CommonException\NetworkException\CurlException` on posting to Slack

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-slack-client/blob/master/CONTRIBUTING.md) document.**

## License

PHP Slack Client is under the MIT license.
