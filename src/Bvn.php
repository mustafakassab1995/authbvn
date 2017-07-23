<?php
namespace Flutterwave;

use Flutterwave\FlutterEncrypt;

/**
* interacts with the bvn api on flutterwave
*/
class Bvn {

  //@var array resources
  private static $bvnResources = [
    "staging" => [
      "verify" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/verify",
      "validate" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/validate",
      "resendOtp" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/resendOtp"
    ],
    "production" => [
    "verify" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/verify",
      "validate" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/validate",
      "resendOtp" => "https://authbvn.herokuapp.com/authbvn/api/v1.0/resendOtp"
    ]
  ];

  /**
  * use verify to confirm the customer with the bvn
  * is the owner of the bvn
  * @param string $bvn
  * @param string $optOption can be voice or sms defaults to sms
  * @return ApiResponse
  */
  public static function verify($bvn, $otpOption = Flutterwave::SMS) {
    FlutterValidator::validateClientCredentialsSet();
    $resource = self::$bvnResources[Flutterwave::getEnv()]["verify"];
    $encryptedOtpOption = FlutterEncrypt::encrypt3Des($otpOption, Flutterwave::getApiKey());
    $resp = (new ApiRequest($resource))
              ->addBody("country", "NGN")
              ->addBody("verifyUsing", "SMS")
              ->addBody("bvn", $bvn)
              ->makePostRequest();
    return $resp;
  }

  /**
   * validate the otp sent to the bvn owners phone
   * @param string $bvn used in verify call
   * @param string $otp otp sent to the bvn owners phone
   * @param string $transactionRef the transaction reference in the verify response data
   */
  public static function validate($bvn, $otp, $transactionRef) {
    FlutterValidator::validateClientCredentialsSet();
    $resource = self::$bvnResources[Flutterwave::getEnv()]["validate"];
  

    $resp = (new ApiRequest($resource))
              ->addBody("bvn", $bvn)
              ->addBody("transactionReference", $transactionRef)
              ->addBody("otp", $otp)
              ->addBody("country", "NGN")
              ->makePostRequest();
    return $resp;
  }

  /**
   * resend otp if bvn owner did not get the first otp message
   * @param string $transactionRef transaction reference from verify response
   * @param string $otpOption can be sms or voice. default is sms
   */
  public static function resendOtp($transactionRef, $otpOption = Flutterwave::SMS) {
    FlutterValidator::validateClientCredentialsSet();
    $encryptedRef = FlutterEncrypt::encrypt3Des($transactionRef, Flutterwave::getApiKey());
    $encryptedOption = FlutterEncrypt::encrypt3Des($otpOption, Flutterwave::getApiKey());
    $resource = self::$bvnResources[Flutterwave::getEnv()]["resendOtp"];
    $resp = (new ApiRequest($resource))
              ->addBody("VerifyUsing", "SMS")
              ->addBody("transactionReference", $transactionRef)
              ->addBody("country", "NGN")
              ->makePostRequest();
    return $resp;
  }
}
