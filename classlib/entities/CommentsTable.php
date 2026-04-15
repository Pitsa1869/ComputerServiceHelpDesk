<?php
/**
* This file contains the commentsTable Class Template
* 
*/

 /**
 * 
 * The purpose of this commentsTable [template] class is to implement the table entity class for the 'commentsTable' table in the database. 
 * 
 * 
 * To use this TEMPLATE - change 'commentsTable' to the required table everywhere it appears 
 *  
 * eg: if you want to define a table entity class  for a database table called 'suppliers'
 * <ul>
 * <li>Rename this file - replace the 'commentsTable' with 'SupplierTable' in the file name </li>
 * <li>Rename class  - replace the 'commentsTable' with 'SupplierTable' as the class name </li>
 * <li>Edit this file to REPLACE 'XXX' in the class constructor with the table name 'supplier' [lower case]</li>
 * <li>Move this file to its correct folder in the project eg /classlib/entities/ </li> 
 * <li>Finally include this file in the index.php </li>
 * </ul>
 * 
 * 
 * 
 * @author Gerry Guinane
 * 
 */

class commentsTable extends TableEntity {

    /**
     * Constructor for the commentsTable Class
     * 
     * @param MySQLi $databaseConnection  The database connection object. 
     */
    function __construct($databaseConnection){
        parent::__construct($databaseConnection,'comment');  //the name of the table is passed to the parent constructor
    }
    //END METHOD: Construct
   
    
        /**
        * Performs a SELECT query to returns all records from the table where messages are TO the specified user or ALL users and NOT authored by the specified user 
        *
        * @param string $ticketID The ticket's unique ID
        * 
        * @return mixed Returns false on failure. For successful SELECT returns a mysqli_result object $rs
        */
    public function getCommentsByTicketID($ticketID)
    {
        $this->SQL = "SELECT c.dateTimeStamp as 'Date',c.userID as 'Author', ut.userTypeDescr as 'userType' ,c.contents as 'Comment' FROM comment c LEFT JOIN user u ON c.userID=u.userID RIGHT JOIN usertype ut ON u.userTypeNr = ut.userTypeNr WHERE ticketID='$ticketID' ORDER BY dateTimeStamp ASC";

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

            return false;  //return false to indicate that an error has occurred
        }
    }
    
    
    /**
    * Adds a new comment to the database
    *
    * @param string $ticketID The ticket's unique ID
    * @param string $userID The user ID of the current logged-in user
    * @param string $commentContent The comment text from the form
    * 
    * @return mixed Returns true on success. Returns false on failure
    */
    public function addComment($ticketID, $userID, $commentContent)
    {
        // Sanitize inputs to prevent SQL injection
        $ticketID = $this->db->real_escape_string($ticketID);
        $userID = $this->db->real_escape_string($userID);
        $commentContent = $this->db->real_escape_string($commentContent);
        
        // Create the INSERT query with current timestamp
        $this->SQL = "INSERT INTO comment (ticketID, userID, contents) 
                      VALUES ('$ticketID', '$userID', '$commentContent')";

        //execute the query using a try catch 
        try {
            $result = $this->db->query($this->SQL);  //execute the query

            if ($result) {
                return true;  //comment was successfully added
            } else {
                //the query has not executed successfully
                $this->MySQLiErrorNr = $this->db->errno;
                $this->MySQLiErrorMsg = $this->db->error;
                return false;
            }
        } catch (Exception $ex) {
            //an exception has occurred - get the details for diagnostic purposes
            $this->MySQLiErrorNr = $ex->getCode(); //get the exception number
            $this->MySQLiErrorMsg = $ex->getMessage(); //get the exception error message

            return false;  //return false to indicate that an error has occurred
        }
    }
    
}

