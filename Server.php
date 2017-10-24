<?php

//Server class
class Server
{
    //Server properties
    private $serverIP;

    //Server constructor
    public function __construct()
    {

    }

    //Setter and Getter for serverIP
    public function getServerIP()
    {
        return $this->serverIP;
    }
    public function setServerIP($serverIP)
    {
        $this->serverIP = $serverIP;
    }

    //Function to get and set the local IP
    public function discoverIPAddress()
    {
        $localIP = $_SERVER['SERVER_ADDR'];
        $this->setServerIP($localIP);
    }

}