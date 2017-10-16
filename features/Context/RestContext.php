<?php

namespace RPGBehat;


use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Mink\Driver\GoutteDriver;
use Behat\MinkExtension\Context\RawMinkContext;
use Goutte\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\Assert;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;

class RestContext extends RawMinkContext
{

    private $restObject = null;

    /** @var string */
    private $restObjectMethod = 'get';

    /** @var Response */
    private $response   = null;
    private $requestUrl = null;

    private $extraHeaders = [];

    private $baseUrl = 'http://172.17.0.1:8001';

    public function __construct()
    {
        $this->restObject = new \stdClass();
    }

    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $scope
     */
    public static function prepare(BeforeScenarioScope $scope)
    {
        shell_exec('bin/console app:fixtures:reload');
    }


    /**
     * @Given /^I want to send a "([^"]*)" request$/
     */
    public function iWantToSendARequest($method)
    {
        $this->restObjectMethod = $method;
    }


    /**
     * @Given /^I send "([^"]*)" request to "([^"]*)"$/
     *
     * @throws \Exception
     */
    public function iSendRequestTo($requestType, $url)
    {
        $this->restObjectMethod = $requestType;
        try {
            $this->iRequest($url);
        } catch (BadResponseException $e) {
            if (!$this->response) {
                $this->response = $e->getResponse();
            }
        }
    }

    /**
     * @Given /^body of request contains json$/
     * @param PyStringNode $json
     */
    public function bodyOfRequestContainsJson(PyStringNode $json)
    {
        $this->restObject = $json->getRaw();
    }


    /**
     * @Given /^I set "([^"]*)" header to "([^"]*)"$/
     */
    public function iSetHeaderTo($header, $value)
    {
        $this->extraHeaders[$header] = $value;
    }

    /**
     * @When /^I request "([^"]*)"$/
     * @throws \Exception
     */
    public function iRequest($pageUrl)
    {
        $this->requestUrl = $pageUrl;

        $restObject = count((array)$this->restObject) == 0 ? null : $this->restObject;

        $response = null;
        try {
            switch (strtoupper($this->restObjectMethod)) {
                case 'GET':
                    $response = $this->getGoutteClient()->getClient()
                        ->get($this->getUrl() ,[
                            RequestOptions::HEADERS => $this->extraHeaders
                        ]);
                    break;
                case 'POST':
                    $response = $this->getGoutteClient()->getClient()
                        ->post($this->getUrl(), [
                            RequestOptions::BODY => $restObject,
                            RequestOptions::HEADERS => array_merge($this->extraHeaders, ['Content-Type' => 'application/json'])
                        ]);
                    break;
                case 'DELETE':
                    $response = $this->getGoutteClient()->getClient()
                        ->delete($this->getUrl(),[
                            RequestOptions::HEADERS => $this->extraHeaders
                        ]);
                    break;
                case 'PUT':
                    $response = $this->getGoutteClient()->getClient()
                        ->put($this->getUrl(), [
                            RequestOptions::BODY => $restObject,
                            RequestOptions::HEADERS => array_merge($this->extraHeaders, ['Content-Type' => 'application/json'])
                        ]);
                    break;
                case 'PATCH':
                    $response = $this->getGoutteClient()->getClient()
                        ->patch($this->getUrl(), [
                            RequestOptions::BODY => $restObject,
                            RequestOptions::HEADERS => array_merge($this->extraHeaders, ['Content-Type' => 'application/json'])
                        ]);
                    break;
                default:
                    throw new \Exception('Invalid request method: ' . $this->restObjectMethod);
            }
            $this->response = $response;
        } catch (BadResponseException $exception) {
            $this->response = $exception->getResponse();
        }
    }

    /**
     * @Then /^the response is JSON$/
     * @throws \Exception
     */
    public function theResponseIsJson()
    {
        $data = json_decode($this->response->getBody());

        if (empty($data)) {
            throw new \Exception("Response was not JSON\n" . $this->response->getBody());
        }
    }

    /**
     * @Given /^the response has a "([^"]*)" property$/
     * @And /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAProperty($propertyName)
    {
        $data = $this->getResponseJsonData();

        $this->checkPropertyExist($data, $propertyName);
    }

    /**
     * @Given /^the response has not a "([^"]*)" property$/
     * @And /^the response has not a "([^"]*)" property$/
     * @throws \Exception
     */
    public function theResponseHasNotAProperty($propertyName)
    {
        $data = $this->getResponseJsonData();
        try {
            $this->checkPropertyExist($data, $propertyName);
            throw new \Exception("Property '" . $propertyName . "'exists ");
        } catch (NoSuchPropertyException $e) {

        }
    }

    /**
     * @Given /^the response has a "([^"]*)" property with "([^"]*)" value$/
     */
    public function theResponseHasAPropertyWithValue($propertyName, $value)
    {
        $value         = $value == 'false' ? false : $value;
        $value         = $value == 'true' ? true : $value;
        $propertyValue = $this->getResponseProperty($propertyName);
        if (is_array($propertyValue) && !$propertyValue) {
            $propertyValue = "";
        }
        Assert::assertEquals($value, $propertyValue);
    }

    /**
     * @Then /^the response is empty$/
     */
    public function theResponseIsEmpty()
    {
        Assert::assertEmpty($this->getResponseJsonData());
    }


    /**
     * @Given /^response contain "([^"]*)" elements$/
     * @param $size
     */
    public function responseContainElements($size)
    {
        Assert::assertCount(intval($size), $this->getResponseJsonData(true));
    }


    /**
     * @param integer
     * @Then /^the response has size of (\d+)$/
     */
    public function theResponseSize($size)
    {
        Assert::assertCount(intval($size), $this->getResponseJsonData());
    }

    /**
     * @Given /^the response has a "([^"]*)" property in list$/
     * @And /^the response has a "([^"]*)" property in list$/
     */
    public function theResponseHasAPropertyInList($propertyName)
    {
        $data = json_decode($this->response->getBody());
        $data = array_pop($data);
        $this->checkPropertyExist($data, $propertyName);
    }


    /**
     * @Then /^the "([^"]*)" property equals "([^"]*)"$/
     * @throws \Exception
     */
    public function thePropertyEquals($propertyName, $propertyValue)
    {
        $data = json_decode($this->response->getBody());

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new \Exception("Property '" . $propertyName . "' is not set!\n");
            }
            if ($data->$propertyName !== $propertyValue) {
                throw new \Exception('Property value mismatch! (given: ' . $propertyValue . ', match: '
                                     . $data->$propertyName . ')');
            }
        } else {
            throw new \Exception("Response was not JSON\n" . $this->response->getBody());
        }
    }

    /**
     * @Given /^the type of the "([^"]*)" property is ([^"]*)$/
     * @throws \Exception
     */
    public function theTypeOfThePropertyIsNumeric($propertyName, $typeString)
    {
        $data = json_decode($this->response->getBody());

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new \Exception("Property '" . $propertyName . "' is not set!\n");
            }
            // check our type
            switch (strtolower($typeString)) {
                case 'numeric':
                    if (!is_numeric($data->$propertyName)) {
                        throw new \Exception("Property '" . $propertyName . "' is not of the correct type: " .
                                             $typeString . "!\n");
                    }
                    break;
            }

        } else {
            throw new \Exception("Response was not JSON\n" . $this->response->getBody());
        }
    }

    /**
     * @Given /^the response text contains "([^"]*)"$/
     * @param $text
     */
    public function theResponseTextContains($text)
    {
        Assert::assertTrue(strpos($this->response->getBody(), $text) !== false);
    }


    /**
     * @Then /^echo last response$/
     */
    public function echoLastResponse()
    {
        echo
            $this->getUrl() . "\n\n" .
            $this->response->getBody()
        ;
    }

    /**
     * @Then /^I should see response status code (\d+)$/
     */
    public function iShouldSeeResponseStatusCode($code)
    {
        Assert::assertEquals($code, $this->response->getStatusCode(), sprintf(
            'Wrong response status code on page "%s"', $this->response->getStatusCode()
        ));
    }

    private function getUrl()
    {
        return $this->baseUrl . $this->requestUrl;
    }

    private function checkPropertyExist($data, $propertyName)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $accessor->getValue($data, $propertyName);
    }

    /**
     * @param bool $assoc
     * @return mixed
     */
    private function getResponseJsonData($assoc = false)
    {
        return json_decode($this->response->getBody(), $assoc);
    }

    private function getResponseProperty($propertyName)
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        return $accessor->getValue($this->getResponseJsonData(), $propertyName);
    }

    /**
     * @return \Behat\Mink\Driver\DriverInterface
     */
    private function getDriver()
    {
        return $this->getSession()->getDriver();
    }

    /**
     * @throws \Exception
     * @return Client
     */
    private function getGoutteClient()
    {
        $driver = $this->getDriver();
        if ($driver instanceof GoutteDriver) {
            /** @var $driver \Behat\Mink\Driver\GoutteDriver */
            return $driver->getClient();
        }
        throw new \Exception("Driver " . get_class($driver) . " does not support client");
    }

}
