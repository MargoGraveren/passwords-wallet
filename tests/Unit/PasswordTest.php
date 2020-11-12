<?php

namespace Tests\Unit;

use App\Http\Controllers\PasswordController;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    private $sha512Key = 'eb3c65fd80fae3d4455529117e9c8c758e9ea73042041c0932b4b0b5f5e4909e6daa51ee82c32136c0bedeb068f170901a62124adbcfa47710faaf19a3a0d448';
    private $hmacKey = '6b9eefc1cc88a500a1531778c727f72a';

    // ENCRYPT PASSWORD

    // testing encrypting passwords with SHA512 when parameters are correct
    /**
     * @dataProvider generateExampleCorrectPasswordsToEncryptWithSha512
     */
    public function testIsPasswordEncryptableWithSha512_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = PasswordController::encryptPassword($plainText, $this->sha512Key);
        $this->assertTrue($result != '');
    }

    // testing encrypting passwords with SHA512 when key is missing

    /**
     * @dataProvider generateExampleCorrectPasswordsToEncryptWithSha512
     */
    public function testIsPasswordEncryptableWithSha512_returnCorrectResult_whenKeyIsMissing($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, null);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsToEncryptWithSha512(){
        return $passwords[] = [['fcwe24few23'], ['f32wesdewfr23fdwe'], ['7823e983293qyhf98dxaiwwyfd']];
    }

    // testing encrypting passwords with SHA512 when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswordsToEncryptWithSha512
     */
    public function testIsPasswordEncryptableWithSha512_throwException_noParameterGiven($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, $this->sha512Key);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleEmptyPasswordsToEncryptWithSha512(){
        return $passwords[] = [[null], ['']];
    }

    // testing encrypting passwords with HMAC when parameters are correct

    /**
     * @dataProvider generateExampleCorrectPasswordsToEncryptWithHMAC
     */
    public function testIsPasswordEncryptableWithHMAC_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = PasswordController::encryptPassword($plainText, $this->hmacKey);
        $this->assertTrue($result != '');
    }

    // testing encrypting passwords with HMAC when key is missing

    /**
     * @dataProvider generateExampleCorrectPasswordsToEncryptWithHMAC
     */
    public function testIsPasswordEncryptableWithHMAC_returnCorrectResult_whenKeyIsMissing($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, null);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsToEncryptWithHMAC(){
        return $passwords[] = [['fcwe24few23'], ['f32wesdewfr23fdwe'], ['7823e983293qyhf98dxaiwwyfd']];
    }

    // testing encrypting passwords with HMAC when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswordsToEncryptWithHMAC
     */
    public function testIsPasswordEncryptableWithHMAC_throwException_noParameterGiven($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, $this->hmacKey);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleEmptyPasswordsToEncryptWithHMAC(){
        return $passwords[] = [[null], ['']];
    }

    //DECRYPT PASSWORD

    // testing decrypting passwords with SHA512 when parameters are correct
    /**
     * @dataProvider generateExampleCorrectPasswordsToDecryptWithSha512
     */
    public function testIsPasswordDecryptableWithSha512_returnCorrectResult_correctParameterGiven($cipherText)
    {
        $result = PasswordController::decryptPassword($cipherText, $this->sha512Key);
        $this->assertTrue($result != '');
    }

    // testing decrypting passwords with SHA512 when the key is missing
    /**
     * @dataProvider generateExampleCorrectPasswordsToDecryptWithSha512
     */
    public function testIsPasswordDecryptableWithSha512_returnCorrectResult_whenKeyIsMissing($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, null);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsToDecryptWithSha512(){
        return $passwords[] = [
            [PasswordController::encryptPassword('fcwe24few23', $this->sha512Key)],
            [PasswordController::encryptPassword('f32wesdewfr23fdwe', $this->sha512Key)],
            [PasswordController::encryptPassword('7823e983293qyhf98dxaiwwyfd', $this->sha512Key)]
        ];
    }

    // testing decrypting passwords with SHA512 when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswordsToDecryptWithSha512
     */
    public function testIsPasswordDecryptableWithSha512_throwException_noParameterGiven($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, $this->sha512Key);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleEmptyPasswordsToDecryptWithSha512(){
        return $passwords[] = [[null], ['']];
    }

    // testing decrypting passwords with HMAC when parameters are correct

    /**
     * @dataProvider generateExampleCorrectPasswordsToDecryptWithHMAC
     */
    public function testIsPasswordDecryptableWithHMAC_returnCorrectResult_correctParameterGiven($cipherText)
    {
        $result = PasswordController::decryptPassword($cipherText, $this->hmacKey);
        $this->assertTrue($result != '');
    }

    // testing decrypting passwords with HMAC when the key is missing

    /**
     * @dataProvider generateExampleCorrectPasswordsToDecryptWithHMAC
     */
    public function testIsPasswordDecryptableWithHMAC_returnCorrectResult_whenKeyIsMissing($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, null);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsToDecryptWithHMAC(){
        return $passwords[] = [
            [PasswordController::encryptPassword('fcwe24few23', $this->hmacKey)],
            [PasswordController::encryptPassword('f32wesdewfr23fdwe', $this->hmacKey)],
            [PasswordController::encryptPassword('7823e983293qyhf98dxaiwwyfd', $this->hmacKey)]
        ];
    }

    // testing decrypting passwords with HMAC when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswordsToDecryptWithHMAC
     */
    public function testIsPasswordDecryptableWithHMAC_throwException_noParameterGiven($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, $this->hmacKey);
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleEmptyPasswordsToDecryptWithHMAC(){
        return $passwords[] = [[null], ['']];
    }
}
