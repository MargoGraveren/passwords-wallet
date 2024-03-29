<?php

namespace Tests\Unit;

use App\Http\Controllers\PasswordController;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    private $sha512Key = 'eb3c65fd80fae3d4455529117e9c8c758e9ea73042041c0932b4b0b5f5e4909e6daa51ee82c32136c0bedeb068f170901a62124adbcfa47710faaf19a3a0d448';
    private $hmacKey = '6b9eefc1cc88a500a1531778c727f72a';

    //data providers
    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPlainPasswords(){
        return $passwords[] = [['fcwe24few23'], ['f32wesdewfr23fdwe'], ['7823e983293qyhf98dxaiwwyfd']];
    }

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleEmptyPasswords(){
        return $passwords[] = [[null], ['']];
    }

    // HASH PASSWORD

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordHashableWithSha512_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = hash('sha512', $plainText);
        $this->assertTrue($result != null);
    }

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordHashableWithSha512_returnWarning_missingParameterWithHashType($plainText)
    {
        $this->expectWarning();
        $result = hash(null, $plainText);
    }

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordHashableWithHMAC_throwException_noParameterGiven($plainText)
    {
        $result = hash_hmac('md5', $plainText, 'exampleKey');
        $this->assertTrue($result != null);
    }

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordHashableWithHMAC_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = hash_hmac('md5', $plainText, 'exampleKey');
        $this->assertTrue($result != null);
    }

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordHashableWithHMAC_returnWarning_missingParameterWithHashType($plainText)
    {
        $this->expectWarning();
        $result = hash_hmac(null, $plainText, 'exampleKey');
    }

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordHashableWithSha512_returnCorrectResult_noParameterGiven($plainText)
    {
        $result = hash_hmac('md5', $plainText, 'exampleKey');
        $this->assertTrue($result != null);
    }

    // ENCRYPT PASSWORD

    // testing encrypting passwords with SHA512 when parameters are correct
    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordEncryptableWithSha512_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = PasswordController::encryptPassword($plainText, $this->sha512Key);
        $this->assertTrue($result != '');
    }

    // testing encrypting passwords with SHA512 when key is missing

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordEncryptableWithSha512_returnCorrectResult_whenKeyIsMissing($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, null);
    }

    // testing encrypting passwords with SHA512 when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordEncryptableWithSha512_throwException_noParameterGiven($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, $this->sha512Key);
    }

    // testing encrypting passwords with HMAC when parameters are correct

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordEncryptableWithHMAC_returnCorrectResult_correctParameterGiven($plainText)
    {
        $result = PasswordController::encryptPassword($plainText, $this->hmacKey);
        $this->assertTrue($result != '');
    }

    // testing encrypting passwords with HMAC when key is missing

    /**
     * @dataProvider generateExampleCorrectPlainPasswords
     */
    public function testIsPasswordEncryptableWithHMAC_returnCorrectResult_whenKeyIsMissing($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, null);
    }

    // testing encrypting passwords with HMAC when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordEncryptableWithHMAC_throwException_noParameterGiven($plainText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::encryptPassword($plainText, $this->hmacKey);
    }

    //DECRYPT PASSWORD

    //data provider passwords decrypted with SHA512
    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsEncryptedWithSha512(){
        return $passwords[] = [
            [PasswordController::encryptPassword('fcwe24few23', $this->sha512Key)],
            [PasswordController::encryptPassword('f32wesdewfr23fdwe', $this->sha512Key)],
            [PasswordController::encryptPassword('7823e983293qyhf98dxaiwwyfd', $this->sha512Key)]
        ];
    }

    //data provider passwords decrypted with HMAC

    /**
     * @return array       // <-- added typehint here
     */
    public function generateExampleCorrectPasswordsDecryptedWithHMAC(){
        return $passwords[] = [
            [PasswordController::encryptPassword('fcwe24few23', $this->hmacKey)],
            [PasswordController::encryptPassword('f32wesdewfr23fdwe', $this->hmacKey)],
            [PasswordController::encryptPassword('7823e983293qyhf98dxaiwwyfd', $this->hmacKey)]
        ];
    }

    // testing decrypting passwords with SHA512 when parameters are correct
    /**
     * @dataProvider generateExampleCorrectPasswordsEncryptedWithSha512
     */
    public function testIsPasswordDecryptableWithSha512_returnCorrectResult_correctParameterGiven($cipherText)
    {
        $result = PasswordController::decryptPassword($cipherText, $this->sha512Key);
        $this->assertTrue($result != '');
    }

    // testing decrypting passwords with SHA512 when the key is missing
    /**
     * @dataProvider generateExampleCorrectPasswordsEncryptedWithSha512
     */
    public function testIsPasswordDecryptableWithSha512_returnCorrectResult_whenKeyIsMissing($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, null);
    }

    // testing decrypting passwords with SHA512 when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordDecryptableWithSha512_throwException_noParameterGiven($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, $this->sha512Key);
    }

    // testing decrypting passwords with HMAC when parameters are correct

    /**
     * @dataProvider generateExampleCorrectPasswordsDecryptedWithHMAC
     */
    public function testIsPasswordDecryptableWithHMAC_returnCorrectResult_correctParameterGiven($cipherText)
    {
        $result = PasswordController::decryptPassword($cipherText, $this->hmacKey);
        $this->assertTrue($result != '');
    }

    // testing decrypting passwords with HMAC when the key is missing

    /**
     * @dataProvider generateExampleCorrectPasswordsDecryptedWithHMAC
     */
    public function testIsPasswordDecryptableWithHMAC_returnCorrectResult_whenKeyIsMissing($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, null);
    }

    // testing decrypting passwords with HMAC when parameters are empty

    /**
     * @dataProvider generateExampleEmptyPasswords
     */
    public function testIsPasswordDecryptableWithHMAC_throwException_noParameterGiven($cipherText)
    {
        $this->expectException(InvalidArgumentException::class);
        $result = PasswordController::decryptPassword($cipherText, $this->hmacKey);
    }
}
