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
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Content
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */
namespace GotCms\Bundle\ApiBundle\Controller\Content;

use GotCms\Core\Mvc\Controller\BaseRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcherInterface;

/**
 * Translation Controller
 *
 * @category   GotCms\Bundle
 * @package    ApiBundle
 * @subpackage Controller\Content
 */
class TranslationController extends BaseRestController
{
    /**
     * List all users that can receive gifts
     *
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getTranslationsAction(ParamFetcherInterface $paramFetcher)
    {

        $translator   = new Translator();
        $translations = $translator->getValues();
        $data         = array();

        foreach ($translations as $translation) {
            if (empty($data[$translation['src_id']])) {
                $data[$translation['src_id']] = array(
                    'source' => $translation['source'],
                    'id' => $translation['src_id'],
                    'destinations' => array()

                );
            }

            $data[$translation['src_id']]['destinations'][] = array(
                'id' => $translation['dst_id'],
                'value' => $translation['destination'],
                'locale' => $translation['locale'],
            );
        }

        return array('translations' => $data);
    }

    /**
     * Create new translations
     *
     * @param Request $request Http request object
     *
     * @return array
     */
    public function postTranslationAction(Request $request)
    {
        $translationFilter = new TranslationFilter();
        $translationFilter->setData($data);
        if ($translationFilter->isValid()) {
            $source = $translationFilter->getValue('source');
            $data   = array();
            foreach ($translationFilter->getValue('destination') as $destinationId => $destination) {
                if (empty($destination)) {
                    continue;
                }

                $data[$destinationId] = array('value' => $destination);
            }

            foreach ($translationFilter->getValue('locale') as $localeId => $locale) {
                if (empty($data[$localeId])) {
                    continue;
                }

                if (empty($locale)) {
                    unset($data[$localeId]);
                    continue;
                }

                $data[$localeId]['locale'] = $locale;
            }

            $translator = new Translator();
            return array('translation' => $translator->setValue($source, $data));
        }

        return array('content' => 'Invalid data', 'errors' => $translationFilter->getMessages());
    }

    /**
     * Create new user
     *
     * @param Request $request Http request object
     *
     * @return array
     */
    public function patchTranslations(Request $request)
    {
        $translationFilter = new TranslationFilter();
        $translationFilter->get('locale')->setRequired(false);
        $translationFilter->setData($data);
        if ($translationFilter->isValid()) {
            $translator   = new Translator();
            $sources      = $translationFilter->getValue('source');
            $destinations = $translationFilter->getValue('destination');
            $return       = array();
            foreach ($sources as $sourceId => $source) {
                $translator->update(array('source' => $source), sprintf('id = %d', $sourceId));
                if (!empty($destinations[$sourceId]) and !empty($destinations[$sourceId]['locale'])) {
                    $return[] = $translator->setValue($sourceId, array($destinations[$sourceId]));
                }
            }

            return array('translations' => $return);
        }

        return array('content' => 'Invalid data', 'errors' => $translationFilter->getMessages());
    }
}
