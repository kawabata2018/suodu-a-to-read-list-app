<?php

class User { 
    private $userId;
    private $userName;
    private $password;
    private $profile;
    private $iconPath;
    private $createdAt;         // timestamp
    private $isProtected;       // boolean
    private $deleteFlag;        // boolean

    // constructor
    public function __construct(){
    }
    public function __constructIP($userId, $password){
        $this->userId = $userId;
        $this->password = $password;
    }

    // setters
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setUserName($userName){
        $this->userName = $userName;
    }
    public function setPassword($password){
        $this->password = $password;
    }
    public function setProfile($profile){
        $this->profile = $profile;
    }
    public function setIconPath($iconPath){
        $this->iconPath = $iconPath;
    }
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
    public function setIsProtected($isProtected){
        $this->isProtected = $isProtected;
    }
    public function setDeleteFlag($deleteFlag){
        $this->deleteFlag = $deleteFlag;
    }

    // getters
    public function getUserId(){
        return $this->userId;
    }
    public function getUserName(){
        return $this->userName;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getProfile(){
        return $this->profile;
    }
    public function getIconPath(){
        return $this->iconPath;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getIsProtected(){
        return $this->isProtected;
    }
    public function getDeleteFlag(){
        return $this->deleteFlag;
    }

}

?>