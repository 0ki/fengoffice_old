<?php    
    $options = explode(",",user_config_option("filters_dashboard"));
    
    $activities =  ApplicationLogs::getLastActivities();
    $limit = $options[2];
    $acts = array();
    $acts['data'] = array();
    foreach($activities as $activity){
        $user = Contacts::findById($activity->getCreatedById());
        $object = Objects::findObject($activity->getRelObjectId());
        
        if($object){
            $key = $activity->getRelObjectId() . "-" . $activity->getCreatedById();

            if(count($acts['data']) < ($limit*2)){
                if(!array_key_exists($key, $acts['data'])){
                    $acts['data'][$key] = $object;
                    $acts['created_by'][$key] = $user;
                    $acts['act_data'][$key] = $activity->getActivityDataView($user,$object);
                    $acts['date'][$key] = $activity->getCreatedOn() instanceof DateTimeValue ? friendly_date($activity->getCreatedOn()) : lang('n/a');
                }else{
                    $acts['data'][$key] = $object;
                    $acts['created_by'][$key] = $user;
                    $acts['act_data'][$key] = $activity->getActivityDataView($user,$object,true);
                    $acts['date'][$key] = $activity->getCreatedOn() instanceof DateTimeValue ? friendly_date($activity->getCreatedOn()) : lang('n/a');
                }            
            }else{
                break;
            }        
        }
    }
    
    $total = $limit ;
    $genid = gen_id();
    if (count($acts['data']) > 0) {
            include_once 'template.php';
    }
?>