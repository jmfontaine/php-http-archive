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

class PhpHttpArchive_Entry_Timings extends PhpHttpArchive_Element_Abstract
{
    protected $_blocked;
    protected $_connect;
    protected $_dns;
    protected $_receive;
    protected $_send;
    protected $_wait;

    protected function _loadData(array $data)
    {
        if (!empty($data['blocked'])) {
            $this->setBlocked($data['blocked']);
        }

        if (!empty($data['connect'])) {
            $this->setConnect($data['connect']);
        }

        if (!empty($data['dns'])) {
            $this->setDns($data['dns']);
        }

        $this->setReceive($data['receive']);
        $this->setSend($data['send']);
        $this->setWait($data['wait']);
    }

    public function getBlocked()
    {
        return $this->_blocked;
    }

    public function getConnect()
    {
        return $this->_connect;
    }

    public function getDns()
    {
        return $this->_dns;
    }

    public function getReceive()
    {
        return $this->_receive;
    }

    public function getSend()
    {
        return $this->_send;
    }

    public function getWait()
    {
        return $this->_wait;
    }
}