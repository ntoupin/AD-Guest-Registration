# AD-Guest-Registration
Active Directory / LDAP Guest Registration PHP Web Portal


Initial Stages - the current script is functional however it needs a lot of customization/config parameters in each file in order to work as well as a lot of code to cleanup and optimize.

Eventually there will be a single configuration file to edit with only the necessary configurations.

See each file's comments in the code for what to configure to use it at its current state.


Full Description Below

-----------------------------------------------------------------
#ADGR

ADGR at its base is a simple php script that allows any (or designated user in active directory) log in via the php script's portal and fill out aform that will automatically create a new account in active directory. That account will be made with a defined prefix, "guest_" by default, and created in the specified AD OU, "GuestUsers" by default, with an expiration date and time controlled by the form. Also in the form is additional information such as the guests name, location they will be in, what user member is "sponsoring" the guest.


## Current Features:
* LDAP/AD login
* Choose what users can create a guest account
* Users choose guest account expiration (1 hour, 1 day, 2 day, etc.)
* Users choose guest username and password for ease of use
* Additional information gathered for system logging (location, purpose, guest first and last name, staff creating the account)
* Error catch for duplicate users
* Printable "ticket" to give to the guest on creation
* Automated creation of guest account in active directory/ldap with user's inputted information
* Automatic "cleaning" of old expired guest accounts via scheduled task on domain controller
* Responsive design (bootstrap) for mobile


## Future Features
* History for users (will show a record of guests they "sponsored" in the past, when those expired, what username/password they gave them, etc.)
* Log system (for admin/technical use - lookup right in the script user sponsor history, search for guest name, username, etc.)
* A few more checks to ensure a duplicate is not being created and/or a safe fail that creates a user anyways with a randomly generated number after it.


### Login screen (uses LDAP/AD credentials)
![Login Screenshot](/../Screenshots/screenshots-demo/login.jpg?raw=true "Login")

---
### Registration form to fill out guest details
![Form Screenshot](/../Screenshots/screenshots-demo/form.jpg?raw=true "Form")

---
### Sample form filled, dropdown of account expiration options
![Form Screenshot](/../Screenshots/screenshots-demo/form-filled.jpg?raw=true "Form Filled")

---
### Successful registration of guest account
![Registration Screenshot](/../Screenshots/screenshots-demo/successful-registration.jpg?raw=true "Registration")

---
### Duplicate error
![Duplicate Screenshot](/../Screenshots/screenshots-demo/name-taken-error.jpg?raw=true "Duplicate")

---
### Printable "ticket" to hand to guest
![Printable Screenshot](/../Screenshots/screenshots-demo/printable-ticket.jpg?raw=true "Printable")

---
### AD user created
![User Screenshot](/../Screenshots/screenshots-demo/ad-user.jpg?raw=true "User")


