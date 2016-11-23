Trip Builder API
Name: Wei Guo
How to run and use program:

1. add new files airport.txt, API.php, apiTester.php to htdocs\tripbuilder\web
2. run the following url to test the API
Create Trip page
response: aiport id and name
http://localhost/tripbuilder/web/apiTester.php?action=create

Add flight to a trip
response: trip info, flight info
http://localhost/tripbuilder/web/apiTester.php?action=remove&tripid=1

Remove/edit flight from a trip
response: trip info, flight info, selected flight info. 
http://localhost/tripbuilder/web/apiTester.php?action=remove&tripid=1


Extra features:--
Known bugs:No security setup
Other Notes:--