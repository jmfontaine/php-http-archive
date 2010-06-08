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

class PhpHttpArchiveTest extends PHPUnit_Framework_TestCase
{
    protected function _initializeVfsStream()
    {
        @include_once 'vfsStream/vfsStream.php';
        if (!class_exists('vfsStream', false)) {
            return false;
        }

        vfsStreamWrapper::register();
        return true;
    }

    /*
     * Autoloader
     */

    /**
     * @test
     * @runTestInSeparateProcess true
     * @covers PhpHttpArchive::registerAutoloader
     */
    public function registersAutoloader()
    {
        // Unregister existing autoloaders to avoid biased tests
        $autoloaders = spl_autoload_functions();
        foreach ($autoloaders as $autoloader) {
            spl_autoload_unregister($autoloader);
        }

        require_once 'PhpHttpArchive.php';
        PhpHttpArchive::registerAutoloader();
        $this->assertSame(
            array(
                array('PhpHttpArchive', 'autoload'),
            ),
            spl_autoload_functions()
        );
    }

    /**
     * @test
     * @covers PhpHttpArchive::autoload
     */
    public function autoloaderCanLoadAClass()
    {
        // Unregister existing autoloaders to avoid biased tests
        $autoloaders = spl_autoload_functions();
        foreach ($autoloaders as $autoloader) {
            spl_autoload_unregister($autoloader);
        }

        require_once 'PhpHttpArchive.php';
        PhpHttpArchive::registerAutoloader();

        $browser = new PhpHttpArchive_Browser();
        $this->assertSame('PhpHttpArchive_Browser', get_class($browser));
    }

    /*
     * Archive creation
     */

    /**
     * @test
     * @covers PhpHttpArchive::create
     */
    public function createsAnEmptyArchive()
    {
        $archive = PhpHttpArchive::create();
        $this->assertSame('PhpHttpArchive', get_class($archive));
    }

    /**
     * @test
     * @covers PhpHttpArchive::create
     */
    public function createsAnEmptyArchiveSpecifyingAVersionNumber()
    {
        $archive = PhpHttpArchive::create('1.2');
        $this->assertSame('PhpHttpArchive', get_class($archive));
        $this->assertSame('1.2', $archive->getVersion());
    }

    /*
     * Browser
     */

    /**
     * @test
     * @covers PhpHttpArchive::getBrowser
     * @covers PhpHttpArchive::setBrowser
     */
    public function handlesTheBrowserObject()
    {
        $browser = new PhpHttpArchive_Browser();
        $archive = PhpHttpArchive::create();
        $archive->setBrowser($browser);
        $this->assertSame($browser, $archive->getBrowser());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setBrowser
     * @expectedException PHPUnit_Framework_Error
     */
    public function settingTheBrowserObjectWithAnInvalidValidTriggersAnError()
    {
        $archive = PhpHttpArchive::create();
        $archive->setBrowser(new StdClass());
    }

    /**
     * @test
     * @covers PhpHttpArchive::getBrowser
     */
    public function retrievesTheBrowserObjectWithoutSettingItUpFirst()
    {
        // At first there is no browser object
        $archive = PhpHttpArchive::create();
        $this->assertAttributeEquals(null, '_browser', $archive);

        // We retrieve can a browser object whithout defining one first
        $browser = $archive->getBrowser();
        $this->assertSame('PhpHttpArchive_Browser', get_class($browser));
    }

    /**
     * @test
     * @covers PhpHttpArchive::getBrowser
     */
    public function alwaysRetrievesTheSameBrowserObject()
    {
        $archive  = PhpHttpArchive::create();
        $browser1 = $archive->getBrowser();
        $browser2 = $archive->getBrowser();
        $this->assertSame($browser1, $browser2);
    }

    /*
     * Creator
     */

    /**
     * @test
     * @covers PhpHttpArchive::setCreator
     * @covers PhpHttpArchive::getCreator
     */
    public function handlesTheCreatorObject()
    {
        $creator = new PhpHttpArchive_Creator();
        $archive = PhpHttpArchive::create();
        $archive->setCreator($creator);
        $this->assertSame($creator, $archive->getCreator());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setCreator
     * @expectedException PHPUnit_Framework_Error
     */
    public function settingTheCreatorObjectWithAnInvalidValidTriggersAnError()
    {
        $archive = PhpHttpArchive::create();
        $archive->setCreator(new StdClass());
    }

    /**
     * @test
     * @covers PhpHttpArchive::getCreator
     */
    public function retrievesCreatorObjectWithoutSettingItUpFirst()
    {
        // At first there is no browser object
        $archive = PhpHttpArchive::create();
        $this->assertAttributeEquals(null, '_creator', $archive);

        // We retrieve can a browser object whithout defining one first
        $creator = $archive->getCreator();
        $this->assertSame('PhpHttpArchive_Creator', get_class($creator));
    }

    /**
     * @test
     * @covers PhpHttpArchive::getCreator
     */
    public function alwaysRetrievesTheSameCreatorObject()
    {
        $archive  = PhpHttpArchive::create();
        $creator1 = $archive->getCreator();
        $creator2 = $archive->getCreator();
        $this->assertSame($creator1, $creator2);
    }

    /*
     * Entries
     */

    /**
     * @test
     * @covers PhpHttpArchive::setEntries
     * @covers PhpHttpArchive::getEntries
     */
    public function handlesTheEntriesObject()
    {
        $entries = new PhpHttpArchive_Entries();
        $archive = PhpHttpArchive::create();
        $archive->setEntries($entries);
        $this->assertSame($entries, $archive->getEntries());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setEntries
     * @expectedException PHPUnit_Framework_Error
     */
    public function settingTheEntriesObjectWithAnInvalidValidTriggersAnError()
    {
        $archive = PhpHttpArchive::create();
        $archive->setEntries(new StdClass());
    }

    /**
     * @test
     * @covers PhpHttpArchive::getEntries
     */
    public function retrievesEntriesObjectWithoutSettingItUpFirst()
    {
        // At first there is no browser object
        $archive = PhpHttpArchive::create();
        $this->assertAttributeEquals(null, '_entries', $archive);

        // We retrieve can a browser object whithout defining one first
        $entries = $archive->getEntries();
        $this->assertSame('PhpHttpArchive_Entries', get_class($entries));
    }

    /**
     * @test
     * @covers PhpHttpArchive::getEntries
     */
    public function alwaysRetrievesTheSameEntriesObject()
    {
        $archive  = PhpHttpArchive::create();
        $entries1 = $archive->getEntries();
        $entries2 = $archive->getEntries();
        $this->assertSame($entries1, $entries2);
    }

    /*
     * Pages
     */

    /**
     * @test
     * @covers PhpHttpArchive::setPages
     * @covers PhpHttpArchive::getPages
     */
    public function handlesThePagesObject()
    {
        $pages   = new PhpHttpArchive_Pages();
        $archive = PhpHttpArchive::create();
        $archive->setPages($pages);
        $this->assertSame($pages, $archive->getPages());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setPages
     * @expectedException PHPUnit_Framework_Error
     */
    public function settingThePagesObjectUsingAnInvalidValueTriggersAnError()
    {
        $archive = PhpHttpArchive::create();
        $archive->setPages(new StdClass());
    }

    /**
     * @test
     * @covers PhpHttpArchive::getPages
     */
    public function retrievesThePagesObjectWithoutSettingItUpFirst()
    {
        // At first there is no browser object
        $archive = PhpHttpArchive::create();
        $this->assertAttributeEquals(null, '_pages', $archive);

        // We retrieve can a browser object whithout defining one first
        $pages = $archive->getPages();
        $this->assertSame('PhpHttpArchive_Pages', get_class($pages));
    }

    /**
     * @test
     * @covers PhpHttpArchive::getPages
     */
    public function alwaysRetrievesTheSamePagesObject()
    {
        $archive = PhpHttpArchive::create();
        $pages1  = $archive->getPages();
        $pages2  = $archive->getPages();
        $this->assertSame($pages1, $pages2);
    }

    /*
     * Version
     */

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     * @covers PhpHttpArchive::getVersion
     */
    public function handlesVersion()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion('1.1');
        $this->assertSame('1.1', $archive->getVersion());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     * @expectedException InvalidArgumentException
     */
    public function settingVersionUsingInvalidTypeThrowsAnInvalidArgumentException()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion(1.1);
    }

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     * @expectedException InvalidArgumentException
     */
    public function settingVersionUsingInvalidFormatThrowsAnInvalidArgumentException()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion('v1.1');
    }

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     */
    public function versionCanBeSetToFutureMinorVersion()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion('1.2');
        $this->assertSame('1.2', $archive->getVersion());
    }

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     * @expectedException InvalidArgumentException
     */
    public function versionCanNotBeSetToFutureMajorVersion()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion('2.0');
    }

    /**
     * @test
     * @covers PhpHttpArchive::setVersion
     * @expectedException InvalidArgumentException
     */
    public function versionCanNotBeSetToPreviousMinorVersion()
    {
        $archive = PhpHttpArchive::create();
        $archive->setVersion('1.0');
    }

    /*
     * Loading data
     */

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromArray
     */
    public function loadsDataFromAnArray()
    {
        $data    = require FILES_PATH . '/array_valid.php';
        $archive = PhpHttpArchive::loadFromArray($data);
        $this->assertSame('Unit tests', $archive->getCreator()->getName());
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromArray
     * @expectedException InvalidArgumentException
     */
    public function loadingInvalidDataFromAnArrayThrowsAnInvalidArgumentException()
    {
        $data    = require FILES_PATH . '/array_invalid.php';
        $archive = PhpHttpArchive::loadFromArray($data);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromArray
     * @expectedException InvalidArgumentException
     */
    public function loadingDataFromAnArrayMissingCreatorInfosThrowsAnInvalidArgumentException()
    {
        $data = require FILES_PATH . '/array_valid.php';
        unset($data['log']['creator']);
        $archive = PhpHttpArchive::loadFromArray($data);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromArray
     * @expectedException InvalidArgumentException
     */
    public function loadingDataFromAnArrayMissingEntriesInfosThrowsAnInvalidArgumentException()
    {
        $data = require FILES_PATH . '/array_valid.php';
        unset($data['log']['entries']);
        $archive = PhpHttpArchive::loadFromArray($data);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromJson
     */
    public function loadsDataFromAJsonString()
    {
        $json    = file_get_contents(FILES_PATH . '/json_valid.js');
        $archive = PhpHttpArchive::loadFromJson($json);
        $this->assertSame('Unit tests', $archive->getCreator()->getName());
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::loadFromJson
     * @expectedException InvalidArgumentException
     */
    public function loadingDataFromABogusJsonStringThrowsAnInvalidArgumentException()
    {
        $json    = file_get_contents(FILES_PATH . '/json_bogus.js');
        $archive = PhpHttpArchive::loadFromJson($json);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromJson
     * @expectedException InvalidArgumentException
     */
    public function loadingInvalidDataFromAJsonStringThrowsAnInvalidArgumentException()
    {
        $json    = file_get_contents(FILES_PATH . '/json_invalid.js');
        $archive = PhpHttpArchive::loadFromJson($json);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromFile
     */
    public function loadsDataFromAFile()
    {
        $path    = FILES_PATH . '/archive_valid.har';
        $archive = PhpHttpArchive::loadFromFile($path);
        $this->assertSame('Unit tests', $archive->getCreator()->getName());
    }

    /**
     * @test
     * @covers PhpHttpArchive::loadFromFile
     * @expectedException InvalidArgumentException
     */
    public function loadingDataFromAnUnreadableFileThrowsAnInvalidArgumentException()
    {
        $path    = FILES_PATH . '/archive_missing.har';
        $archive = PhpHttpArchive::loadFromFile($path);
    }

    /**
     * @test
     * @covers PhpHttpArchive::loadFromFile
     * @expectedException InvalidArgumentException
     */
    public function loadingDataFromABogusFileThrowsAnInvalidArgumentException()
    {
        $path    = FILES_PATH . '/archive_bogus.har';
        $archive = PhpHttpArchive::loadFromFile($path);
    }

    /**
     * @test
     * @covers PhpHttpArchive::__construct
     * @covers PhpHttpArchive::_loadData
     * @covers PhpHttpArchive::loadFromFile
     * @expectedException InvalidArgumentException
     */
    public function loadingInvalidDataFromAFileThrowsAnInvalidArgumentException()
    {
        $path    = FILES_PATH . '/archive_invalid.har';
        $archive = PhpHttpArchive::loadFromFile($path);
    }

    /*
     * Saving data
     */

    /**
     * @test
     * @covers PhpHttpArchive::saveToFile
     */
    public function savesDataToAFile()
    {
        if (!$this->_initializeVfsStream()) {
            $this->markTestSkipped('vfsStream not installed');
        }

        $sourcePath    = FILES_PATH . '/archive_valid.har';
        $sourceArchive = PhpHttpArchive::loadFromFile($sourcePath);

        vfsStreamWrapper::setRoot(new vfsStreamDirectory('tmp'));
        $destinationPath = vfsStream::url('tmp') . '/archive.har';
        $sourceArchive->saveToFile($destinationPath);

        $sourceData      = file_get_contents($sourcePath);
        $destinationData = file_get_contents($destinationPath);
        $this->assertEquals($sourceData, $destinationData);
    }

    /**
     * @test
     * @covers PhpHttpArchive::loadFromFile
     * @expectedException Exception
     */
    public function savingToAUnwriteableFileThrowsAnException()
    {
        if (!$this->_initializeVfsStream()) {
            $this->markTestSkipped('vfsStream not installed');
        }

        $sourcePath = FILES_PATH . '/archive_valid.har';
        $archive    = PhpHttpArchive::loadFromFile($sourcePath);

        $destinationPath = vfsStream::url('missing/dir') . '/archive.har';
        $archive->saveToFile($destinationPath);
    }

    /**
     * @test
     * @covers PhpHttpArchive::_formatJson
     * @covers PhpHttpArchive::toJson
     */
    public function savesDataToAJsonString()
    {
        $path    = FILES_PATH . '/archive_valid.har';
        $archive = PhpHttpArchive::loadFromFile($path);
        $json    = file_get_contents(FILES_PATH . '/json_valid.js');
        $this->assertSame($json, $archive->toJson());
    }

    /**
     * @test
     * @covers PhpHttpArchive::toArray
     */
    public function savesDataToAnArray()
    {
        $data    = require FILES_PATH . '/array_valid.php';
        $archive = PhpHttpArchive::loadFromArray($data);
        $this->assertSame($data, $archive->toArray());
    }

    /*
     * Bugs
     */
}