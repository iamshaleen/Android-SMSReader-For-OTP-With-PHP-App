# SMSReader for Readeing SMS OTP's and sending to server to be accessed via php
PHP Code and Android App to retrive SMS OTP's

- Rename the php files AKA remove the "-June2023" from the PHP filenames.

Use Case:
- To retrive OTP's from a phone via a URL and consome the URL for automated scanners/internal use etc.

Usage:
- Add all folders manually
- Host the php files on a server
- Update the server IP/Port in the URL's in the Android Project under MainActivity.java
- Install the Android App on a phone.
- Retrive the OTP via getMobileOTP.php

  Example: http://192.168.1.2:8888/POCMobileOTP/getMobileOTP.php?sow=1234567&mobile=87654321

