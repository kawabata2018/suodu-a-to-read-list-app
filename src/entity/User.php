<?php

class User { 
    private $userId;
    private $userName;
    private $password;
    private $profile;
    private $iconPath;
    private $createdAt;
    private $isProtected;
    private $deleteFlag;

    // constructor
    public function __construct($userId, $password){
        $this->userId = $userId;
        $this->password = $password;
    }

    // setters
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setUserName($userName){
        $this->$userName = $userName;
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
        return $userId;
    }
    public function getUserName(){
        return $userName;
    }
    public function getPassword(){
        return $password;
    }
    public function getProfile(){
        return $profile;
    }
    public function getIconPath(){
        return $iconPath;
    }
    public function getCreatedAt(){
        return $createdAt;
    }
    public function getIsProtected(){
        return $isProtected;
    }
    public function getDeleteFlag(){
        return $deleteFlag;
    }

}

?>