<?php

namespace App\Models;

use App\Controllers\Connection;
use App\Flash;
use App\Lib\Helpers;
use App\Mail;
use App\Token;
use Core\Model;
use Core\View;
use PDO;
use Faker;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    /**
     * User constant
     */
    const USER = true;

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * User constructor.
     * @param array $data
     */
    public function __construct($data=[])
    {
        foreach ($data as $key => $value){
            $this->$key=$value;
        }
    }

    /* **************************************
     * Section 1
     * Signup User Functions
     * ***************************************
     * */

    /**
     * Save user information into database
     *
     * @return bool|false
     */
    public function save(){

        $this->validate();

        if(empty($this->errors)){
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $pid = self::generateProfileId(7);
            $avatar = self::getDefaultAvatar($this->gender);

            $token = new Token();
            $hashed_token = $token->getHash();             // Saved in users table
            $this->activation_token = $token->getValue();  // To be send in email

            $sql = 'INSERT INTO users (mobile, email, password_hash, for_id, gender, pid, avatar, activation_hash)
                    VALUES (:mobile, :email, :password_hash, :cFor, :gender, :pid, :avatar, :activation_hash)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':mobile', $this->mobile, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':cFor', $this->cFor, PDO::PARAM_INT);
            $stmt->bindValue(':gender', $this->gender, PDO::PARAM_INT);
            $stmt->bindValue(':pid', $pid, PDO::PARAM_STR);
            $stmt->bindValue(':avatar', $avatar, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);

            return $stmt->execute();

        }

        return false;
    }

    /**
     * Validate User Input
     */
    public function validate(){

        // cFor
        if($this->cFor==''){
            $this->errors[] = 'For is required';
        }

        // gender
        if($this->gender==''){
            $this->errors[] = 'Gender is required';
        }

        // email address
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Invalid email';
        }
        if($this->emailExists($this->email)){
            $this->errors[] = 'Email already exists';
        }

        // mobile address
        if (!preg_match("/^[6-9]\d{9}$/",$this->mobile)) {
            $this->errors[] = 'Invalid mobile number';
        }

        if($this->mobileExists($this->mobile)){
            $this->errors[] = 'Mobile already exists';
        }

        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }
    }

    /**
     * @param $size
     * @return string
     */
    public static function generateProfileId($size){

        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 2;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $alpha_key . $key;

    }

    /**
     * @param $gender
     * @return string
     */
    public static function getDefaultAvatar($gender){

        return $gender==1?'avatar_groom.jpg':'avatar_bride.jpg';
    }

    /* **************************************
     * Section 2
     * Login User Functions
     * ***************************************
     * */

    /**
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public static function authenticate($email, $password){

        $user = static::findByEmail($email);
        if($user){
            if(password_verify($password,$user->password_hash)){
                return $user;
            }
        }
        return false;
    }

    /**
     * Used to remember user at database level
     * @return bool
     */
    public function rememberLogin(){

        $token = new Token();
        $hashed_token = $token->getHash();

        $this->remember_token = $token->getValue();
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;

        $sql = "INSERT INTO remembered_logins (token_hash, user_id, expires_at) 
                VALUES (:token_hash, :user_id, :expires_at)";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $hashed_token,PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /* **************************************
      * Section - 3
      * Find User Functions
      * ***************************************
      * */

    /**
     * @param $email
     * @param null $ignore_id
     * @return bool
     */
    public function emailExists($email, $ignore_id=null){

        $user = static::findByEmail($email);

        if($user){
            if($user->id !=$ignore_id){
                return true;
            }
        }
        return false;

    }

    /**
     * @param $mobile
     * @param string $ignore_id
     * @return bool
     */
    public function mobileExists($mobile, $ignore_id=''){

        $user = static::findByMobile($mobile);

        if($user){
            if($ignore_id != $user->id){
                return true;
            }
        }
        return false;

    }

    /**
     * @param $email
     * @return mixed
     */
    public static function findByEmail($email){

        $sql = "SELECT * FROM users WHERE email= :email";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':email',$email,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $mobile
     * @return mixed
     */
    public static function findByMobile($mobile){

        $sql = "SELECT * FROM users WHERE mobile= :mobile";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':mobile',$mobile,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function findByID($id){

        //$sql = "SELECT * FROM users WHERE id= :id";

        $sql = "SELECT users.*,
            heights.feet as ht, 
            religions.name as religion,
            languages.text as lang,
            maritals.status as mstatus,
            educations.name as edu,
            degrees.name as deg,
            universities.name as university,
            occupations.name as occ,
            sectors.name as sector,
            incomes.level as income,
            fathers.status as faa,
            mothers.status as maa,
            fam_affluence.status as fama,
            fam_values.name as famv,
            fam_types.name as famt,
            fam_incomes.level as fami,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            bodies.type as body,
            complexions.type as complexion,
            blood_groups.type as bg,
            thalassemia.status as thal,
            challenged.status as chal,
            citizenship.status as res,
            signs.text as sun,
            rashis.text as rashi,
            nakshatras.text as nak,
            mangliks.status as manglik
            FROM users
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.community_id
            LEFT JOIN maritals ON maritals.id = users.marital_id    
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN degrees ON degrees.id = users.degree_id
            LEFT JOIN universities ON universities.id = users.university_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            LEFT JOIN sectors ON sectors.id = users.sector_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN fathers ON fathers.id = users.father_id
            LEFT JOIN mothers ON mothers.id = users.mother_id
            LEFT JOIN fam_affluence ON fam_affluence.id = users.famAffluence_id
            LEFT JOIN fam_values ON fam_values.id = users.famValue_id
            LEFT JOIN fam_types ON fam_types.id = users.famType_id
            LEFT JOIN fam_incomes ON fam_incomes.id = users.famIncome_id
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN bodies ON bodies.id = users.body_id
            LEFT JOIN complexions ON complexions.id = users.complexion_id
            LEFT JOIN blood_groups ON blood_groups.id = users.bGroup_id
            LEFT JOIN thalassemia On thalassemia.id = users.thalassemia_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN citizenship ON citizenship.id = users.citizenship_id
            LEFT JOIN signs ON signs.id = users.sun_id
            LEFT JOIN rashis ON rashis.id = users.moon_id
            LEFT JOIN nakshatras ON nakshatras.id = users.nakshatra_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            WHERE users.id= :id";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }


    /**
     * @param $pid
     * @return mixed
     */
    public static function findByProfileId($pid){

        $sql = "SELECT users.*,
            heights.feet as ht, 
            religions.name as religion,
            languages.text as lang,
            maritals.status as mstatus,
            educations.name as edu,
            degrees.name as deg,
            universities.name as university,
            occupations.name as occ,
            sectors.name as sector,
            incomes.level as income,
            fathers.status as faa,
            mothers.status as maa,
            fam_affluence.status as fama,
            fam_values.name as famv,
            fam_types.name as famt,
            fam_incomes.level as fami,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            bodies.type as body,
            complexions.type as complexion,
            blood_groups.type as bg,
            thalassemia.status as thal,
            challenged.status as chal,
            citizenship.status as res,
            signs.text as sun,
            rashis.text as rashi,
            nakshatras.text as nak,
            mangliks.status as manglik
            FROM users
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.community_id
            LEFT JOIN maritals ON maritals.id = users.marital_id    
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN degrees ON degrees.id = users.degree_id
            LEFT JOIN universities ON universities.id = users.university_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            LEFT JOIN sectors ON sectors.id = users.sector_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN fathers ON fathers.id = users.father_id
            LEFT JOIN mothers ON mothers.id = users.mother_id
            LEFT JOIN fam_affluence ON fam_affluence.id = users.famAffluence_id
            LEFT JOIN fam_values ON fam_values.id = users.famValue_id
            LEFT JOIN fam_types ON fam_types.id = users.famType_id
            LEFT JOIN fam_incomes ON fam_incomes.id = users.famIncome_id
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN bodies ON bodies.id = users.body_id
            LEFT JOIN complexions ON complexions.id = users.complexion_id
            LEFT JOIN blood_groups ON blood_groups.id = users.bGroup_id
            LEFT JOIN thalassemia On thalassemia.id = users.thalassemia_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN citizenship ON citizenship.id = users.citizenship_id
            LEFT JOIN signs ON signs.id = users.sun_id
            LEFT JOIN rashis ON rashis.id = users.moon_id
            LEFT JOIN nakshatras ON nakshatras.id = users.nakshatra_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            WHERE pid=?";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pid]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /* **************************************
     * Section 4
     * Ajax call Functions
     * ***************************************
     * */

    public function moveProfile($sender,$receiver){

        // json encode
        //$like_array = json_encode($like_array);

        // prepare query
        $query = "UPDATE users SET like_array=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);

        // save to database
        $status =  $stmt->execute([$like_array,$this->id]);

        if($status){
            Notification::save('profile_liked',$profile_id);
        }

    }


    /**
     * @param $like_array
     * @param $profile_id
     * @return void
     */
    /*public function likeProfile($like_array,$profile_id){

        // json encode
        $like_array = json_encode($like_array);

        // prepare query
        $query = "UPDATE users SET like_array=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);

        // save to database
        $status =  $stmt->execute([$like_array,$this->id]);

        if($status){
            Notification::save('profile_liked',$profile_id);
        }

    }*/

    /**
     * @param $short_array
     * @return bool
     */
    /*public function shortProfile($short_array){

        // json encode
        $short_array = json_encode($short_array);

        // prepare query
        $query = "UPDATE users SET short_array=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);

        // save to database
        return $stmt->execute([$short_array,$this->id]);

    }*/

    /**
     * @param $hide_array
     * @return bool
     */
    /*public function hideProfile($hide_array){

        // json encode
        $hide_array = json_encode($hide_array);

        // prepare query
        $query = "UPDATE users SET hide_array=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);

        // save to database
        return $stmt->execute([$hide_array,$this->id]);

    }*/

    /**
     * @param $time
     * @return bool
     */
    public function updateLastUserActivity($time){

        $id = $this->id;
        $sql = "UPDATE users SET last_activity=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$time,$id]);


    }

    public function updateRandomShortlist($arr){

        $id = $this->id;
        $sql = "UPDATE users SET short_array=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$arr,$id]);


    }

    /**
     * @param $userId
     * @param $mobile
     * @return bool
     */
    public static function updateMobile($userId, $mobile){

        $query = "UPDATE users SET mobile=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);
        return $stmt->execute([$mobile,$userId]);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function getProfileBasicInfo($userId){

        $sql = "SELECT u.id, u.pid, u.avatar, u.first_name, u.last_name, u.dob, e.name as edu, o.name as occ, sec.name as sec,
                ton.name as lag, rel.name as rel
                FROM users AS u
                LEFT JOIN educations as e ON e.id=u.education_id
                LEFT JOIN occupations as o ON o.id=u.occupation_id
                LEFT JOIN sectors as sec ON sec.id = u.sector_id
                LEFT JOIN religions as rel ON rel.id = u.religion_id
                LEFT JOIN tongues as ton ON ton.id = u.language_id
                WHERE u.id='$userId'";
        $pdo=Model::getDB();
        $stmt=$pdo->query($sql);
        $stmt->execute();
        return $stmt->fetch();
    }



    /* **************************************
     *  Section 5
     *  Administrative Functions
     * ***************************************
     * */

    public static function newMembers(){

        $sql = "SELECT * FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY id desc";
        $pdo = Model::getDB();

        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /**
     * @return int
     */
    public static function getPaidUserCount(){

        $sql = "SELECT * FROM users WHERE is_paid=1";

        $pdo = Model::getDB();
        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * Admin Recent Paid Members
     *
     * @return array
     */
    public static function recentPaidMembers(){

        $sql = "SELECT * FROM users WHERE is_paid=1 ORDER BY id desc LIMIT 10";
        $pdo = Model::getDB();

        $stmt = $pdo->query($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    /* **************************************
    *  Section 6
    *  Referral Program Functions
    * ***************************************
    * */

    /**
     * Persist referral code and hash to database
     *
     * @param $code
     * @param $hash
     * @return bool
     */
    public function insertUserReferral($code, $hash){

        $sql = "UPDATE users SET referral_code= :referral_code, referral_hash= :referral_hash WHERE id= :user_id";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':referral_code', $code,PDO::PARAM_STR);
        $stmt->bindValue(':referral_hash', $hash,PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Fetch user class from referral code
     * @param $code
     * @return mixed
     */
    public static function getUserFromReferralCode($code){

        $token = new Token($code);
        $token_hash = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE referral_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();

    }

    /**
     * Get id of referred-by user
     * @param $code
     * @return mixed
     */
    protected static function getReferredByUserId($code){

        $referredByUser = self::getUserFromReferralCode($code);
        if($referredByUser){
            return $referredByUser->id;
        }
        return null;

    }


    /* **************************************
     *  Section 7
     *  Password Reset Functions
     * ***************************************
     * */

    /**
     * Send password reset instructions to the user specified
     *
     * @param string $email The email address
     *
     * @return void
     */
    public static function sendPasswordReset($email)
    {
        $user = static::findByEmail($email);

        if ($user) {

            if ($user->startPasswordReset()) {

                $user->sendPasswordResetEmail();

            }
        }
    }

    /**
     * Start the password reset process by generating a new token and expiry
     *
     * @return bool
     */
    protected function startPasswordReset()
    {
        $token = new Token();
        $hashed_token = $token->getHash();
        $this->password_reset_token = $token->getValue();

        $expiry_timestamp = time() + 60 * 60 * 2;  // 2 hours from now

        $sql = 'UPDATE users
                SET password_reset_hash = :token_hash,
                    password_reset_expires_at = :expires_at
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $expiry_timestamp), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Send password reset instructions in an email to the user
     *
     * @return void
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    protected function sendPasswordResetEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

        $text = View::getTemplate('Password/reset_email.txt', ['url' => $url]);
        $html = View::getTemplate('Password/reset_email.html', ['url' => $url]);

        Mail::send($this->email, 'Password reset', $text, $html);
    }

    /**
     * Find a user model by password reset token and expiry
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     */
    public static function findByPasswordReset($token)
    {
        $token = new Token($token);
        $hashed_token = $token->getHash();

        $sql = 'SELECT * FROM users
                WHERE password_reset_hash = :token_hash';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {

            // Check password reset token hasn't expired
            if (strtotime($user->password_reset_expires_at) > time()) {

                return $user;
            }
        }
    }

    /**
     * Reset the password
     *
     * @param string $password The new password
     *
     * @return boolean  True if the password was updated successfully, false otherwise
     */
    public function resetPassword($password)
    {
        $this->password = $password;

        $this->validateResetPassword();

        if (empty($this->errors)) {

            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'UPDATE users
                    SET password_hash = :password_hash,
                        password_reset_hash = NULL,
                        password_reset_expires_at = NULL
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validation for new password
     */
    protected function validateResetPassword(){

        if (strlen($this->password) < 6) {
            $this->errors[] = 'Please enter at least 6 characters for the password';
        }

        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one letter';
        }

        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'Password needs at least one number';
        }

    }

    /* *********************************
     * Section 8
     * Account Activation Functions
     * **********************************
     * */

    /**
     * Send an email to the user containing the activation link
     *
     * @return void
     */
    public function sendActivationEmail()
    {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/register/activate/' . $this->activation_token;

        $text = View::getTemplate('register/activation_email.txt', ['url' => $url]);
        $html = View::getTemplate('register/activation_email.html', ['url' => $url]);

        Mail::send($this->email, 'Account activation', $text, $html);
        // TODO with mail exception
    }

    /**
     * Activate the user account with the specified activation token
     *
     * @param string $value Activation token from the URL
     *
     * @return void
     */
    public static function activate($value)
    {
        $token = new Token($value);
        $hashed_token = $token->getHash();

        $sql = 'UPDATE users
                SET is_active = 1, ev = 1,
                    activation_hash = null
                WHERE activation_hash = :hashed_token';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':hashed_token', $hashed_token, PDO::PARAM_STR);

        $stmt->execute();
    }


    /* *********************************
     *  Section 9
     *  Advance Search
     * **********************************
     * */

    public static function recentVisitor($uid){

        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            move_profile.num as mov,
            visit_profile.sender as visitor,       
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id
            LEFT JOIN visit_profile ON visit_profile.sender = users.id
            
            WHERE visit_profile.sender IS NOT NULL 
       
        ";

        $sql .= " ORDER BY visit_profile.created_at DESC";
        $sql .= " LIMIT 10";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


    public static function shortlist($uid): array
    {

        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
          
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            move_profile.num as mov, 
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id            
            
            WHERE move_profile.sender= :id AND move_profile.num = 2
       
        ";

        $sql .= " ORDER BY move_profile.created_at DESC";
        $sql .= " LIMIT 10";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function newlist($uid): array
    {
        $cUser = self::findByID($uid);
        $cg = $cUser->gender;
        $min_ht = $cUser->min_ht;
        $max_ht = $cUser->max_ht;
        $min_age = $cUser->min_age;
        $maxDate = \Carbon\Carbon::today()->subYears($min_age)->endOfDay()->toDateString();
        $max_age = $cUser->max_age;
        $minDate = \Carbon\Carbon::today()->subYears($max_age)->toDateString();
        $casteAry = implode(',',json_decode($cUser->mycastes));
        //$casteAry = array_values($cUser->mycastes);

        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            users.height_id,
            users.manglik_id,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            move_profile.num as mov, 
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id            
            
            WHERE move_profile.num IS NULL
            
            AND users.gender != :cg
            AND users.height_id >= :min_ht
            AND users.height_id <= :max_ht
            AND users.dob <= CAST('$maxDate' AS DATE)
            AND users.dob >= CAST('$minDate' AS DATE)
               
        ";
        if($cUser->cnb == 0){
            $sql .= "AND (users.caste_id IN ($casteAry) OR users.caste_id IS NULL)";
        }else{
            $sql .= "AND (users.caste_id IN ($casteAry) OR users.caste_id IS NULL OR users.cnb=1)";
        }

        if($cUser->pm==0){
            $sql .= "AND (users.manglik_id <> 1 OR users.manglik_id IS NULL)";
        }else{
            $sql .= "AND (users.manglik_id <> 2 OR users.manglik_id IS NULL)";
        }

        $sql .= " ORDER BY users.id DESC";
        $sql .= " LIMIT 10";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':cg',$cg,PDO::PARAM_INT);
        $stmt->bindParam(':min_ht',$min_ht,PDO::PARAM_INT);
        $stmt->bindParam(':max_ht',$max_ht,PDO::PARAM_INT);
//        $stmt->bindParam(':min_age',$min_age,PDO::PARAM_INT);
//        $stmt->bindParam(':max_age',$max_age,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function customSearchResults($advQuery=''){

        /*
         * Build query ----- 1
         * */
        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            move_profile.num as mov,
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id
            
            WHERE users.id <=20 AND move_profile.num IS NULL 
       
        ";


        if(!empty($advQuery)){
            $sql .= " WHERE ";
            $i=1;
            foreach ($advQuery as $query){
                if($i < count($advQuery)){
                    $sql .= $query." AND ";
                }else{
                    $sql .= $query;
                }
                $i++;
            }
        }

        $sql .= " ORDER BY users.id ASC";
        //$sql .= " ORDER BY rand()";
        $sql .= " LIMIT 10";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function getAdvanceSearchResults($advQuery=''){

        /*
         * Build query ----- 1
         * */
        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            move_profile.num as mov,
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id
            
            WHERE users.id <=10
       
        ";


        if(!empty($advQuery)){
            $sql .= " WHERE ";
            $i=1;
            foreach ($advQuery as $query){
                if($i < count($advQuery)){
                    $sql .= $query." AND ";
                }else{
                    $sql .= $query;
                }
                $i++;
            }
        }

        $sql .= " ORDER BY users.id ASC";
        //$sql .= " ORDER BY rand()";
        $sql .= " LIMIT 20";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /* *********************************
     *  Section 9
     *  Quick Search ~
     * **********************************
     * */

    public static function getQuickSearchResults($advQuery=''): array
    {

        /*
         * Build query ----- 1
         * */
        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            
            heights.ft as ht, 
            religions.name as religen,
            languages.text as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            districts.text as town,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN languages ON languages.value = users.language_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN districts ON districts.id = users.district_id
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
       
        ";


        if(!empty($advQuery)){
            $sql .= " WHERE ";
            $i=1;
            foreach ($advQuery as $query){
                if($i < count($advQuery)){
                    $sql .= $query." AND ";
                }else{
                    $sql .= $query;
                }
                $i++;
            }
        }

        $sql .= " ORDER BY users.id ASC";
        //$sql .= " ORDER BY rand()";
        $sql .= " LIMIT 10";

        //var_dump($sql);

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }



    /* *********************************
     *  Section 9
     *  Advance Search
     * **********************************
     * */

    public static function verifyUser($userId){

        $sql = "UPDATE users SET is_verified=1 WHERE id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * On Successful payment update user paid status
     * @param $userId
     * @return bool
     */
    public static function updateUserPaidStatus($userId){

        $sql = "UPDATE users SET is_paid=1 WHERE id=?";
        $pdo=Model::getDB();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$userId]);

    }



    /**
     * Seed users table for development
     * with given number of rows
     * @param $num
     */
    public static function seedUsersTable($num){

        $faker = Faker\Factory::create();


        $sql = "INSERT INTO users( pid, mobile, email, password_hash, first_name, last_name, name, username, gender, 
                avatar, for_id, height_id, language_id, occupation_id, district_id, education_id, dob, marital_id, 
                religion_id, degree_id, university_id, community_id) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);

        // Password is fixed for seeding purpose
        $hashedPwd = password_hash('titanic2020', PASSWORD_DEFAULT);

        for($i=0; $i < $num; $i++) {
            $pid = self::generateProfileId(7);
            $mobile = $faker->phoneNumber;
            $email = $faker->email;
            $fn = $faker->firstName;
            $ln = $faker->lastName;
            $name = $fn . ' ' . $ln;
            $username = $faker->userName;
            $gender = rand(1, 2);
            $avatar = $gender == 1 ? 'avatar_groom.jpg' : 'avatar_bride.jpg';
            $cFor = rand(1, 7);
            $ht = array_rand(UserVariables::heights());
            $lag = array_rand(UserVariables::getTongues());
            $occ = array_rand(UserVariables::getOccupations());
            $dis = array_rand(UserVariables::districts());
            $edu = array_rand(UserVariables::getEducations());
            $dob = UserVariables::randomDate(1987 - 01 - 01, 2000 - 12 - 31);
            $ms = array_rand(UserVariables::maritals());
            $rel = array_rand(UserVariables::religions());
            $deg = array_rand(UserVariables::degrees());
            $uni = array_rand(UserVariables::universities());
            $com = array_rand(UserVariables::communities());

            $stmt->execute([$pid, $mobile, $email, $hashedPwd, $fn, $ln, $name, $username, $gender,
                $avatar, $cFor,$ht, $lag, $occ, $dis, $edu, $dob, $ms, $rel, $deg, $uni, $com]);


        }
    }

    public static function timeQuery($t){

        $query = "SELECT * FROM users WHERE created_at > ?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($query);
        $stmt->execute([$t]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    public function likesArr(){

        $user_likes = $this->like_array;
        return Helpers::emptyStringIntoArray($user_likes);

    }

    public function shortsArr(){

        $user_shorts = $this->short_array;
        return Helpers::emptyStringIntoArray($user_shorts);

    }

    public function hidesArr(){

        $user_hides = $this->hide_array;
        return Helpers::emptyStringIntoArray($user_hides);

    }


    /* **************************************
     *  Section
     *  Update User Functions
     * ***************************************
     * */

    /**
     * @param $data
     * @return bool
     */
    public function saveUserProfile($data){

        foreach ($data as $key => $value){
            $this->$key=$value;
        }

        $this->name = $this->first_name.' '.$this->last_name;
        $this->dob = $this->year.'-'.$this->month.'-'.$this->day;
        $this->country_id = 77;

        $sql = "UPDATE users SET 
                first_name= :fName,
                last_name= :lName,
                name= :name, 
                dob= :dob,
                religion_id= :religion,
                community_id= :community,
                education_id= :education,
                occupation_id= :occupation,
                marital_id= :marital,
                manglik_id= :manglik,
                height_id= :height,
                country_id= :country
                WHERE id= :id";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([
            ':fName'=>$this->first_name,
            ':lName'=>$this->last_name,
            ':name'=>$this->name,
            ':dob'=>$this->dob,
            ':religion'=>$this->religion_id,
            ':community'=>$this->community_id,
            ':education'=>$this->education_id,
            ':occupation'=>$this->occupation_id,
            ':marital'=>$this->marital_id,
            ':manglik'=>$this->manglik_id,
            ':height'=>$this->height_id,
            ':country'=>$this->country_id,
            ':id'=>$this->id
        ]);
    }

    public static function getFiveRandomProfiles($gender){

        $sql = "SELECT id from users WHERE gender!=?";
        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$gender]);

        $user_ids = array_keys($stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC));

        $list =  array_rand($user_ids,3);
        $returnArr=array();
        foreach ($list as $k=>$v){
            $returnArr[]=$user_ids[$v];
        }
        return $returnArr;

    }

    public function updateOtp($otp){

        $this->otp = $otp;
        $sql = "UPDATE users SET otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->otp,
            $this->id
        ]);
    }

    public function verifyMobile(){

        $sql = "UPDATE users SET mv=?,otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([1,Null,$this->id]);
    }


    public function updateBasicInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $sql = "UPDATE users SET first_name=?, last_name=?, caste_id=?, language_id=?, marital_id=?, height_id=?, 
                country_id=?, state_id=?, district_id=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->first_name,
            $this->last_name,
            $this->caste_id,
            $this->language_id,
            $this->marital_id,
            $this->height_id,
            $this->country_id,
            $this->state_id,
            $this->district_id,
            $this->id
        ]);
    }

    public function updateCasteInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }
        $mycastes = json_encode($this->mycastes);

        $sql = "UPDATE users SET mycastes=? WHERE id =?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([$mycastes, $this->id]);
    }

    public function updatePartnerPreference($data): bool
    {
        foreach($data as $key=>$val){
            $this->$key=$val;
        }
        $mycastes = json_encode($this->mycastes);
        $cnb = $this->cnb;
        $min_age = $this->min_age;
        $max_age = $this->max_age;
        $min_ht = $this->min_ht;
        $max_ht = $this->max_ht;
        $pm = $this->pm;

        $sql = "UPDATE users SET mycastes=?,cnb=?,min_age=?,max_age=?,min_ht=?,max_ht=?,pm=? WHERE id =?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([$mycastes,$cnb,$min_age,$max_age,$min_ht,$max_ht,$pm,$this->id]);
    }

    public function updateEduCareerInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $db = Model::getDB();
        $sql = "UPDATE users SET education_id=?, degree_id=?, university_id=?, other_deg=?, sector_id=?, 
                occupation_id=?, working_in=?, income_id=? WHERE id=?";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            $this->education_id,
            $this->degree_id,
            $this->university_id,
            $this->other_deg,
            $this->sector_id,
            $this->occupation_id,
            $this->working_in,
            $this->income_id,
            $this->id]);

        return $result;
    }

    public function updateFamilyInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $db = Model::getDB();
        $sql = "UPDATE users SET father_id=?, mother_id=?, bros=?, mbros=?, sis=?, msis=?,
                famAffluence_id=?, famType_id=?, famValue_id=?, famIncome_id=? WHERE id=?";
        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            $this->father_id,
            $this->mother_id,
            $this->bros,
            $this->mbros,
            $this->sis,
            $this->msis,
            $this->famAffluence_id,
            $this->famType_id,
            $this->famValue_id,
            $this->famIncome_id,
            $this->id
        ]);

        return $result;

    }

    public function updateLifestyleInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }
        $langs = json_encode($this->langs);

        $db = Model::getDB();
        $sql = "UPDATE users SET diet_id=?, smoke_id=?, drink_id=?, pets=?, house=?, car=?, body_id=?, complexion_id=?,
                weight_id=?, bGroup_id=?,thalassemia_id=?,hiv=?,challenged_id=?,citizenship_id=?,langs=? WHERE id =?";
        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            $this->diet_id,
            $this->smoke_id,
            $this->drink_id,
            $this->pets,
            $this->house,
            $this->car,
            $this->body_id,
            $this->complexion_id,
            $this->weight_id,
            $this->bGroup_id,
            $this->thalassemia_id,
            $this->hiv,
            $this->challenged_id,
            $this->citizenship_id,
            $langs,
            $this->id
        ]);

        return $result;
    }

    public function updateLikesInfo($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $myHobbies = json_encode($this->myhobbies);
        $myInterests = json_encode($this->myinterests);

        $db = Model::getDB();
        $sql = "UPDATE users SET myhobbies=?, myinterests=? WHERE id =?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$myHobbies,$myInterests,$this->id]);
    }

    public function updateAstroDetails($data){

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $db = Model::getDB();
        $sql = "UPDATE users SET sun_id=?, moon_id=?, nakshatra_id=?, horoscope=?, manglik_id=?, hm=?, hp=? WHERE id =?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->sun_id,
            $this->moon_id,
            $this->nakshatra_id,
            $this->horoscope,
            $this->manglik_id,
            $this->hm,
            $this->hp,
            $this->id
        ]);
    }

    /*public static function getUsersByTimestamp($t){

        $sql = "SELECT * FROM users WHERE created_at<='.$t.'";

        $db= Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/

    public static function liveSearch($start, $limit): array
    {

        $query = "SELECT * FROM users";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    public static function liveSearchCount(): int
    {

        $query = "SELECT * FROM users";

        if($_POST['query'] != ''){
            $query .= '
            WHERE first_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR last_name LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR email LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();


    }

    public function incrementAc(){

        $rcn = new RecordContact();

        $this->ac = $this->ac+1;

        $db = Model::getDB();
        $sql = "UPDATE users SET ac=? WHERE id =?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->ac,
            $this->id
        ]);

    }


}
