=== Custom password encryption ===
Contributors: marchfeld
Tags: password, login, encryption, users
Tested up to: 3.8.1


Custom password encryption enable to login for imported users with other password encryption then the default md5 encryption.

== Description ==

Currently supported password encryptions are mysql OLD_PASSWORD and mysql PASSWORD, so if you have migrate from application with user's passwords encrypted with those two methods it will enable them to login.

This is useful if you don't want to force all existing users to reset password.

== Installation ==

Upload the Custom password encryption plugin to your blog, Activate it, then choose encryption method in Settings -> Custom password encryption).

== Changelog ==

= 0.1 =
* encryption  mysql OLD_PASSWORD
* encryption  mysql PASSWORD

= 0.2 =
* localization inplemented


