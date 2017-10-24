<?php
require_once ("SQLConnection.php");


class Person
{
    private $firstName;
    private $middleInitial;
    private $lastName;
    private $password;
    private $email;
    private $phone;
    private $houseNumber;
    private $street;
    private $cityCounty;
    private $stateAbb;
    private $countryAbb;
    private $zip;
    private $DOB;
    private $rabiesOwnCost;
    private $rabiesShot;
    private $rabiesDate;
    private $rehabilitationPermit;
    private $permitType;
    private $clocked;
    private $lastInDate;
    private $lastInTime;
    private $lastOutDate;
    private $lastOutTime;
    private $carpentrySkills;
    private $volunteerType;

    function __construct()
    {

    }

    public function clockTime($email,$miles, $date, $animal, $address)
    {
        $newSQL = new SQLConnection();
        $conn = new mysqli($newSQL->getServerName(), $newSQL->getUserName(), $newSQL->getPassword(), $newSQL->getDB());

        $sql = "select p.personid,clocked from person p inner join login l on p.personid = l.personid 
            where email='".$email."'";

        $result = $conn->query($sql);

        if ($result){
            while ($row = $result->fetch_assoc()){
                $personid = $row["personid"];
                $clocked = $row["clocked"]; //if person is clocked in or not (0 if not, 1 if they are)
            }
        }

        if ($clocked == 0){

            if ($miles !== ""){
                $insertMiles = "insert into miles (dateAdded,timeAdded,miles,personid) 
                  values (CURRENT_DATE,CURRENT_TIME,".$miles.",".$personid.")";
                $newSQL->sendQuery($insertMiles);
            }
            if ($date !== "update miles set dateAdded = ") {
                $query = "";
                $newSQL->sendQuery($query);
            }
            if ($animal !== "") {
                $query = "";
                $newSQL->sendQuery($query);
            }
            if ($address !== "") {
                $query = "";
                $newSQL->sendQuery($query);
            }
            $updatePersonIn = "update person set clocked = 1, lastinTime = CURRENT_TIME, lastinDate=CURRENT_DATE
              where personid=".$personid;
            $newSQL->sendQuery($updatePersonIn);
        }

        if ($clocked == 1){
            $updatePersonOut = "update person set clocked = 0, lastoutTime = CURRENT_TIME , lastinDate=CURRENT_DATE 
              where personid=".$personid;
            $newSQL->sendQuery($updatePersonOut);

            $getHours = "select concat(lastinDate, ' ', lastinTime) as clockedIn, current_timestamp as clockedOut from person 
                where personid = ".$personid;

            $result = $newSQL->getResult($getHours);

            if ($result){
                while ($row = $result->fetch_assoc()){
                    $clockedIn = strtotime($row["clockedIn"]);
                    $clockedOut = strtotime($row["clockedOut"]);
                }
                $diff = $clockedOut - $clockedIn;
                $hours = number_format(($diff / (60*60)),2);
            }

            $insertHours ="insert into hours (dateAdded,timeAdded,hours,personid)
              values (CURRENT_DATE,CURRENT_TIME,".$hours.",".$personid.")";

            $newSQL->sendQuery($insertHours);
            return $clocked;
        }
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getMiddleInitial()
    {
        return $this->middleInitial;
    }

    public function setMiddleInitial($middleInitial)
    {
        $this->middleInitial = $middleInitial;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getCityCounty()
    {
        return $this->cityCounty;
    }

    public function setCityCounty($cityCounty)
    {
        $this->cityCounty = $cityCounty;
    }

    public function getStateAbb()
    {
        return $this->stateAbb;
    }

    public function setStateAbb($stateAbb)
    {
        $this->stateAbb = $stateAbb;
    }

    public function getCountryAbb()
    {
        return $this->countryAbb;
    }

    public function setCountryAbb($countryAbb)
    {
        $this->countryAbb = $countryAbb;
    }

    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getDOB()
    {
        return $this->DOB;
    }

    /**
     * @param mixed $DOB
     */
    public function setDOB($DOB)
    {
        $this->DOB = $DOB;
    }

    /**
     * @return mixed
     */
    public function getRabiesOwnCost()
    {
        return $this->rabiesOwnCost;
    }

    /**
     * @param mixed $rabiesOwnCost
     */
    public function setRabiesOwnCost($rabiesOwnCost)
    {
        $this->rabiesOwnCost = $rabiesOwnCost;
    }

    /**
     * @return mixed
     */
    public function getRabiesShot()
    {
        return $this->rabiesShot;
    }

    /**
     * @param mixed $rabiesShot
     */
    public function setRabiesShot($rabiesShot)
    {
        $this->rabiesShot = $rabiesShot;
    }

    /**
     * @return mixed
     */
    public function getRabiesDate()
    {
        return $this->rabiesDate;
    }

    /**
     * @param mixed $rabiesDate
     */
    public function setRabiesDate($rabiesDate)
    {
        $this->rabiesDate = $rabiesDate;
    }

    /**
     * @return mixed
     */
    public function getRehabilitationPermit()
    {
        return $this->rehabilitationPermit;
    }

    /**
     * @param mixed $rehabilitationPermit
     */
    public function setRehabilitationPermit($rehabilitationPermit)
    {
        $this->rehabilitationPermit = $rehabilitationPermit;
    }

    /**
     * @return mixed
     */
    public function getPermitType()
    {
        return $this->permitType;
    }

    /**
     * @param mixed $permitType
     */
    public function setPermitType($permitType)
    {
        $this->permitType = $permitType;
    }

    /**
     * @return mixed
     */
    public function getClocked()
    {
        return $this->clocked;
    }

    /**
     * @param mixed $clocked
     */
    public function setClocked($clocked)
    {
        $this->clocked = $clocked;
    }

    /**
     * @return mixed
     */
    public function getLastInDate()
    {
        return $this->lastInDate;
    }

    /**
     * @param mixed $lastInDate
     */
    public function setLastInDate($lastInDate)
    {
        $this->lastInDate = $lastInDate;
    }

    /**
     * @return mixed
     */
    public function getLastInTime()
    {
        return $this->lastInTime;
    }

    /**
     * @param mixed $lastInTime
     */
    public function setLastInTime($lastInTime)
    {
        $this->lastInTime = $lastInTime;
    }

    /**
     * @return mixed
     */
    public function getLastOutDate()
    {
        return $this->lastOutDate;
    }

    /**
     * @param mixed $lastOutDate
     */
    public function setLastOutDate($lastOutDate)
    {
        $this->lastOutDate = $lastOutDate;
    }

    /**
     * @return mixed
     */
    public function getLastOutTime()
    {
        return $this->lastOutTime;
    }

    /**
     * @param mixed $lastOutTime
     */
    public function setLastOutTime($lastOutTime)
    {
        $this->lastOutTime = $lastOutTime;
    }

    /**
     * @return mixed
     */
    public function getCarpentrySkills()
    {
        return $this->carpentrySkills;
    }

    /**
     * @param mixed $carpentrySkills
     */
    public function setCarpentrySkills($carpentrySkills)
    {
        $this->carpentrySkills = $carpentrySkills;
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
?>