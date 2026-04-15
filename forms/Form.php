<?php
/**
* This file contains the Form Class
* 
*/

/**
 * 
 * Form class - is a helper class that generates HTML forms  
 * 
 *  
 * @author Gerry Guinane
 * 
 */

class Form {


/**
 * Generates a HTML user select form 
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */    
public static function form_select_user($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">User ID (email)</label><input required type="text" class="form-control" id="userID" name="userID" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnUserSelect">Select</button>';
        $form.='</form>';
        return $form;
}    
    
    
    
/**
 * Generates a HTML login form 
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */    
public static function form_login($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">ID (email)</label><input required type="text" class="form-control" id="userID" name="userID" >';
        $form.='<label for="password">Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnLogin">Login</button>';
        $form.='</form>';
        return $form;
}    

/**
 * Generates a HTML password change form
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_password_change($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="pass1">Enter New Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enter New Password</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='<label for="password">Enter OLD Password</label><input required type="password" class="form-control" id="password" name="password" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnChangePW">Change Password</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdatePW" value="updatePWCancel">Cancel</button>';
        $form.='</form>';
        return $form;
} 

/**
 * 
 * Generates a HTML form for editing account details. 
 * 
 * The form generated will display but does not permit editing of the users ID.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param mysqli_result $userRecord Resultset containing the current user details from the database  user table 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_edit_account($countyTable,$userRecord, $pageID){
        $userRecordArray=$userRecord->fetch_assoc();
        extract($userRecordArray); //makes constructing the form a little easier
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
       
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control"  value="'.$FirstName.'" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control"   value="'.$LastName.'" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';
        
        //hidden DEFAULT input values for user type and login enabled
        $form.= '<input type="hidden" id="userTypeNr" name="userTypeNr" value="'.$userTypeNr.'">'; //default user type is customer
        $form.= '<input type="hidden" id="userEnabled" name="userEnabled" value="1">'; //default enabled to login is true        
        
        $form.='<label for="email">email (not editable)</label><input required readonly type="text" class="form-control" value="'.$email.'" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';

        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateAccount" value="update">Update</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdateAccount" value="update">Cancel Update</button>';
        $form.='</form>';
        
        return $form;
    }


/**
 * 
 * Generates a HTML form for editing account details. 
 * 
 * The form generated will display but does not permit editing of the users ID.  
 * 
 * @param CountyTable $countyTable A county table entity object.
 * @param UserTypeTable $userTypeTable A county table entity object.
 * @param mysqli_result $userRecord Resultset containing the current user details from the database  user table 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_administrator_edit_account($countyTable,$userTypeTable,$userRecord, $pageID){
    
    
        $userTypeList=array();
        if($rs=$userTypeTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $userTypeList[$row['userTypeNr']]=$row['userTypeDescr'];   //build an array of user types
            }
        } 
        
        
        $userRecordArray=$userRecord->fetch_assoc();
        extract($userRecordArray); 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="userID">User ID (not editable)</label><input required readonly type="text" class="form-control"   value="'.$userID.'" id="userID" name="userID" >';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control"  value="'.$FirstName.'" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control"   value="'.$LastName.'" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        $form.='<label for="userTypeNr">Select Usertype</label>';
        $form.='<select class="form-control" id="userTypeNr" name="userTypeNr">';
              $form.= '<option value="'.$userTypeNr.'" selected>'.$userTypeDescr.'</option>';
          foreach($userTypeList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';


        $form.='<label for="userEnabled">Enable/Disable User Access</label>';
        $form.='<select class="form-control" id="userEnabled" name="userEnabled">';
              if($userEnabled){
                  $form.= '<option value="1">LOGIN ENABLED</option>';  
                  $form.= '<option value="0">DISABLE LOGIN</option>'; 
              }
              else{
                  $form.= '<option value="0">LOGIN NOT ENABLED</option>';  
                  $form.= '<option value="1">ENABLE LOGIN</option>'; 
              }
        $form.='</select>';
        

        $form.='<label for="email">email (not editable)</label><input required readonly type="text" class="form-control" value="'.$email.'" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" value="'.$mobile.'" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';

        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnUpdateAccount" value="update">Update</button>';
        $form.='<button type="submit" class="btn btn-default" name="btnCancelUpdateAccount" value="update">Cancel Update</button>';
        $form.='</form>';
        
        return $form;
    }

    
    
/**
 * Generates a HTML form for registering a new  account.  It is intended for administrator use
 * 
 * The form generated will display a drop down list/chooser of user types.  
 * 
 * @param UserTypeTable $userTypeTable A user type table entity object.
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_register($countyTable,$userTypeTable, $pageID){
        $userTypeList=array();
        if($rs=$userTypeTable->getAllRecords()){
            while ($row = $rs->fetch_assoc()){
                $userTypeList[$row['userTypeNr']]=$row['userTypeDescr'];   //build an array of user types
            }
        } 
        
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        $form.='<label for="userTypeNr">Select Usertype</label>';
        $form.='<select class="form-control" id="userTypeNr" name="userTypeNr">';
              $form.= '<option value="99" selected>Select a User Type</option>';
          foreach($userTypeList as $key=>$value){
              $form.= '<option value="'.$key.'">'.$value.'</option>';  
          }
        $form.='</select>';

        $form.='<label for="userEnabled">Enable/Disable User Access</label>';
        $form.='<select class="form-control" id="userEnabled" name="userEnabled">';
                  $form.= '<option value="1" selected>LOGIN ENABLED(DEFAULT)</option>';  
                  $form.= '<option value="0">LOGIN NOT ENABLED </option>';  
                  $form.= '<option value="1">ENABLE LOGIN</option>'; 
        $form.='</select>';

        $form.='<label for="email">email (this will be your user ID) </label><input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';
        $form.='<label for="pass1">Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enterPassword</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnRegister" value="registerUser">Register</button>';
        $form.='</form>';
        
        return $form;
    }
    

  
/**
 * Generates a HTML form for registering a new  account.  It is intended for CUSTOMER use
 * 
 * The form generated will display default hidden values.
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form.
 * @return string String containing the generated form.
 */
public static function form_register_customer($countyTable,$pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="firstName">First Name</label><input required type="text" class="form-control" id="firstName" name="firstName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="First Name (up to 45 Characters)">';
        $form.='<label for="lastName">Last Name</label><input required type="text" class="form-control" id="lastName" name="lastName" pattern="[a-zA-Z0-9óáéí\']{1,45}" title="Last Name (up to 45 Characters)" >';

        //hidden DEFAULT input values for user type and login enabled
        $form.= '<input type="hidden" id="userTypeNr" name="userTypeNr" value="3">'; //default user type is customer
        $form.= '<input type="hidden" id="userEnabled" name="userEnabled" value="1">'; //default enabled to login is true


        $form.='<label for="email">email (this will be your user ID) </label><input type="text" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9@.]{1,45}" title="enter a valid email" >';
        $form.='<label for="mobile">mobile</label><input type="text" class="form-control" id="mobile" name="mobile" pattern="[0-9()+-\']{7,20}" title="enter a valid phone number" >';
        $form.='<label for="pass1">Password</label><input required type="password" class="form-control" id="pass1" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">';
        $form.='<label for="pass2">Re-enterPassword</label><input required type="password" class="form-control" id="pass2" name="pass2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the above password exactly">';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" name="btnRegister" value="registerUser">Register</button>';
        $form.='</form>';
        
        return $form;
    }
        
    
    
      

    
/**
 * Generates a HTML CONFIRM form (Button)
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @param string $choice The value of the chosen variable to be confirmed. 
 * @param string $btnText The text to appear on the form button. 
 * @return string String containing the generated form.
 */    
public static function form_confirm($pageID,$btnText,$choice){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<button type="submit" class="btn btn-default" value='.$choice.' name="btnConfirm">'.$btnText.'</button>';
        $form.='<button type="submit" class="btn btn-default" value='.FALSE.' name="btnConfirm">CANCEL</button>';
        $form.='</form>';
        return $form;
}    
   

/**
 * Generates a HTML Ticket Creation form
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */    
public static function form_create_ticket($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="topic">Topic</label><input required type="text" class="form-control" id="topic" name="topic" >';
        $form.='<label for="description">Description</label><textarea required type="textarea" class="form-control" id="description" name="description" style="height: 500px;"></textarea>';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnCreateTicket">Submit Ticket</button>';
        $form.='</form>';
        return $form;
}    


/**
 * Generates a HTML form for adding a comment to a ticket
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @return string String containing the generated form.
 */
public static function form_add_comment($pageID, $ticketID = ''){

        $form = '<div class="comment-form" style="border: 2px solid #0066cc; border-radius: 5px; padding: 20px; margin-top: 20px; background-color: #f0f7ff;">';
        
        $form .= '<h4 style="color: #333; margin-top: 0;">Add a Comment</h4>';
        
        $form .= '<form action="index.php?pageID=' . htmlspecialchars($pageID) .'&TicketID=' . htmlspecialchars($ticketID) . '" method="post">';
        
        if (!empty($ticketID)) {
            $form .= '<input type="hidden" name="ticketID" value="' . htmlspecialchars($ticketID) . '">';
        }
        
        $form .= '<div style="margin-bottom: 15px;">';
        $form .= '<textarea name="comment" style="width: 100%; min-height: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;" placeholder="Write your comment here..." required></textarea>';
        $form .= '</div>';
        
        $form .= '<div style="text-align: right;">';
        $form .= '<button type="submit" name="btnAddComment" value="TRUE" style="background-color: #0066cc; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: bold;">Comment</button>';
        $form .= '</div>';
        
        $form .= '</form>';

        return $form;
}

/**
 * Generates a HTML form for displaying tickets by customer
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @param string $customerID The ID of the customer whose tickets are to be displayed. 
 * @return string String containing the generated form.
 */
public static function form_ticketsByCustomer($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="customerID">Enter Customer ID</label><input required type="text" class="form-control" id="customerID" name="customerID" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnViewTicketsByCustomer">View Tickets</button>';
        $form.='</form>';
        return $form;
}

/**
 * Generates a HTML form for displaying tickets by technician
 * 
 * @param string $pageID The pageID of the page which will be used to process the login form. 
 * @param string $technicianID The ID of the technician whose tickets are to be displayed. 
 * @return string String containing the generated form.
 */
public static function form_ticketsByTechnician($pageID){
        $form='<form method="post" action="index.php?pageID='.$pageID.'">';
        $form.='<div class="form-group">';
        $form.='<label for="technicianID">Enter Technician ID</label><input required type="text" class="form-control" id="technicianID" name="technicianID" >';
        $form.='</div> ';
        $form.='<button type="submit" class="btn btn-default" value="TRUE" name="btnViewTicketsByTechnician">View Tickets</button>';
        $form.='</form>';
        return $form;
}
}