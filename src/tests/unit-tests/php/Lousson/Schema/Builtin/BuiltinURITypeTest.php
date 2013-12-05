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
 *  Lousson\Schema\Builtin\BuiltinURITypeTest class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Mathias J. Hennig <mhennig at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Builtin;

/** Dependencies: */
use Lousson\Schema\AbstractTypeTest;
use Lousson\Schema\Builtin\BuiltinURIType;
use Lousson\URI\Builtin\BuiltinURIFactory;

/**
 *  A test case for the BuiltinURIType class
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class BuiltinURITypeTest extends AbstractTypeTest
{
    /**
     *
     */
    public function getType()
    {
        return new BuiltinURIType();
    }

    /**
     *
     */
    public function provideImportTestData()
    {
        $factory = new BuiltinURIFactory();
        $uriList = array(
            "urn:lousson:test",
            "http://example.com/",
        );

        foreach ($uriList as $uri) {
            $value = $factory->getURI($uri);
            $data[] = array($uri, $value);
        }

        return $data;
    }

    /**
     *
     */
    public function provideExportTestData()
    {
        $factory = new BuiltinURIFactory();
        $uriList = array(
            "urn:lousson:test",
            "http://example.com/",
        );

        foreach ($uriList as $uri) {
            $value = $factory->getURI($uri);
            $data[] = array($uri, $value);
        }

        foreach ($uriList as $uri) {
            $data[] = array($uri, $uri);
        }

        return $data;
    }

    /**
     *
     */
    public function provideInvalidInput()
    {
        $input = parent::provideInvalidInput();

        $input[] = array("--not-an-uri--");
        $input[] = array("");

        return $input;
    }

    /**
     *
     */
    public function provideInvalidValues()
    {
        $values = parent::provideInvalidValues();

        $values[] = array("--not-an-uri--");
        $values[] = array("");

        return $values;
    }
}

