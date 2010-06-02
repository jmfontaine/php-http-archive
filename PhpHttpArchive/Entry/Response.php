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

class PhpHttpArchive_Entry_Response extends PhpHttpArchive_Element_Abstract
{
    protected $_bodySize = -1;
    protected $_content;
    protected $_cookies;
    protected $_headers;
    protected $_headersSize = -1;
    protected $_httpVersion;
    protected $_redirectUrl;
    protected $_status;
    protected $_statusText;

    protected function _loadData(array $data)
    {
        $this->setBodySize($data['bodySize']);
        $this->setCookies($data['cookies']);
        $this->setHeaders($data['headers']);
        $this->setHeadersSize($data['headersSize']);
        $this->setHttpVersion($data['httpVersion']);
        $this->setRedirectUrl($data['redirectURL']);
        $this->setStatus($data['status']);
        $this->setStatusText($data['statusText']);
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

    public function getContent()
    {
        if (null === $this->_content) {
            $this->_content = new PhpHttpArchive_Entry_Response_Content();
        }
        return $this->_content;
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

    public function getRedirectUrl()
    {
        return $this->_redirectUrl;
    }

    public function getStatus()
    {
        return $this->_status;
    }

    public function getStatusText()
    {
        return $this->_statusText;
    }

    public function setCookies(PhpHttpArchive_Entry_Cookies $cookies)
    {
        $this->_cookies = $cookies;
        return $this;
    }

    public function setContent(PhpHttpArchive_Entry_Response_Content $content)
    {
        $this->_content = $content;
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

    public function setRedirectUrl($redirectUrl)
    {
        $this->_redirectUrl = (string) $redirectUrl;
        return $this;
    }

    public function setStatus($status)
    {
        $this->_status = (string) $status;
        return $this;
    }

    public function setStatusText($statusText)
    {
        $this->_statusText = (string) $statusText;
        return $this;
    }

    public function toArray()
    {
        return array(
            'status'      => $this->getStatus(),
            'statusText'  => $this->getStatusText(),
            'httpVersion' => $this->getHttpVersion(),
            'cookies'     => $this->getCookies()->toArray(),
            'headers'     => $this->getHeaders()->toArray(),
            'content'     => $this->getContent()->toArray(),
            'redirectUrl' => $this->getRedirectUrl(),
            'headersSize' => $this->getHeadersSize(),
            'bodySize'    => $this->getBodySize(),
        );
    }
}