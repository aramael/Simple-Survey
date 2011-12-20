Simple Response Bias Test
=========================

A simple php application to run collect responses for a statistics survey measuring response bias by asking a qualitative control and biased question and measure the differences between the two responses. 

Requirements
------------
A Simple LAMP Server

Installation
------------

Just Open `resources/config.php` and change the following constants:

1. `$db_Host` -- *Database Host URL. Defaults to localhost*
2. `$db_Name` -- *Database Name*
3. `$db_User` -- *Database Username*
4. `$db_Pass` -- *Database Password for User*
5. `$project_url` -- *Project URL*
6. `$project_name` -- *The Title Element in the Project*
7. `$project_manager` -- *The name of the preferred contact person*
8. `$project_manager_email` -- *The email of the preferred contact person*
9. `$control_question` -- *The Control Question*
10. `$question_1` -- *The first biased question*
11. `$question_2` -- *The second biased question*

Running the Survey
----------------

Once you input all of the test subjects into the database, you can run `resources/treatment.php`. This code will automatically assign users to one of the two biased questions. You can email users with their answer links by running `resources/email.php`

About
-----

This is a modified version of the Horace Mann AP Statistics Survey Website and was created by [@aramael] [1].

  [1]: https://twitter.com/#!/aramael "MSN Search"
