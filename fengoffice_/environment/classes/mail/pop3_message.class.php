<?php
class POP3_Message
{
    // {{{ private attributes
    private $intMsgNum = 0;
    private $arrHeader = array();
    private $arrBody = array();
    private $arrAttachments = array();
    // }}}
    // {{{ __construct()
    function __construct( $intMsgNum, $strMessage )
    {
        $this->intMsgNum = $intMsgNum;
        $this->parseMessage($strMessage);
    }
    // }}}
    // {{{ __destruct()
    function __destruct()
    {
        $this->intMsgNum = 0;
        $this->arrHeader = NULL;
        $this->arrBody = NULL;
        $this->arrAttachments = NULL;
    }
    // }}}
    // {{{ getMessageNum()
    public function getMessageNum()
    {
        return $this->intMsgNum;
    }
    // }}}
    // {{{ getHeader()
    public function getHeader( $bAsArray = FALSE )
    {
        if( !$bAsArray )
        {
            $strHeader = "";
            foreach($this->arrHeader AS $strHeadLine )
            {
                $strHeader .= $strHeadLine;
            }
            return $strHeader;
        }
        return $this->arrHeader;
    }
    // }}}
    // {{{ getBody()
    public function getBody( $bAsArray = TRUE )
    {
        if( !$bAsArray )
        {
            $strBody = "";
            foreach($this->arrBody AS $strBodyLine )
            {
                $strBody .= $strBodyLine;
            }
            return $strBody;
        }
        return $this->arrBody;
    }
    // }}}
    // {{{ __toString()
    function __toString()
    {
        return $this->getHeader() . $this->getBody();
    }
    // }}}
    // {{{ getAttachment()
    public function getAttachment( $intAttchmentNum = 0 )
    {   
    }
    // }}}
    // {{{ getAttachments()
    public function getAttachments()
    {
    }
    // }}}
    // {{{ storeAttachment()
    public function storeAttachment( $intAttachmentNum )
    {
    }
    // }}}
    // {{{ storeAttachments()
    public function storeAttachments( $strDirectoryPath = "./" )
    {
    }
    // }}}

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////// PRIVATE FUNCTIONS ///////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////
    // {{{ parseMessage()
    private function parseMessage( &$strMessage )
    {
        // 1. Split header from the Body
        // 2. Parse the Header and Body
        // 2.1 Body: Parse attachments
    }
    // }}}
    // {{{ ()
    // }}}
}
?>