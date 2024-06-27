<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1> Turn14 API</h1>
    <h2> product generator</h2>
    <p class="p1">
        This program is only for companies/people that are paid distributors for https://www.turn14.com/ you must have access to use the API to get credentials 
    </p>
    <p class="p1">
        What does it do: Allows the user search and download car parts pertaining to a certain car name and brand id in csv format(ex: challenger)
        How does it work: Combines 3 different tables of data(car parts) to easily get the Photo, Price and description of the product and download in csv format
    </p>
    <p>
        <ul>Step 1: change the 'a.php' file to update and save your ClientID and Client Secret(You must get this from turn14)
        <ul>Step 2: Type a car name (lower case) in the Car name textbox and brand id in the brand id textbox</ul>
        <ul>(To find the brand id construct an API request to retrieve brandid from turn14, one tool would be postman. https://www.postman.com/)</ul>
        <ul>Step 3: Generate the list, preview then download the data</ul>
        <ul>*This tool calls on the "short-description" to find car names so it will not get products with no name in the short description*</ul>
        <ul>*All car name entries currently need to be lowecase and match turn14 data*</ul>
        <ul>*This tool makes 3 different requests and combines the products on their unqie id, it is meant to be changed to pull what you need*</ul>
    </p>
        <div class="warning-header">
        *This tool is not meant to be used as a live website or by someone without programming knoweldge * Contact for help Danadon404@gmail.com
        </div>

    <form>
        <!-- Main form -->
        <label> Car name  : 
        <input placeholder="ex.'viper'" id="a">
        </label>
        <label> Brand id  : 
        <input placeholder="Brand Id" id="b">
        </label>
        <button type="submit" id="_g">Generate</button>
        <div id="r"></div>
        <div id="e"></div>
    </form>

    <div id="t"></div>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700&display=swap');
        * {
            font-family: 'Outfit', sans-serif;
        }
        h1{
            
              text-align: center;
              font-size: 5rem;
            
        }
        h2{
            text-align: center;
            font-size: 2.5rem;
        }
        p{
            text-align: center;
            font-size: 1rem;
        }
        .p1{
            text-align: center;
            font-size: 1.5rem;
        }
        ul{
            text-align: center;
            font-size: 1rem;
        }
        form {
            display: flex;
            max-width: 450px;
            margin: 0 auto;
            margin-top: 120px;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        form input {
            display: block;
            width: 46%;
            height: 37px;
            border: 1px solid #000;
            padding: 0 10px;
        }
        form * {
            border-radius: 3.5px;
        }
        form button {
            margin-top: 20px;
            width: 100%;
            background-color: #000;
            color: #fff;
            padding: 12px;
            border: none;
            cursor: pointer;
        }
        #r {
            border-top: 2px solid #efefef;
            margin-top: 30px;
            padding-top: 30px;
            width: 100%;
        }
        #r span {
            margin-bottom: 10px;
            width: 100%;
            display: block;
        }
        .error {
            color: red;
        }
        span.pricing {
            padding: 7px 14px;
            background: rgba(0,0,0,0.85);
            color: #fff;
            display: inline-block !important;
        }
        .flex {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .flex span {
            color: #000;
            display: block;
            border-radius: 5px;
            text-align: center;
            padding: 10px 20px;
            border: 2px solid #000;
            cursor: pointer;
        }
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        tr, th, table {
    border: 1px solid #000;
    border-collapse: collapse;
    text-align: left;
}
tbody tr td:nth-child(7), th td:nth-child(7) {
    max-width: 70px;
    overflow: hidden;
}
td, th {
    padding: 5px 10px;
}
tbody td {
    border: 2px solid #d2d1d1;
    border-top: none;
    border-collapse: collapse;
}
#t {
    margin-top: 30px;
}
.warning-header {
    text-align: center;
  font-weight: bold;
  color: #ff0000; /* Set your desired text color */
  background-color: #ffeeaa; /* Set your desired background color */
  padding: 10px;
  border: 1px solid #ffcc00; /* Set your desired border color */
}
    </style>
    <script src="./a.js"></script>
</body>
</html>
