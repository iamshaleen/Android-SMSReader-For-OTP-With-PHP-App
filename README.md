# SMSReader for Readeing SMS OTP's and sending to server to be accessed via php
PHP Code and Android App to retrive SMS OTP's

- Rename the php files AKA remove the "-June2023" from the PHP filenames.

Use Case:
- To retrive OTP's from a phone via a URL and consome the URL for automated scanners/internal use etc.

Usage:
- Add all folders manually:<br>
  This includes adding sow-files, state-files folder in the root directiory and the phone number directories in both the folders respectively 
- Host the php files on a server such as apache
  
For Android Project v1:
- Update the server IP/Port in the URL's in the Android Project under MainActivity.java
- Update the phone numbers in the PHP code (all 3 files) as well as under MainActivity.java
- Build the Android Studio Project and install the Android App on a phone.

For Android Project v2:
- Update the server IP/Port in the URL's in the Android Project under SmsProcessor.java
- Update the phone numbers in the PHP code (all 3 files) as well as under SmsProcessor.java
- Build the Android Studio Project and install the Android App on a phone.
  
OTP Retrieval:
- Retrive the OTP via getMobileOTP.php.<br>
- Example: http://192.168.1.215:8888/POCMobileOTP/getMobileOTP.php?sow=1234567&mobile=98765432

