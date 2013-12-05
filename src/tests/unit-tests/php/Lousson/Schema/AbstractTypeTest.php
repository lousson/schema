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
 * Lousson\Schema\AbstractTypeTest class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema;

/** Dependencies: */
use Lousson\Schema\AbstractTest;
use Lousson\Schema\Builtin\BuiltinSchema;

/**
 * An abstract test case for schema classes
 *
 * The Lousson\Schema\AbstractTypeTest class has been introduced to
 * ease the creation of unit-tests for implementations of the AnySchema
 * interface.
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
abstract class AbstractTypeTest extends AbstractTest
{
    /**
     *
     */
    abstract public function getType();

    /**
     *
     */
    abstract public function provideImportTestData();

    /**
     *
     */
    abstract public function provideExportTestData();

    /**
     *
     */
    public function getNamespaceURI()
    {
        return null;
    }

    /**
     *
     */
    public function provideInvalidInput()
    {
        return array(
            array(array("foo" => $this)),
            array($this),
            array(array("foo" => "bar", "baz")),
        );
    }

    /**
     *
     */
    public function provideInvalidValues()
    {
        return array(
            array(array("foo" => $this)),
            array($this),
        );
    }

    /**
     *
     */
    public function provideCompatibleTypes()
    {
        $urType = $this->getBuiltinType("anyType");
        return array(array($urType));
    }

    /**
     *
     */
    public function provideCompatibleTestData()
    {
        $compatible = array();
        $types = $this->provideCompatibleTypes();
        $testData = $this->provideImportTestData();

        foreach (array_values($types) as $i => $type) {
            $compatible[] = array(
                $type[0],
                $testData[$i % count($testData)][1]
            );
        }

        return $compatible;
    }

    /**
     * @dataProvider        provideImportTestData
     * @test
     */
    public function testValidImport($input, $expected)
    {
        $type = $this->getType();
        $this->assertInstanceOf(self::I_TYPE, $type);

        $value = $type->import($input);
        $this->assertEquals($expected, $value);

        $output = $type->export($value);
        $value = $type->import($output);
        $this->assertEquals($expected, $value);
    }

    /**
     * @dataProvider        provideExportTestData
     * @test
     */
    public function testValidExport($value, $expected)
    {
        $type = $this->getType();
        $this->assertInstanceOf(self::I_TYPE, $type);

        $output = $type->export($value);
        $this->assertEquals($expected, $output);

        $import = $type->import($output);
        $output = $type->export($import);
        $this->assertEquals($expected, $output);
    }

    /**
     * @dataProvider        provideInvalidInput
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an error
     */
    public function testInvalidImport($input)
    {
        $type = $this->getType();
        $this->assertInstanceOf(self::I_TYPE, $type);

        /* Should raise a schema exception */
        $type->import($input);
    }

    /**
     * @dataProvider        provideInvalidValues
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an error
     */
    public function testInvalidExport($value)
    {
        $type = $this->getType();
        $this->assertInstanceOf(self::I_TYPE, $type);

        /* Should raise a schema exception */
        $type->export($value);
    }

    /**
     * @dataProvider        provideCompatibleTestData
     * @test
     */
    public function testCompatibleType(AnyType $compatible, $value)
    {
        $type = $this->getType();
        $this->assertInstanceOf(self::I_TYPE, $type);
        $alpha = $type->exportTo($compatible, $value);
        $backport = $type->importFrom($compatible, $alpha);
        $beta = $type->exportTo($compatible, $backport);
        $this->assertEquals($alpha, $beta);
    }

    /**
     *
     */
    final protected function getBuiltinType($name)
    {
        $schema = BuiltinSchema::getInstance();
        $type = $schema->getType($name, self::NS_SCHEMA);
        return $type;
    }
}

