<?php
/**
* This file contains the TechnicianTickets Class
* 
*/


/**
 * TechnicianTickets is an extended PanelModel Class
 * 
 * The purpose of this class is to generate HTML view panel headings and template content
 * for an <em><b>UNDER CONSTRUCTION</b></em>  page.  The content generated is intended for 3 panel
 * view layouts. 
 * 
 * This class is intended as a PLACEHOLDER during Development - Use the XXXPanelContent class to implement 
 * its replacement. 
 *
 * @author gerry.guinane
 * 
 */

class AdminTickets extends PanelModel {
  
    /**
    * Constructor Method
    * 
    * The constructor for the PanelModel class. The TechnicianTickets class provides the 
    * panel content for up to 3 page panels.
    * 
    * @param User $user  The current user
    * @param MySQLi $db The database connection handle
    * @param Array $postArray Copy of the $_POST array
    * @param String $pageTitle The page Title
    * @param String $pageHead The Page Heading
    * @param String $pageID The currently selected Page ID
    * 
    */  
    function __construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID){  
        $this->modelType='TechnicianTickets';
        parent::__construct($user,$db,$postArray,$pageTitle,$pageHead,$pageID);
    } 

    
    /**
     * Set the Panel 1 heading 
     */
    public function setPanelHead_1(){
        
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_1='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_1='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_1='<h3>Menu Item</h3>';
                break;
            }//end switch   
        
    }
    
    /**
    * Set the Panel 1 text content 
    */ 
    public function setPanelContent_1(){
        
        switch ($this->pageID) {
            case "tickets":  //sample menu item handler
                $this->panelContent_1='This is tickets sub-menu. Select an option from the top menu bar';
                break;
            case "allTickets":  //sample menu item handler
                $table=new ticketsTable($this->db);
                $rs=$table->getAllTickets();
                $this->panelContent_1= $table->generateAvailableTicketsTableWithButtons($rs);
                array_push($this->panelModelObjects,$table); #for diagnostic purposes
                break;
            case "ticketsByCustomer":  //sample menu item handler
                $this->panelContent_1=Form::form_ticketsByCustomer($this->pageID);
                break;
                array_push($this->panelModelObjects); #for diagnostic purposes
                break;
            case "ticketsByTechnician":  //sample menu item handler
                $this->panelContent_1=Form::form_ticketsByTechnician($this->pageID);
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_1="Panel 1 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            }//end switch   
        
    }        

    /**
     * Set the Panel 2 heading 
     */
    public function setPanelHead_2(){ 
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_2='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_2='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_2='<h3>Menu Item</h3>';
                break;
            }//end switch   
    }  
    
    
    /**
    * Set the Panel 2 text content 
    */ 
    public function setPanelContent_2(){
        switch ($this->pageID) {
            case "ticketsByCustomer":  //sample menu item handler
                if(isset($_POST['btnViewTicketsByCustomer']) && !empty($_POST['customerID']))
                {
                    $table=new ticketsTable($this->db);
                    $rs=$table->getTicketsByCustomer($_POST['customerID']);
                    $this->panelContent_2= $table->generateAvailableTicketsTableWithButtons($rs);
                    array_push($this->panelModelObjects,$table); #for diagnostic purposes
                }
                else {
                    $this->panelContent_2 = "Please select a customer to view their tickets.";
                }
                break;
            case "ticketsByTechnician":  //sample menu item handler
                if(isset($_POST['btnViewTicketsByTechnician']) && !empty($_POST['technicianID']))
                {
                    $table=new ticketsTable($this->db);
                    $rs=$table->getTicketsByTechnician($_POST['technicianID']);
                    $this->panelContent_2= $table->generateAvailableTicketsTableWithButtons($rs);
                    array_push($this->panelModelObjects,$table); #for diagnostic purposes
                }
                else {
                    $this->panelContent_2 = "Please select a technician to view their tickets.";
                }
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_2="Panel 2 content for \$pageID <b>DEFAULT</b> menu item is under construction.";
                break;
            }//end switch   
    }

    /**
     * Set the Panel 3 heading 
     */
    public function setPanelHead_3(){ 
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelHead_3='<h3>Menu Item 1</h3>';
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelHead_3='<h3>Menu Item 2</h3>';
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelHead_3='<h3>Menu Item</h3>';
                break;
            }//end switch   
    } 
    
    /**
    * Set the Panel 3 text content 
    */ 
    public function setPanelContent_3(){
        switch ($this->pageID) {
            case "menuItem1":  //sample menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            case "menuItem2":  //sample menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>$this->pageID</b> menu item is under construction.";
                break;
            default:  //sample DEFAULT menu item handler
                $this->panelContent_3="Panel 3 content for \$pageID <b>DEFAULT</b> menu item is under construction.";
                break;
            }//end switch   
    }        

        
}
        