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

class PhpHttpArchive_Entry_Cache_State extends PhpHttpArchive_Element_Abstract
{
    protected $_eTag;
    protected $_expires;
    protected $_hitCount;
    protected $_lastAccess;

    protected function _loadData(array $data)
    {
        $this->setETag($data['eTag']);

        if (!empty($data['expires'])) {
            $this->setExpires($data['expires']);
        }

        $this->setLastAccess($data['lastAccess']);
        $this->setHitCount($data['hitCount']);
    }

    public function getETag()
    {
        return $this->_eTag;
    }

    public function getExpires($format = null)
    {
        if (null === $format) {
            $format = DateTime::ISO8601;
        }
        return $this->_expires->format($format);
    }

    public function getHitCount()
    {
        return $this->_hitCount;
    }

    public function getLastAccess($format = null)
    {
        if (null === $format) {
            $format = DateTime::ISO8601;
        }
        return $this->_lastAccess->format($format);
    }

    public function setETag($eTag)
    {
        $this->_eTag = $eTag;
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

    public function setHitCount($hitCount)
    {
        $this->_hitCount = (int) $hitCount;
        return $this;
    }

    public function setLastAccess($lastAccess)
    {
        $dateTime = DateTime::createFromFormat(
            DateTime::ISO8601,
            $lastAccess
        );
        if (false === $dateTime) {
            throw new InvalidArgumentException(
                "Provided \"lastAccess\" ($lastAccess) value is not a
                 valid ISO 8601 value"
            );
        }

        $this->_lastAccess = $dateTime;
        return $this;
    }

    public function toArray()
    {
        return array(
            'expires'    => $this->getExpires(),
            'lastAccess' => $this->getLastAccess(),
            'eTag'       => $this->getETag(),
            'hitCount'   => $this->getHitCount(),
        );
    }
}