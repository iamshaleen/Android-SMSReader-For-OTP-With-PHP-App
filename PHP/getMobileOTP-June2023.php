<?php
    $otp_array = array();
    if(isset($_GET['sow']) && preg_match("/^[0-9]+$/", $_GET['sow']) && isset($_GET['mobile']) && ($_GET['mobile']=='87654321' || $_GET['mobile']=='98765432')) //check sow and phone number
    {
        $sow = $_GET['sow'];
            $mobile = $_GET['mobile'];
        $filename= "";
        $otpmessage = "";
        if($sow===null){
            echo "\nSOW is null";
        }else{
            //echo "\nSOW is ".$sow;
            $filename="sow-files/".$mobile."/".$sow.".txt";
        }
        if(file_exists("state-files/".$mobile."/".$sow."-otp_array_file.json")){
            //echo "\nSOW State File exists";
            $otp_array=file_get_contents("state-files/".$mobile."/".$sow."-otp_array_file.json");
            //echo "\ncontents are ".$otp_array;
        }else{
            //echo "\nSOW State File does not exist. Creating new file";
            $fileopen=fopen("state-files/".$mobile."/".$sow."-otp_array_file.json",'w');
            fclose($fileopen);
            $otp_array=file_get_contents("state-files/".$mobile."/".$sow."-otp_array_file.json");
            //echo "\n".($otp_array==null);
        }
        
        if($otp_array!=null){
            $otpmessage=file_get_contents($filename,true,null,0,null);
            if($otpmessage===false){
                    echo "\nNo new OTP";
                    $fp = fopen('otplog.txt', 'a');
                fwrite($fp,"\n OTP is: no new otp");
                fclose($fp);
            }else{

                //echo "\nOTP is ".$otpmessage;
                $otp_array_value=json_decode($otp_array,true);
                //echo "\nThis OTP is ".$otp_array_value[$sow];
                if($otpmessage==$otp_array_value[$sow]){
                        echo "\nNo new OTP. Last OTP is ".str_replace("\n"," ",$otpmessage);
                        $fp = fopen('otplog.txt', 'a');
                fwrite($fp,"\n OTP is: no new otp");
                fclose($fp);

                }else{
                        echo "\n".str_replace("\n"," ",$otpmessage);
                        $fp = fopen('otplog.txt', 'a');
                fwrite($fp,"\n OTP is ".$otpmessage);
                fclose($fp);
                    //unset($otp_array[$sow]);
                    $otp_array_value=json_decode($otp_array,true);
                    $otp_array_value[$sow]=$otpmessage;
                    $otp_array=json_encode($otp_array_value);
                    file_put_contents("state-files/".$mobile."/".$sow."-otp_array_file.json",$otp_array);
                }
            }
        }else{
            //echo "\nin else";
            $otpmessage=file_get_contents($filename,true,null,0,null);
            if($otpmessage===false){
                    echo "\nNo new OTP";
                    $fp = fopen('otplog.txt', 'a');
                fwrite($fp,"\n OTP is: no new otp");
                fclose($fp);
            }else{
                //echo "\nOTP Message is not false";
                echo "\n".str_replace("\n"," ",$otpmessage);
                $entry=json_encode(array($sow => $otpmessage));
                //echo "\n".$entry;
                file_put_contents("state-files/".$mobile."/".$sow."-otp_array_file.json",$entry,FILE_APPEND);
                $fp = fopen('otplog.txt', 'a');
                fwrite($fp,"\n OTP is ".$otpmessage);
                fclose($fp);
            }
        }      
    }else{
        echo "\nmissing or incorrect params";
    }

?>
