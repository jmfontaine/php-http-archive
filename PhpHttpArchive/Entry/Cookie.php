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

class PhpHttpArchive_Entry_Cookie extends PhpHttpArchive_Element_Abstract
{
    protected $_domain;
    protected $_expires;
    protected $_httpOnly;
    protected $_name;
    protected $_path;
    protected $_value;

    protected function _loadData(array $data)
    {
        if (!empty($data['domain'])) {
            $this->setDomain($data['domain']);
        }

        if (empty($data['name'])) {
            throw new InvalidArgumentException('Cookie name is missing');
        }
        $this->setName($data['name']);

        if (!empty($data['domain'])) {
            $this->setPath($data['path']);
        }

        if (!empty($data['expires'])) {
            $this->setPath($data['expires']);
        }

        if (!empty($data['httpOnly'])) {
            $this->setHttpOnly($data['httpOnly']);
        }

        if (empty($data['value'])) {
            throw new InvalidArgumentException('Cookie value is missing');
        }
        $this->setValue($data['value']);
    }

    public function getDomain()
    {
        return $this->_domain;
    }

    public function getExpires($format = null)
    {
        if (null === $this->_expires) {
            $value = null;
        } else {
            if (null === $format) {
                $format = DateTime::ISO8601;
            }
            $value = $this->_expires->format($format);
        }

        return $value;
    }

    public function getHttpOnly()
    {
        return $this->_httpOnly;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function getValue()
    {
        return $this->_value;
    }

    public function setDomain($domain)
    {
        $this->_domain = (string) $domain;
        return $this;
    }

    public function setExpires($expires)
    {
        $dateTime = DateTime::createFromFormat(
            DateTime::ISO8601,
            $expires
        );
        if (false === $dateTime) {
            throw new InvalidArgumentException(
                "Provided \"expires\" ($expires) value is not a
                 valid ISO 8601 value"
            );
        }

        $this->_expires = $dateTime;
        return $this;
    }

    public function setHttpOnly($httpOnly)
    {
        $this->_httpOnly = (bool) $httpOnly;
        return $this;
    }

    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    public function setPath($path)
    {
        $this->_path = (string) $path;
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
            'name'     => $this->getName(),
            'value'    => $this->getValue(),
            'path'     => $this->getPath(),
            'domain'   => $this->getDomain(),
            'expires'  => $this->getExpires(),
            'httpOnly' => $this->getHttpOnly(),
        );
    }
}