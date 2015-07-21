# QSARDW Frontend Application

QSARDW is an open source web-based tool that provides a standardized workflow for creating, cleaning, reviewing and sharing a chemical database.
Although it is intended to be used for cleaning datasets for QSAR calculations it really can be used for removing duplicates in every chemical dataset.

The frontend application is the user interface of the system.

## Requirements

The frontend is fully tested with Ubuntu 14.04 LTS with the standard packages. It requires:

* Apache web server 2.4.x
* PHP 5.5.x (php5-fpm is suggested for better performance)
* Mysql 5.5.x


## Installation

The setup process assumes that the frontend will be installed under the /qsardw root folder. If you want to use another root folder
you should modify the base configuration and scripts.

### Create the root folder

```
sudo mkdir /qsardw
```

### Clone the project and change permissions
```
cd /qsardw
sudo git clone https://github.com/qsardw/qsardw-frontend.git
sudo chown -R www-data.www-data qsardw-frontend
```

### Create other app folders
```
cd /qsardw/qsarw-frontend
sudo bash create-folders.sh
```

### Copy sample virtualhost
```
cd /qsardw/qsarw-frontend
sudo cp sample-virtualhost.conf /etc/apache2/sites-available/qsardw.conf
```

### Edit virtualhost
```
cd /etc/apache2/sites-available
sudo vim qsardw.conf
```

You should change the values of **ServerAdmin** and **ServerName** in order to set the proper values for your installation

For example

```
...
ServerAdmin admin@qsardw.org
ServerName app.qsardw.org
...

```

### Create the database
```
cd /qsardw/qsardw-frontend/resources/sql
mysql -u root -p < qsardw.sql
```

### Create an user for accesing the database
```
mysql -u root -p -D qsardw

mysql> GRANT ALL PRIVILEGES ON qsardw.* TO 'qsardw_owner'@'127.0.0.1' IDENTIFIED BY 'yoursecretepassword';
mysql> GRANT ALL PRIVILEGES ON qsardw.* TO 'qsardw_owner'@'localhost' IDENTIFIED BY 'yoursecretepassword';
```

You should change *yoursecretpassword* with a valid and secure password for your installation.

### Configure database connection
```
sudo vim /qsardw/qsardw-frontend/config/production.php
```
You should change the values of **user** and **password** properties with values used in the previous step.

```
    'user'=> 'qsardw_owner',
    'password'=> 'yoursecretepassword',
```

### Activate the virtualhost and reload apache
```
sudo a2ensite qsardw.conf
sudo service apache2 reload
```
