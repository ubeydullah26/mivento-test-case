# PHP Developer Challenge

You need to write a PHP script to properly import the CSV file into a MySQL database.
You are free to use Composer to install any library (like PhpSpreadsheet) but shouldn't install any framework (like Laravel) to write this script.

We expect you to finish this assessment in the following three days after the interview.

You can download the sample code and CSV file here:
[https://github.com/mivento/assessment-php](https://github.com/mivento/assessment-php "https://github.com/mivento/assessment-php")

**Import rules:**

- You will create a table schema for the CSV file. SQL dump of table structure should also be pushed with the final code.
- CSV file has 6 columns including name, surname, email, employee_id, phone, and points. Email, phone, and employee_id columns should be unique. Therefore, the script needs to check if duplicate records exist. If so, don't import them.
- Email and Phone fields need to be valid. Phone field needs to be in this format: 5431234567 (not 05431234567 or something else)

**Plus:**

- Showing the result of the import function (success or failure) in the UI is a plus.
- You can improve the provided code and add any functionality like AJAX, error handling, etc... This is a big plus.
- Adding a README file and writing detailed instructions on how to run the project is a plus.
- Deploying project to a host such as Render or any shared hosting is a plus.

You need to push the code to any repository hosting service such as GitHub, GitLab or Bitbucket and send the repository and demo links to [development@mivento.com](mailto:development@mivento.com "development@mivento.com").

Please don’t hesitate to contact if you have any questions.
