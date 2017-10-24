<?php

/**
 * Created by PhpStorm.
 * User: Zoe
 * Date: 4/2/2017
 * Time: 7:08 PM
 */
class outreach
{

    private $outreachID;
    private $passionateIssuesSA;
    private $whyInterestedSA;
    private $publicSpeakingSA;
    private $whatDoYouBringSA;
    private $numShadows;
    private $shadowed1Date;
    private $shadowed2Date;
    private $shadowed3Date;
    private $intro;
    private $leadAlone;
    private $offsite;
    private $notes;


    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getOutreachID()
    {
        return $this->outreachID;
    }

    /**
     * @param mixed $outreachID
     */
    public function setOutreachID($outreachID)
    {
        $this->outreachID = $outreachID;
    }

    /**
     * @return mixed
     */
    public function getPassionateIssuesSA()
    {
        return $this->passionateIssuesSA;
    }

    /**
     * @param mixed $passionateIssuesSA
     */
    public function setPassionateIssuesSA($passionateIssuesSA)
    {
        $this->passionateIssuesSA = $passionateIssuesSA;
    }

    /**
     * @return mixed
     */
    public function getWhyInterestedSA()
    {
        return $this->whyInterestedSA;
    }

    /**
     * @param mixed $whyInterestedSA
     */
    public function setWhyInterestedSA($whyInterestedSA)
    {
        $this->whyInterestedSA = $whyInterestedSA;
    }

    /**
     * @return mixed
     */
    public function getPublicSpeakingSA()
    {
        return $this->publicSpeakingSA;
    }

    /**
     * @param mixed $publicSpeakingSA
     */
    public function setPublicSpeakingSA($publicSpeakingSA)
    {
        $this->publicSpeakingSA = $publicSpeakingSA;
    }

    /**
     * @return mixed
     */
    public function getWhatDoYouBringSA()
    {
        return $this->whatDoYouBringSA;
    }

    /**
     * @param mixed $whatDoYouBringSA
     */
    public function setWhatDoYouBringSA($whatDoYouBringSA)
    {
        $this->whatDoYouBringSA = $whatDoYouBringSA;
    }

    /**
     * @return mixed
     */
    public function getNumShadows()
    {
        return $this->numShadows;
    }

    /**
     * @param mixed $numShadows
     */
    public function setNumShadows($numShadows)
    {
        $this->numShadows = $numShadows;
    }

    /**
     * @return mixed
     */
    public function getShadowed1Date()
    {
        return $this->shadowed1Date;
    }

    /**
     * @param mixed $shadowed1Date
     */
    public function setShadowed1Date($shadowed1Date)
    {
        $this->shadowed1Date = $shadowed1Date;
    }

    /**
     * @return mixed
     */
    public function getShadowed2Date()
    {
        return $this->shadowed2Date;
    }

    /**
     * @param mixed $shadowed2Date
     */
    public function setShadowed2Date($shadowed2Date)
    {
        $this->shadowed2Date = $shadowed2Date;
    }

    /**
     * @return mixed
     */
    public function getShadowed3Date()
    {
        return $this->shadowed3Date;
    }

    /**
     * @param mixed $shadowed3Date
     */
    public function setShadowed3Date($shadowed3Date)
    {
        $this->shadowed3Date = $shadowed3Date;
    }

    /**
     * @return mixed
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @param mixed $intro
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    }

    /**
     * @return mixed
     */
    public function getLeadAlone()
    {
        return $this->leadAlone;
    }

    /**
     * @param mixed $leadAlone
     */
    public function setLeadAlone($leadAlone)
    {
        $this->leadAlone = $leadAlone;
    }

    /**
     * @return mixed
     */
    public function getOffsite()
    {
        return $this->offsite;
    }

    /**
     * @param mixed $offsite
     */
    public function setOffsite($offsite)
    {
        $this->offsite = $offsite;
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