<?php

namespace Github\Tests;

use Github\Client;
use Github\Exception\InvalidArgumentException;

/**
 * Client unit test
 *
 * @author Leszek Prabucki <leszek.prabucki@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor()
    {
        $client = new Client();

        $this->assertInstanceOf('Github\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingLoginAndPassword()
    {
        $client = new Client();
        $client->authenticate('login', 'password', Client::AUTH_HTTP_PASSWORD);

        $this->assertInstanceOf('Github\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingHttpToken()
    {
        $client = new Client();
        $client->authenticate('login', 'password', Client::AUTH_HTTP_TOKEN);

        $this->assertInstanceOf('Github\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldAuthenticateUsingUrlToken()
    {
        $client = new Client();
        $client->authenticate('login', 'password', Client::AUTH_URL_TOKEN);

        $this->assertInstanceOf('Github\HttpClient\HttpClient', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldClearHeadersLaizly()
    {
        $client = new Client();
        $client->clearHeaders();

        $this->assertInstanceOf('Github\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldSetHeadersLaizly()
    {
        $client = new Client();
        $client->setHeaders(array('header1', 'header2'));

        $this->assertInstanceOf('Github\HttpClient\HttpClientInterface', $client->getHttpClient());
    }

    /**
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client();
        $client->api('do_not_exist');
    }

    public function getApiClassesProvider()
    {
        return array(
            array('user', 'Github\Api\User'),
            array('current_user', 'Github\Api\CurrentUser'),
            array('git_data', 'Github\Api\GitData'),
            array('gists', 'Github\Api\Gists'),
            array('issue', 'Github\Api\Issue'),
            array('markdown', 'Github\Api\Markdown'),
            array('organization', 'Github\Api\Organization'),
            array('repo', 'Github\Api\Repo'),
            array('pull_request', 'Github\Api\PullRequest'),
        );
    }
}
