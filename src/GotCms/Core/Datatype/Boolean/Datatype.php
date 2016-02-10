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
 * @category   GotCms\Core
 * @package    Datatype
 * @subpackage Boolean
 * @author     Pierre Rambaud (GoT) <pierre.rambaud86@gmail.com>
 * @license    GNU/LGPL http://www.gnu.org/licenses/lgpl-3.0.html
 * @link       http://www.got-cms.com
 */

namespace GotCms\Core\Datatype\Boolean;

use GotCms\Core\Datatype\Datatype as AbstractDatatype;
use GotCms\Core\Entity\Property;

/**
 * Manage Boolean datatype
 *
 * @category   GotCms\Core
 * @package    Datatype
 * @subpackage Boolean
 */
class Datatype extends AbstractDatatype
{
    /**
     * Datatype name
     *
     * @var string
     */
    protected $name = 'boolean';

    /**
     * Retrieve editor
     *
     * @param Property $property Property
     *
     * @return Editor
     */
    public function getEditor(Property $property)
    {
        $this->setProperty($property);
        if ($this->editor === null) {
            $this->editor = new Editor($this);
        }

        return $this->editor;
    }

    /**
     * Retrieve prevalue editor
     *
     * @return \GotCms\Core\Datatype\AbstractDatatype\AbstractPrevalueEditor
     */
    public function getPrevalueEditor()
    {
        if ($this->prevalueEditor === null) {
            $this->prevalueEditor = new PrevalueEditor($this);
        }

        return $this->prevalueEditor;
    }
}
