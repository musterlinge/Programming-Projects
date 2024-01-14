# Auto Parts Website
This will be a guide to setting up the database provided to you by us. Firstly follow the link provided here to begin setting up the database
[How_to_see_PHP_changes_on_your_browser (2).pdf](https://github.com/CSCI-467-Auto-Parts-Website/Website/files/13589663/How_to_see_PHP_changes_on_your_browser.2.pdf)


Now viewing the link download the required system aka Xampp and follow the steps in activating the modules. Making sure that both Apache and mySQL are activated and running Go to phpmyadmin http://localhost/phpmyadmin/index.php to begin running the query and establishing the database. Selecting the SQL tab in the top left corner copy the repo files from Github labeled as database.sql And paste the entire query into the run SQL query queries on server form. Once the entire query has been pasted select a go towards the middle right center of the page this will then run the query and build the database that we will be working with.

Make sure that your xampp file is in an accessible location for example on your desktop the htdocs file is where we will be accessing the entire web page's contents.
For example, when I downloaded the Xampp download I placed the download file on my desktop then once accessing the Xampp download file look for a file labeled htdocs inside this file we will paste all of the GitHub files provided on the GitHub This is where all the PHP and HTML and images are located and will be accessed

Now that we have the database set up the files are in the correct location and the database is enabled in the xampp control panel we can begin accessing the website.
Type in your Search "localhost" If all was done correctly you should see the index page for the website created in the top right corner you can see three tabs home , products and sign in Clicking home will direct you back to the current page you are viewing clicking on products will take you to the product page clicking on sign in will direct you to a sign in page where the workers and or admin can sign in and view their appropriate web pages.

Let's begin with the products page clicking on the products tab you will be directed to the products page which will show a number of items and an image with a brief description a price in the available quantity in the white text box you can see a number one you can adjust this number up or down and then select add to cart to add the number of items you specified to the cart at the bottom of the page is a view cart button clicking that button will direct you to the cart php page There you will see a brief summary of the items in your cart along with the price quantity subtotal and total weight additionally you will see a subtotal with the shipping and handling charge applied and the total weight of your items you will see a checkout and a back to products button towards the right check out will direct you to a form where you enter your information as a customer clicking back to products will take you back to the products page there is a remove button towards the right of the items name which will remove the item from your cart

Viewing the checkout page you will see forms for name, email, address, credit card number, and expiration date Along with a total cost and total weight of the items in your cart Once you select place order you will be redirected to a thank you php page in this page you will have a summary of the ordered details the order details that will be displayed are the order id the name of the customer the email of the customer that they provided the shipping address of the customer the total weight and price of the items in your cart the order date that the order was selected on and the status of your order which is pending until approved additionally there will be a thank you message at the bottom of the page

You can go back to the products page at anytime and add more items to your cart if you are to enter the exact same information you will notice that the order ID increments best still contains all the same information of the customer

Directing to the sign in page you will see a form that has the form boxes for email and password in this case
Admin
  Email: admin@gmail.com
  Password: admin

Workers
  Email: sj@gmail.com
  Password: sj

Workers
  Email: ww@gmail.com
  Password: ww
  
Workers
  Email: skh@gmail.com
  Password: kh

Entering the admin credentials on this sign in page will direct you to the administrative interface where the administrator can set the shipping and handling charges for the weight brackets the weight brackets range from one to 5 and they increment and pounds of 25. You can adjust the charge of each weight bracket by selecting the weight bracket and then entering the charge you would like to update it to once you are satisfied select the set charge button on the right side of the form this will update the database query with the new charge amount at the bottom of the page is the view orders table you can select a date range and order status or a price range or any combination of these to view the Orders and lists their order ID their customer ID their total weight their total price the date and the status of the order.

Let's walk through viewing an order assuming that you followed the products page and cart checkout as mentioned earlier if you simply search the order you will view The order that you submitted and because the order status is set to pending when you click search orders it will display all the relevant information

Going back to the sign in page let's enter a worker's information The workers are able to review the available inventory which displays their part number their name and their quantity And a brief description of the item Doing so you can enter a part number for example let's enter 1001 After entering the part number the part number along with the name of the part along with the quantity and the inventory will be displayed in black text you can then input a quantity that you would like to add for example if you enter the number 5 five parts will be added to the correct information in the tables

Now looking at the warehouse tab we will see we have four options print packing list a print invoice print shipping labels and update order status Upon selecting an order number which should be displayed if you click the warehouse tab in this instance if you are entering an order for the first time the order id will be 1 If you enter the number one in the order number form or text box and then click view new order number You will see the product name along with the product number and the quantity of that item that was ordered Selecting print invoice along with the correct order number will display in invoice with the Dreamteam Auto Parts title a billing address of the customer who entered their information the order number the total price a table that displays the product name product number the quantity of the product and the subtotal price of all the items that were ordered below will show a subtotal a shipping and handling charge and then the total Selecting print shipping label will display a shipping label with the shipping address of the customer
You will be shown the current order number you are viewing and the current status if you have not updated the status to shipped it should show pending once you select update status to shift you will see a confirmation message pop up If you then go back to the products page you will see that the number of products available has been updated
