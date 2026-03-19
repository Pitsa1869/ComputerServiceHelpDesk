<?php
/**
* This file contains the configuration settings  for this application
* 
*/

/**
* This file contains settings that are required by the framework and to control
 * how it operates.  
* 
*/

/**
 * 
 * @global String FRAMEWORK_VERSION The current release version of the DDA Framework
 * 
 */
define ('FRAMEWORK_VERSION','16.20260309');  //The current release version of the DDA Framework


/**
 * 
 * @global Boolean DEBUG_MODE True for DEBUG mode turned on
 * 
 */
define ('DEBUG_MODE',TRUE);  //True for DEBUG mode turned on


/**
 * 
 * @global Boolean ENCRYPT_PW True for password encryption enabled
 * 
 */
define ('ENCRYPT_PW',TRUE);  //True if Passwords are hash encrypted

/**
 * 
 * @global String PAGE_TITLE String containing the page title (appears in the browser tab) of all pages in this application.
 * 
 */
define ('PAGE_TITLE','DDA Framework'); //site wide page title (tab label at top of web page)




//Note no PHP end tag in this file : 
//If a file contains only PHP code, it is preferable to omit the PHP closing tag at the end of the file.
//This prevents accidental whitespace or new lines being added after the PHP closing tag

//**DO NOT EDIT BELOW THIS LINE**
//===========================================================

//initialise the installation variables
$appName=PAGE_TITLE;  //default application name
$installed=FALSE;//TRUE if installed. Used only for Practical Assessments
$practicalAck=FALSE;//Flag used during Practical Assessments 
