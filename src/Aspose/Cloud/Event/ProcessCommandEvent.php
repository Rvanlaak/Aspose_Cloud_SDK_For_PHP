<?php

namespace Aspose\Cloud\Event;

class ProcessCommandEvent extends AbstractEvent
{
    const PRE_CURL = 'aspose.utils.pre_curl';
    const POST_CURL = 'aspose.utils.post_curl';

    /**
     * This value will be set during the POST_CURL event
     * @var string
     */
    private $result;


    function __construct($result=null)
    {
        $this->result = $result;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

}