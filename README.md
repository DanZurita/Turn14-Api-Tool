This program is only for companies/people that are paid distributors for https://www.turn14.com/ you must have access to get credentials and to use the API

*This tool is only if you want to get car parts by searching the name of the car*

What does it do: Allows the user search and download car parts pertaining to a certain car and brand id in csv format

How does it work: Combines 3 different tables of data(car parts) to easily get the Photo, Price and description of the product and download in csv format

Step 1: change the 'a.php' file to update and save your ClientID and Client Secret(You must get this from turn14)

Step 2: Type a car name (lower case) in the Car name textbox and brand id in the brand id textbox (To find the brand id construct an API request to retrieve brandid from turn14, one tool would be postman. https://www.postman.com/)

Step 3: Generate the list, preview then download the data

*This tool calls on the "short-description" to find car names so it will not get products with no name in the short description *

*All car name entries currently need to be lowecase and match turn14 data *

*This tool makes 3 different requests and combines the products on their unqie id, it is meant to be changed to pull what you need *

*This tool is not meant to be used as a live website or by someone without programming knoweldge *




Contact for help Danadon404@gmail.com

