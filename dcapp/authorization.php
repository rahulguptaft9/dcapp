<?php

include_once dirname(__FILE__) . '/' . 'components/application.php';
include_once dirname(__FILE__) . '/' . 'components/utils/hash_utils.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_authentication/user_defined_user_authentication.php';
include_once dirname(__FILE__) . '/' . 'components/security/grant_manager/user_defined_user_grant_manager.php';
include_once dirname(__FILE__) . '/' . 'components/security/user_identity_storage/user_identity_session_storage.php';
include_once dirname(__FILE__) . '/' . 'components/security/recaptcha.php';

function CheckUserIdentity($username, $password, &$result)
{
    date_default_timezone_set("Asia/Kolkata");
          $adServer = "ldap://prdldap01.dcservices.in";
        
                	    $ldap = ldap_connect($adServer);
                	    $username = $_POST['username'];
                	    $password = $_POST['password'];
                		$dn = 'ou=people,dc=nd,ou=user,dc=cdac,dc=in';
                		$dn1 = 'ou=DC-MGMT,dc=nd,ou=user,dc=cdac,dc=in';
                	    $userdn = 'uid='.$username.','.$dn ;
                	    $userdn1 = 'cn='.$username.','.$dn1 ;
                	    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
                	    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
        
                		if ($bind = ldap_bind($ldap, $userdn, $password) )
                		{
    $myfile = "../logs/".date("Y-m-d").".log";
    $txt = "Date: ".date("d-m-Y")." ".date("h:i:sa")." IP: ".$_SERVER['REMOTE_ADDR']." User: ".$username ;
    file_put_contents($myfile, $txt, FILE_APPEND | LOCK_EX);
    file_put_contents($myfile, "\r\n", FILE_APPEND | LOCK_EX);
            			  $sr=ldap_search($ldap, $dn, "uid=".$username);
            		    $info1 = ldap_get_entries($ldap, $sr);
            			$user = $info1[0]["cn"][0];
            			$sr1=ldap_search($ldap, $dn1, "cn=NOC");
             			$info = ldap_get_entries($ldap, $sr1);
            			//echo "Data for " . $info["count"] . " items returned:<p>";
            			$nocmember = $info[0]["memberuid"]["count"];
            			for ($j=0; $j<$nocmember; $j++) {
            				$memberid = $info[0]["memberuid"][$j];
            				if ($username == $memberid) {
                				$result = true;
    
            				break;
            				}
            			   $result = false;
            			}
            			echo  $username." you are not the Member of NOC Team & unauthorized access is being logged!";
                		}
        
        			else if ($bind = ldap_bind($ldap, $userdn1, $password) )
                		{
    $myfile = "../logs/".date("Y-m-d").".log";
    $txt = "Date: ".date("d-m-Y")." ".date("h:i:sa")." IP: ".$_SERVER['REMOTE_ADDR']." User: ".$username ;
    file_put_contents($myfile, $txt, FILE_APPEND | LOCK_EX);
    file_put_contents($myfile, "\r\n", FILE_APPEND | LOCK_EX);
    
            		//	echo "IN 2nd check";
        					 	    $sr=ldap_search($ldap, $dn1, "cn=".$username);
        						    $info1 = ldap_get_entries($ldap, $sr);
        							$user = $info1[0]["cn"][0];
        							$userid = $info1[0]["uid"][0];
        						//	echo $userid;
        							$sr1=ldap_search($ldap, $dn1, "cn=NOC");
        				 			$info = ldap_get_entries($ldap, $sr1);
        							//echo "Data for " . $info["count"] . " items returned:<p>";
        							$nocmember = $info[0]["memberuid"]["count"];
        				for ($j=0; $j<$nocmember; $j++) {
            				$memberid = $info[0]["memberuid"][$j];
            				if ($userid == $memberid) {
                				$result = true;
    
            				break;
            				}
            			   $result = false;
            			}
            			echo $username." you are not the Member of NOC Team & unauthorized access is being logged!!";
    
                		}
        
        
                		 else
                			{
                			$error = "Username or Password is invalid";
            $myfile = "../logs/Failed-".date("Y-m-d").".log";
    $txt = "Date: ".date("d-m-Y")." ".date("h:i:sa")." IP: ".$_SERVER['REMOTE_ADDR']." User: ".$username;
    file_put_contents($myfile, $txt, FILE_APPEND | LOCK_EX);
    file_put_contents($myfile, "\r\n", FILE_APPEND | LOCK_EX);
                			$result = false;
        
                			}
}

function GetReCaptcha($formId)
{
    return null;
}

function SetUpUserAuthorization()
{
    $hasher = GetHasher('');
    $userAuthentication = new UserDefinedUserAuthentication(new UserIdentitySessionStorage(), false, $hasher);
    $userAuthentication->OnCheckUserIdentity->AddListener('CheckUserIdentity');
    $grantManager = new UserDefinedUserGrantManager();

    GetApplication()->SetUserAuthentication($userAuthentication);
    GetApplication()->SetUserGrantManager($grantManager);
    GetApplication()->SetDataSourceRecordPermissionRetrieveStrategy(new HardCodedDataSourceRecordPermissionRetrieveStrategy(array()));
}
