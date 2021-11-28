<?php

/*
|--------------------------------------------------------------------------
| Load PHP dotenv and require non-empty values
|--------------------------------------------------------------------------
|
| Require that the Slack web hook URL and channel variables be specified
| in the .env file.
| 
*/
require(__DIR__ . '/vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required(['SLACKURL', 'SLACKCHA'])->notEmpty();


/*
|--------------------------------------------------------------------------
| Load Slack for PHP client
|--------------------------------------------------------------------------
*/

use Maknz\Slack\Client as SlaClient;

$client = new SlaClient($_ENV["SLACKURL"]);


/*
|--------------------------------------------------------------------------
| Construct and post SMS to Slack channel
|--------------------------------------------------------------------------
*/
$client->to($_ENV["SLACKCHA"])
    ->send(
        $_REQUEST['Body'] .
        "\r\n - From: " . $_REQUEST['From'] .
        "\r\n - To: " . $_REQUEST['To']
    );


/*
|--------------------------------------------------------------------------
| Load SignalWire PHP client
|--------------------------------------------------------------------------
|
| Optionally load the SignalWire REST client to delete the incoming
| message from the cloud.
| 
*/
if (!empty($_ENV["SWPROJECT"])) {
    $dotenv->required(['SWPROJECT', 'SWAPIKEY', 'SWSPACE'])->notEmpty();

    use SignalWire\Rest\Client as SWClient;

    $swClient = new SWClient(
        $_ENV["SWPROJECT"],
        $_ENV["SWAPIKEY"],
        array("signalwireSpaceUrl" => $_ENV["SWSPACE"])
    );
    $swClient->messages($_REQUEST['MessageSid'])
        ->delete();
}
