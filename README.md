PHP off the Rails
-----------------

hi, guys. this is my newest library for php. it makes php apps
instantly better. it supports modern technologies ,such as
"off railing". it was made with memory in mind, so it unsets
everything just in  case PHP will forget ( not that this will
ever happen because   php is perfect :-) ) .

anyways ,this library is so easy to use that you probably could
use it without guide, if not see that example

```php
<?;
;// includ my awesome lib //;
;require 'off-rails.php'
;
;get('/', 'howdyworld')
;whatever('*', 'errorz')
;function howdyworld (){
;echo 'hello world
;'
;}
;function  errorz( $page) {
;  echo "i'm sorry, but..."
;   echo "$page doesn't exist!"
;echo 'would you like to create it'
;      echo 'that would be fatal error, so i leaf'
;}
;//?>
```
