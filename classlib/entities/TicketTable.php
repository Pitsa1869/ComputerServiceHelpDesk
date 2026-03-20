<?php

/**
 * This file contains the ticketsTable Class
 * 
 */

/**
 * 
 * ticketsTable entity class implements the table entity class for the 'tickets' table in the database. 
 * 
 * @author Gerry Guinane
 * 
 */

class ticketsTable extends TableEntity
{

    /**
     * Constructor for the TableEntity Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection)
    {
        parent::__construct($databaseConnection, 'tickets');  //the name of the table is passed to the parent constructor
    }


   
    /**
     * Performs a SELECT query to returns all records from the table where messages are TO the specified user or ALL users and NOT authored by the specified user 
     *
     * @param string $userID The user's unique ID
     * 
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getUserMessages($userID)
    {
        $this->SQL = "SELECT ticketID as 'TicketID',dateTimeStamp as 'Date opened',topic as 'Description',status as 'Status' FROM tickets WHERE ticketAuthorID='$userID' AND status!='Closed'";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                if ($rs->num_rows >= 1) {  //this query should return 1 or more records
                    return $rs;  //the resultset can be returned as it contains ONLY one record
                } else {
                    //no records returned for this query 
                    return false;
                }
            } else {
                //the query has not executed successfully
                return false;
            }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr = $ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg = $ex->getMessage(); //get the exception error message
            return false;
        }
    }


    /**
     * Performs a SELECT query to returns all closed messages for the specified user
     *
     * @param string $userID The user's unique ID
     * 
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getUserClosedMessages($userID)
    {
        $this->SQL = "SELECT ticketID as 'TicketID',dateTimeStamp as 'Date opened',ticketAuthorID as 'Author',topic as 'Description',dateTimeClosed as 'Date closed' FROM tickets WHERE ticketAuthorID='$userID' AND status='Closed'";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                if ($rs->num_rows >= 1) {  //this query should return 1 or more records
                    return $rs;  //the resultset can be returned as it contains ONLY one record
                } else {
                    //no records returned for this query 
                    return false;
                }
            } else {
                //the query has not executed successfully
                return false;
            }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr = $ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg = $ex->getMessage(); //get the exception error message
            return false;
        }
    }


    /**
     * Inserts a new record in the table. 
     * 
     * @param array $postArray containing data to be inserted :-
     * <ul> 
     * <li>$postArray['message'] string Containing the message</li>
     * <li>$postArray['msgTo'] string Containing the ID of the message recipient or blank if message is to ALL</li>
     * </ul>
     * 
     * @param User $user The user object
     * 
     * @return boolean TRUE if message is added successfully , else FALSE
     * 
     * 
     */
    public function addRecord($postArray, $user)
    {

        //get the values entered in the registration form contained in the $postArray argument     
        extract($postArray);



        //user data
        $userID = $user->getUserID();

        // ticket data
        $topic = $postArray['topic'];
        $ticketText = $postArray['description'];    
        //Note - this function does not validate that the $msgTo user  ID is valid. 



        //construct the INSERT SQL
        $this->SQL = "INSERT INTO tickets (topic,ticketText,ticketAuthorID) VALUES ('$topic','$ticketText','$userID')";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                return true;
            } else {
                //the query has not executed successfully
                return false;
            }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr = $ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg = $ex->getMessage(); //get the exception error message
            return false;
        }
    }



       /**
     * Performs a SELECT query to returns record from the table which matches the specified ticketID
     *
     * @param string $ticketID The ticket's unique ID
     * 
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getTicketDetails($ticketID)
    {
        $this->SQL = "SELECT ticketID as 'TicketID',dateTimeStamp as 'Date opened',topic as 'Topic',ticketText as 'Description',status as 'Status' FROM tickets WHERE ticketID='$ticketID'";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                if ($rs->num_rows == 1) {  //this query should return 1 record
                    return $rs;  //the resultset can be returned as it contains ONLY one record
                } else {
                    //no records returned for this query 
                    return false;
                }
            } else {
                //the query has not executed successfully
                return false;
            }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr = $ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg = $ex->getMessage(); //get the exception error message
            return false;
        }
    }
}
