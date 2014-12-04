<?php
/**
 * Auto generated from member.proto at 2014-11-28 17:05:08
 */

namespace Structure;

/**
 * Member message
 */
class PbMember extends \ProtobufMessage
{
    /* Field index constants */
    const MID = 1;
    const NICKNAME = 2;
    const EMAIL = 3;
    const REGTIME = 4;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::MID => array(
            'name' => 'mid',
            'required' => false,
            'type' => 5,
        ),
        self::NICKNAME => array(
            'name' => 'nickname',
            'required' => false,
            'type' => 7,
        ),
        self::EMAIL => array(
            'name' => 'email',
            'required' => false,
            'type' => 7,
        ),
        self::REGTIME => array(
            'name' => 'regtime',
            'required' => false,
            'type' => 5,
        ),
    );

    /**
     * Constructs new message container and clears its internal state
     *
     * @return null
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Clears message values and sets default ones
     *
     * @return null
     */
    public function reset()
    {
        $this->values[self::MID] = null;
        $this->values[self::NICKNAME] = null;
        $this->values[self::EMAIL] = null;
        $this->values[self::REGTIME] = null;
    }

    /**
     * Returns field descriptors
     *
     * @return array
     */
    public function fields()
    {
        return self::$fields;
    }

    /**
     * Sets value of 'mid' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setMid($value)
    {
        return $this->set(self::MID, $value);
    }

    /**
     * Returns value of 'mid' property
     *
     * @return int
     */
    public function getMid()
    {
        return $this->get(self::MID);
    }

    /**
     * Sets value of 'nickname' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setNickname($value)
    {
        return $this->set(self::NICKNAME, $value);
    }

    /**
     * Returns value of 'nickname' property
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->get(self::NICKNAME);
    }

    /**
     * Sets value of 'email' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setEmail($value)
    {
        return $this->set(self::EMAIL, $value);
    }

    /**
     * Returns value of 'email' property
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->get(self::EMAIL);
    }

    /**
     * Sets value of 'regtime' property
     *
     * @param int $value Property value
     *
     * @return null
     */
    public function setRegtime($value)
    {
        return $this->set(self::REGTIME, $value);
    }

    /**
     * Returns value of 'regtime' property
     *
     * @return int
     */
    public function getRegtime()
    {
        return $this->get(self::REGTIME);
    }
}
