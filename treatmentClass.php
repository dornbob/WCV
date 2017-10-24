<?php

/**
 * Created by PhpStorm.
 * User: Zoe
 * Date: 4/2/2017
 * Time: 6:57 PM
 */
class treatment
{

    private $treatmentID;
    private $interestsHobbies;
    private $smMam;
    private $lrgMam;
    private $RVS;
    private $eagle;
    private $smRaptor;
    private $lrgRaptor;
    private $reptile;
    private $vet;
    private $tech;
    private $vetStudent;
    private $techStudent;
    private $vetAssistant;
    private $medicating;
    private $bandaging;
    private $woundCare;
    private $diag;
    private $anesthesia;
    private $notes;

    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getTreatmentID()
    {
        return $this->treatmentID;
    }

    /**
     * @param mixed $treatmentID
     */
    public function setTreatmentID($treatmentID)
    {
        $this->treatmentID = $treatmentID;
    }

    /**
     * @return mixed
     */
    public function getInterestsHobbies()
    {
        return $this->interestsHobbies;
    }

    /**
     * @param mixed $interestsHobbies
     */
    public function setInterestsHobbies($interestsHobbies)
    {
        $this->interestsHobbies = $interestsHobbies;
    }

    /**
     * @return mixed
     */
    public function getSmMam()
    {
        return $this->smMam;
    }

    /**
     * @param mixed $smMam
     */
    public function setSmMam($smMam)
    {
        $this->smMam = $smMam;
    }

    /**
     * @return mixed
     */
    public function getLrgMam()
    {
        return $this->lrgMam;
    }

    /**
     * @param mixed $lrgMam
     */
    public function setLrgMam($lrgMam)
    {
        $this->lrgMam = $lrgMam;
    }

    /**
     * @return mixed
     */
    public function getRVS()
    {
        return $this->RVS;
    }

    /**
     * @param mixed $RVS
     */
    public function setRVS($RVS)
    {
        $this->RVS = $RVS;
    }

    /**
     * @return mixed
     */
    public function getEagle()
    {
        return $this->eagle;
    }

    /**
     * @param mixed $eagle
     */
    public function setEagle($eagle)
    {
        $this->eagle = $eagle;
    }

    /**
     * @return mixed
     */
    public function getSmRaptor()
    {
        return $this->smRaptor;
    }

    /**
     * @param mixed $smRaptor
     */
    public function setSmRaptor($smRaptor)
    {
        $this->smRaptor = $smRaptor;
    }

    /**
     * @return mixed
     */
    public function getLrgRaptor()
    {
        return $this->lrgRaptor;
    }

    /**
     * @param mixed $lrgRaptor
     */
    public function setLrgRaptor($lrgRaptor)
    {
        $this->lrgRaptor = $lrgRaptor;
    }

    /**
     * @return mixed
     */
    public function getReptile()
    {
        return $this->reptile;
    }

    /**
     * @param mixed $reptile
     */
    public function setReptile($reptile)
    {
        $this->reptile = $reptile;
    }

    /**
     * @return mixed
     */
    public function getVet()
    {
        return $this->vet;
    }

    /**
     * @param mixed $vet
     */
    public function setVet($vet)
    {
        $this->vet = $vet;
    }

    /**
     * @return mixed
     */
    public function getTech()
    {
        return $this->tech;
    }

    /**
     * @param mixed $tech
     */
    public function setTech($tech)
    {
        $this->tech = $tech;
    }

    /**
     * @return mixed
     */
    public function getVetStudent()
    {
        return $this->vetStudent;
    }

    /**
     * @param mixed $vetStudent
     */
    public function setVetStudent($vetStudent)
    {
        $this->vetStudent = $vetStudent;
    }

    /**
     * @return mixed
     */
    public function getTechStudent()
    {
        return $this->techStudent;
    }

    /**
     * @param mixed $techStudent
     */
    public function setTechStudent($techStudent)
    {
        $this->techStudent = $techStudent;
    }

    /**
     * @return mixed
     */
    public function getVetAssistant()
    {
        return $this->vetAssistant;
    }

    /**
     * @param mixed $vetAssistant
     */
    public function setVetAssistant($vetAssistant)
    {
        $this->vetAssistant = $vetAssistant;
    }

    /**
     * @return mixed
     */
    public function getMedicating()
    {
        return $this->medicating;
    }

    /**
     * @param mixed $medicating
     */
    public function setMedicating($medicating)
    {
        $this->medicating = $medicating;
    }

    /**
     * @return mixed
     */
    public function getBandaging()
    {
        return $this->bandaging;
    }

    /**
     * @param mixed $bandaging
     */
    public function setBandaging($bandaging)
    {
        $this->bandaging = $bandaging;
    }

    /**
     * @return mixed
     */
    public function getWoundCare()
    {
        return $this->woundCare;
    }

    /**
     * @param mixed $woundCare
     */
    public function setWoundCare($woundCare)
    {
        $this->woundCare = $woundCare;
    }

    /**
     * @return mixed
     */
    public function getDiag()
    {
        return $this->diag;
    }

    /**
     * @param mixed $diag
     */
    public function setDiag($diag)
    {
        $this->diag = $diag;
    }

    /**
     * @return mixed
     */
    public function getAnesthesia()
    {
        return $this->anesthesia;
    }

    /**
     * @param mixed $anesthesia
     */
    public function setAnesthesia($anesthesia)
    {
        $this->anesthesia = $anesthesia;
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