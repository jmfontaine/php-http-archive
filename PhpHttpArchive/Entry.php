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

class PhpHttpArchive_Entry extends PhpHttpArchive_Element_Abstract
{
    protected $_pageRef;
    protected $_request;
    protected $_startedDateTime;
    protected $_time;

    protected function _loadData(array $data)
    {
        $this->setPageRef($data['pageRef']);
        $this->setRequest($data['request']);
        $this->setStartedDateTime($data['startedDateTime']);
        $this->setTime($data['time']);
    }

    public function getPageRef()
    {
        return $this->_pageRef;
    }

    public function getRequest()
    {
        if (null === $this->_request) {
            $this->_request = new PhpHttpArchive_Entry_Request();
        }
        return $this->_request;
    }

    public function getStartedDateTime($format = null)
    {
        if (null === $format) {
            $format = DateTime::ISO8601;
        }
        return $this->_startedDateTime->format($format);
    }

    public function getTime()
    {
        return $this->_time;
    }

    public function setPageRef($pageRef)
    {
        $this->_pageRef = (string) $pageRef;
        return $this;
    }

    public function setRequest(PhpHttpArchive_Entry_Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    public function setStartedDateTime($startedDateTime)
    {
        $dateTime = DateTime::createFromFormat(
            DateTime::ISO8601,
            $startedDateTime
        );
        if (false === $dateTime) {
            throw new InvalidArgumentException(
                "Provided \"startedDateTime\" ($startedDateTime) value is not a
                 valid ISO 8601 value"
            );
        }

        $this->_startedDateTime = $dateTime;
        return $this;
    }

    public function setTime($time)
    {
        $this->_time = (int) $time;
        return $this;
    }
}