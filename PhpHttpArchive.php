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

class PhpHttpArchive
{
    protected $_browser;
    protected $_creator;
    protected $_data;
    protected $_entries;
    protected $_pages;
    protected $_version = '1.1';

    protected function _parseData($data)
    {
        $data = $data['log'];

        $this->setVersion($data['version']);

        $this->_browser = new PhpHttpArchive_Browser($data['browser']);
        $this->_creator = new PhpHttpArchive_Creator($data['creator']);
        $this->_entries = new PhpHttpArchive_Entries($data['entries']);
        $this->_pages   = new PhpHttpArchive_Pages($data['pages']);
    }

    public function __construct($data)
    {
        $this->setData($data);
    }

    public function getBrowser()
    {
        return $this->_creator;
    }

    public function getCreator()
    {
        return $this->_creator;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function getEntries()
    {
        return $this->_entries;
    }

    public function getPages()
    {
        return $this->_pages;
    }

    public function getVersion()
    {
        return $this->_version;
    }

    public static function loadFromJson($data)
    {
        $data = json_decode($data, true);
        return new self($data);
    }

    public static function loadFromArray(array $data)
    {
        return new self($data);
    }

    public function loadFromFile($path)
    {
        $data = @file_get_contents($path);

        if (false === $data) {
            throw new InvalidArgumentException(
                "HTTP archive is not readable ($path)"
            );
        }

        return self::loadFromJson($data);
    }

    public function setData($data)
    {
        $this->_data = $data;
        $this->_parseData($data);
        return $this;
    }

    public function setVersion($version)
    {
        $this->_version = (string) $version;
        return $this;
    }
}