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

class PhpHttpArchive_Entry_Cache extends PhpHttpArchive_Element_Abstract
{
    protected $_afterRequest;
    protected $_beforeRequest;

    protected function _loadData(array $data)
    {
        $this->setAfterRequest($data['afterRequest']);
        $this->setBeforeRequest($data['beforeRequest']);
    }

    public function getAfterRequest()
    {
        if (null === $this->_afterRequest) {
            $this->_afterRequest = new PhpHttpArchive_Entry_Cache_State();
        }
        return $this->_afterRequest;
    }

    public function getBeforeRequest()
    {
        if (null === $this->_beforeRequest) {
            $this->_beforeRequest = new PhpHttpArchive_Entry_Cache_State();
        }
        return $this->_beforeRequest;
    }

    public function setAfterRequest(PhpHttpArchive_Entry_Cache_State $state)
    {
        $this->_afterRequest = $state;
        return $this;
    }

    public function setBeforeRequest(PhpHttpArchive_Entry_Cache_State $state)
    {
        $this->_beforeRequest = $state;
        return $this;
    }

    public function toArray()
    {
        return array(
            'beforeRequest' => $this->getBeforeRequest()->toArray(),
            'afterRequest'  => $this->getAfterRequest()->toArray(),
        );
    }
}