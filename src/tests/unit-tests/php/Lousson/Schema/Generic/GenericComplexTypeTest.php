<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 textwidth=75: *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Copyright (c) 2013, The Lousson Project                               *
 *                                                                       *
 * All rights reserved.                                                  *
 *                                                                       *
 * Redistribution and use in source and binary forms, with or without    *
 * modification, are permitted provided that the following conditions    *
 * are met:                                                              *
 *                                                                       *
 * 1) Redistributions of source code must retain the above copyright     *
 *    notice, this list of conditions and the following disclaimer.      *
 * 2) Redistributions in binary form must reproduce the above copyright  *
 *    notice, this list of conditions and the following disclaimer in    *
 *    the documentation and/or other materials provided with the         *
 *    distribution.                                                      *
 *                                                                       *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   *
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     *
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS     *
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE        *
 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,            *
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES    *
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR    *
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)    *
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,   *
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)         *
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED   *
 * OF THE POSSIBILITY OF SUCH DAMAGE.                                    *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/**
 *  Lousson\Schema\Generic\GenericComplexTypeTest class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Generic;

/** Dependencies: */
use Lousson\Schema\AbstractTypeTest;
use Lousson\Schema\AnyType;
use Lousson\Schema\Generic\GenericComplexType;


/**
 * A test case for the GenericComplexType class
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class GenericComplexTypeTest extends AbstractTypeTest
{
    /**
     *
     */
    public function getType()
    {
        if (null === $this->_type) {
            $anyURIType = $this->getBuiltinType("anyURI");
            $stringType = $this->getBuiltinType("string");

            $this->_type = new GenericComplexType();
            $this->_type->setMemberType("target", $anyURIType);
            $this->_type->setMemberType("title", $stringType);
        }

        return $this->_type;
    }

    /**
     *
     */
    public function provideImportTestData()
    {
        $testedType = $this->getType();
        $anyURIType = $testedType->getMemberType("target");
        $stringType = $testedType->getMemberType("title");

        $target = "http://example.com/";
        $targetURI = $anyURIType->import($target);

        $title = "This is an example";

        $completeInput = array("target" => $target, "title" => $title);
        $completeValue = array("target" => $targetURI, "title" => $title);

        $incompleteInput = array("target" => $target);
        $incompleteValue = array("target" => $targetURI);

        $testData = array(
            array($incompleteInput, $incompleteValue),
            array($completeInput, $completeValue),
        );

        return $testData;
    }

    /**
     *
     */
    public function provideExportTestData()
    {
        $testData = self::provideImportTestData();

        foreach ($testData as &$testParameters) {
            $parameterCache = $testParameters[0];
            $testParameters[0] = $testParameters[1];
            $testParameters[1] = $parameterCache;
        }

        return $testData;
    }

    /**
     *
     */
    public function provideInvalidInput()
    {
        $input = parent::provideInvalidInput();
        $input[] = array(array("target" => "http://:sense/less?"));
        return $input;
    }

    /**
     * Test the normalizeNCName() method
     *
     * The testNormalizeNCName() method is a test case for the
     * (protected!) normalizeNCName() method; a short kludge to
     * provoke an error condition and increase code coverage.
     *
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an error
     */
    public function testNormalizeNCName()
    {
        $type = $this->getType();
        $reflection = new \ReflectionClass($type);
        $method = $reflection->getMethod("normalizeNCName");
        $method->setAccessible(true);
        $name = ":foo";
        $method->invokeArgs($type, array(&$name));
    }

    /**
     * Test the normalizeValue() method
     *
     * The testNormalizeValue() method is a test case for the
     * (protected!) normalizeValue() method; a short kludge to
     * provoke an error condition and increase code coverage.
     *
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an error
     */
    public function testNormalizeValue()
    {
        $type = $this->getType();
        $reflection = new \ReflectionClass($type);
        $method = $reflection->getMethod("normalizeValue");
        $method->setAccessible(true);
        $method->invokeArgs($type, array(&$this));
    }

    /**
     * Test the normalizeRecord() method
     *
     * The testNormalizeRecord() method is a test case for the
     * (protected!) normalizeRecord() method; a short kludge to
     * provoke an error condition and increase code coverage.
     *
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an error
     */
    public function testNormalizeRecord()
    {
        $type = $this->getType();
        $reflection = new \ReflectionClass($type);
        $method = $reflection->getMethod("normalizeRecord");
        $method->setAccessible(true);
        $record = array("foo" => "bar", "baz");
        $method->invokeArgs($type, array(&$record));
    }

    /**
     * The type to test
     *
     * @var \Lousson\Schema\AnyType
     */
    private $_type;
}

