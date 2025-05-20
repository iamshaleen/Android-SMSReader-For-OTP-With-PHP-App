<?php

    if(isset($_POST['sow']) && isset($_POST['otpmessage']) && !($_POST['sow']==null) && !($_POST['otpmessage']==null) && preg_match("/^[0-9]+$/", $_POST['sow']) && isset($_POST['mobile']) && ($_POST['mobile']=='98765432' || $_POST['mobile']=='87654321')) //check sow 
    {
        $sow = $_POST['sow'];
        $otpmessage = $_POST['otpmessage'];
        $number = $_POST['mobile'];
        echo "SOW is ".$sow;
        $filename="sow-files/".$number."/".$sow.".txt";
        
        if(file_exists($filename)){
            echo "\nSOW already added. Deleting existing file";
            $status=unlink($filename);
            if($status){
                echo "\nFile deleted successfully. Creating new file";
                $fp=fopen($filename,'w');
                if($fp===null){
                    echo "\nFile not created";
                }else{
                    echo "\nNew File created successfully";
                    fwrite($fp,$otpmessage);
                    fclose($fp);
                }
            }else{
                echo "\nFile could not be deleted successfully";
            }

        }else{
            echo "\nFilename is ".$filename;
            $fp=fopen($filename,'w');
            if($fp===null){
                echo "\nFile not created";
            }else{
                echo "\nFile created successfully";
                fwrite($fp,$otpmessage);
                fclose($fp);
            }
        }
    }else{
        echo "missing or incorrect params";
    }

?>
