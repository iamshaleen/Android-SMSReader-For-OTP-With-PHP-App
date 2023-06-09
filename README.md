# SMSReader for Readeing SMS OTP's and sending to server to be accessed via php
PHP Code and Android App to retrive SMS OTP's

- Rename the php files AKA remove the "-June2023" from the PHP filenames.

- Run otpcopy.sh with nohup 
- Command: nohup ./optcopy.sh &

Use Case:
- To retrive OTP's from a phone via a URL and consome the URL for automated scanners/internal use etc.

Usage:
- Add all folders manually
- Host the php files on a server
- Update the server IP/Port in the URL's in the Android Project under MainActivity.java
- Install the Android App on a phone.
- Retrive the OTP on via getMobileOTP.php

