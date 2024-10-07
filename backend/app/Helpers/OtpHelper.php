<?php
namespace App\Helpers;

use App\Models\Otp;
use Illuminate\Support\Facades\Hash;

class OtpHelper
{
    /**
     * @var OTP_TTL Default otp digits length
     */
    const OTP_DIGITS_LENGTH = 6;

    /**
     * @var OTP_TTL Default TTL in minutes
     */
    const OTP_TTL= 15;

    public function createOtp(string $identifier, ?int $length = null) : string
    {
        $schema = $this->generateCode($length);
        $this->delete($this->getOtp($identifier));
        Otp::create([
            'unique_identifier' => $identifier,
            'code' => $schema['hashed'],
            'created_at' => now()
        ]);
        return $schema['plain_text'];
    }

    private function generateCode(?int $length): array
    {
        $code = $this->generateRandomNumber($length ?? static::OTP_DIGITS_LENGTH);
        return [
            'plain_text'    => $code,
            'hashed'        => Hash::make($code)
        ];
    }

    private function generateRandomNumber(int $length) :string
    {
        $min = pow(10, $length - 2);
        $max = pow(10, $length) - 1;
        $random = mt_rand($min, $max);

        return str_pad($random, $length, '0', STR_PAD_LEFT);
    }

    public function hasExpired(?Otp $otp, ?int $ttl = null): bool
    {
        $ttl = $ttl ? : static::OTP_TTL;
        if(!$otp){
            return true;
        }
        return now()->greaterThan($otp->created_at->addMinutes($ttl));
    }

    public function getOtp(string $identifier) : ?Otp
    {
        return Otp::where('unique_identifier', $identifier)->latest('id')->first();
    }

    public function check(?Otp $otp, string $code) : bool
    {
        if(!$otp){
            return false;
        }
        $validity = Hash::check($code, $otp->code);
        return ($validity);
        if($validity){
            $this->delete($otp);
        }
        return $validity;
    }

    private function delete(?Otp $otp) :bool
    {
        if(!$otp){
            return false;
        }
        return $otp->delete();
    }
}