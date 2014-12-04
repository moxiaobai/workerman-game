<?php
/**
 * Auto generated from cmd.proto at 2014-11-28 17:02:10
 */

/**
 * cmd message
 */
class Cmd extends \ProtobufMessage
{
    /* Field index constants */
    const OBJ = 1;
    const METHOD = 2;
    const PARAMS = 3;

    /* @var array Field descriptors */
    protected static $fields = array(
        self::OBJ => array(
            'name' => 'obj',
            'required' => true,
            'type' => 7,
        ),
        self::METHOD => array(
            'name' => 'method',
            'required' => true,
            'type' => 7,
        ),
        self::PARAMS => array(
            'name' => 'params',
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
        $this->values[self::OBJ] = null;
        $this->values[self::METHOD] = null;
        $this->values[self::PARAMS] = array();
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
     * Sets value of 'obj' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setObj($value)
    {
        return $this->set(self::OBJ, $value);
    }

    /**
     * Returns value of 'obj' property
     *
     * @return string
     */
    public function getObj()
    {
        return $this->get(self::OBJ);
    }

    /**
     * Sets value of 'method' property
     *
     * @param string $value Property value
     *
     * @return null
     */
    public function setMethod($value)
    {
        return $this->set(self::METHOD, $value);
    }

    /**
     * Returns value of 'method' property
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->get(self::METHOD);
    }

    /**
     * Appends value to 'params' list
     *
     * @param string $value Value to append
     *
     * @return null
     */
    public function appendParams($value)
    {
        return $this->append(self::PARAMS, $value);
    }

    /**
     * Clears 'params' list
     *
     * @return null
     */
    public function clearParams()
    {
        return $this->clear(self::PARAMS);
    }

    /**
     * Returns 'params' list
     *
     * @return string[]
     */
    public function getParams()
    {
        return $this->get(self::PARAMS);
    }

    /**
     * Returns 'params' iterator
     *
     * @return ArrayIterator
     */
    public function getParamsIterator()
    {
        return new \ArrayIterator($this->get(self::PARAMS));
    }

    /**
     * Returns element from 'params' list at given offset
     *
     * @param int $offset Position in list
     *
     * @return string
     */
    public function getParamsAt($offset)
    {
        return $this->get(self::PARAMS, $offset);
    }

    /**
     * Returns count of 'params' list
     *
     * @return int
     */
    public function getParamsCount()
    {
        return $this->count(self::PARAMS);
    }
}
