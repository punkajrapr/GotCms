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
 * Layout controller tests
 *
 * @package GotCms\Bundle\ApiBundle\Tests
 */
class LayoutControllerTest extends BaseRestTestCase
{
    protected $fixtures = ['GotCms\Bundle\ApiBundle\Tests\DataFixtures\ORM\LoadLayoutData'];

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
     * Get Layouts action should return all layouts
     *
     * @return null
     */
    public function testGetLayoutsAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/layouts'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
    }

    /**
     * Get Layout action with invalid id should return HTTP_NOT_FOUND
     *
     * @return null
     */
    public function testGetLayoutActionWithWrongId()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/layouts/1000'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NOT_FOUND,
            $client
        );
    }

    /**
     * Get Layout action should return layout
     *
     * @return null
     */
    public function testGetLayoutAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/layouts/1'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
        $layout = json_decode($jsonResponse);
        $this->assertEquals('content', $layout->content);
    }

    /**
     * Post Layout action must failed with invalid credentials
     *
     * @return null
     */
    public function testPostLayoutActionInvalidData()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/layouts',
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
     * Post Layout action must success with valid data
     *
     * @return null
     */
    public function testPostLayoutAction()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/layouts',
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
     * Put Layout action should be ok with valid data
     *
     * @return null
     */
    public function testPutLayoutAction()
    {
        $layout = $this->repos()->getLayoutRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'PUT',
            'api/development/layouts/1',
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
        $newLayout = json_decode($jsonResponse);
        $this->assertEquals($layout->getId(), $newLayout->id);
        $this->assertEquals('new-identifier', $newLayout->identifier);
        $this->assertEquals('new content', $newLayout->content);
        $this->assertEquals('desc', $newLayout->description);
        $this->assertEquals('blablabla', $newLayout->name);
    }

    /**
     * Put Layout action should not be ok with invalid data
     *
     * @return null
     */
    public function testPutLayoutActionWithInvalidData()
    {
        $layout = $this->repos()->getLayoutRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'PUT',
            'api/development/layouts/1',
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
     * Delete layout should not work with wrong id
     *
     * @return null
     */
    public function testDeleteLayoutActionWithInvalidId()
    {
        $client = $this->getClient();
        $client->request(
            'DELETE',
            'api/development/layouts/10000'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NOT_FOUND,
            $client
        );
    }

    /**
     * Delete layout should be ok with valid id
     *
     * @return null
     */
    public function testDeleteLayoutActionWithValidId()
    {
        $layout = $this->repos()->getLayoutRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'DELETE',
            'api/development/layouts/1'
        );
        $this->assertInstanceOf('GotCms\\Core\\Entity\\Layout', $layout);
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NO_CONTENT,
            $client
        );
    }
}
