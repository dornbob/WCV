<?php
require_once ("SQLConnection.php");
/**
 * Created by PhpStorm.
 * User: Timothy Shenk
 * Date: 4/3/2017
 * Time: 1:29 PM
 */
class Document
{
    private $documentID;
    private $personID;
    private $docName;
    private $docType;
    private $fileName;
    private $fileLocation;
    private $appType;
    private $dateAdded;

    function __construct(){

    }

    /**
     * @return mixed
     */
    public function getDocumentID()
    {
        return $this->documentID;
    }

    /**
     * @param mixed $documentID
     */
    public function setDocumentID($documentID)
    {
        $this->documentID = $documentID;
    }

    /**
     * @return mixed
     */
    public function getPersonID()
    {
        return $this->personID;
    }

    /**
     * @param mixed $personID
     */
    public function setPersonID($personID)
    {
        $this->personID = $personID;
    }

    /**
     * @return mixed
     */
    public function getDocName()
    {
        return $this->docName;
    }

    /**
     * @param mixed $docName
     */
    public function setDocName($docName)
    {
        $this->docName = $docName;
    }

    /**
     * @return mixed
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * @param mixed $docType
     */
    public function setDocType($docType)
    {
        $this->docType = $docType;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getFileLocation()
    {
        return $this->fileLocation;
    }

    /**
     * @param mixed $fileLocation
     */
    public function setFileLocation($fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    /**
     * @return mixed
     */
    public function getAppType()
    {
        return $this->appType;
    }

    /**
     * @param mixed $appType
     */
    public function setAppType($appType)
    {
        $this->appType = $appType;
    }

    /**
     * @return mixed
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param mixed $dateAdded
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;
    }

    public function uploadDocument($personid,$document,$docType,$department){
        // ex($_Session["personid"],input "name",rabies document, na)
        $newSQL = new SQLConnection();
        $fileType = $docType; //resume,cover letter, rabies document, and other are valid options
        $appType = $department; //Animal Care,outreach,transport,treatment,na are valid options
        echo $fileType . "</br>";
        echo $appType . "</br>";
        $target_dir = "documents/";
        $extension = strtolower(pathinfo($_FILES[$document]["name"],PATHINFO_EXTENSION));

        $query = "select max(documentID) as 'maxid' from documents";
        $newSQL->sendQuery($query);
        $result = $newSQL->getResult($query);
        $documentID = 0;

        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $documentID = $row["maxid"] + 1;
            }
        }

        $query = "select concat(firstname, ' ', lastname) as 'name' from person where personid = " . $personid;
        $newSQL->sendQuery($query);
        $result = $newSQL->getResult($query);
        $personName = "person";
        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $personName = $row["name"];
            }
        }

        $query = "select count(*) as 'count' from documents d inner join person p on d.personid = p.personid where p.personid = " . $personid;
        $newSQL->sendQuery($query);
        $result = $newSQL->getResult($query);
        $docCount = 12;
        if ($result) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $docCount = $row["count"];
            }
        }

        $fileName = $personName . " - " . $fileType . " - " . $documentID . "." . $extension;
        $target_file = $target_dir . $fileName;

        $uploadOk = 1;
        //only allow 10 document uploads
        if ($docCount >= 11) {
            echo "maximum of 10 documents already uploaded" . "</br>";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES[$document]["size"] > 20000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats

        $allowedExts = array("pdf", "doc", "docx", "txt");
        if (($_FILES[$document]["type"] == "text/plain") ||
            ($_FILES[$document]["type"] == "application/pdf") ||
            ($_FILES[$document]["type"] == "application/msword") ||
            ($_FILES[$document]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") &&
            in_array($extension, $allowedExts)){
        }
        else {
            $uploadOk = 0;
            //echo "Upload is not a text, pdf, or word file. ";
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES[$document]["tmp_name"], $target_file)) {
                //echo "The file " . basename($_FILES[$document]["name"]) . " has been uploaded.";

                $todayDate = date("Y-m-d");
                $query = "insert into documents values (null, " . $personid . ", '" . $fileType . "', '"
                    . $extension . "', '" . $fileName . "', '" . $target_file . "', '" . $appType . "', '" .  $todayDate . "')";
                //echo "<br>" . $query;
                $newSQL->sendQuery($query);

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }



}