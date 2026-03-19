<?php
/**
* This file contains the CustomerTickets Class
* 
*/


/**
 * CustomerTickets is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for a <em><b>CUSTOMER user tickets</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * @author gerry.guinane
 * 
 */



class CustomerTickets extends PanelModel{

    /**
    * Constructor Method
    * 
    * The constructor for the PanelModel class. The ManageSystems class provides the 
    * panel content for up to 3 page panels.
    * 
    * @param User $user  The current user
    * @param MySQLi $db The database connection handle
    * @param Array $postArray Copy of the $_POST array
    * @param String $pageTitle The page Title
    * @param String $pageHead The Page Heading
    * @param String $pageID The currently selected Page ID
    */   
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='CustomerTickets';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 



    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        switch ($this->pageID) {

            case "tickets":
                $this->panelHead_1='<h3>Tickets</h3>';
                break;

            case "viewTickets":
                $this->panelHead_1='<h3>View my Tickets</h3>';
                break;
            case "createTicket":
                $this->panelHead_1='<h3>Create Ticket Form</h3>';
                break;
            case "closedTickets":
                $this->panelHead_1='<h3>Closed Tickets</h3>';
                break;
            default:
                $this->panelHead_1='<h3>Messages</h3>';
                break;
            }//end switch       
    }
    
    /**
    * Set the Panel 1 text content 
    */      
    public function setPanelContent_1(){
        switch ($this->pageID) {
            case "tickets":
                $this->panelContent_1='This is tickets sub-menu. Select an option from the top menu bar';
                break;

            case "viewTickets":
                $table=new ticketsTable($this->db);
                $rs=$table->getUserMessages($this->user->getUserID());
                $this->panelContent_1= HelperHTML::generateTABLE($rs);
                array_push($this->panelModelObjects,$table); #for diagnostic purposes
                break;

            case "closedTickets":
                $table=new ticketsTable($this->db);
                $rs=$table->getUserClosedMessages($this->user->getUserID());
                $this->panelContent_1= HelperHTML::generateTABLE($rs);
                array_push($this->panelModelObjects,$table); #for diagnostic purposes
                break;
            
            case "createTicket":
                {
                    $this->panelContent_1=Form::form_create_ticket($this->pageID);  
                    break;
                }
                break;
            default:
                $this->panelContent_1='Messages';
                break;            
            }//end switch  
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        switch ($this->pageID) {
            case "tickets":
                $this->panelHead_2='<h3>Messages</h3>';
                break;

            case "viewTickets":
                $this->panelHead_2='<h3>View Messages</h3>';
                break;
            case "createTicket":
                $this->panelHead_2='<h3>Instructions</h3>';
                break;
            case "closedTickets":
                $this->panelHead_2='<h3>Closed Messages</h3>';
                break;

            default:
                $this->panelHead_2='<h3>Messages</h3>';
                break;            
            }//end switch
    }   
    
    /**
    * Set the Panel 2 text content 
    */      
    public function setPanelContent_2(){
        switch ($this->pageID) {
            case "tickets":
                $this->panelContent_2='This tickets sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;

            case "viewTickets":
                $this->panelContent_2='View Messages';
                break;
            case "createTicket":
                {
                    if(isset($this->postArray['btnCreateTicket'])){
                        $table=new ticketsTable($this->db);
                        $result=$table->addRecord($this->postArray,$this->user);
                        if($result){
                            $this->panelContent_2='<h4 style="color:green">Your ticket has been created successfully</h4>';
                        }
                        else{
                            $this->panelContent_2='<h4 style="color:red">There was a problem creating your ticket. Please try again later.</h4>';
                        }
                    }
                    else{
                        $this->panelContent_2='Enter the topic and description for your ticket and click submit to create a new ticket. 
                        <br><br> A technician will respond to your ticket as soon as possible. You can view the status of your tickets by clicking the view menu option.';
                    }
                }
                break;
            case "closedTickets":
                $this->panelContent_2='Closed Messages';
                break;

            default:
                $this->panelContent_2='Messages';
                break;   
            }//end switch

    }        

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        switch ($this->pageID) {
            case "tickets":
                $this->panelHead_3='<h3>Messages</h3>';
                break;

            case "viewTickets":
                $this->panelHead_3='<h3>View Messages</h3>';
                break;
            case "createTicket":
                $this->panelHead_3='<h3>Create Ticket</h3>';
                break;
            case "closedTickets":
                $this->panelHead_3='<h3>Closed Messages</h3>';
                break;
            default:
                $this->panelHead_3='<h3>Messages</h3>';
                break;            
            }//end switch
    }
    
    /**
    * Set the Panel 3 text content 
    */      
    public function setPanelContent_3(){//set the panel 2 content
        switch ($this->pageID) {
            case "tickets":
                $this->panelContent_3='This tickets sub-menu illustrates a number of different implementations of messaging between users - including live chat which utilises AJAX';
                break;

            case "viewTickets":
                $this->panelContent_3='View Messages';
                break;
            case "createTicket":
                $this->panelContent_3='Create Ticket';
                break;
            case "closedTickets":
                $this->panelContent_3='Closed Messages';
                break;
            default:
                $this->panelContent_3='Messages';
                break;   
            }//end switch

    }    



        
}//end class
        