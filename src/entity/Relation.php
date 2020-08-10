<?php

class Relation { 
    private $relationId;
    private $userId;
    private $followingId;
    private $status;            // int (0: default, 1: blocked , 2: pending)
    private $relatedAt;         // timestamp

    // constructor
    public function __construct(){
    }

    // setters
    public function setRelationId($relationId){
        $this->relationId = $relationId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setfollowingId($followingId){
        $this->followingId = $followingId;
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setRelatedAt($relatedAt){
        $this->relatedAt = $relatedAt;
    }

    // getters
    public function getRelationId(){
        return $this->relationId;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getFollowingId(){
        return $this->followingId;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getRelatedAt(){
        return $this->relatedAt;
    }

}

?>