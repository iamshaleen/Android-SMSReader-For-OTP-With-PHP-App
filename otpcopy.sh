#!/bin/bash
while true
do
    sshpass - p "<password here>" rsync -acv <your-user>@<IP address>:/var/www/html/POCMobileOTP/sow-files/* /var/www/html/sow-files/
done