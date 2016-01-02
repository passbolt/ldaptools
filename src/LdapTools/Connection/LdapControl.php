<?php
/**
 * This file is part of the LdapTools package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LdapTools\Connection;

/**
 * Represents an LDAP control.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class LdapControl
{
    /**
     * @var string The OID for the control.
     */
    protected $oid;

    /**
     * @var bool The criticality of the control.
     */
    protected $criticality = false;

    /**
     * @var mixed The value for the control.
     */
    protected $value;

    /**
     * @param string $oid
     */
    public function __construct($oid)
    {
        $this->oid = $oid;
    }

    /**
     * Set the OID for the control.
     *
     * @param string $oid
     * @return $this
     */
    public function setOid($oid)
    {
        $this->oid = $oid;

        return $this;
    }

    /**
     * Get the OID for the control.
     *
     * @return string
     */
    public function getOid()
    {
        return $this->oid;
    }

    /**
     * Set the criticality for the control.
     *
     * @param bool $criticality
     * @return $this
     */
    public function setCriticality($criticality)
    {
        $this->criticality = (bool) $criticality;

        return $this;
    }

    /**
     * Get the criticality for the control.
     *
     * @return bool
     */
    public function getCriticality()
    {
        return $this->criticality;
    }

    /**
     * Set the value for the control.
     *
     * @param mixed $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value for the control.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the control array structure that ldap_set_option expects.
     *
     * @return array
     */
    public function toArray()
    {
        $control = [
            'oid' => $this->oid,
            'iscritical' => $this->criticality
        ];
        if (!is_null($this->value)) {
            $control['value'] = $this->value;
        }

        return $control;
    }
}
