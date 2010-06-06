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
 * @package Tests
 * @author Jean-Marc Fontaine <jm@jmfontaine.net>
 * @copyright 2010 Jean-Marc Fontaine <jm@jmfontaine.net>
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

class PhpHttpArchive_BrowserTest extends PHPUnit_Framework_TestCase
{
    /*
     * Methods
     */

   /**
     * @test
     * @covers PhpHttpArchive_Browser::_loadData
     */
    public function loadsDataAtInstantiation()
    {
        $data = array(
            'name'    => 'Dummy browser',
            'version' => '3.0',
        );

        $browser = new PhpHttpArchive_Browser($data);
        $this->assertSame($data, $browser->toArray());
    }

    /**
     * @test
     * @covers PhpHttpArchive_Browser::setName
     * @covers PhpHttpArchive_Browser::getName
     */
    public function handlesName()
    {
        $browser = new PhpHttpArchive_Browser();
        $browser->setName('Dummy browser');
        $this->assertSame('Dummy browser', $browser->getName());
    }

   /**
     * @test
     * @covers PhpHttpArchive_Browser::setVersion
     * @covers PhpHttpArchive_Browser::getVersion
     */
    public function handlesVersion()
    {
        $browser = new PhpHttpArchive_Browser();
        $browser->setVersion('3.0');
        $this->assertSame('3.0', $browser->getVersion());
    }

   /**
     * @test
     * @covers PhpHttpArchive_Browser::toArray
     */
    public function providesDataAsAnArray()
    {
        $browser = new PhpHttpArchive_Browser();
        $browser->setName('Dummy browser');
        $browser->setVersion('3.0');

        $expectedData = array(
            'name'    => 'Dummy browser',
            'version' => '3.0',
        );
        $this->assertSame($expectedData, $browser->toArray());
    }

   /**
     * @test
     * @covers PhpHttpArchive_Browser::toArray
     */
    public function providesDataAsAnEmptyArrayIfThereIsNoData()
    {
        $browser = new PhpHttpArchive_Browser();
        $this->assertSame(array(), $browser->toArray());
    }

    /*
     * Bugs
     */
}