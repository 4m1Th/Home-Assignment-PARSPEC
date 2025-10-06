***IP Address Of the login pages***

3.84.212.240

***Vulnerable Login Page***

http://3.84.212.240/index.php

***Secured Login Page***

http://3.84.212.240/secure.php

***Steps For Deploying This Project In EC2 Instance***
1. Deploy an Ec2 in AWS (I choosed ubuntu t2.micro)
2. Setup a security group to allow the HTTP connection
<img width="1837" height="924" alt="image" src="https://github.com/user-attachments/assets/80248d2e-72c5-47ff-9183-ab5832310a48" />


3. Attach the newly created security group with the ec2 that we spinned up Actions->Security->Change Security Group
<img width="1898" height="750" alt="image" src="https://github.com/user-attachments/assets/1959b0e4-901e-48b6-8897-10eee3b56fa9" />

4. Login to the Ec2 and run the following ```install.sh``` script. It will install all the required dependencies and packages
5. By default mod-security rule engine is configured on DetectionOnly. For reconfiguring it, change change ```SecRuleEngine DetectionOnly``` to ```SecRuleEngine On``` by going to the following file ```/etc/modsecurity/modsecurity.conf```

***Setting Up DataBase***

Login to MariaDB and create a test DB + table

Use this in an isolated lab environment only — the schema below is intentionally insecure for learning and testing.

Login to MariaDB:

```sudo mysql -u root -p```

Inside MariaDB — create the database, table, and sample rows:

```CREATE DATABASE sqli_lab;```
```USE sqli_lab;```


```CREATE TABLE users (```
```id INT AUTO_INCREMENT PRIMARY KEY,```
```username VARCHAR(100Create a low-privilege DB user for the application) NOT NULL,```
```fullname VARCHAR(100)```
```);```


```INSERT INTO users (username, fullname) VALUES```
```('alice', 'Alice Example'),```
```('bob', 'Bob Example');```

Create a low-privilege DB user for the application:

```CREATE USER 'appuser'@'localhost' IDENTIFIED BY 'AppP@ssw0rd';```
```GRANT SELECT ON sqli_lab.* TO 'appuser'@'localhost';```
```FLUSH PRIVILEGES;```
```EXIT;```

6. Clone this project
   ```git clone https://github.com/4m1Th/Home-Assignment-PARSPEC.git```
7. Move it to ```/var/www/html/*``` folder.
8. Set ownership — Ubuntu typically runs Apache as www-data
```sudo chown www-data:www-data /var/www/html/index.php /var/www/html/welcome.php /var/www/html/logout.php```
```sudo chmod 644 /var/www/html/*.php```
9. Restart the apache server
   ```systemctl restart apache2.service```

**Configuring OWASP Core Rule Set (CRS)***

``` cd /usr/share```

```sudo git clone https://github.com/coreruleset/coreruleset.git /usr/share/modsecurity-crs```

```sudo cp /usr/share/modsecurity-crs/crs-setup.conf.example /usr/share/modsecurity-crs/crs-setup.conf ```


Then include CRS from the Apache ModSecurity conf. Edit /etc/apache2/mods-available/security2.conf (or add a new include under /etc/modsecurity/) and ensure it includes something like:

```# /etc/apache2/mods-available/security2.conf (snippet)```

```SecDataDir /var/cache/modsecurity```

```IncludeOptional /usr/share/modsecurity-crs/crs-setup.conf```

```IncludeOptional /usr/share/modsecurity-crs/rules/*.conf```

Restart the Apache:
 ```systemctl restart apache2.service```


10. Visit ```http://3.84.212.240/index.php``` or ```http://3.84.212.240/secure.php```
