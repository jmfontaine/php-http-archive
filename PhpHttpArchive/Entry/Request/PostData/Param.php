<?php
/**
 * Copyright (c) 2010, Jean-Marc Fontaine
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the <organization> nor the
 *       names of its contributors may be used to endorse or promote products
 *       derived from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @package PHP HTTP Archive
 * @author Jean-Marc Fontaine <jm@jmfontaine.net>
 * @copyright 2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

class PhpHttpArchive_Entry_Request_PostData_Param
    extends PhpHttpArchive_Element_Abstract
{
    protected $_contentType;
    protected $_fileName;
    protected $_name;
    protected $_value;

    protected function _loadData(array $data)
    {
        $this->setName($data['name']);

        if (!empty($data['value'])) {
            $this->setValue($data['value']);
        }
    }

    public function getContentType()
    {
        return $this->_contentType;
    }

    public function getFileName()
    {
        return $this->_fileName;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setContentType($contentType)
    {
        $this->_contentType = (string) $contentType;
        return $this;
    }

    public function setFileName($fileName)
    {
        $this->_fileName = (string) $fileName;
        return $this;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function setValue($value)
    {
        $this->_value = (string) $value;
        return $this;
    }

    public function toArray()
    {
        return array(
            'name'        => $this->getName(),
            'value'       => $this->getValue(),
            'fileName'    => $this->getFileName(),
            'contentType' => $this->getContentType(),
        );
    }
}