# PHP Slack Client

[![Build Status](https://travis-ci.org/markenwerk/php-slack-client.svg?branch=master)](https://travis-ci.org/markenwerk/php-slack-client)
[![Test Coverage](https://codeclimate.com/github/markenwerk/php-slack-client/badges/coverage.svg)](https://codeclimate.com/github/markenwerk/php-slack-client/coverage)
[![Dependency Status](https://www.versioneye.com/user/projects/571f8827fcd19a00415b2836/badge.svg)](https://www.versioneye.com/user/projects/571f8827fcd19a00415b2836)
[![Code Climate](https://codeclimate.com/github/markenwerk/php-slack-client/badges/gpa.svg)](https://codeclimate.com/github/markenwerk/php-slack-client)
[![Latest Stable Version](https://poser.pugx.org/markenwerk/slack-client/v/stable)](https://packagist.org/packages/markenwerk/slack-client)
[![Total Downloads](https://poser.pugx.org/markenwerk/slack-client/downloads)](https://packagist.org/packages/markenwerk/slack-client)
[![License](https://poser.pugx.org/markenwerk/slack-client/license)](https://packagist.org/packages/markenwerk/slack-client)

A basic Slack client library providing simple posting to Slack channels using the webhook API.

## Installation

```{json}
{
   	"require": {
        "markenwerk/slack-client": "~1.0"
    }
}
```

## Usage

### Autoloading and namesapce

```{php}  
require_once('path/to/vendor/autoload.php');
```

### Posting to a channel

The following example will produce a post in a Slack channel looking like this: 

![Slack ]

```{php}
use SlackClient\SlackAttachment;
use SlackClient\SlackAttachmentField;
use SlackClient\SlackClient;
use SlackClient\SlackMessage;

$client = new SlackClient();
$client
	->setSubdomainName('markenwerk')
	->setToken('<YOUR_API_TOKEN>')
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
```

---

## Extending the Basic HTTP Client

Every part of the client is based upon proper interfaces. Most class instances can get injected into the client itself. 
If you want to extend the client just write some classes implementing the according interface and you´re done with that. 

Take a look at the [PHP JSON HTTP Client](https://github.com/markenwerk/php-json-http-client) which is an extension of the PHP Basic HTTP Client.

---

## Exception handling

PHP Basic HTTP Client provides different exceptions – also provided by the PHP Common Exceptions project – for proper handling.  
You can find more information about [PHP Common Exceptions at Github](https://github.com/markenwerk/php-common-exceptions).

### Exceptions to be expected

In general you should expect that any setter method could thrown an `\InvalidArgumentException`. The following exceptions could get thrown while using PHP Basic HTTP Client.

- `CommonException\IoException\FileNotFoundException` on configuring a `ClientCertificateAuthentication`instance
- `CommonException\IoException\FileReadableException` on configuring a `ClientCertificateAuthentication`instance
- `BasicHttpClient\Exception\HttpRequestAuthenticationException` on performing a request
- `BasicHttpClient\Exception\HttpRequestException` on performing a request
- `CommonException\NetworkException\ConnectionTimeoutException` on performing a request
- `CommonException\NetworkException\CurlException` on performing a request

---

## Contribution

Contributing to our projects is always very appreciated.  
**But: please follow the contribution guidelines written down in the [CONTRIBUTING.md](https://github.com/markenwerk/php-slack-client/blob/master/CONTRIBUTING.md) document.**

## License

PHP Slack Client is under the MIT license.