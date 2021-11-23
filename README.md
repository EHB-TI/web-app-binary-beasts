# Goal

We want to build a web application that allows EhB students & teachers to schedule events for meeting up with each other. Students and teachers can sign up with the Ehb e-mailaddress, and create events as well as join events. Teachers can assign students to class groups and create group-specific events that can only be viewed and joined by students of that group.

# Acceptance criteria

- [x] As as teacher I can sign up using my EhB e-mailaddress
- [x] As as student I can sign up using my EhB e-mailaddress
- [x] As a teacher or student I can login/logout
- [ ] As a teacher I can create/view/edit/delete groups
- [x] As a teacher I can view all students
- [x] As a teacher I can (un)assign students to groups
- [ ] As a student or teacher I can create/edit/delete an event
- [ ] As a teacher I can create/edit/delete an event private to a specific group
- [ ] As a student or teacher I can view a list of all events
- [ ] As a student I can view a list of all events in my group
- [ ] As a student or teacher I can view the details of an event
- [ ] As a student or teacher I can see all attendees of an event if I have rights to do so
- [ ] As a student or teacher I can indicate if I will be attending an event

# Threat model
![image](https://user-images.githubusercontent.com/21662496/139757528-ff6aef38-4c15-4249-8011-092809ffd583.png)

![image](https://user-images.githubusercontent.com/21662496/139757560-0920c60b-49fd-4fd6-b427-80772bc409ae.png)

## Threats
- Sensitive data exposure   => Using Cryptography, Using TLS for REST API, and activating RDS and S3 encryption
- Injection => Data Validation, other techniques on database access level like escaping special characters, or using LIMIT in queries to avoid returning data in BULK
- Identification issues => build in strategies to avoid brute force attacks,prohibit weak passwords, add multifactor authentication, avoid saving clear or encrypted passwords, invalidate tokens and/or session id's after logout, avoid poor password recovery strategies like questions to legitmate user,make use of a well known tested authentication provder library instead of writing the code by yourself, Make use of a secure protocol like Oaut2.0 with openIdconnect for example
- Authorization issues => use principle of least privileges or deny by default except for public resources,use same access control configuration/mechanisme throughout the complete application
- CSRF => Use anti forgery token
- XSS Cros Site Scripting => Using validation and user input sanitization

# Using STRIDE 
 - Spoofing: 
     - The User uses a webbrowser to access the application UI there is a risk of spoofing on this level => Solving with Https Encryption and authentication to ensure the auser identity 2FA auth is possible within the app.
     - The system Administrator uses the AWS console to log to the AWS infrastructure, there the security is guaranteed by AWS so no need for us to add additional scurity

 - Tampering: 
     - We make use of Encryption to avoid any man in the middle attack so data can not be tampered at this level
     - Using authorization and roles within the app we are sure that only the authorized people modify data
     - Between App and data as it is in AWS infrastructure we don't provide any additional security except RDS encryption

 - Repudiation
    - Using logging we can trace back all the user actions

 - Information Disclosure
    - Using Cryptography, Using TLS for REST API, and activating RDS and S3 encryption

- Denial of Service
   - Using loadbalancer and elastic cloud computing AWS provides auto scaling cababilities to ensure availability

- Elevation of privileges
   - making use of roles within the app will avoid having access to the wrong resources
   - making use of 2FA will give an additional security when it comes to securing access to the app. It will be difficult to get Admin priviliges for example even if you are able to get admin credentials
   - role can't be choosen but is automatically assigned by application
   

# Deployment
*minimally, this section contains a public URL of the app. A description of how your software is deployed is a bonus. Do you do this manually, or did you manage to automate? Have you taken into account the security of your deployment process?*

# Users
A couple of existing users are already included for testing purposes: 

- admin@ehb.be - Admin1
- student@student.ehb.be - Student1
- teacher@teacher.ehb.be - Teacher1
# *you may want further sections*
*especially if the use of your application is not self-evident*
