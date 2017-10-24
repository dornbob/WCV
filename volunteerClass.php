<?php

/**
 * Created by PhpStorm.
 * User: Zoe
 * Date: 3/24/2017
 * Time: 8:22 PM
 */
class volunteer
{

    private $appStatus;
    private $lastIn;
    private $lastOut;
    private $volunteerType;

    function __construct(){
        $this->setAppStatus('Pending');
        $this->setLastIn(null);
        $this->setLastOut(null);
        $this->setVolunteerType('');
    }

    /**
     * @return mixed
     */
    public function getAppStatus()
    {
        return $this->appStatus;
    }

    /**
     * @param mixed $appStatus
     */
    public function setAppStatus($appStatus)
    {
        $this->appStatus = $appStatus;
    }

    /**
     * @return mixed
     */
    public function getLastIn()
    {
        return $this->lastIn;
    }

    /**
     * @param mixed $lastIn
     */
    public function setLastIn($lastIn)
    {
        $this->lastIn = $lastIn;
    }

    /**
     * @return mixed
     */
    public function getLastOut()
    {
        return $this->lastOut;
    }

    /**
     * @param mixed $lastOut
     */
    public function setLastOut($lastOut)
    {
        $this->lastOut = $lastOut;
    }

    /**
     * @return mixed
     */
    public function getVolunteerType()
    {
        return $this->volunteerType;
    }

    /**
     * @param mixed $volunteerType
     */
    public function setVolunteerType($volunteerType)
    {
        $this->volunteerType = $volunteerType;
    }



}