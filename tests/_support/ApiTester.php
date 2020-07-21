<?php
namespace App\Tests;

use Codeception\Actor;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class ApiTester extends Actor
{
    use _generated\ApiTesterActions;

    private function getKey(): string
    {
        return '?apiKey='.explode(',', $_ENV['KEYS'])[0];
    }

    public function sendPostApiRequest(
        $uri,
        $params
    ) {
        $this->haveHttpHeader('accept', 'application/json');
        $this->haveHttpHeader('content-type', 'application/json');
        $this->sendPOST($uri.$this->getKey(), $params);
        return $this->validateAndReturnResponse();
    }

    public function sendGetApiRequest($uri, $params = [])
    {
        $this->sendGET($uri.$this->getKey(), $params);
        return $this->validateAndReturnResponse();
    }

    public function sendPatchApiRequest($uri, $params)
    {
        $this->sendPATCH($uri.$this->getKey(), $params);
        return $this->validateAndReturnResponse();
    }

    /**
     * @return mixed
     */
    protected function validateAndReturnResponse()
    {
        $this->seeResponseCodeIsSuccessful();
        $this->seeResponseIsJson();

        return json_decode($this->grabResponse(), true);
    }
}
