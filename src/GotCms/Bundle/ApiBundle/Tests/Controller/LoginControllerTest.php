<?php
/**
 * Controller tests
 *
 * PHP version >= 5.5
 *
 * @category   Game\Tests
 * @package    Game\RestBundle\Tests
 * @subpackage Controller
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       https://www.prettysimplegames.com/
 */
namespace Game\RestBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Login controller tests
 *
 * @package Game\RestBundle\Tests
 */
class LoginControllerTest extends BaseTestCase
{
    protected $fixtures = ['Game\RestBundle\DataFixtures\ORM\LoadUserData'];

    /**
     * Login action must failed with invalid credentials
     *
     * @return null
     */
    public function testPostLoginActionInvalidCreds()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'user/login',
            [
                'login' => 'nothing',
                'password' => 'nothing'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals('{"errors":"Invalid credentials"}', $jsonResponse);
    }

    /**
     * Login action must failed with unactive user
     *
     * @return null
     */
    public function testPostLoginActionUnactiveUser()
    {
        $user = $this->repos()
            ->getUserRepository()
            ->find(1);

        $user->setIsActive(false);
        $this->getDoctrine()->getEntityManager()->persist($user);
        $this->getDoctrine()->getEntityManager()->flush();

        $client = $this->getClient();
        $client->request(
            'POST',
            'user/login',
            [
                'login' => 'user#0',
                'password' => 'nothing'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(
            Response::HTTP_FORBIDDEN,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals('{"errors":"User not activate"}', $jsonResponse);
    }

    /**
     * Login action must works with valid creds
     *
     * @return null
     */
    public function testPostLoginActionValidCreds()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'user/login',
            [
                'login' => 'user#0',
                'password' => 'nothing'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();

        $user     = $this->repos()
            ->getUserRepository()
            ->find(1);
        $jsonData = $this->serialize($user->sanitize(), 'json');

        $this->assertJson($jsonResponse);
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals($jsonData, $jsonResponse);
    }

    /**
     * Login action return user information if
     * user is already connected
     *
     * @return null
     */
    public function testPostLoginActionAlreadyConnected()
    {
        $user   = $this->logIn();
        $client = $this->getClient();
        $client->request(
            'POST',
            'user/login'
        );
        $jsonResponse = $client->getResponse()->getContent();

        $jsonData = $this->serialize($user->sanitize(), 'json');

        $this->assertJson($jsonResponse);
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals($jsonData, $jsonResponse);
    }

    /**
     * Logout action
     *
     * @return null
     */
    public function testGetLogoutAction()
    {
        $user   = $this->logIn();
        $client = $this->getClient();
        $client->request(
            'GET',
            'user/logout'
        );
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        $this->assertEquals('[]', $jsonResponse);
        $this->assertNull($this->getContainer()->get('session')->get('user'));
    }
}
