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
 * Lousson\Schema\Builtin\BuiltinStringType class definition
 *
 * @package     org.lousson.schema
 * @copyright   (c) 2013, The Lousson Project
 * @license     http://opensource.org/licenses/bsd-license.php New BSD License
 * @author      Attila G. Levai <sgnl19 at quirkies.org>
 * @filesource
 */
namespace Lousson\Schema\Builtin;

/* Dependencies: */
use Lousson\Schema\Builtin\BuiltinAtomicType;

/**
 * A generic implementation of the AnySchema interface
 *
 * @since       lousson/Lousson_Schema-0.1.0
 * @package     org.lousson.schema
 */
class BuiltinStringType extends BuiltinAtomicType
{
    /**
     * The type name of the StringType
     *
     * @var string
     */
    const NAME = "string";

    /**
     * Obtain a string type instance
     *
     * The static getInstance() method is a shortcut used to obtain a
     * StringType instance.
     *
     * Note that this method is deprecated; it has been introduced only
     * to work as an intermediary solution for the dependency issue in
     * the AbstractEnty class anyway!
     *
     * @return  \Lousson\Schema\Type\StringType
     *          A string type instance is returned on success
     */
    public static function getInstance()
    {
        static $instance = null;
        isset($instance) || ($instance = new self());
        return $instance;
    }

    /**
     * Obtain the type's name
     *
     * The getName() method is used to retrieve the name of the type; the
     * same as the value of the StringType::NAME constant.
     *
     * @return  string
     *          The type's name is returned on success.
     */
    public function getName()
    {
        return self::NAME;
    }
}

