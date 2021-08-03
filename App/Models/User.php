<?php

namespace App\Models;


use App\Lib\Helpers;
use App\Mail;
use App\Token;
use Core\Model;
use Core\View;
use PDO;
use Faker;


/**
 * Class User
 * @package App\Models
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
    public function __construct(array $data=[])
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
    public function save(): bool
    {

        $this->validate();

        if(empty($this->errors)){
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $this->pid = self::generateProfileId(7);
            $avatar = self::getDefaultAvatar($this->gender);

            $this->myhobbies = [];
            $this->myinterests = [];
            $this->mycastes = [];
            $this->langs = [];
            $myhobbies = json_encode($this->myhobbies);
            $myinterests = json_encode($this->myinterests);
            $mycastes = json_encode($this->mycastes);
            $langs = json_encode($this->langs);

            $token = new Token();
            $hashed_token = $token->getHash();             // Saved in users table
            $this->activation_token = $token->getValue();  // To be send in email

            $sql = 'INSERT INTO users (mobile, email, password_hash, for_id, gender, pid, avatar, activation_hash, myhobbies, myinterests, mycastes, langs)
                    VALUES (:mobile, :email, :password_hash, :cFor, :gender, :pid, :avatar, :activation_hash, :hobbies, :interests, :castes, :langs)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':mobile', $this->mobile, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $password_hash, PDO::PARAM_STR);
            $stmt->bindValue(':cFor', $this->cFor, PDO::PARAM_INT);
            $stmt->bindValue(':gender', $this->gender, PDO::PARAM_INT);
            $stmt->bindValue(':pid', $this->pid, PDO::PARAM_STR);
            $stmt->bindValue(':avatar', $avatar, PDO::PARAM_STR);
            $stmt->bindValue(':activation_hash', $hashed_token, PDO::PARAM_STR);
            $stmt->bindValue(':hobbies',$myhobbies,PDO::PARAM_STR);
            $stmt->bindValue(':interests',$myinterests,PDO::PARAM_STR);
            $stmt->bindValue(':castes',$mycastes,PDO::PARAM_STR);
            $stmt->bindValue(':langs',$langs,PDO::PARAM_STR);

            $result = $stmt->execute();

            if($result){
                $this->id = $db->lastInsertId();
            }

            return $result;

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

        $pattern = '/^[0-9A-Za-z!@#$%^&*?]{8,32}$/';
        if (preg_match($pattern, $this->password) == 0) {
            $this->errors[] = 'Minimum 8 digits alphabet, number and special character !@#$%^&*? ';
        }

//        if (strlen($this->password) < 5) {
//            $this->errors[] = 'Please enter at least 6 characters for the password';
//        }
//
//        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
//            $this->errors[] = 'Password needs at least one letter';
//        }
//
//        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
//            $this->errors[] = 'Password needs at least one number';
//        }
    }

    /**
     * Validate Mobile
     */
    public function validateMobile(){

        // mobile address
        if (!preg_match("/^[6-9]\d{9}$/",$this->mobile)) {
            $this->errors[] = 'Invalid mobile number';
        }

        // whatsapp address
        if (!preg_match("/^[6-9]\d{9}$/",$this->whatsapp)) {
            $this->errors[] = 'Invalid whatsapp number';
        }

    }


    /**
     * Validate name
     */
    public function validateName(){

        $f_name = filter_var($this->first_name, FILTER_SANITIZE_STRING);
        if (!preg_match("/^[A-Za-z]{3,}+([\ A-Za-z]+)*$/",$f_name)) {
            $this->errors[] = 'Invalid first name';
        }

        $l_name = filter_var($this->last_name, FILTER_SANITIZE_STRING);
        if (!preg_match("/^[A-Za-z]{3,}$/",$l_name)) {
            $this->errors[] = 'Invalid last name';
        }

    }

    /**
     * Validate name
     */
    public function validateWhatsapp(){

        // whatsapp address
        if (!preg_match("/^[6-9]\d{9}$/",$this->whatsapp)) {
            $this->errors[] = 'Invalid whatsapp number';
        }

    }

    /**
     * @param $size
     * @return string
     */
    public static function generateProfileId($size): string
    {

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
    public static function getDefaultAvatar($gender): string
    {

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
    public function rememberLogin(): bool
    {

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
    public function emailExists($email, $ignore_id=null): bool
    {

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
    public function mobileExists($mobile, $ignore_id=''): bool
    {

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

        $sql = self::majorDotSql();
        $sql .= "WHERE users.id= :id";

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

        $sql = self::majorDotSql();
        $sql .= "WHERE pid=?";

        $pdo = static::getDB();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pid]);

        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @return string
     */
    protected static function majorDotSql(): string
    {

        return $sql = "SELECT users.*,
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            castes.text as caste,
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
            LEFT JOIN communities ON communities.id = users.community_id    
            LEFT JOIN countries ON countries.id = users.country_id    
            LEFT JOIN castes ON castes.value = users.caste_id     
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
        ";
    }

    /**
     * @return string
     */
    protected static function minorDotSql(): string
    {

        return "SELECT   
            users.id,
            users.pid,
            users.email,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            users.mobile,
            users.height_id,
            users.manglik_id,
            users.state,
            users.district,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            images.linked,
            images.approved,
            
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            castes.text as caste,
            
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
            LEFT JOIN communities ON communities.id = users.community_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN castes ON castes.value = users.caste_id    
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN move_profile ON move_profile.receiver = users.id

            ";
    }

    /**
     * @return string
     */
    protected static function minorDotSql2(): string
    {

        return "SELECT    
            users.id,
            users.pid,
            users.email,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            users.mobile,
            users.height_id,
            users.manglik_id,
            users.state,
            users.district,
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            images.linked,
            images.approved,
            
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            castes.text as caste,
            
            users.horoscope, 
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,    
            visit_profile.sender as visitor,   
                        
            users.hiv,
            users.rsa
            
            FROM users
            
            LEFT JOIN images ON images.user_id = users.id
            
            LEFT JOIN heights ON heights.id = users.height_id
            LEFT JOIN religions ON religions.id = users.religion_id
            LEFT JOIN communities ON communities.id = users.community_id
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id
            LEFT JOIN castes ON castes.value = users.caste_id    
            
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            LEFT JOIN visit_profile ON visit_profile.sender = users.id

            ";
    }

    /* **************************************
     * Section 4
     * Ajax call Functions
     * ***************************************
     * */

    /**
     * @param $time
     * @return bool
     */
    public function updateLastUserActivity($time): bool
    {

        $id = $this->id;
        $sql = "UPDATE users SET last_activity=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$time,$id]);

    }

    /**
     * @param $userId
     * @param $mobile
     * @return bool
     */
    public static function updateMobile($userId, $mobile): bool
    {

        $query = "UPDATE users SET mobile=? WHERE id=?";
        $pdo = Model::getDB();
        $stmt=$pdo->prepare($query);
        return $stmt->execute([$mobile,$userId]);
    }


    /* **************************************
     *  Section 5
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
    protected function startPasswordReset(): bool
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
        $url = 'https://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $this->password_reset_token;

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
    public function resetPassword(string $password): bool
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

        $pattern = '/^[0-9A-Za-z!@#$%^&*?]{8,32}$/';
        if (preg_match($pattern, $this->password) == 0) {
            $this->errors[] = 'Minimum 8 digits, can have alphabet, number and special character !@#$%^&*? ';
        }

    }

    /* *********************************
     * Section 6
     * Account Activation Functions
     * **********************************
     * */

    /**
     * Send an email to the user containing the activation link
     *
     * @return void
     *
     */
    public function sendActivationEmail()
    {
        $url = 'https://' . $_SERVER['HTTP_HOST'] . '/register/activate/' . $this->activation_token;

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

    /**
     * @param $uid
     * @return bool
     */
    public static function markFB($uid): bool
    {

        $sql = 'UPDATE users
                SET fb_add = 1 
                WHERE id = :uid';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':uid', $uid, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /* *********************************
     *  Section 7
     *  Shortlist and visitors
     * 8 functions
     * **********************************
     * */

    /**
     * @param $uid
     * @param $pps
     * @return array
     */
    public static function newlist($uid,$pps): array
    {
        $cUser = self::findByID($uid);
        $cg = $cUser->gender;
        $rel = $cUser->religion_id;
        $min_ht = $cUser->min_ht;
        $max_ht = $cUser->max_ht;
        $min_age = $cUser->min_age;
        $maxDate = \Carbon\Carbon::today()->subYears($min_age)->endOfDay()->toDateString();
        $max_age = $cUser->max_age;
        $minDate = \Carbon\Carbon::today()->subYears($max_age)->toDateString();
        $casteAry = implode(',',json_decode($cUser->mycastes));
        //$casteAry = array_values($cUser->mycastes);


        $sql= self::minorDotSql();
        $sql.="WHERE move_profile.num IS NULL
            AND users.is_active = 1            
            AND users.gender != :cg
            AND users.religion_id = :rel
            
               
        ";

        if($pps){

            $sql .= "AND users.height_id >= :min_ht
            AND users.height_id <= :max_ht
            AND users.dob <= CAST(:max_dt AS DATE)
            AND users.dob >= CAST(:min_dt AS DATE)";

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

            $stmt->bindParam(':max_dt',$maxDate);
            $stmt->bindParam(':min_dt',$minDate);

        }else{
            $sql .= " ORDER BY users.id DESC";
            $sql .= " LIMIT 10";

            $pdo = Model::getDB();
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':cg',$cg,PDO::PARAM_INT);
            $stmt->bindParam(':rel',$rel,PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * @param $uid
     * @return int
     */
    public static function countShortlisted($uid): int
    {
        $sql = "SELECT * FROM users LEFT JOIN move_profile ON move_profile.receiver = users.id            
            
            WHERE move_profile.sender= :id AND move_profile.num = 2 AND users.is_active=1";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * @param $uid
     * @return int
     */
    public static function countRecentVisitor($uid): int
    {
        $sql = "SELECT * FROM users LEFT JOIN visit_profile ON visit_profile.sender = users.id            
            
            WHERE visit_profile.receiver= :id AND users.is_active=1";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount();

    }

    /**
     * Kept for refernece
     * @param $uid
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function testQuery($uid, int $offset=0, int $limit=10): array
    {
        $sql = "SELECT u.id, u.pid, i.user_id, i.img_id, i.filename
        FROM
        (SELECT sender, receiver, num FROM move_profile WHERE sender= :id AND num = 2 ORDER BY created_at DESC LIMIT :offset, :limit) AS k
        LEFT JOIN users as u ON (k.receiver = u.id)
        LEFT JOIN images as i ON (k.receiver = i.user_id)
        WHERE u.is_active=1
        ";

        //$sql .= "WHERE move_profile.sender= :id AND move_profile.num = 2 AND u.is_active=1";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $uid
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function shortlistPagination($uid, int $offset=0, int $limit=10): array
    {
        $sql = "SELECT
            u.id,
            u.pid,
            u.email,
            u.first_name,
            u.last_name,
            u.gender,
            u.dob,
            u.mobile,
            u.height_id,
            u.manglik_id,
            u.state,
            u.district,
            u.hiv,
            u.rsa,
            u.horoscope, 
       
            i.user_id as iuid,
            i.filename,
            i.pp,
            i.linked,
            i.approved,
            
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            castes.text as caste,
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng,
       
            k.num as mov
        FROM
             
        (SELECT sender, receiver, num FROM move_profile WHERE sender= :id AND num = 2 ORDER BY created_at DESC LIMIT :offset, :limit) AS k
            
        LEFT JOIN users as u ON (k.receiver = u.id)
        LEFT JOIN images as i ON (k.receiver = i.user_id)
            
        LEFT JOIN heights ON heights.id = u.height_id
        LEFT JOIN religions ON religions.id = u.religion_id
        LEFT JOIN communities ON communities.id = u.community_id
        LEFT JOIN countries ON countries.id = u.country_id
        LEFT JOIN incomes ON incomes.id = u.income_id
        LEFT JOIN maritals ON maritals.id = u.marital_id
        LEFT JOIN mangliks ON mangliks.id = u.manglik_id
        LEFT JOIN castes ON castes.value = u.caste_id    
        LEFT JOIN educations ON educations.id = u.education_id
        LEFT JOIN occupations ON occupations.id = u.occupation_id  
        LEFT JOIN diets ON diets.id = u.diet_id
        LEFT JOIN smokes ON smokes.id = u.smoke_id
        LEFT JOIN drinks ON drinks.id = u.drink_id
        LEFT JOIN challenged ON challenged.id = u.challenged_id
        WHERE u.is_active=1
        ";

        //$sql .= "WHERE move_profile.sender= :id AND move_profile.num = 2 AND u.is_active=1";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param $uid
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function recentVisitorPagination($uid, int $offset=0, int $limit=10): array
    {
        $sql = "SELECT
            u.id,
            u.pid,
            u.email,
            u.first_name,
            u.last_name,
            u.gender,
            u.dob,
            u.mobile,
            u.height_id,
            u.manglik_id,
            u.state,
            u.district,
            u.hiv,
            u.rsa,
            u.horoscope, 
       
            i.user_id as iuid,
            i.filename,
            i.pp,
            i.linked,
            i.approved,
            
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,
            castes.text as caste,
            educations.name as edu,
            occupations.name as occ,
            diets.type as diet,
            smokes.status as smoke,
            drinks.status as drink,
            challenged.status as challeng
       
        FROM
             
        (SELECT sender, receiver FROM visit_profile WHERE receiver= :id ORDER BY created_at DESC LIMIT :offset, :limit) AS k
            
        LEFT JOIN users as u ON (k.sender = u.id)
        LEFT JOIN images as i ON (k.sender = i.user_id)
            
        LEFT JOIN heights ON heights.id = u.height_id
        LEFT JOIN religions ON religions.id = u.religion_id
        LEFT JOIN communities ON communities.id = u.community_id
        LEFT JOIN countries ON countries.id = u.country_id
        LEFT JOIN incomes ON incomes.id = u.income_id
        LEFT JOIN maritals ON maritals.id = u.marital_id
        LEFT JOIN mangliks ON mangliks.id = u.manglik_id
        LEFT JOIN castes ON castes.value = u.caste_id    
        LEFT JOIN educations ON educations.id = u.education_id
        LEFT JOIN occupations ON occupations.id = u.occupation_id  
        LEFT JOIN diets ON diets.id = u.diet_id
        LEFT JOIN smokes ON smokes.id = u.smoke_id
        LEFT JOIN drinks ON drinks.id = u.drink_id
        LEFT JOIN challenged ON challenged.id = u.challenged_id
        WHERE u.is_active=1
        ";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Deprecated kept for reference
     * @param $uid
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function shortlist($uid, int $offset=0, int $limit=10): array
    {

        $sql = self::minorDotSql();
        $sql .= "WHERE move_profile.sender= :id AND move_profile.num = 2 AND users.is_active=1
        ORDER BY move_profile.created_at DESC LIMIT :offset, :limit";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * Deprecated kept for reference
     * @param $uid
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function recentVisitor($uid, int $offset=0, int $limit=10): array
    {

        $sql = self::minorDotSql2();
        $sql .= "WHERE visit_profile.receiver =:id AND users.is_active = 1 ORDER BY visit_profile.created_at DESC";
        $sql .= " LIMIT :offset, :limit";

        $pdo = Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id',$uid,PDO::PARAM_INT);
        $stmt->bindParam(':offset',$offset,PDO::PARAM_INT);
        $stmt->bindParam(':limit',$limit,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    /* *********************************
     *  Section 8
     *  User Search
     * **********************************
     * */
    /**
     * Kept for reference
     * @param string $advQuery
     * @return array
     */
    public static function customSearchResults($advQuery=''): array
    {

        $sql = self::minorDotSql();
        $sql .= " WHERE users.id <=20 AND move_profile.num IS NULL ";

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

    /**
     * Kept for reference and testing
     * @param string $advQuery
     * @return array
     */
    public static function getAdvanceSearchResults($advQuery=''): array
    {

        $sql = self::minorDotSql();
        $sql .= " WHERE users.id <=10";

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


    /**
     * Front page quick Search - Login not required
     * @param string $advQuery
     * @return array
     */
    public static function getQuickSearchResults($advQuery=''): array
    {

        $sql = "SELECT
    
            users.id,
            users.pid,
            users.first_name,
            users.last_name,
            users.gender,
            users.dob,
            users.state,
            users.district,            
            
            images.user_id as iuid,
            images.filename,
            images.pp,
            images.approved,
            images.linked,
            
            heights.ft as ht, 
            religions.name as religion,
            communities.name as lang,
            countries.name as country,
            incomes.level as income,
            maritals.status as mstatus,
            mangliks.status as manglik,        
            castes.text as caste,
            
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
            LEFT JOIN communities ON communities.id = users.community_id         
            LEFT JOIN countries ON countries.id = users.country_id
            LEFT JOIN incomes ON incomes.id = users.income_id
            LEFT JOIN maritals ON maritals.id = users.marital_id
            LEFT JOIN mangliks ON mangliks.id = users.manglik_id            
            LEFT JOIN castes ON castes.value = users.caste_id
                
            LEFT JOIN educations ON educations.id = users.education_id
            LEFT JOIN occupations ON occupations.id = users.occupation_id
            
            LEFT JOIN diets ON diets.id = users.diet_id
            LEFT JOIN smokes ON smokes.id = users.smoke_id
            LEFT JOIN drinks ON drinks.id = users.drink_id
            LEFT JOIN challenged ON challenged.id = users.challenged_id
            
            WHERE users.is_active=1
        ";

        //$sql = self::minorDotSql();
        //$sql .= " WHERE users.is_active=1";
        if(!empty($advQuery)){
            //$sql .= " WHERE ";
            $sql .= " AND ";
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
     *  Extra Functions
     * **********************************
     * */

    public static function getContact($oid){
        $sql = 'SELECT whatsapp,email,mobile,one_way FROM users
                WHERE id=?';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute([$oid]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $userId
     * @return bool
     */
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


        $sql = "INSERT INTO users( pid, mobile, email, is_active, password_hash, first_name, last_name, gender, 
                avatar, for_id, height_id, language_id, occupation_id, district_id, education_id, dob, marital_id, 
                religion_id, degree_id, university_id, community_id, manglik_id, caste_id, myhobbies,mycastes,myinterests,langs) 
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $pdo = Model::getDB();
        $stmt = $pdo->prepare($sql);

        // Password is fixed for seeding purpose
        $hashedPwd = password_hash('titanic2020', PASSWORD_DEFAULT);

        for($i=0; $i < $num; $i++) {
            $pid = self::generateProfileId(7);
            $mobile = $faker->phoneNumber;
            $email = $faker->email;
            $ia = 1;
            $fn = $faker->firstName;
            $ln = $faker->lastName;
            //$name = $fn . ' ' . $ln;
            //$username = $faker->userName;
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
            $man = rand(1, 3);
            $caste = array_rand(UserVariables::castes());
            $hob = '[]';
            $cas = '[]';
            $ier = '[]';
            $lan = '[]';

            $stmt->execute([$pid, $mobile, $email, $ia, $hashedPwd, $fn, $ln, $gender,
                $avatar, $cFor,$ht, $lag, $occ, $dis, $edu, $dob, $ms, $rel, $deg, $uni, $com, $man, $caste,$hob,$cas,$ier,$lan]);


        }
    }

    /**
     * @param $t
     * @return array
     */
    public static function timeQuery($t){

        $query = "SELECT * FROM users WHERE created_at > ?";
        $pdo = Model::getDB();
        $stmt = $pdo->prepare($query);
        $stmt->execute([$t]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);

    }


    /* **************************************
     *  Section 10
     *  Update User Functions
     * ***************************************
     * */

    /**
     * @param $data
     * @return bool
     */
    public function saveUserProfile($data): bool
    {

        foreach ($data as $key => $value){
            $this->$key=$value;
        }

        if($this->country_id == 77){
            $this->state = $this->st_india;
            $this->district = $this->ds_india;
        }else{
            $this->state = $this->st_other;
            $this->district = $this->ds_other;
        }

        $this->validateName();
        $this->validateWhatsapp();

        if(empty($this->errors)){

            //$this->name = $this->first_name.' '.$this->last_name;
            $this->dob = $this->year.'-'.$this->month.'-'.$this->day;
            $this->country_id = 77;

            $sql = "UPDATE users SET 
                first_name= :fName,
                last_name= :lName,            
                dob= :dob,
                religion_id= :religion,
                community_id= :community,
                caste_id= :caste, 
                manglik_id= :manglik,
                marital_id= :marital,
                height_id= :height,
                whatsapp= :whatsapp,
                education_id= :education,
                income_id= :income, 
                occupation_id= :occupation,                
                country_id= :country,
                state= :state,
                district= :district                
                WHERE id= :id";

            $pdo = Model::getDB();
            $stmt=$pdo->prepare($sql);
            return $stmt->execute([
                ':fName'=>$this->first_name,
                ':lName'=>$this->last_name,
                ':dob'=>$this->dob,
                ':religion'=>$this->religion_id,
                ':community'=>$this->community_id,
                ':caste'=>$this->caste_id,
                ':manglik'=>$this->manglik_id,
                ':marital'=>$this->marital_id,
                ':height'=>$this->height_id,
                ':whatsapp'=>$this->whatsapp,
                ':education'=>$this->education_id,
                ':income'=>$this->income_id,
                ':occupation'=>$this->occupation_id,
                ':country'=>$this->country_id,
                ':state'=>$this->state,
                ':district'=>$this->district,
                ':id'=>$this->id
            ]);
        }
        return false;
    }


    /**
     * @param $otp
     * @return bool
     */
    public function updateOtp($otp): bool
    {

        $this->otp = $otp;
        $sql = "UPDATE users SET otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->otp,
            $this->id
        ]);
    }

    /**
     * @return bool
     */
    public function verifyMobile(): bool
    {

        $sql = "UPDATE users SET mv=?,otp=? WHERE id=?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([1,Null,$this->id]);
    }


    /**
     * @param $data
     * @return bool
     */
    public function updateBasicInfo($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $this->validateName();

        if(empty($this->errors)) {

            $sql = "UPDATE users SET first_name=?, last_name=?, caste_id=?, tongue_id=?, marital_id=?, height_id=?, 
                    country_id=?, state=?, district=? WHERE id=?";

            $db = Model::getDB();
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                $this->first_name,
                $this->last_name,
                $this->caste_id,
                $this->tongue_id,
                $this->marital_id,
                $this->height_id,
                $this->country_id,
                $this->state,
                $this->district,
                $this->id
            ]);
        }
        return false;
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateCasteInfo($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }
        $mycastes = json_encode($this->mycastes);

        $sql = "UPDATE users SET mycastes=? WHERE id =?";

        $db = Model::getDB();
        $stmt = $db->prepare($sql);
        return $stmt->execute([$mycastes, $this->id]);
    }

    /**
     * @param $data
     * @return bool
     */
    public function updatePartnerPreference($data): bool
    {
        foreach($data as $key=>$val){
            $this->$key=$val;
        }
        $mycastes = json_encode($this->mycastes);
        //$mycastes = ($this->mycastes===[])?ltrim("[]"):json_encode($this->mycastes);
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

    /**
     * @param $data
     * @return bool
     */
    public function updateEduCareerInfo($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $working_in = filter_var($this->working_in, FILTER_SANITIZE_STRING);
        if (!preg_match("/^[A-Za-z0-9\.]{3,}+([\ A-Za-z0-9\.]+)*$/",$working_in)) {
            $this->working_in = NUll;
        }
        $other_deg = filter_var($this->other_deg, FILTER_SANITIZE_STRING);
        if (!preg_match("/^[A-Za-z0-9\.]{3,}+([\ A-Za-z0-9\.]+)*$/",$other_deg)) {
            $this->other_deg = NUll;
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

    /**
     * @param $data
     * @return bool
     */
    public function updateFamilyInfo($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $db = Model::getDB();
        $sql = "UPDATE users SET father_name=?, mother_name=?, father_id=?, mother_id=?, bros=?, mbros=?, sis=?, msis=?,
                famAffluence_id=?, famType_id=?, famValue_id=?, famIncome_id=? WHERE id=?";
        $stmt = $db->prepare($sql);

        $result = $stmt->execute([
            $this->father_name,
            $this->mother_name,
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

    /**
     * @param $data
     * @return bool
     */
    public function updateLifestyleInfo($data): bool
    {

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

    /**
     * @param $data
     * @return bool
     */
    public function updateLikesInfo($data): bool
    {

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

    /**
     * @param $data
     * @return bool
     */
    public function updateAstroDetails($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $db = Model::getDB();
        $sql = "UPDATE users SET sun_id=?, moon_id=?, nakshatra_id=?, horoscope=?, kundli_details=?, manglik_id=?, hm=?, hp=? WHERE id =?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->sun_id,
            $this->moon_id,
            $this->nakshatra_id,
            $this->horoscope,
            $this->kundli_details,
            $this->manglik_id,
            $this->hm,
            $this->hp,
            $this->id
        ]);
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateContactInfo($data): bool
    {

        foreach($data as $key=>$val){
            $this->$key=$val;
        }

        $this->validateMobile();

        if(empty($this->errors)){

            $db = Model::getDB();
            $sql = "UPDATE users SET mobile=?, whatsapp=?, one_way=? WHERE id =?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([
                $this->mobile,
                $this->whatsapp,
                $this->one_way,
                $this->id
            ]);
        }

        return false;

    }

    /*public static function getUsersByTimestamp($t){

        $sql = "SELECT * FROM users WHERE created_at<='.$t.'";

        $db= Model::getDB();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_OBJ);
    }*/

    /**
     * @param $start
     * @param $limit
     * @return array
     */
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

    /**
     * @return int
     */
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

    /**
     * @return bool
     */
    public function incrementAc(): bool
    {

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
