# authbvn
https://authbvn.herokuapp.com/

## authbvn
-validate bvn
-get user info


### Requirements
- > PHP 5.5.3

### Installation

Add authbvn to your `composer.json` file
```
"require": {
  "mustafakassab1995/authbvn": "dev-master"
}
```

Then do to update your packages with authbvn
```
composer update
```

If your framework does not autoload by default or you are creating a composer project from scratch, please
remember that you will need to include vendor/autoload e.g
```
require_once 'path_to_vendor/autoload.php';
```



### Please note that a success status on our response does not always mean that the payment was successful, it most probably simply means that we were able to make an attempt in processing the payment. This means that you as a customer has to ensure that you check the content of the data returned for the proper response, for response codes and response messages especially.
