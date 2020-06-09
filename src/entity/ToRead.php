<?php

class ToRead { 
    private $toreadId;
    private $userId;
    private $isCompleted;       // boolean
    private $bookName;
    private $authorName;
    private $memo;
    private $colorTag;          // int
    private $totalPage;         // int
    private $currentPage;       // int
    private $completedOn;       // date
    private $targetDate;        // date
    private $createdAt;         // timestamp
    private $updatedAt;         // timestamp
    private $deleteFlag;        // boolean

    // constructor
    public function __construct(){
    }

    // setters
    public function setToreadId($toreadId){
        $this->toreadId = $toreadId;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setIsCompleted($isCompleted){
        $this->isCompleted = $isCompleted;
    }
    public function setBookName($bookName){
        $this->bookName = $bookName;
    }
    public function setAuthorName($authorName){
        $this->authorName = $authorName;
    }
    public function setMemo($memo){
        $this->memo = $memo;
    }
    public function setColorTag($colorTag){
        $this->colorTag = $colorTag;
    }
    public function setTotalPage($totalPage){
        $this->totalPage = $totalPage;
    }
    public function setCurrentPage($currentPage){
        $this->currentPage = $currentPage;
    }
    public function setCompletedOn($completedOn){
        $this->completedOn = $completedOn;
    }
    public function setTargetDate($targetDate){
        $this->targetDate = $targetDate;
    }
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt($updatedAt){
        $this->updatedAt = $updatedAt;
    }
    public function setDeleteFlag($deleteFlag){
        $this->deleteFlag = $deleteFlag;
    }

    // getters
    public function getToreadId(){
        return $this->toreadId;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getIsCompleted(){
        return $this->isCompleted;
    }
    public function getBookName(){
        return $this->bookName;
    }
    public function getAuthorName(){
        return $this->authorName;
    }
    public function getMemo(){
        return $this->memo;
    }
    public function getColorTag(){
        return $this->colorTag;
    }
    public function getTotalPage(){
        return $this->totalPage;
    }
    public function getCurrentPage(){
        return $this->currentPage;
    }
    public function getCompletedOn(){
        return $this->completedOn;
    }
    public function getTargetDate(){
        return $this->targetDate;
    }
    public function getCreatedAt(){
        return $this->createdAt;
    }
    public function getUpdatedAt(){
        return $this->updatedAt;
    }
    public function getDeleteFlag(){
        return $this->deleteFlag;
    }
    public function getProgressPct() {
        // return int (0-100)
        return floor(100 * $this->currentPage / $this->totalPage);
    }
    /**
     * method to get the days between target date and today
     * return non-negative integer
     */
    public function getDaysDiff() {
        $today = date('Y-m-d');
        $day1 = new DateTime($this->targetDate);
        $day2 = new DateTime($today);
        $diff = $day1->diff($day2);
        return $diff->days;
    }
    /**
     * method to get whether or not overdue
     * return true if overdue else false
     */
    public function getIsOverDue() {
        $today = date('Y-m-d');
        $day1 = new DateTime($this->targetDate);
        $day2 = new DateTime($today);
        return ($day1<$day2);
    }

}

?>