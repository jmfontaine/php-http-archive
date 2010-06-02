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

class PhpHttpArchive_Page extends PhpHttpArchive_Element_Abstract
{
    protected $_id;
    protected $_pageTimings;
    protected $_startedDateTime;
    protected $_title;

    protected function _loadData(array $data)
    {
        $this->setId($data['id']);
        $this->setPageTimings($data['pageTimings']);
        $this->setStartedDateTime($data['startedDateTime']);
        $this->setTitle($data['title']);
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getPageTimings()
    {
        if (null === $this->_pageTimings) {
            $this->_pageTimings = new PhpHttpArchive_Page_Timings();
        }
        return $this->_pageTimings;
    }

    public function getStartedDateTime($format = null)
    {
        if (null === $format) {
            $format = DateTime::ISO8601;
        }
        return $this->_startedDateTime->format($format);
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setId($id)
    {
        $this->_id = (string) $id;
        return $this;
    }

    public function setPageTimings(PhpHttpArchive_Page_Timings $pageTimings)
    {
        $this->_pageTimings = $pageTimings;
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

    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
}