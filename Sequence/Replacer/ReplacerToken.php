<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 18:29
 */

namespace Kebza\SequenceBundle\Sequence\Replacer;


class ReplacerToken
{
    protected $token;
    protected $params;
    protected $replace;

    /**
     * Token constructor.
     * @param $token
     * @param $params
     * @param $replace
     */
    public function __construct($token, $params, $replace)
    {
        $this->token = $token;
        $this->params = $params;
        $this->replace = $replace;
    }


    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getReplace()
    {
        return $this->replace;
    }


}