<?php
// vim: expandtab sw=4 ts=4 sts=4 nowrap nu fdm=marker
/**
 * POP3 Class
 * 
 * This class provide access to a pop3 server through the pop3 protocol
 *  
 * @need: >=php-5.2.x
 * @author: j0inty.sL
 * @email: bestmischmaker@web.de
 * @version: 0.7.1-beta
 *
 * NOTES:
 * - IPv6 support NEVER tested
 */
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
// {{{ class POP3
class POP3
{ 
    // {{{ Error constants
	const ERR_NONE = 0;
	const ERR_LOG = 1;
	const ERR_SOCKETS = 2;
	const ERR_PARAMETER = 3;
    const ERR_NOT_IMPLEMENTS = 4;
    const ERR_INVALID_STATE = 5;
    const ERR_STREAM = 6;
	const ERR_SEND_CMD = 7;
	// }}}
    // {{{ POP3 state constants
    const STATE_DISCONNECT = 100;
    const STATE_AUTHORIZATION = 101;
    const STATE_TRANSACTION = 102;
    // }}}
    // {{{ private attributes
    const DEFAULT_BUFFER_SIZE = 4096;
	private $bLogOpened = FALSE;
	private $resLogFp = FALSE;
	private $strLogFile = NULL;
    private $bHideUsernameAtLog = TRUE;

    private $bUseSockets;
	private $bSocketConnected = FALSE;
    private $strHostname = NULL;
    private $strIPAdress = NULL;
    private $intPort = NULL;

    private $intCurState = self::STATE_DISCONNECT;
    private $strAPOPBanner = NULL;
	private $bAPOPAutoDetect;
    // }}}
    // {{{ __construct()
    /*
     * Constructor
     *
     * @param NULL|string $strLogFile  Path to a log file or NULL for no log
     * @param bool $bAPOPAutoDetect  APOP Auto Dection on|off
     * @param bool $bHideUsernameAtLog  Does the Username should hide at the log file 
     * @param bool $bUseSockets  Use the socket extension (default = TRUE) But it check is the extension_loaded, too
     *             !!! Only needed by them who have the sockets extension loaded but want tzo use the stream functions !!!
     * 
     * @throw POP3_Exception
     */
	public function __construct( $strLogFile = NULL, $bAPOPAutoDetect = TRUE, $bHideUsernameAtLog = TRUE, $bUseSockets = TRUE )
    {
        if( !is_bool($bAPOPAutoDetect) )
		{
			throw new POP3_Exception("Invalid APOP auto detect parameter given.", self::ERR_PARAMETER);
		}
		if( !is_bool($bHideUsernameAtLog) )
        {
            throw new POP3_Exception("Invalid Hide Username at log file parameter given.", self::ERR_PARAMETER);
        }

        // Check for sockets extension if needed
		if( $bUseSockets && extension_loaded("sockets") )
		{
			$this->bUseSockets = TRUE;
		}
		else
		{
			$this->bUseSockets = FALSE;
		}

		// Activate logging if needed
		if( !is_null($strLogFile) )
		{
			$this->strLogFile = $strLogFile;
			$this->openlog();
		}
		// Activate or Deactivate APOP Auto Detect mechanism
		$this->bAPOPAutoDetect = $bAPOPAutoDetect;
        $this->bHideUsernameAtLog = $bHideUsernameAtLog;
	}
    // }}}
    // {{{ __destruct()
	/*
     * Destructor
     *
     * @throw POP3_Exception
     */
	public function __destruct()
	{
		$this->disconnect();
		$this->closelog();
	}
    // }}}
    // {{{ connect()
    /*
     * connect
     *
     * @param NULL|string $strHostname  Hostname or ip adress of a pop3 server
     * @param integer $intPort  The port for the pop3 service (default is 110)
     * @param array $arrConnectionTimeout  array("sec" => "", "usec" => "")
     * @param bool $bIPv6  IP Version 6 Protocol
     *
     * @throw POP3_Exception
     */
	public function connect( &$strHostname , $intPort = 110, $arrConnectionTimeout = array("sec" => 10, "usec" => 0), $bIPv6 = FALSE )
	{
	    $this->checkState(POP3::STATE_DISCONNECT);
        /// Parameter checks ///
        if( !is_string($strHostname) )
        {
            throw new POP3_Exception("Invalid host parameter given", self::ERR_PARAMETER);
        }

        if( !is_int($intPort) || $intPort < 1 || $intPort > 65535 ) 
        {
            throw new POP3_Exception("Invalid port parameter given", self::ERR_PARAMETER);
        }
        if( !is_array($arrConnectionTimeout) || !is_int($arrConnectionTimeout["sec"]) || !is_int($arrConnectionTimeout["usec"]) )
        {
            throw new POP3_Exception("Invalid connection timeout parameter given", self::ERR_PARAMETER);
        }
        if( !is_bool($bIPv6) )
        {
            throw new POP3_Exception("Invalid IPv6 parameter given", self::ERR_PARAMETER);
        }
        
        $this->strHostname = $strHostname;
        $this->intPort = $intPort; 
        
        /// Connecting ///
		if( $this->bUseSockets )
		{
            if( !$this->resSocket = @socket_create( (($bIPv6) ? AF_INET6 : AF_INET), SOCK_STREAM, SOL_TCP ) )
			{
				throw new POP3_Exception("", self::ERR_SOCKETS);
			}
            $this->log( ($bIPv6) ? "AF_INET6" : "AF_INET" ."-TCP Socket created (using sockets extension)");

			$this->setSockTimeout($arrConnectionTimeout);
			
            if( !@socket_connect($this->resSocket, $this->strHostname, $this->intPort)
            	|| !@socket_getpeername($this->resSocket,$this->strIPAdress) )
			{
				throw new POP3_Exception("", self::ERR_SOCKETS);
			}
        }
		else
		{
            $dTimeout = (double) implode(".",$arrConnectionTimeout);
			if( !$this->resSocket = @fsockopen("tcp://". $this->strHostname, $this->intPort, $intErrno, $strError, $dTimeout) )
			{
				throw new POP3_Exception( "[". $intErrno."] -- ". $strError, self::ERR_STREAM );
			}
			
			$this->setSockTimeout($arrConnectionTimeout);
            $this->strIPAdress = @gethostbyname($this->strHostname);
		}
        $this->bSocketConnected = TRUE;
        $this->log("Connected to ". $this->strIPAdress .":". $this->intPort ." [". $this->strHostname ."]");
        
        // Get the first response with, if APOP support avalible, the apop banner.
        $strBuffer = "";
        $strBuffer = $this->recvString();
        $this->log($strBuffer);
        $this->parseBanner($strBuffer);
		$this->intCurState = self::STATE_AUTHORIZATION;
	}
    // }}}
	// {{{ disconnect()
    /*
	 * Disconnect from the server.
     * CAUTION:
     * This function doesn't send the QUIT command to the server so all as delete marked emails won't delete.
	 *
	 * @return void
	 * @throw POP3_Exception
	 */
	public function disconnect()
	{
		if( $this->bSocketConnected )
        {
            if( $this->bUseSockets )
            {
                if( @socket_close($this->resSocket) === FALSE )
                {
                    throw new POP3_Exception("", self::ERR_SOCKETS);
                }
            }
            else
            {
                if( !@fclose($this->resSocket) )
			    {
				    throw new POP3_Exception("fclose(): Failed to close socket", self::ERR_STREAM);
			    }
            }
            $this->bSocketConnected = FALSE;
            $this->log("Disconneted from ". $this->strIPAdress .":". $this->intPort ." [". $this->strHostname ."]" );
        }
	}
    // }}}
    // {{{ login()
	/**
	 * Authorize to the pop3 server with your login datas.
	 *
	 * @param string $strUser  Username
	 * @param string $strPass  Password
	 * @param boolean $bApop  APOP Authorization Mechanism
	 *
	 * @return void
	 * @throw POP3_Exception
	 */
	public function login( $strUser, $strPass, $bAPOP = FALSE)
	{
        $this->checkState(self::STATE_AUTHORIZATION);
		if( !is_string($strUser) || strlen($strUser) == 0 )
		{
			throw new POP3_Exception("Invalid username string given", self::ERR_PARAMETER);
		}
		if( !is_string($strPass) )
		{
			throw new POP3_Exception("Invalid password string given", self::ERR_PARAMETER);
		}
		if( !is_bool($bAPOP) )
		{
			throw new POP3_Exception("Invalid APOP variable given", self::ERR_PARAMETER);
		}

		if( $this->bAPOPAutoDetect && !is_null($this->strAPOPBanner) && !$bAPOP)
		{
			$bAPOP = TRUE;
		}

		if( $bAPOP )
		{
			// APOP Auth			
			$this->sendCmd("APOP ". $strUser ." ". hash("md5",$this->strAPOPBanner . $strPass, false), "APOP ". (($this->bHideUsernameAtLog) ? hash("sha256",$strUser . microtime(true),false) : $strUser) ." ". hash("md5",$this->strAPOPBanner . $strPass, false));
		}
		else
		{
			// POP3 Auth
			$this->sendCmd( "USER ". $strUser, "USER ". (($this->bHideUsernameAtLog) ? hash("sha256",$strUser . microtime(true),false) : $strUser) );
			$this->sendCmd( "PASS ". $strPass, "PASS ". hash("sha256",$strPass . microtime(true),false) );
		}
		$this->intCurState = self::STATE_TRANSACTION;
    }
    // }}}
    // {{{ quit()
    /**
	 * Send the quit command to the server.
     * All as delete marked messages will remove from the mail drop.
	 *
	 * @return void
	 * @throw POP3_Exception
	 */
    public function quit()
    {
        try
        {
            $this->checkState(self::STATE_TRANSACTION);
        }
        catch( POP3_Exception $e )
        {
            $this->checkState(self::STATE_AUTHORIZATION);
        }
        $this->sendCmd("QUIT");
	}
    // }}}
    // {{{ getStat()
    /**
     * Get the stats from the pop3 server
     * This is only a string with the count of mails and their size in your mail drop.
     *
     * @return string  example: "+OK 2 3467"
     * @throw POP3_Exception
     */
	public function getStat()
	{
		$this->checkState(self::STATE_TRANSACTION);
        return $this->sendCmd("STAT");    
	}
    // }}}
    // {{{ getMsg()
    /**
     * Recieve a raw message.
     *
     * @param int intMsgNum  The message number on the pop3 server.
     *
     * @return string  Complete message
     * @throw POP3_Exception
     */
    public function getMsg( $intMsgNum )
    {
		$this->checkState(self::STATE_TRANSACTION);
        $this->checkMsgNum($intMsgNum);
		$this->sendCmd("RETR ". $intMsgNum );
		return $this->recvToPoint(); 
    }
    // }}}
    // {{{ getList()
    /**
     * Get a list with message number and the size in bytes of a message.
     *
     * @return string  A String with a list of all message number and size in your mail drop seperated by "\r\n"
     * @throw POP3_Exception
     */
    public function getList()
    {
		$this->checkState(self::STATE_TRANSACTION);
        $this->sendCmd("LIST");
		return $this->recvToPoint();
    }

    // }}}
    // {{{ getUidl()
    /**
     * Get a list with message number and the unique id on the pop3 server. 
     *
     * @return string  Unique ID List
     * @throw POP3_Exception
     */
    public function getUidl()
    {
	    $this->checkState(self::STATE_TRANSACTION);
        $this->sendCmd("UIDL");
		return $this->recvToPoint();
    }
    // }}}
    // {{{ getTop()
    /**
     * Get the message header and if you want x lines of the message body.
     *
     * @param int intMsgNum  The message number on the pop3 server.
     * @param int intLines  The count of lines of the message body. (default is 0)
     *
     * @return string  Message header
     * @throw POP3_Exception
     */
    public function getTop( $intMsgNum , $intLines = 0 )
    {
        $this->checkState(self::STATE_TRANSACTION);
        $this->checkMsgNum($intMsgNum);
        if( !is_int($intLines) ) throw new POP3_Exception("Invalid line number given", self::ERR_PARAMETER);
        $this->sendCmd("TOP ". $intMsgNum ." ". $intLines);
        return $this->recvToPoint();
    }
    
    
    public function getCurState(){
    	return $this->intCurState;
    }
    
     
    public function getAPOPAutoDetect(){
    	return  $this->bAPOPAutoDetect;
    }
    
    public function setAPOPAutoDetect($val){
    	return  $this->bAPOPAutoDetect = $val;
    }
   
    
    // }}}
    // {{{ deleteMsg
    /*
     * Mark a message as delete
     *
     * @param int $intMsgNum  Message Number on the pop3 server
     *
     * @return NULL
     * @throw POP3_Exception
     */
    public function deleteMsg( $intMsgNum )
    {
        $this->checkState(self::STATE_TRANSACTION);
        $this->checkMsgNum($intMsgNum);
        $this->sendCmd("DELE ". $intMsgNum);
        return;
    }
    // }}}
    // {{{ getMails()
    /*
     *
     * @param array $arrMsgNums  Numeric array with the message numbers on the pop3 server
     *
     * @return array  An array of messages stored under the message number
     * @throw POP3_Exception
     */
    public function getMails( $arrMsgNums )
    {
        $arrMsgs = array();
        foreach( $arrMsgNums as $intMsgNum )
        {
            $arrMsgs[$intMsgNum] = $this->getMsg($intMsgNum);
        }
        return $arrMsgs;
    }
	// }}}
    // {{{ getOfficeStatus()
    /**
     * Get the office status. That means that you will get an array
     * with all needed informations about your mail drop.
     * The array is build up like discribed here.
     *
     * $result = array( "count" => "Count of messages in your mail drop",
     *                  "octets" => "Size of your mail drop in bytes",
     *                  
     *                  "msg_number" => array("uid" => "The unique id of the message on the pop3 server",
     *                                        "octets" => "The size of the message in bytes"
     *                                  ),
     *                  "and soon"
     *          );
     *
     * @return array  
     * @throw POP3_Exception
     */
	public function getOfficeStatus()
	{
        $this->checkState(self::STATE_TRANSACTION);
        $arrRes = array();

		$strSTATs = $this->getStat();
        $arrSTATs = explode(" ",trim($strSTATs));
        $arrRes["count"] = (int) $arrSTATs[1];
		$arrRes["octets"] = (int) $arrSTATs[2];

        if( $arrRes["count"] > 0 )
        {
		    $strUIDLs = $this->getUidl();
		    $strLISTs = $this->getList();
                    
            $arrUIDLs = explode("\r\n",trim($strUIDLs));
		    $arrLISTs = explode("\r\n",trim($strLISTs));
		
            for($i=1; $i<=$arrRes["count"]; $i++)
		    {
                list(,$intUIDL) = explode(" ", trim($arrUIDLs[$i-1]));
                list(,$intLIST) = explode(" ", trim($arrLISTs[$i-1]));
			    $arrRes[$i]["uid"] = (int) $intUIDL;
			    $arrRes[$i]["octets"] = (int) $intLIST;
		    }
        }
		return $arrRes;
	}
    // }}}
    // {{{ saveToFile()
    public function saveToFile( $strPathToFile, &$strMail )
    {
        if( is_file($strPathToFile) )
        {
            throw new POP3_Exception("File \"". $strFile ."\" already exists", self::ERR_PARAMETER);
        }
        if( !$resFile = @fopen($strPathToFile,"w") )
        {
            throw new POP3_Exception("Can't open file \"". $strPathToFile ."\"", self::ERR_STREAM);
        }
        if( !@fwrite($resFile,$strMail,strlen($strMail)) )
        {
            throw new POP3_Exception("Couldn't write to file \"". $strPathToFile ."\"", self::ERR_STREAM);
        }
        @fclose($resFile);

    }
    // }}}
    // {{{ saveToFileFromServer
    /*
     * This function store a message under their message number.
     * And that in the folder that was given by the path parameter.
     *
     * @param int $intMsgNum  Message Number on the server @see getOfficeStatus(), list()
     * @param string $strPathToDir  Path to the directory where the mail should be store.
     * @param string $strFileEnding  The file ending for a email (default ".eml")
     *
     * @return void
     * @throw POP3_Exception
     */
    public function saveToFileFromServer( $intMsgNum, $strPathToDir = "./", $strFileEnding = ".eml" )
    {
        if( !is_dir($strPathToDir) || !is_writeable($strPathToDir) )
        {
            throw new POP3_Exception( $strPathToDir ." is not a directory or the directory is not writeable", self::ERR_PARAMETER);
        }
        $strPathToFile = $strPathToDir . $intMsgNum . $strFileEnding;
        $this->saveToFile($strPathToFile, $this->getMsg($intMsgNum));
    }
    // }}}
    // {{{ saveToSQL
    public function saveToSQL( &$resDBHandler, $strTable )
    {
    }
    // }}}
    // {{{ saveToSQLFromServer
    public function saveToSQLFromServer( $intMsgNum, &$resDBHandler, $strTable = "inbox" )
    {
        
    }
    // }}}
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////// Private functions ///////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////
    // {{{ checkState()
    /**
     * Compare the current state with the needed state.
     *
     * @param integer $intNeededState
     *
     * @throw POP3_Exception
     */
    private function checkState( $intNeededState )
    {
        if ( $this->intCurState != $intNeededState) 
            throw new POP3_Exception("Invalid State !!! Please check your Code !!!", self::ERR_INVALID_STATE);
    }
    // }}}
    // {{{ checkMsgNum
    private function checkMsgNum( &$intMsgNum )
    {
        if( !is_int($intMsgNum) )
        {
            throw new POP3_Exception("Invalid message number given", self::ERR_PARAMETER);
        }
    }
    // }}}
    // {{{ send
    /**
     * Send a string to the server.
     * Will append the network lineend "\r\n".
     *
     * @param string strCmd  The string that should send to the pop3 server
     * 
     * @return void
     * @throw POP3_Exception
     */
	private function send( $strCmd )
    {
        $strCmd .= "\r\n";
        if( $this->bUseSockets )
        {
            if( @socket_send($this->resSocket, $strCmd, strlen($strCmd), 0) === FALSE )
            {
                throw new POP3_Exception("", self::ERR_SOCKETS);                
            }
        }
        else
        {
            if( !@fwrite($this->resSocket, $strCmd, strlen($strCmd)) )
            {
                throw new POP3_Exception("fwrite(): Failed to write string to socket",self::ERR_STREAM);
            }
        }
    }
    // }}}
    // {{{ sendCmd
    /**
     * This function send the command to the server and will get the response
     * If the command goes failed, the function will throw the POP3_Exception with the
     * ERR_SEND_CMD error code and the response as error message.
     *
     * @param string $strCmd  The string with the command for the pop3 server
     * @param string $strLog  Workaround for non clear passwords and usernames in log file
     *
     * @return string  Server response if it was successfull
     * @throw POP3_Exception
     */
	private function sendCmd( $strCmd , $strLog = NULL )
	{
		( !is_null($strLog) ) ? $this->log($strLog) : $this->log($strCmd);
		$this->send($strCmd);
		$strRes = $this->recvString();
		$this->log($strRes);
        // 1. the check for the strlen of the result is a workaround for some server who don't send something after the quit command
        // 2. should run with qmailer too...qmailer bug (pop3.class.inc) "." instead of "+OK" after RETR command
		if( strlen($strRes) > 0 && $strRes{0} == '-' )
		{
			throw new POP3_Exception(trim($strRes), self::ERR_SEND_CMD);
		}
        return $strRes;
	}
    // }}}
    // {{{ recv()
    /**
     * Return value:
     * -----------------------------

     a) on success returns number of bytes read

     b) in case of no data on line, returns zero and $buf will be set to NULL.

     c) on failure returns false, and $buf will be set to NULL.
     To get the error code/message, call the appropriate socket functions.

     d) in case of disconnect, the function returns either b) or c) which depends on how connection was closed from the other end.
     It returns 0 if the connection was closed gracefully with FIN squence and false if it was reset.
     *
     */
    private function recv( &$strBuffer, $intBufferSize = 4096 )
    {
		$strBuffer = "";
        if( $this->bUseSockets )
        {
            $intReadBytes = @socket_recv($this->resSocket, $strBuffer, $intBuferSize, 0);
            if( $intReadBytes === FALSE )
            {
                throw new POP3_Exception("", POP3::ERR_SOCKETS);
            }
		}
        else
        {
            if( !$strBuffer = @fread($this->resSocket, $intBufferSize) )
			{
				throw new POP3_Exception("fread(): Couldn't recieve from socket", self::ERR_STREAM);
			}
        }
		return $intReadBytes;
    }
    // }}}
    // {{{ recvString()
	private function recvString( $intBufferSize = self::DEFAULT_BUFFER_SIZE )
	{
		$strBuffer = "";
		if( $this->bUseSockets )
		{
			if( ($strBuffer = @socket_read($this->resSocket, $intBufferSize , PHP_NORMAL_READ)) === FALSE )
			{
				throw new POP3_Exception("", self::ERR_SOCKETS);
			}
            // Workaround because socket_read with PHP_NORMAL_READ stop at "\r" but the network string ends with "\r\n"
            // so we need to call the socket_read function again to get the "\n"
            if( ($strBuffer2 = @socket_read($this->resSocket, 1 , PHP_NORMAL_READ)) === FALSE )
            {
                throw new POP3_Exception("", self::ERR_SOCKETS);
            }
            $strBuffer .= $strBuffer2;
        }
		else
		{
			if( !$strBuffer = @fgets($this->resSocket, $intBufferSize) )
			{
				throw new POP3_Exception("fgets(): Couldn't recieve the string from socket", self::ERR_STREAM);
			}
		}
		return $strBuffer;
	}
    // }}}
    // {{{ recvToPoint()	
	private function recvToPoint()
	{
		$strRes = "";
		while(true)
		{
			$strBuffer = $this->recvString();
            $strRes .= $strBuffer;
			if( strlen($strBuffer) == 3 && $strBuffer{0} == '.'  )
			{
				break;
			}
		}
		return $strRes;
	}
    // }}}
    // {{{ setSockTimeout()
    /**
     * @param array $arrTimeout  "sec" => seconds, "usec" => microseconds
     */
    private function setSockTimeout( $arrTimeout )
    {
        if( !is_array($arrTimeout) || !is_int($arrTimeout["sec"]) || !is_int($arrTimeout["usec"]) )
        {
            throw new POP3_Exception("Invalid Connection Timeout given", self::ERR_PARAMETER);
        }

   	    if( $this->bUseSockets )
	    {
            if( !@socket_set_option($this->resSocket,SOL_SOCKET, SO_RCVTIMEO, $arrTimeout)
                || !@socket_set_option($this->resSocket,SOL_SOCKET, SO_SNDTIMEO, $arrTimeout) )
            {
                throw new POP3_Exception("", POP3::ERR_SOCKETS);
            }
	    }
        else
        {
            if( !@stream_set_timeout($this->resSocket, $arrTimeout["sec"], $arrTimeout["usec"]) )
            {
                throw new POP3_Exception("stream_set_timeout(): Failed to set stream timeout", self::ERR_STREAM);
            }
        }
        $this->log("Set socket timeout to ". implode(".",$arrTimeout) ." secondes.");
    }
    // }}}
    // {{{ parseBanner()
    private function parseBanner( $strBuffer )
    {
        $intBufferLength = strlen($strBuffer);
        $bOpenTag = FALSE;
        for( $i=0; $i < $intBufferLength; $i++ )
        {
            if( $strBuffer{$i} === '>' )
            {
                break;
            }
            if( $bOpenTag )
            {
                $this->strAPOPBanner .= $strBuffer{$i};
                continue;
            }
            if( $strBuffer{$i} === '<' )
            {
                $bOpenTag = TRUE;
            }
        }
    }
    // }}}
    
    /**
     * // LOGGING FUNCTIONS
     */
    // {{{ openlog()
	private function openlog()
	{
		if( !$this->bLogOpened && !is_null($this->strLogFile) )
		{
			if( !$this->resLogFp = @fopen($this->strLogFile,"a+") )
			{
				throw new POP3_Exception("Couldn't open log file: ". $this->strLogFile, self::ERR_LOG);
			}
			$this->bLogOpened = TRUE;
		}
	}
    // }}}
    // {{{ closelog()
	private function closelog()
	{
		if( $this->bLogOpened )
		{
			@fclose($this->resLogFp);
			$this->bLogOpened = FALSE;
		}
	}
	// }}}
    // {{{ log()
	private function log( $str )
	{
    	if (defined('DEBUG_EMAIL') && DEBUG_EMAIL){
			if( $this->bLogOpened )
			{
			    $str = date("Y-m-d H:i:s") .": ". trim($str) . PHP_EOL;
				if( !@fwrite( $this->resLogFp, $str, strlen($str) ) )
				{
					return new POP3_Exception("Failed to write to log file. (" . trim($str) . ")", self::ERR_LOG);
				}
			}
		}
	}
    // }}}
}
// }}}
//////////////////////////////////////////////////////////////////////
//////////////////////// EXPERIMENTAL ////////////////////////////////
//////////////////////////////////////////////////////////////////////
// {{{ POP3_Message
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
// }}}
?>