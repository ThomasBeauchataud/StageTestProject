## Requirements
- PHP >= 7.4.0

## The Installation
- Create a `.env` file with fields like below
```
#.env

APP_ENV=dev
APP_SECRET=3ad0df3f91d2bfab4ed76ddb3e9ff319
DATABASE_URL={YOUR DATABASE URL HERE}
MAIlER_DSN={YOU DSN EMAIL HERE}
```
- Run `php composer.phar update` to install packages
- Create database tables by running `php bin/console doctrine:migration:migrate`
- Populate tables by running SQL commands below0
> Your email must be a gmail email, or you have to install another bridge:
```
INSERT INTO `admin` (`email`, `password`) VALUES ({YOUR EMAIL HERE}, '4a7d1ed414474e4033ac29ccb8653d9b');

INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Jones', 'Alyson', 'kklocko@example.net', 'Female', '2010-10-15', 'Macao', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Harvey', 'Jay', 'zfisher@example.org', 'Male', '1984-01-19', 'France', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Koch', 'Stanton', 'kub.madelyn@example.org', 'Male', '1989-10-05', 'Uzbekistan', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Boyle', 'Enrique', 'egottlieb@example.com', 'Male', '1978-12-11', 'Jersey', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Walker', 'Chet', 'dstiedemann@example.net', 'Female', '2014-03-08', 'Jersey', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Bauch', 'Marc', 'johnson.chaim@example.net', 'Male', '1979-11-04', 'Greece', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Reilly', 'Calista', 'bell.beier@example.com', 'Female', '1992-11-25', 'Greece', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Kutch', 'Greta', 'dejah.torp@example.org', 'Female', '2017-03-02', 'France', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Yost', 'Robb', 'hdeckow@example.com', 'Male', '1990-07-11', 'France', 'Farmer');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`, `job`) VALUES ('Ratke', 'Lucius', 'mschmeler@example.net', 'Male', '1984-09-22', 'Latvia', 'Farmer');
```

## The Application
- Internet users can register by clicking on the `Register` tab then by filling out the form
- Administrators can manage internet users by connecting through the `Login` tab then clicking on the `Admin` tab
> If you created the administrator with the SQL command above, login credentials are your email, and the password is 0000
- Administrators can delete an internet user by clicking on the `Delete` button, edit them by clicking on the raw of the user to edit 
and create a new internet user by clicking on the sub tab `User Creation`

## The Tests
You can execute tests by running `php bin/phpunit`