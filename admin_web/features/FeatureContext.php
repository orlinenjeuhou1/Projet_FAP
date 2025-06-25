<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeatureContext extends RawMinkContext implements Context
{
    private $response;
    private $request;

    /**
     * @When I send a GET request to :url
     */
    public function iSendAGetRequestTo($url)
    {
        $this->request = Request::create($url, 'GET');
        $this->response = $this->getMink()->getSession()->getDriver()->getClient()->request('GET', $url);
    }

    /**
     * @When I send a POST request to :url with body:
     */
    public function iSendAPostRequestToWithBody($url, PyStringNode $body)
    {
        $this->request = Request::create($url, 'POST', [], [], [], [], $body->getRaw());
        $this->response = $this->getMink()->getSession()->getDriver()->getClient()->request('POST', $url, [], [], [], $body->getRaw());
    }

    /**
     * @Then the response status code should be :code
     */
    public function theResponseStatusCodeShouldBe($code)
    {
        $statusCode = $this->getMink()->getSession()->getStatusCode();
        if ($statusCode != $code) {
            throw new Exception("Expected status code $code, got $statusCode");
        }
    }

    /**
     * @Then the response should contain JSON
     */
    public function theResponseShouldContainJson()
    {
        $content = $this->getMink()->getSession()->getPage()->getContent();
        $decoded = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Response is not valid JSON: " . json_last_error_msg());
        }
    }

    /**
     * @Then the response should contain :text
     */
    public function theResponseShouldContain($text)
    {
        $content = $this->getMink()->getSession()->getPage()->getContent();
        if (strpos($content, $text) === false) {
            throw new Exception("Response does not contain '$text'");
        }
    }
}
