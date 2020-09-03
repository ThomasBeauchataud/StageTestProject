## The Installation
- Create a `.env` file with fields like below
```
#.env

APP_ENV=dev
APP_SECRET=3ad0df3f91d2bfab4ed76ddb3e9ff319
DATABASE_URL={YOUR DATABASE URL HERE}
MAIlER_DSN={YOU DSN MAIL HERE}
```
- Run `composer update` to install packages
- Create database tables by running `php bin/console doctrine:migration:migrate`
- Populate tables by running SQL commands below:
```
INSERT INTO `admin` (`email`, `password`) VALUES ('test@0000', '4a7d1ed414474e4033ac29ccb8653d9b');

INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Jones', 'Alyson', 'kklocko@example.net', 'Female', '2010-10-15', 'Macao');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Harvey', 'Jay', 'zfisher@example.org', 'Male', '1984-01-19', 'France');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Koch', 'Stanton', 'kub.madelyn@example.org', 'Male', '1989-10-05', 'Uzbekistan');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Boyle', 'Enrique', 'egottlieb@example.com', 'Male', '1978-12-11', 'Jersey');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Walker', 'Chet', 'dstiedemann@example.net', 'Female', '2014-03-08', 'Jersey');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Bauch', 'Marc', 'johnson.chaim@example.net', 'Male', '1979-11-04', 'Greece');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Reilly', 'Calista', 'bell.beier@example.com', 'Female', '1992-11-25', 'Greece');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Kutch', 'Greta', 'dejah.torp@example.org', 'Female', '2017-03-02', 'France');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Yost', 'Robb', 'hdeckow@example.com', 'Male', '1990-07-11', 'France');
INSERT INTO `user` (`name`, `surname`, `email`, `gender`, `birth_date`, `country`) VALUES ('Ratke', 'Lucius', 'mschmeler@example.net', 'Male', '1984-09-22', 'Latvia');
```
## The Application