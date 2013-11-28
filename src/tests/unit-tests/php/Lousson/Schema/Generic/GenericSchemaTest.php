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
 *  Lousson\Schema\Generic\GenericSchemaTest class definition
 *
 *  @package    org.lousson.schema
 *  @copyright  (c) 2013, The Lousson Project
 *  @license    http://opensource.org/licenses/bsd-license.php New BSD License
 *  @author     Mathias J. Hennig <mhennig at quirkies.org>
 *  @filesource
 */
namespace Lousson\Schema\Generic;

/** Dependencies: */
use Lousson\Schema\AbstractSchemaTest;

/**
 *  A test case for the GenericSchema class
 *
 *  @since      lousson/Lousson_Schema-0.1.0
 *  @package    org.lousson.schema
 *  @link       http://www.phpunit.de/manual/current/en/
 */
class GenericSchemaTest extends AbstractSchemaTest
{
    /**
     * Obtain a schema instance
     *
     * The getSchema() method is used in the test cases to obtain an
     * instance of the schema implementation under test.
     *
     * @return  \Lousson\Schema\AnySchema
     *          An instance of the test schema is returned on success
     *
     * @throws  \Exception
     *          Raised in case of an internal error
     */
    public function getSchema()
    {
        $this->assertNotNull($this->_schema);
        return $this->_schema;
    }

    /**
     * Prepare test suite
     *
     * The setUp() method is invoked to reset the test runtime and to
     * prepare for the next test invocation.
     */
    public function setUp()
    {
        $this->_schema = new GenericSchema();
    }

    /**
     * The schema under test
     *
     * @var \Lousson\Schema\Generic\GenericSchema
     */
    private $_schema;
}

