<?php
/**
 * Auto generated from test.proto at 2014-11-28 15:09:50
 */

/**
 * test message
 */
class Test extends \ProtobufMessage
{
    /* Field index constants */
    const CMD = 1;
    const MID = 2;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::CMD => array(
            'name' => 'cmd',
            'required' => true,
            'type' => 7,
        ),
        self::MID => array(
            'name' => 'mid',
            'repeated' => true,
            'type' => 7,
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
        $this->values[self::CMD] = null;
        $this->values[self::MID] = array();
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
     * Sets value of 'cmd' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setCmd($value)
    {
        return $this->set(self::CMD, $value);
    }

    /**
     * Returns value of 'cmd' property
     *
     * @return string
     */
    public function getCmd()
    {
        return $this->get(self::CMD);
    }

    /**
     * Appends value to 'mid' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendMid($value)
    {
        return $this->append(self::MID, $value);
    }

    /**
     * Clears 'mid' list
     *
     * @return null
     */
    public function clearMid()
    {
        return $this->clear(self::MID);
    }

    /**
     * Returns 'mid' list
     *
     * @return string[]
     */
    public function getMid()
    {
        return $this->get(self::MID);
    }

    /**
     * Returns 'mid' iterator
     *
     * @return ArrayIterator
     */
    public function getMidIterator()
    {
        return new \ArrayIterator($this->get(self::MID));
    }

    /**
     * Returns element from 'mid' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getMidAt($offset)
    {
        return $this->get(self::MID, $offset);
    }

    /**
     * Returns count of 'mid' list
     *
     * @return int
     */
    public function getMidCount()
    {
        return $this->count(self::MID);
    }
}
