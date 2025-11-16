# DataAnalysisAndProcessing
## How it looks
![DataAnalysisAndProcessingApp](https://github.com/user-attachments/assets/3e8ed149-43da-48f2-9885-00f73b03c490)
## What the app is doing
My application allows to choose one user which has got some transactions (one or more) - in the code there is a query which selects the users with transactions (some may not have any). The app calculates balance for each calendar month for given user and displays it in the table on the same page below the form.
## Explanation
The database contains the users table, users accounts table (each user can have multiple accounts) and transactions table which contains information about money transfers between accounts. Transactions can occur between accounts of different users or between different accounts of the same user.

The monthly balance is defined as the total of all incoming transactions across all user accounts minus the total of all outgoing transactions across all user accounts for a calendar month. The balance can be negative. 

The user is selected from a dropdown menu. Only users with transactions will appear in the dropdown.

The result is displayed in a table format, where the first column shows the month, and the second column shows the monthly balance.

Backend requests are sent without reloading the page.

The data are present in the **db.php** file which I add to the database and after calculating the balance, the scores will look excactly like in the gif.
## Technologies
Creating the app required from me knowledge of PHP (including writing SQL queries), html, css, js, jQuery. I saved and read the data in / from sqlite database. I handled exceptions. The app is resposive.
## Running
At first, you should create the `database_php_data_analysis_and_processing.sqlite` file in the main folder with app. It should be initially blank.

You can run the app in Xampp. You need to place the folder with my project in this directory: `C:\xampp\htdocs`. Then, in Xampp Control Panel you should start the Apache server. Next, when you write in the brower: `http://localhost/DataAnalysisAndProcessing/` where DataAnalysisAndProcessing is the name of the folder with app, you will see the app. You can see the data in the database using DB Brower for SQLite app.



