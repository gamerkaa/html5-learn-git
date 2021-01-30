# msgsys
Learning to write HTML5, Javascript, Ajax and PHP program to allow for inter-pc messaging.

## Using msgsys
This app is a backend script that allows inter-pc messaging on apache/xampp server.
1. index.html allows user to login to a channel with specified username (Use Poll Msg button).
2. Click the send msg textbox and type in text, then hit Send Msg to send it (using the 'Enter' key works too)
3. Incoming messages will automatically be populated in the area below the form controls.
4. The user who is logged in (or not yet) can be deleted by setting the user name in textbox, setting the channel name in textbox and hit 'Delete User'.
5. When no more users are present for a given channel (specified in the channel textbox), the channel will be deleted and purged from server.

Use the index.html to customise the script according to requirements. The msgsys.php and folder structure is not to be altered.
Also keep in mind the url to the msgsys.php file when customising index.html for use in custom site.
