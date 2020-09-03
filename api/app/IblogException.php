<?php
namespace think\exception;
use Exception;

class IblogException extends \RuntimeException
{
    protected $class;

    public function __construct(string $message, string $code = '', Exception $previous = null)
    {
        $this->message = $message;

        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取类名
     * @access public
     * @return string
     */
}