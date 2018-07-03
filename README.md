# Payrix
Assessment for Payrix PHP candidate

1. In 3 PHP pages or more, create a MVC style website that does the following:
a. Takes a username, password and full name in a form
b. Submit to a server using standard <form> HTML functionality
c. Validate the input on the server side (including checking if username is used already)
d. Stores the user in the database
e. Respond to the user based on success:
i. Redirects the user to a page with a message indicating success, if successful
ii. Goes back to the form page and indicates errors, if not successful
2. In 2 PHP pages or more, create a CLI application that does the following:
a. Requests a username from the user
b. Checks if that username is in the database
c. Responds to the user based on username existing:
i. If it exists, respond with full name and exit
ii. If it doesn’t exist, respond that it doesn’t exist and re-request a username
d. If the user calls the application with the ‘multi’ command line argument, keep
requesting usernames after responding with full name, until the user enters ‘\quit’
3. Design 2 tables in database of choice and send dump file that does the following:
a. Stores user information (at least username, password, full name)
b. Stores a record for each time a user logs in to the system with the timestamp and ip of
the request
c. The record log must be associated with the user record appropriately
