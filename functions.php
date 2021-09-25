<?php

###### USEFUL FUNCTIONS #######

########################################
#
# Function:  dump_debug()
#
# Determine if Get string is either empty or invalid (i.e. not numeric)
function dump_debug($input, $collapse=false) {
    $recursive = function($data, $level=0) use (&$recursive, $collapse) {
        global $argv;

        $isTerminal = isset($argv);

        if (!$isTerminal && $level == 0 && !defined("DUMP_DEBUG_SCRIPT")) {
            define("DUMP_DEBUG_SCRIPT", true);

            echo '<script language="Javascript">function toggleDisplay(id) {';
            echo 'var state = document.getElementById("container"+id).style.display;';
            echo 'document.getElementById("container"+id).style.display = state == "inline" ? "none" : "inline";';
            echo 'document.getElementById("plus"+id).style.display = state == "inline" ? "inline" : "none";';
            echo '}</script>'."\n";
        }

        $type = !is_string($data) && is_callable($data) ? "Callable" : ucfirst(gettype($data));
        $type_data = null;
        $type_color = null;
        $type_length = null;

        switch ($type) {
            case "String":
                $type_color = "green";
                $type_length = strlen($data);
                $type_data = "\"" . htmlentities($data) . "\""; break;

            case "Double":
            case "Float":
                $type = "Float";
                $type_color = "#0099c5";
                $type_length = strlen($data);
                $type_data = htmlentities($data); break;

            case "Integer":
                $type_color = "red";
                $type_length = strlen($data);
                $type_data = htmlentities($data); break;

            case "Boolean":
                $type_color = "#92008d";
                $type_length = strlen($data);
                $type_data = $data ? "TRUE" : "FALSE"; break;

            case "NULL":
                $type_length = 0; break;

            case "Array":
                $type_length = count($data);
        }

        if (in_array($type, array("Object", "Array"))) {
            $notEmpty = false;

            foreach($data as $key => $value) {
                if (!$notEmpty) {
                    $notEmpty = true;

                    if ($isTerminal) {
                        echo $type . ($type_length !== null ? "(" . $type_length . ")" : "")."\n";

                    } else {
                        $id = substr(md5(rand().":".$key.":".$level), 0, 8);

                        echo "<a href=\"javascript:toggleDisplay('". $id ."');\" style=\"text-decoration:none\">";
                        echo "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>";
                        echo "</a>";
                        echo "<span id=\"plus". $id ."\" style=\"display: " . ($collapse ? "inline" : "none") . ";\">&nbsp;&#10549;</span>";
                        echo "<div id=\"container". $id ."\" style=\"display: " . ($collapse ? "" : "inline") . ";\">";
                        echo "<br />";
                    }

                    for ($i=0; $i <= $level; $i++) {
                        echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }

                    echo $isTerminal ? "\n" : "<br />";
                }

                for ($i=0; $i <= $level; $i++) {
                    echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                echo $isTerminal ? "[" . $key . "] => " : "<span style='color:black'>[" . $key . "]&nbsp;=>&nbsp;</span>";

                call_user_func($recursive, $value, $level+1);
            }

            if ($notEmpty) {
                for ($i=0; $i <= $level; $i++) {
                    echo $isTerminal ? "|    " : "<span style='color:black'>|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                if (!$isTerminal) {
                    echo "</div>";
                }

            } else {
                echo $isTerminal ?
                        $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
                        "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";
            }

        } else {
            echo $isTerminal ?
                    $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "  " :
                    "<span style='color:#666666'>" . $type . ($type_length !== null ? "(" . $type_length . ")" : "") . "</span>&nbsp;&nbsp;";

            if ($type_data != null) {
                echo $isTerminal ? $type_data : "<span style='color:" . $type_color . "'>" . $type_data . "</span>";
            }
        }

        echo $isTerminal ? "\n" : "<br />";
    };

    call_user_func($recursive, $input);
}

########################################
#
# Function:  DBValidGet()
#
# Determine if Get string is either empty or invalid (i.e. not numeric)

function DBValidGet ($GetID) {

        $result = TRUE;

        # check to make sure all Get ID's have values, that they are numeric, and less than 10 characters
        if ($GetID == "") { $result = false; }
        if ((is_numeric($GetID) == false) && ($GetID!="Summer")) { $result = false; }
        if (strlen($GetID) > 10) { $result = false; }
        
        #done
        return( $result );

} # end DBValidGet

########################################
#
# Function:  bAdmin()
#
# Determine if user is an administrative user

function bAdmin ($userID) {

        $result = FALSE;
        
        $adminUsers=array("ulmeram","glcrc","mc2655","sr33449","donajo","burnssa1","jcw2753","nvs","paj264");

        # check to make sure all Get ID's have values, that they are numeric, and less than 10 characters
        if (in_array($userID,$adminUsers)) { $result = true; }
        
        #done
        return( $result );

} # end bAdmin

########################################
#
# Function:  bSuperAdmin()
#
# Determine if user is an administrative user

function bSuperAdmin ($userID) {

        $result = FALSE;
        
        $adminUsers=array("ulmeram","burnssa1","paj264");

        # check to make sure all Get ID's have values, that they are numeric, and less than 10 characters
        if (in_array($userID,$adminUsers)) { $result = true; }
        
        #done
        return( $result );

} # end bAdmin


########################################
#
# Function:  issetor()
#
# takes a variable as argument and returns it, if it exists, or a default value, if it doesn't.
# https://stackoverflow.com/questions/5836515/what-is-the-php-shorthand-for-print-var-if-var-exist

function issetor(&$var, $default = false) {
    return isset($var) ? $var : $default;
}

########################################
#
# Function:  RemoveBS
#
# Removes character encoding nightmares
# https://stackoverflow.com/questions/1189007/removing-strange-characters-from-php-string

function RemoveBS($Str) {  
  $StrArr = str_split($Str); $NewStr = '';
  foreach ($StrArr as $Char) {    
    $CharNo = ord($Char);
    if ($CharNo == 163) { $NewStr .= $Char; continue; } // keep £ 
    if ($CharNo > 31 && $CharNo < 127) {
      $NewStr .= $Char;    
    }
  }  
  return $NewStr;
}

function stripCourseNumber(&$item) {
		   $item = substr($item,0,8);
			}
			
########################################
#
# Function:  getEnrolledCount
#
# Looks up count of enrolled students for a given unique course number from TED

function getEnrolledCount($uniqueID) {  
  // initialize variables
	$host    = 'ldaps://entdir.utexas.edu';
	$port    = 	636;				// be sure to include the port
	$base_dn = 'dc=entdir,dc=utexas,dc=edu';
	$user_dn = 'uid=4658evsd,ou=services';	// replace ut_eid with user's UT EID
						   // if ted service account ou=services

	$user_name = $user_dn . ',' . $base_dn;
	$user_pass = 'a-w6;2f#c!64%q-)0(reiz0swwhj+-zice0z5';		// replace ut_eid_password with user's password
	// open new connection
	// $ds is the link identifier for the directory
	$ldapconn = ldap_connect($host, $port)
          or die("Could not connect to $host");

	if ($ldapconn) {
  		// bind credentials to server for authentication
   		 $ldapbind = ldap_bind($ldapconn, $user_name, $user_pass);
		// perform LDAP search operation - search by surname 
    	$search = ldap_search($ldapconn, $base_dn, 'utexasEduPersonClassUniqueNbr='.$uniqueID);
    	// get entries from search
    	$entries = ldap_get_entries($ldapconn, $search);
    	return $entries['count'];
    	}
			}
			
########################################
#
# Function:  getCurrentSemester
#
# Looks up count of enrolled students for a given unique course number from TED

function getCurrentSemester() {  
  $today=idate('z');
	if ($today<142) {
		return 2;
	} 
	if ($today>=142 && $today<230) {
		return "summer";
	} 
	if ($today>=230 && $today<=365) {
		return 1;
	}
}
?>