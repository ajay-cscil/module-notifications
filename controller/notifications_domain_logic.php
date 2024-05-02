<?php
 /**
  *
  * write any custom code in this class, build operation wont overwrite this class once generated;
  */
  namespace module\notifications\controller;
  class notifications_domain_logic extends \kernel\controller{

	public static function newNotificationCount(){
		return \module\notifications\model\notifications::getInstance()->newNotificationCount();
	}

	public function _mark_notification_as_read($request){
                $modelObj = $this->modelObj();
                $ids = $this->id($request);
                if (!is_array($ids)) {
                    $ids = [$ids];
                }
		$notificationUsersObject=\module\notifications\model\notification_users::getInstance();
		$notificationUsersIDS=\select(['id'])
                                    ->from($notificationUsersObject)
                                    ->where([
                                        'notification_id'=>$ids
                                    ])
                                    ->execute()
                                    ->fetchAll(\PDO::FETCH_COLUMN,0);
		foreach($notificationUsersIDS as $notificationUsersID){
 			update(["last_viewed"=>\kernel\locale::systemDatetime()])
                    	->from($notificationUsersObject)
                    	->where(["id"=>$notificationUsersID])
                    	->execute();
		}
                
		$data=$request->data;
                $data['notifications']['last_viewed']=\select(['notification_id'])
                                    ->from($notificationUsersObject)
                                    ->where([
                                        'notification_id'=>$ids,
                                        'last_viewed IS NOT NULL'
                                    ])
                                    ->execute()
                                    ->fetchAll(\PDO::FETCH_COLUMN,0);
		$request->set('data',$data);
		$request->set('unread_notification_count',$modelObj->newNotificationCount());
	}
        public function _mark_notification_as_delete($request){
                $modelObj = $this->modelObj();
                $ids = $this->id($request);
                if (!is_array($ids)) {
                    $ids = [$ids];
                }
                $notificationUsersObject=\module\notifications\model\notification_users::getInstance();
                $notificationUsersIDS=\select(['id'])
                                    ->from($notificationUsersObject)
                                    ->where([
                                        'notification_id'=>$ids
                                    ])
                                    ->execute()
                                    ->fetchAll(\PDO::FETCH_COLUMN,0);
                foreach($notificationUsersIDS as $notificationUsersID){
                    $notificationUsersObject->delete($notificationUsersID);
		}
		$request->set('unread_notification_count',$modelObj->newNotificationCount());
       }
  }
