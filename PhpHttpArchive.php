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

/**
 * Main class for manipulating HTTP Archive files.
 */
class PhpHttpArchive
{
    const VERSION = '0.1';

    /**
     * Name and version info of used browser.
     *
     * @var PhpHttpArchive_Browser
     */
    protected $_browser;

    /**
     * Name and version info of the log creator application.
     *
     * @var PhpHttpArchive_Creator
     */
    protected $_creator;

    /**
     * List of all exported requests.
     *
     * @var PhpHttpArchive_Entries
     */
    protected $_entries;

    /**
     * List of all exported pages. This field is missing if the application
     * does not support grouping by pages.
     *
     * @var PhpHttpArchive_Pages
     */
    protected $_pages;

    /**
     * Version number of the format. If not specified, "1.1" is assumed.
     *
     * @var string
     */
    protected $_version = '1.1';

    protected function _loadData(array $data)
    {
        if (!array_key_exists('log', $data)) {
            throw new InvalidArgumentException(
                'Invalid data: missing "log" element'
            );
        }
        $data = $data['log'];

        if (array_key_exists('version', $data)) {
            $this->setVersion($data['version']);
        }

        if (array_key_exists('browser', $data)) {
            $this->_browser = new PhpHttpArchive_Browser($data['browser']);
        }

        if (!array_key_exists('creator', $data)) {
            throw new InvalidArgumentException('Missing "creator" data');
        }
        $this->_creator = new PhpHttpArchive_Creator($data['creator']);

        if (!array_key_exists('entries', $data)) {
            throw new InvalidArgumentException('Missing "entries" data');
        }
        $this->_entries = new PhpHttpArchive_Entries($data['entries']);

        if (array_key_exists('pages', $data)) {
            $this->_pages = new PhpHttpArchive_Pages($data['pages']);
        }
    }

    protected function __construct(array $data = null, $version = null)
    {
        if (null !== $version) {
            $this->setVersion($version);
        }

        if (null !== $data) {
            $this->_loadData($data);
        }
    }

    /**
     * Formats JSON data.
     *
     * Borrowed from Zend Framework's Zend_JSON::prettyPrint() method and
     * slightly edited.
     *
     * @see http://framework.zend.com/apidoc/1.10/Zend_Json/Zend_Json.html#prettyPrint
     * @param string $json JSON data to format
     */
    protected function _formatJson($json)
    {
        $tokens = preg_split(
            '|([\{\}\]\[,])|',
            $json,
            -1,
            PREG_SPLIT_DELIM_CAPTURE
        );
        $result       = '';
        $indentLevel  = 0;
        $indentString = '    ';

        foreach($tokens as $token) {
            if ('' == $token) {
                continue;
            }

            $prefix = str_repeat($indentString, $indentLevel);
            if($token == '{' || $token == '[') {
                $indentLevel++;
                if($result != '' && $result[strlen($result)-1] == "\n") {
                    $result .= $prefix;
                }
                $result .= "$token\n";
            } else if($token == '}' || $token == ']') {
                $indentLevel--;
                $prefix = str_repeat($indentString, $indentLevel);
                $result .= "\n$prefix$token";
            } else if($token == ',') {
                $result .= "$token\n";
            } else {
                $result .= $prefix . $token;
            }
        }
        return $result;
    }

    public static function create($version = null)
    {
        return new self(null, $version);
    }

    public function getBrowser()
    {
        if (null === $this->_browser) {
            $this->_browser = new PhpHttpArchive_Browser();
        }
        return $this->_browser;
    }

    public function getCreator()
    {
        if (null === $this->_creator) {
            $this->_creator = new PhpHttpArchive_Creator();
        }
        return $this->_creator;
    }

    public function getEntries()
    {
        if (null === $this->_entries) {
            $this->_entries = new PhpHttpArchive_Entries();
        }
        return $this->_entries;
    }

    public function getPages()
    {
        if (null === $this->_pages) {
            $this->_pages = new PhpHttpArchive_Pages();
        }
        return $this->_pages;
    }

    public function getVersion()
    {
        return $this->_version;
    }

    public static function loadFromArray(array $data)
    {
        return new self($data);
    }

    public static function loadFromJson($json)
    {
        $data = json_decode($json, true);
        if (null === $data) {
            throw new InvalidArgumentException(
                'Provided date could not be parsed as valid JSON'
            );
        }
        return self::loadFromArray($data);
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

    public function saveToFile($path)
    {
        $result = @file_put_contents($path, $this->toJson());
        if (false === $result) {
            throw new Exception(
                "HTTP archive is not writeable ($path)"
            );
        }
        return true;
    }

    public function setBrowser(PhpHttpArchive_Browser $browser)
    {
        $this->_browser = $browser;
        return $this;
    }

    public function setCreator(PhpHttpArchive_Creator $creator)
    {
        $this->_creator = $creator;
        return $this;
    }

    public function setEntries(PhpHttpArchive_Entries $entries)
    {
        $this->_entries = $entries;
        return $this;
    }

    public function setPages(PhpHttpArchive_Pages $pages)
    {
        $this->_pages = $pages;
        return $this;
    }

    public function setVersion($version)
    {
        // Check type
        if (!is_string($version)) {
            throw new InvalidArgumentException(
                'Version number must be a string'
            );
        }

        // Check format
        if (!preg_match('/^(\d*)\.(\d*)$/', $version, $matches)) {
            throw new InvalidArgumentException('Invalid version number');
        }

        // Check compatibility
        if (1 != $matches[1] || 1 > $matches[2]) {
            throw new InvalidArgumentException("This library does not support
                this version ($version) of the HTTP Archive specification");
        }

        $this->_version = $version;
        return $this;
    }

    public function toJson()
    {
        $json = json_encode($this->toArray());
        return $this->_formatJson($json);
    }

    public function toArray()
    {
        $result = array(
            'log' => array(
                'version' => $this->getVersion(),
                'creator' => $this->getCreator()->toArray(),
                'entries' => $this->getEntries()->toArray(),
            )
        );

        $browserData = $this->getBrowser()->toArray();
        if (!empty($browserData)) {
            $result['browser'] = $browserData;
        }
        $pagesData = $this->getPages()->toArray();
        if (!empty($pagesData)) {
            $result['pages'] = $pagesData;
        }

        return $result;
    }
}