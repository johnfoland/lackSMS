# lackSMS
Transfers incoming SMS messages from SignalWire DIDs to an arbitrary Slack channel. Optionally deletes messages from the cloud after posting to Slack. Run in a Docker container or anywhere else with Composer.

## Configuration and credential requirements
 - A purchased SignalWire number from your Space.
 - A Slack App created with its webhook URL handy.
 - The Slack channel to which you wish to transfer the SMS.
 - A SignalWire API Key, Project ID and Space URL. (Optional: for deleting messages from the cloud)

## Server environment requirements
Docker or: 
 - PHP-FPM 7.x
 - Composer ≥1
 - Nginx, Apache, etc.

## Installation

### Clone repo and edit `.env.example` file
Clone the repo with the method that best suits you, then edit the `.env.example` file as instructed within. If installing with Docker in the next step, just save the `.env.example` file; it will be copied over as `.env` when you build. If installing with Composer, rename with `mv .env.example .env` after saving.

### Install with Docker or Composer
Either build and run a Docker container or install the code and its dependencies using Composer.

#### Build and run with Docker
`docker build -t lacksms . ; docker run -d -p 80:80 lacksms`

#### Installation with Composer
`composer install`

### Optionally rename `postMessage.php` file
Feel free to rename the `postMessage.php` file to whatever you'd like as long as it retains the `.php` extension.

### Set SignalWire webhook
From within your SignalWire Space, edit the settings of the phone number to be used. Under "Messaging Settings", choose "LāML Webhooks" and enter the URI to your instance of `postMessage.php`.

## PHP Dependencies
lackSMS uses the following Composer packages:
 - `vlucas/phpdotenv` : https://github.com/vlucas/phpdotenv
 - `alek13/slack` : https://github.com/php-slack/slack
 - `signalwire/signalwire` : https://github.com/signalwire/signalwire-php
 - `phpunit/phpunit` : https://github.com/sebastianbergmann/phpunit/
 - `symfony/var-dumper` : https://github.com/symfony/var-dumper

