<?php
/**
 * Controller tests
 *
 * PHP version >= 5.5
 *
 * @category   Gotcms\Bundle\ApiBundle\Tests
 * @package    GotCms\Bundle\ApiBundle\Tests
 * @subpackage Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       https://www.prettysimplegames.com/
 */
namespace GotCms\Bundle\ApiBundle\Tests\Controller;

use GotCms\Core\Tests\Controller\BaseRestTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Script controller tests
 *
 * @package GotCms\Bundle\ApiBundle\Tests
 */
class ScriptControllerTest extends BaseRestTestCase
{
    protected $fixtures = ['GotCms\Bundle\ApiBundle\Tests\DataFixtures\ORM\LoadScriptData'];

    /**
     * Clear all useless templates
     *
     * @return null
     */
    protected function setUp()
    {
        $finder       = new Finder();
        $fs           = new Filesystem();
        $templatePath = $this->getClient()->getKernel()->getContainer()->getParameter('gotcms_api.templates_path');
        foreach ($finder->in(sprintf('%s/*/', $templatePath))->files() as $file) {
            $fs->remove($file->getPathName());
        }

        parent::setUp();
    }

    /**
     * Get Scripts action should return all scripts
     *
     * @return null
     */
    public function testGetScriptsAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/scripts'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
    }

    /**
     * Get Script action with invalid id should return HTTP_NOT_FOUND
     *
     * @return null
     */
    public function testGetScriptActionWithWrongId()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/scripts/1000'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NOT_FOUND,
            $client
        );
    }

    /**
     * Get Script action should return script
     *
     * @return null
     */
    public function testGetScriptAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/scripts/1'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
        $script = json_decode($jsonResponse);
        $this->assertEquals('content', $script->content);
    }

    /**
     * Post Script action must failed with invalid credentials
     *
     * @return null
     */
    public function testPostScriptActionInvalidData()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/scripts',
            [
                'identifier' => '&é',
                'name' => 'blablabla'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_BAD_REQUEST,
            $client
        );
        $this->assertContains('.identifier:\n    This value is not valid.', $jsonResponse);
    }

    /**
     * Post Script action must success with valid data
     *
     * @return null
     */
    public function testPostScriptAction()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/scripts',
            [
                'identifier' => 'new-identifier',
                'name' => 'blablabla',
                'content' => 'new-content'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
        $this->assertContains('"name":"blablabla","identifier":"new-identifier"', $jsonResponse);
    }

    /**
     * Put Script action should be ok with valid data
     *
     * @return null
     */
    public function testPutScriptAction()
    {
        $script = $this->repos()->getScriptRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'PUT',
            'api/development/scripts/1',
            [
                'identifier' => 'new-identifier',
                'description' => 'desc',
                'content' => 'new content',
                'name' => 'blablabla'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
        $newScript = json_decode($jsonResponse);
        $this->assertEquals($script->getId(), $newScript->id);
        $this->assertEquals('new-identifier', $newScript->identifier);
        $this->assertEquals('new content', $newScript->content);
        $this->assertEquals('desc', $newScript->description);
        $this->assertEquals('blablabla', $newScript->name);
    }

    /**
     * Put Script action should not be ok with invalid data
     *
     * @return null
     */
    public function testPutScriptActionWithInvalidData()
    {
        $script = $this->repos()->getScriptRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'PUT',
            'api/development/scripts/1',
            [
                'identifier' => '&é(-è)',
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_BAD_REQUEST,
            $client
        );
        $this->assertContains('.identifier:\n    This value is not valid.', $jsonResponse);
    }

    /**
     * Delete script should not work with wrong id
     *
     * @return null
     */
    public function testDeleteScriptActionWithInvalidId()
    {
        $client = $this->getClient();
        $client->request(
            'DELETE',
            'api/development/scripts/10000'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NOT_FOUND,
            $client
        );
    }

    /**
     * Delete script should be ok with valid id
     *
     * @return null
     */
    public function testDeleteScriptActionWithValidId()
    {
        $script = $this->repos()->getScriptRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'DELETE',
            'api/development/scripts/1'
        );
        $this->assertInstanceOf('GotCms\\Core\\Entity\\Script', $script);
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NO_CONTENT,
            $client
        );
    }
}
