<?php
/**
 * No way! Middle class to API - FengOffice integration
 * @author ngunther<nicolas.gunther@gmail.com>
 */
class ApiController extends ApplicationController {

    private $response = NULL;

    /**
    * Constructor
    */  	
    public function __construct() {
        parent::__construct();
        $this->setLayout('empty');        
	}
    
    /**
    * Default action
    */    
    public function index ()
    {
        try{
            $request = $_REQUEST;    

            /*if(!$this->auth($_SESSION['fgmobile_code']))
                throw new Exception('Auth code error!')*/
            
            //Handle action
            $action = $request['m'];      
    
            if(method_exists($this, $action))
                $response = $this->$action($request);
            
            tpl_assign('response', $response);
            
        }catch (Exception $exception){
            throw $exception;
        }
    }
    
    private function auth ($hash)
    {
        return true;
    }

    /**
    * Read a object
    */
    private function get_object ($request)
    {
        try
        {
            $tasks = Objects::findObject($request['oid']);
            return $this->response('json', $tasks->getArrayInfo());
            
        }catch (Exception $exception){
            throw $exception;
        }
    }
    
    /**
    * Retrive list of objects
    *@params mixed options
    *@return object list
    *@throws Exception
    */
    private function listing ($request)
    {
        try
        {   
            $service = $request['srv'];
            $result = $service::getContentObjects(active_context(), ObjectTypes::findById($service::instance()->getObjectTypeId()), $order, $order_dir, null, null, false, false, $start, $limit);
            
            $temp_objects = array();
            foreach ($result->objects as $object)
                //print_r($object->getObjectName());
                array_push($temp_objects, $object->getArrayInfo());
                
            return $this->response('json', $temp_objects);
            
        }catch (Exception $exception){
            throw $exception;
        }
    }
    
    
    private function save_task ()
    {
        
    
    }
    
    private function delete_task ()
    {
        
    
    }    
    
    /**
    * Response formated API results
    *@param response type
    *@param response content
    *@return formated API result
    *@throws Exception
    */    
    private function response ($type = NULL, $response)
    {
        switch($type)
        {   
            case 'json':
                return json_encode($response);
            default:
                throw new Exception('Response type must be defined');
        }
    }
    
    
}