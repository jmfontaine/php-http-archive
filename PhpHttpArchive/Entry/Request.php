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

class PhpHttpArchive_Entry_Request extends PhpHttpArchive_Element_Abstract
{
    protected $_bodySize = -1;
    protected $_cookies;
    protected $_headers;
    protected $_headersSize = -1;
    protected $_httpVersion;
    protected $_method;
    protected $_postData;
    protected $_queryString;
    protected $_url;

    protected function _loadData(array $data)
    {
        $this->setCookies($data['cookies']);
        $this->setHeaders($data['headers']);
        $this->setHttpVersion($data['httpVersion']);
        $this->setMethod($data['method']);

        if (!empty($data['postData'])) {
            $this->setPostData($data['postData']);
        }

        $this->setQueryString($data['queryString']);
        $this->setUrl($data['url']);
    }

    public function getBodySize()
    {
        return $this->_bodySize;
    }

    public function getCookies()
    {
        if (null === $this->_cookies) {
            $this->_cookies = new PhpHttpArchive_Entry_Cookies();
        }
        return $this->_cookies;
    }

    public function getHeaders()
    {
        if (null === $this->_headers) {
            $this->_headers = new PhpHttpArchive_Entry_Headers();
        }
        return $this->_headers;
    }

    public function getHeadersSize()
    {
        return $this->_headersSize;
    }

    public function getHttpVersion()
    {
        return $this->_httpVersion;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function getPostData()
    {
        if (null === $this->_postData) {
            $this->_postData = new PhpHttpArchive_Entry_Request_PostData();
        }
        return $this->_postData;
    }

    public function getQueryString()
    {
        if (null === $this->_queryString) {
            $queryString = new PhpHttpArchive_Entry_Request_QueryString();
            $this->_queryString = $queryString;
        }
        return $this->_queryString;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setBodySize($bodySize)
    {
        $this->_bodySize = (int) $bodySize;
        return $this;
    }

    public function setCookies(PhpHttpArchive_Entry_Cookies $cookies)
    {
        $this->_cookies = $cookies;
        return $this;
    }

    public function setHeaders(PhpHttpArchive_Entry_Headers $headers)
    {
        $this->_headers = $headers;
        return $this;
    }

    public function setHeadersSize($headersSize)
    {
        $this->_headersSize = (int) $headersSize;
        return $this;
    }

    public function setHttpVersion($version)
    {
        $this->_httpVersion = (string) $version;
        return $this;
    }

    public function setMethod($method)
    {
        $this->_method = (string) $method;
        return $this;
    }

    public function setPostData(PhpHttpArchive_Entry_Request_PostData
        $postData)
    {
        $this->_postData = $postData;
        return $this;
    }

    public function setQueryString(PhpHttpArchive_Entry_Request_QueryString
        $queryString)
    {
        $this->_queryString = $queryString;
        return $this;
    }

    public function setUrl($url)
    {
        $this->_url = (string) $url;
        return $this;
    }

    public function toArray()
    {
        return array(
            'method'      => $this->getMethod(),
            'url'         => $this->getUrl(),
            'httpVersion' => $this->getHttpVersion(),
            'cookies'     => $this->getCookies()->toArray(),
            'headers'     => $this->getHeaders()->toArray(),
            'queryString' => $this->getQueryString()->toArray(),
            'postData'    => $this->getPostData()->toArray(),
            'headersSize' => $this->getHeadersSize(),
            'bodySize'    => $this->getBodySize(),
        );
    }
}