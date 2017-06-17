## Laravel 5 - Simple Location-Based Social Network 
It's location-based social network developed by [lvntayn](https://github.com/lvntayn), [theoneremains](https://github.com/theoneremains) and [koniqwe](https://github.com/koniqwe) using the Laravel PHP framework.

Live - https://around.kim

Demo Pages - https://github.com/lvntayn/laravel-social-network/tree/master/public/images/demo

### Installation
* git clone https://github.com/lvntayn/laravel-social-network.git projectname
* cd projectname
* composer install
* php artisan key:generate to regenerate secure key
* create new database and edit .env file for DB settings
* php artisan migrate —seed
* edit .env file for APP configuration and Google API Configuration
* storage, bootstrap/cache and public/cache directories should be writable
* php artisan storage:link
* php artisan serve


### Include
* Laravel 5.4 (https://laravel.com/docs/5.4)
* Bootstrap (http://getbootstrap.com)
* Bootstrap Dialog (https://github.com/nakupanda/bootstrap3-dialog)
* Bootstrap Datepicker (https://github.com/uxsolutions/bootstrap-datepicker/)
* Fancybox (https://github.com/fancyapps/fancybox)
* Font Awesome (http://fortawesome.github.io/Font-Awesome)
* gmaps (https://github.com/hpneo/gmaps)
* SerializeJSON (https://github.com/marioizquierdo/jquery.serializeJSON)
* Select2 (https://github.com/select2/select2)


### Features
* Create a profile with a username, profile picture, cover picture, bio and personal information
* Share Posts, Images
* Find, follow your friends and send direct message to them
* Make comments on Posts, Images
* Like Posts, Images
* Follow new events with notifications
* Add hobbies
* Become a member of a hobby group automatically and interact with other people
* Hide your profile by sharing your location. Let only the people around you to have access to communicate with you
* Find people around you at the same location, having same hobby and become a member of an automatically created hobby group

### Pages 
There are 7 pages. which are Home Page for Login and Sign Up,  TimeLine, Direct Messages and Profile you know.
* Nearby page is for seeing people around you.  
* Groups are created automatically for people who share the same hobby.  You can see group posts in groups page if you added that specific hobby.  
* Following & Followers page shows the list of followers and people you are following.  

### Packages Included
* alexpechkarev/google-maps
* barryvdh/laravel-debugbar
* barryvdh/laravel-ide-helper
* nesbot/carbon

### Requirements
* PHP 5.6.4
* MySQL


### Authors
**lvntayn**
- https://github.com/lvntayn

**theoneremains**
- https://github.com/theoneremains

**koniqwe**
- https://github.com/koniqwe
