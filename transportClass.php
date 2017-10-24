<?php

/**
 * Created by PhpStorm.
 * User: Zoe
 * Date: 4/2/2017
 * Time: 7:14 PM
 */
class transport
{

    private $transportID;
    private $captureRestraint;
    private $distanceLimits;
    private $howFarWillingSA;
    private $animalLimitsSA;
    private $notes;


    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getTransportID()
    {
        return $this->transportID;
    }

    /**
     * @param mixed $transportID
     */
    public function setTransportID($transportID)
    {
        $this->transportID = $transportID;
    }

    /**
     * @return mixed
     */
    public function getCaptureRestraint()
    {
        return $this->captureRestraint;
    }

    /**
     * @param mixed $captureRestraint
     */
    public function setCaptureRestraint($captureRestraint)
    {
        $this->captureRestraint = $captureRestraint;
    }

    /**
     * @return mixed
     */
    public function getDistanceLimits()
    {
        return $this->distanceLimits;
    }

    /**
     * @param mixed $distanceLimits
     */
    public function setDistanceLimits($distanceLimits)
    {
        $this->distanceLimits = $distanceLimits;
    }

    /**
     * @return mixed
     */
    public function getHowFarWillingSA()
    {
        return $this->howFarWillingSA;
    }

    /**
     * @param mixed $howFarWillingSA
     */
    public function setHowFarWillingSA($howFarWillingSA)
    {
        $this->howFarWillingSA = $howFarWillingSA;
    }

    /**
     * @return mixed
     */
    public function getAnimalLimitsSA()
    {
        return $this->animalLimitsSA;
    }

    /**
     * @param mixed $animalLimitsSA
     */
    public function setAnimalLimitsSA($animalLimitsSA)
    {
        $this->animalLimitsSA = $animalLimitsSA;
    }

    /**
     * @return mixed
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }



}