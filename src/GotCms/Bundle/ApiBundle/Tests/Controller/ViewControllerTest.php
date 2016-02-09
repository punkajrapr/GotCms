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

/**
 * View controller tests
 *
 * @package GotCms\Bundle\ApiBundle\Tests
 */
class ViewControllerTest extends BaseRestTestCase
{
    protected $fixtures = ['GotCms\Bundle\ApiBundle\Tests\DataFixtures\ORM\LoadViewData'];

    /**
     * Get Views action should return all views
     *
     * @return null
     */
    public function testGetViewsAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/views'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
    }

    /**
     * Get View action with invalid id should return HTTP_NOT_FOUND
     *
     * @return null
     */
    public function testGetViewActionWithWrongId()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/views/1000'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_NOT_FOUND,
            $client
        );
    }

    /**
     * Get View action should return view
     *
     * @return null
     */
    public function testGetViewAction()
    {
        $client = $this->getClient();
        $client->request(
            'GET',
            'api/development/views/1'
        );
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertJson($jsonResponse);
        $this->assertStatusCode(
            Response::HTTP_OK,
            $client
        );
        $view = json_decode($jsonResponse);
        $this->assertEquals('content', $view->content);
    }

    /**
     * Post View action must failed with invalid credentials
     *
     * @return null
     */
    public function testPostViewActionInvalidData()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/views',
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
     * Post View action must success with valid data
     *
     * @return null
     */
    public function testPostViewAction()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'api/development/views',
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
     * Put View action should be ok with valid data
     *
     * @return null
     */
    public function testPutViewAction()
    {
        $view   = $this->repos()->getViewRepository()->findOneById(1);
        $client = $this->getClient();
        $client->request(
            'PUT',
            'api/development/views/1',
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
        $newView = json_decode($jsonResponse);
        $this->assertEquals($view->getId(), $newView->id);
        $this->assertEquals('new-identifier', $newView->identifier);
        $this->assertEquals('new content', $newView->content);
        $this->assertEquals('desc', $newView->description);
        $this->assertEquals('blablabla', $newView->name);
    }
}
