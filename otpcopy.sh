#!/bin/bash
while true
do
        sshpass -p "<add password here>" rsync -acv va-user1@lab:/var/www/html/POCMobileOTP/sow-files/* /var/www/html/sow-files/
done
