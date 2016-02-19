<?php
/**
 * This source file is part of GotCms.
 *
 * GotCms is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * GotCms is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License along
 * with GotCms. If not, see <http://www.gnu.org/licenses/lgpl-3.0.html>.
 *
 * PHP version >= 5.5
 *
 * @category GotCms\Core
 * @package  GotCms\Core
 * @author   Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license  GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link     http://www.got-cms.com
 */
namespace GotCms\Core;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Client;

/**
 * Class to store and retrieve version
 *
 * @category GotCms\Core
 * @package  GotCms\Core
 */
final class Version
{
    /**
     * GotCms version identification - see compareVersion()
     */
    const VERSION = '2.0.0.a';

    /**
     * The latest stable version GotCms available
     *
     * @var string
     */
    protected static $latestVersion;

    /**
     * Compare the specified GotCms version string $version
     * with the current GotCms\Version::VERSION of GotCms.
     *
     * @param string $version A version string (e.g. "0.7.1").
     *
     * @return int -1 if the $version is older,
     *             0 if they are the same,
     *             and +1 if $version is newer.
     *
     */
    public static function compareVersion($version)
    {
        return version_compare($version, strtolower(self::VERSION));
    }

    /**
     * Fetches the version of the latest stable release.
     *
     * @return string
     */
    public static function getLatest()
    {
        if (null === self::$latestVersion) {
            self::$latestVersion = 'not available';
            $url                 = 'https://api.github.com/repos/GotCms/GotCms/git/refs/tags';
            try {
                $client   = new Client();
                $response = $client->request(
                    'GET',
                    $url,
                    ['verify' => false]
                );

                if ($response->getStatusCode() == Response::HTTP_OK) {
                    $content = $response->getBody();
                }
            } catch (\Exception $e) {
                //Don't care
            }

            //Try to retrieve with file_get_contents
            if (empty($content)) {
                $content = @file_get_contents($url);
            }

            if (!empty($content)) {
                $apiResponse = json_decode($content, true);

                // Simplify the API response into a simple array of version numbers
                $tags = array_map(
                    function ($tag) {
                        return substr($tag['ref'], 10); // Reliable because we're filtering on 'refs/tags/'
                    },
                    $apiResponse
                );

                // Fetch the latest version number from the array
                self::$latestVersion = array_reduce(
                    $tags,
                    function ($a, $b) {
                        return version_compare($a, $b, '>') ? $a : $b;
                    }
                );
            }
        }

        return self::$latestVersion;
    }

    /**
     * Returns true if the running version of GotCms is
     * the latest (or newer??) than the latest tag on GitHub,
     * which is returned by static::getLatest().
     *
     * @return boolean
     */
    public static function isLatest()
    {
        return static::compareVersion(static::getLatest()) < 1;
    }
}
