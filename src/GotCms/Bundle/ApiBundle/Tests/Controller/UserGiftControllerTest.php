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
use Game\RestBundle\Entity\UserGift;
use Game\RestBundle\Entity\User;

/**
 * User gifts controller tests
 *
 * @package Game\RestBundle\Tests
 */
class UserGiftControllerTest extends BaseTestCase
{
    protected $fixtures = [
        'Game\RestBundle\DataFixtures\ORM\LoadUserData',
        'Game\RestBundle\DataFixtures\ORM\LoadGiftTypeData',
        'Game\RestBundle\DataFixtures\ORM\LoadGiftData',
        'Game\RestBundle\DataFixtures\ORM\LoadUserGiftData',
    ];

    /**
     * Get user gifts not connected
     *
     * @return null
     */
    public function testGetUserGiftsActionNotConnected()
    {
        $client = $this->getClient();

        $client->request('GET', 'user/gifts');
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        $this->assertJson($jsonResponse);
        $this->assertEquals('[]', $jsonResponse);
    }

    /**
     * Get user waiting for gifts when not connected
     *
     * @return null
     */
    public function testGetUserGiftsWaitingActionNotConnected()
    {
        $client = $this->getClient();

        $client->request('GET', 'user/gifts/waiting');
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        $this->assertJson($jsonResponse);
        $this->assertEquals('[]', $jsonResponse);
    }

    /**
     * Get user gifts action
     *
     * @return null
     */
    public function testGetUserGiftsAction()
    {
        $this->logIn();
        $client = $this->getClient();

        $client->request('GET', 'user/gifts');
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * Get users waiting for gifts action
     *
     * @return null
     */
    public function testGetUserWaitingGiftsAction()
    {
        $user   = $this->logIn();
        $client = $this->getClient();

        $userGift = new UserGift();
        $userGift->setSender($this->repos()->getUserRepository()->findOneById(2));
        $userGift->setReceiver($user);
        $userGift->setGift($this->repos()->getGiftRepository()->findOneById(1));
        $this->em()->persist($userGift);
        $this->em()->flush();

        $client->request('GET', 'user/gifts/waiting');
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * Send gift to a user not connected
     *
     * @return null
     */
    public function testUserSendGiftsActionNotConnected()
    {
        $client = $this->getClient();

        $client->request('POST', 'users/2/gifts/sends');
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        $this->assertJson($jsonResponse);
        $this->assertEquals('[]', $jsonResponse);
    }

    /**
     * Send gift to a non existing user
     *
     * @return null
     */
    public function testUserSendGiftsActionNotExisting()
    {
        $client = $this->getClient();

        $client->request('POST', 'users/111/gifts/sends');
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        $this->assertJson($jsonResponse);
    }

    /**
     * Send gift to a new user
     *
     * @return null
     */
    public function testUserSendGiftsAction()
    {
        $user   = $this->logIn();
        $client = $this->getClient();

        $newUser = new User();
        $newUser->setLogin('testUser');
        $newUser->setName('testUser');
        $newUser->setEmail('test@testUser.com');
        $newUser->setEncryptedPassword('nothing');

        $this->em()->persist($newUser);
        $this->em()->flush();

        // send to himself
        $client->request('POST', sprintf('/users/%d/gifts/sends', $user->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());

        // normal send
        $client->request('POST', sprintf('/users/%d/gifts/sends', $newUser->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Send it twice
        $client->request('POST', sprintf('/users/%d/gifts/sends', $newUser->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            '{"errors":"Gift has been already sent to this user today."}',
            $jsonResponse
        );
    }

    /**
     * Claim gift to a user not connected
     *
     * @return null
     */
    public function testClaimGiftsActionNotConnected()
    {
        $client = $this->getClient();

        $client->request('POST', 'gifts/1/claims');
        $jsonResponse = $client->getResponse()->getContent();
        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
        $this->assertJson($jsonResponse);
        $this->assertEquals('[]', $jsonResponse);
    }

    /**
     * Claim gift
     *
     * @return null
     */
    public function testClaimGiftsAction()
    {
        $user   = $this->logIn();
        $client = $this->getClient();

        $wrongGift = new UserGift();
        $wrongGift->setSender($this->repos()->getUserRepository()->findOneById(2));
        $wrongGift->setReceiver($this->repos()->getUserRepository()->findOneById(3));
        $wrongGift->setGift($this->repos()->getGiftRepository()->findOneById(1));
        $this->em()->persist($wrongGift);

        $userGift = new UserGift();
        $userGift->setSender($this->repos()->getUserRepository()->findOneById(2));
        $userGift->setReceiver($user);
        $userGift->setGift($this->repos()->getGiftRepository()->findOneById(1));
        $this->em()->persist($userGift);
        $this->em()->flush();

        // claim not his own
        $client->request('POST', sprintf('/gifts/%d/claims', $wrongGift->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());

        // normal claim
        $client->request('POST', sprintf('/gifts/%d/claims', $userGift->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Send it twice
        $client->request('POST', sprintf('/gifts/%d/claims', $userGift->getId()));
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
        $this->assertEquals(
            '{"errors":"Cannot claim this gift."}',
            $jsonResponse
        );
    }
}
