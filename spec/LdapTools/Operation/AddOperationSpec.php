<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\LdapTools\Operation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddOperationSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('foo');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('LdapTools\Operation\AddOperation');
    }

    function it_should_be_able_to_be_constructed_with_a_null_dn()
    {
        $this->beConstructedWith(null);
        $this->shouldHaveType('LdapTools\Operation\AddOperation');

    }

    function it_should_implement_LdapOperationInterface()
    {
        $this->shouldImplement('\LdapTools\Operation\LdapOperationInterface');
    }

    function it_should_set_the_attributes_for_the_add_operation()
    {
        $attributes = ['foo' => 'bar', 'bar' => 'foo'];
        $this->setAttributes($attributes);
        $this->getAttributes()->shouldBeEqualTo($attributes);
    }

    function it_should_set_the_DN_for_the_add_operation()
    {
        $dn = 'cn=foo,dc=example,dc=local';
        $this->setDn($dn);
        $this->getDn()->shouldBeEqualTo($dn);
    }

    function it_should_chain_the_setters()
    {
        $this->setDn('foo')->shouldReturnAnInstanceOf('\LdapTools\Operation\AddOperation');
        $this->setAttributes(['foo' => 'bar'])->shouldReturnAnInstanceOf('\LdapTools\Operation\AddOperation');
    }

    function it_should_get_the_name_of_the_operation()
    {
        $this->getName()->shouldBeEqualTo('Add');
    }

    function it_should_get_the_correct_ldap_function()
    {
        $this->getLdapFunction()->shouldBeEqualTo('ldap_add');
    }

    function it_should_return_the_arguments_for_the_ldap_function_in_the_correct_order()
    {
        $args = [
            'cn=foo,dc=example,dc=local',
            ['foo' => 'bar'],
        ];
        $this->setDn($args[0]);
        $this->setAttributes($args[1]);
        $this->getArguments()->shouldBeEqualTo($args);
    }

    function it_should_get_a_log_formatted_array()
    {
        $this->getLogArray()->shouldBeArray();
        $this->getLogArray()->shouldHaveKey('DN');
        $this->getLogArray()->shouldHaveKey('Attributes');
        $this->getLogArray()->shouldHaveKey('Server');
        $this->getLogArray()->shouldHaveKey('Controls');
    }

    function it_should_mask_password_values_in_the_log_formatted_array()
    {
        $this->setAttributes(['username' => 'foo', 'unicodePwd' => 'correct horse battery staple']);
        $this->getLogArray()->shouldContain(print_r(['username' => 'foo', 'unicodePwd' => '******'], true));
        $this->setAttributes(['username' => 'foo', 'userPassword' => 'correct horse battery staple']);
        $this->getLogArray()->shouldContain(print_r(['username' => 'foo', 'userPassword' => '******'], true));
    }

    function it_should_throw_an_invalid_argument_exception_if_the_dn_is_left_null_when_get_arguments_is_called()
    {
        $this->beConstructedWith(null);
        $this->shouldThrow('\LdapTools\Exception\InvalidArgumentException')->duringGetArguments();
    }

    function it_should_set_a_location()
    {
        $this->setLocation('dc=foo,dc=bar');
        $this->getLocation()->shouldBeEqualTo('dc=foo,dc=bar');
    }
}
