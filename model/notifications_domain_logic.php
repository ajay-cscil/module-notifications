<?php
 /**
  *
  * write any custom code in this class, build operation wont overwrite this class once generated;
  */
  namespace module\notifications\model;
  class notifications_domain_logic extends \kernel\model{
	  
	public function beforeFind(){
            parent::beforeFind();
            if (!isset($this->query['where'])) {
                $this->query['where'] = [];
            }
            $this->query['where'][]=["notification_users.user_id"=>intval(\kernel\user::read('id')) ];
	}

	public function afterFind(&$data) {
		parent::afterFind($data);
        $notificationIDS=array_column($data["data"], "id");
        if($notificationIDS){
                update(["notified"=>1])
                ->from($this->notification_users)
                ->where(["user_id"=>\kernel\user::read("id"),"notification_id"=>$notificationIDS])
                ->execute();
        }
    }
	
	
	public function newNotificationCount(){
         $newNotification=select([
                            "count(1) as new_notification_count",
                            "SUM(IF(notified=1,0,1)) as new_alert_count"
                          ])
                        ->from($this)
                        ->join("notification_users")
                        ->where([
                            "notification_users.user_id"=>\kernel\user::read("id"),
                            "notification_users.last_viewed IS NULL"
                        ])
                        ->execute()
                        ->fetch(\PDO::FETCH_COLUMN,0);

        if(!is_array($newNotification)){
            $newNotification=["new_notification_count"=>0,"new_alert_count"=>0];
        }                    
        $newNotification=array_merge(["notification_count"=>0,"alert_count"=>0],$newNotification);
        return $newNotification;
    }

    public function afterSave($created){
            parent::afterSave($created);
            if($created){
		        $recipientUsers=[];
                if(isset($this->data["recipients"]) && is_string($this->data["recipients"])){
			         $this->data["recipients"]=json_decode($this->data["recipients"],true);
		        } 
                if(isset($this->data["recipients"]) && is_array($this->data["recipients"])){
                    foreach($this->data["recipients"] as $recipient){
                        if($recipient["related_to_model"] =="groups" && !empty($recipient["related_to"])  ){
                            $users=\select(['users.id'])
                            ->from(\module\access_controls\model\groups_users::getInstance())
                            ->join('users')
                            ->where([
                                'groups_users.group_id'=>$recipient["related_to"],
                                'users.is_active'=>1,
                                'users.deleted'=>0
                            ])
                            ->execute()
                            ->fetchAll(\PDO::FETCH_COLUMN,0);
                            if(is_array($users)){
                                $recipientUsers=array_merge($recipientUsers,$users);
                            }
                        }else if($recipient["related_to_model"] =="roles" && !empty($recipient["related_to"])  ){
                            $users=\select(['users.id'])
                            ->from(\module\access_controls\model\roles_users::getInstance())
                            ->join('users')
                            ->where([
                                'roles_users.role_id'=>$recipient["related_to"],
                                'users.is_active'=>1,
                                'users.deleted'=>0
                            ])
                            ->execute()
                            ->fetchAll(\PDO::FETCH_COLUMN,0);
                            if(is_array($users)){
                                $recipientUsers=array_merge($recipientUsers,$users);
                            }
                        }else if($recipient["related_to_model"] =="users" && !empty($recipient["related_to"])  ){
                            $users=\select(['users.id'])
                            ->from(\module\access_controls\model\users::getInstance())
                            ->where([
                                'users.id'=>$recipient["related_to"],
                                'users.is_active'=>1,
                                'users.deleted'=>0
                            ])
                            ->execute()
                            ->fetchAll(\PDO::FETCH_COLUMN,0);
                            if(is_array($users)){
                                $recipientUsers=array_merge($recipientUsers,$users);
                            }
                        }
                    }
                }
                $currentApplicationURL=\kernel\configuration::read('current_application_url');
                $currentApplicationURL=explode('://',$currentApplicationURL)[1];
                $currentApplicationURL=explode("/",$currentApplicationURL)[0];

                foreach($recipientUsers as $recipientUserID){
                    if(!empty($recipientUserID) && $recipientUserID > 0){
                        \module\notifications\model\notification_users::getInstance()
                        ->save(
                            [
                                "user_id"=>$recipientUserID,
                                "notification_id"=>$this->data[$this->primaryKey],
                                "last_viewed"=>null,
                                "notified"=>0
                            ],
                            ["validate"=>false]
                        );

                        $message=json_encode([
                                "url"=> $currentApplicationURL, 
                                "user_id"=> $recipientUserID, 
                                "notification"=> [
                                    "id"=>$this->data["id"],
                                    "message"=>$this->data["message"],
                                    "access_url"=>$this->data["access_url"]
                                ] 
                        ]);
                        \kernel\pubsub::getInstance()->publish("inapp_notifications",$message);
                    }
                }
            }
        }
  }
