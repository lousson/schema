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
 * Lousson\Schema\AbstractSchemaTest class definition
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

/**
 * An abstract test case for schema classes
 *
 * The Lousson\Schema\AbstractSchemaTest class has been introduced to
 * ease the creation of unit-tests for implementations of the AnySchema
 * interface.
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
abstract class AbstractSchemaTest extends AbstractTest
{
    /**
     * Test the getType() method
     *
     * The testValidGetType() method is a test case for the getType()
     * method declared by the AnySchema interface.
     * It utilizes the GenericSchema's setType() method to register a
     * type mock according to the given $name and $namespaceURI, which
     * is expected to be the return value of getType() when invoked
     * with the same parameters.
     *
     * @param   string      $name           The name of the type to look up
     * @param   string      $namespaceURI   The type's namespace
     *
     * @dataProvider    provideValidTypeIDs
     * @test
     *
     * @throws  \PHPUnit_Framework_AssertionFailedError
     *          Raised in case the test discovered any issue
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function testValidGetType($name, $namespaceURI = null)
    {
        $namespaceURI = "urn:lousson:junk";
        $mock = $this->getTypeMock($name, $namespaceURI);
        $schema = $this->getSchema($mock);
        $type = $this->getType($name, $namespaceURI);

        $this->assertEquals(
            $name, $type->getName(), sprintf(
            "%s::getType(\"%s\", ..)->getName() must return ".
            "\"%s\"", get_class($schema), $name, $name
        ));
    }

    /**
     * Test the getType() method
     *
     * The testInvalidGetType() method is a test case for the getType()
     * method declared by the AnySchema interface.
     * It utilizes a $name / $namespaceURI combination that is considered
     * invalid and expects a schema exception to be thrown.
     *
     * @param   string      $name           The name of the type to look up
     * @param   string      $namespaceURI   The type's namespace
     *
     * @dataProvider        provideInvalidTypeIDs
     * @expectedException   Lousson\Schema\AnySchemaException
     * @test
     *
     * @throws  \Lousson\Schema\AnySchemaException
     *          Raised in case the test is successful
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function testInvalidGetType($name, $namespaceURI = null)
    {
        $this->getType($name, $namespaceURI);
    }
}

