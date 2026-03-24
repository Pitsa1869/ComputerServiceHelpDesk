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
     * Generate a table of tickets with action buttons for each ticket
     * 
     * @param mysqli_result $resultSet The result set containing ticket data
     * @param string $pageID The current page ID
     * @return string HTML table with action buttons
     */
    public function generateUserTicketsTableWithButtons($resultSet) {
        $table='';  //start with an empty string
        $pageID = 'ticketDetails';
        if($resultSet == false){
            return 'Sorry - there is no data available matching your query at this time';
        }

        if($resultSet->num_rows === 0){
            return 'Sorry - there is no data available matching your query at this time';
        }
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            // Get the first field value and key from the row
            $firstValue = reset($row);
            $firstKey = key($row);
            
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>";
                }
                $table.=  '<th>Action</th>';
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $value){
                $table.=  "<td>$value</td>";
            }
            $table.=  '<td><a href="'.$_SERVER['PHP_SELF'].'?pageID='.$pageID.'&'.$firstKey.'='.$firstValue.'"><button class="btn btn-sm btn-primary" type="button">View</button></a></td>';
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        
        return $table;
    }

    /**
     * Generate a table of available tickets with action buttons for each ticket
     * 
     * @param mysqli_result $resultSet The result set containing ticket data
     * @return string HTML table with action buttons
     */
    public function generateAvailableTicketsTableWithButtons($resultSet) {
        $table='';  //start with an empty string
        $pageID = 'ticketDetails';
        if($resultSet == false){
            return 'Sorry - there is no data available at this time';
        }

        if($resultSet->num_rows === 0){
            return 'Sorry - there is no data available at this time';
        }
        
        //generate the HTML table
        $i=0;
        $resultSet->data_seek(0);  //point to the first row in the result set
        $table.= '<table class="table table-striped">';
        while ($row = $resultSet->fetch_assoc()) {  //fetch associative array
            // Get the first field value and key from the row
            $firstValue = reset($row);
            $firstKey = key($row);
            
            while ($i===0)  //trick to generate the HTML table headings
            {   $table.=  '<tr>';
                foreach($row as $key=>$value){
                    $table.=  "<th>$key</th>";
                }
                $table.=  '<th>Action</th>';
                $table.=  '</tr>';
                $i=1;  
            }

            $table.=  '<tr>';
            foreach($row as $value){
                $table.=  "<td>$value</td>";
            }
            $table.=  '<td><a href="'.$_SERVER['PHP_SELF'].'?pageID='.$pageID.'&'.$firstKey.'='.$firstValue.'"><button class="btn btn-sm btn-primary" type="button">View</button></a></td>';
            $table.=  '</tr>';
        }
        $table.=  '</table>';
        
        return $table;
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

    
    /**
     * Performs a SELECT query to return the status of a ticket by ticketID
     *
     * @param string $ticketID The ticket's unique ID
     * 
     * @return mixed Returns the status string on success, or false on failure
     */
    public function getTicketStatus($ticketID)
    {
        $this->SQL = "SELECT status FROM tickets WHERE ticketID='$ticketID'";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                if ($rs->num_rows == 1) {  //this query should return 1 record
                    $row = $rs->fetch_assoc();
                    return $row['status'];  //return the status value
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
     * Performs a SELECT query to return all available tickets for the technician to view and assign
     *
     * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
     */
    public function getAvailableTickets($userID)
    {
        $this->SQL = "SELECT ticketID as 'Ticket ID', topic as 'Topic', status as 'Status' from tickets WHERE assignedTechnicianID IS NULL OR assignedTechnicianID = ''";

        //execute the query using a try catch 
        try {
            $rs = $this->db->query($this->SQL);  //execute the query

            if ($rs) {
                if ($rs->num_rows >= 1) {  //this query should return 1 record
                    return $rs;
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
     * Performs a SELECT query to return the author ID of a ticket by ticketID
     *
     * @param string $ticketID The ticket's unique ID
     * 
     * @return mixed Returns the author ID string on success, or false on failure
     */
    public function getTicketAuthorID($ticketID)
    {
        $this->SQL = "SELECT ticketAuthorID FROM tickets WHERE ticketID='$ticketID'";
        $rs = $this->db->query($this->SQL);
        try {
        if ($rs) {
            if ($rs->num_rows >= 1) {  //this query should return 1 record
                return $rs->fetch_assoc()['ticketAuthorID'];
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
     * Performs a SELECT query to return the assigned technician ID of a ticket by ticketID
     *
     * @param string $ticketID The ticket's unique ID
     * 
     * @return mixed Returns the assigned technician ID string on success, or false on failure
     */
    public function getAssignedTechnicianID($ticketID)
    {
        $this->SQL = "SELECT assignedTechnicianID FROM tickets WHERE ticketID='$ticketID'";
        $rs = $this->db->query($this->SQL);
        try {
        if ($rs) {
            if ($rs->num_rows >= 1) {  //this query should return 1 record
                return $rs->fetch_assoc()['assignedTechnicianID'];
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
     * Update the assigned technician for a ticket
     *
     * @param string $ticketID The ticket's unique ID
     * @param string $technicianID The technician's unique ID to be assigned to the ticket
     * 
     * @return boolean Returns true on successful update, or false on failure
     */
    public function assignTechnicianToTicket($ticketID, $assignedTechnicianID)
    {
        $this->SQL = "UPDATE tickets SET assignedTechnicianID='$assignedTechnicianID' WHERE ticketID='$ticketID'";
        $rs = $this->db->query($this->SQL);
        try{
        if ($rs) {
            if ($this->db->affected_rows == 1) {  //this query should affect 1 record
                return true;
            } else {
                //no records updated for this query 
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