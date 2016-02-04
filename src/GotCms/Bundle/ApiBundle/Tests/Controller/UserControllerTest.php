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

/**
 * User controller tests
 *
 * @package Game\RestBundle\Tests
 */
class UserControllerTest extends BaseTestCase
{
    protected $fixtures = ['Game\RestBundle\DataFixtures\ORM\LoadUserData'];

    /**
     * Get action must not return users if not connected
     *
     * @return null
     */
    public function testGetActionReturnsNoUsers()
    {
        $client = $this->getClient();

        $client->request('GET', 'users');
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals('[]', $jsonResponse);
    }

    /**
     * Get action must return all users
     *
     * @return null
     */
    public function testGetActionReturnsAllUsers()
    {
        $connectedUser = $this->logIn();
        $client        = $this->getClient();
        $qb            = $this->repos()
            ->getUserRepository()
            ->createQueryBuilder('u')
            ->where('u != :user')
            ->setParameter('user', $connectedUser);

        $users = $qb->getQuery()->getResult();

        foreach ($users as $idx => $user) {
            $user->sanitize();
        }

        $jsonData = $this->serialize($users, 'json');

        $client->request('GET', 'users');
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals($jsonData, $jsonResponse);
    }

    /**
     * Post action must create new user
     *
     * @return null
     */
    public function testPostActionCreatesNewEntity()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'users',
            [
                'login' => 'testUser',
                'name' => 'testUser',
                'email' => 'test@test.com',
                'password' => 'something'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $this->assertEquals('{"id":11}', $jsonResponse);

        $user = $this->repos()
            ->getUserRepository()
            ->find(11);

        $this->assertEquals('testUser', $user->getLogin());
    }

    /**
     * Post action must return errors
     *
     * @return null
     */
    public function testPostActionWithErrors()
    {
        $client = $this->getClient();
        $client->request(
            'POST',
            'users',
            [
                'login' => 'te',
                'name' => 'tes',
                'email' => 'tes',
                'password' => 'something'
            ]
        );
        $jsonResponse = $client->getResponse()->getContent();

        $this->assertJson($jsonResponse);
        $errors = [
            'errors' => [
                'form' => [
                    'children' => [
                        'login' => [
                            'errors' => ['This value is too short. It should have 4 characters or more.'],
                        ],
                        'name' => [
                            'errors' => ['This value is too short. It should have 4 characters or more.']
                        ],
                        'email' => [
                            'errors' => ['This value is not a valid email address.']
                        ],
                        'password' => [],
                    ],
                ],
                'errors' => []
            ]
        ];

        $this->assertEquals($errors, json_decode($jsonResponse, true));
    }
}
