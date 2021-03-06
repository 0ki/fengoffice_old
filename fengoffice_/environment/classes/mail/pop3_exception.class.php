<?php
// {{{ final class POP3_Exception
final class POP3_Exception extends Exception
{
    // {{{ __construct()
	function __construct( $strErrMessage, $intErrCode )
	{
        switch( $intErrCode )
        {
            case POP3::ERR_NOT_IMPLEMENTS:
                $strErrMessage = "This function isn't implements at time.";
            break;
            
            case POP3::ERR_SOCKETS:
               $strErrMessage = "Sockets Error: (". socket_last_error() .") -- ". socket_strerror(socket_last_error());
            break;
        }
	    parent::__construct($strErrMessage, $intErrCode);	
	}
	// }}}
    // {{{ __toString()
	public function __toString()
	{
		return __CLASS__ ." [". $this->getCode() ."] -- ". $this->getMessage() ." in file ". $this->getFile() ." at line ". $this->getLine(). PHP_EOL ."Trace: ". $this->getTraceAsString() .PHP_EOL;
	}
    // }}}
}
// }}}
?>