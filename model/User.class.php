<?php
require_once("../model/pdo.php");
require_once("../model/Entity.interface.php");

class User implements Entity{
    const SALT = SALT;

    public $id_user=null;
    public $nick="";
    public $email="";

    private $password="";
    private $signed_up="";
    private $last_seen="";

    public function __construct(){
        $this->signed_up = new DateTime($this->signed_up);
        $this->last_seen = new DateTime($this->last_seen);
    }

    /**
     * Fetch a User by Id from database
     * 
     * @param int $id_user the id of the user to be fetched
     * @return User Found user or a new User if ther is no match
     */
    public static function loadById(?int $id_user):User{
        $request = $GLOBALS['database']->prepare(
            "SELECT * FROM user 
            WHERE id_user=:id_user 
            LIMIT 1");
        $request->execute([':id_user'=> $id_user]);
        $user = $request->fetchAll(PDO::FETCH_CLASS, "User");
        return array_shift($user) ?? new User();
    }

    /**
     * @return DateTime sign_up date
     */
    public function getSignedUp():DateTime{
        return $this->signed_up;
    }

    /**
     * @param string $newPassword new unhashed password
     * @return string new hashed password
     */
    public function setPassword(string $newPassword):string{
        return $this->password = sha1(self::SALT.$newPassword.$this->signed_up->format("Y-m-d H:i:s"));
    }

    /**
     * Save User to database
     * 
     * Creates a new User if id_user is null
     * Updates matching user if id_user is not null
     * 
     * @return void
     */
    public function save():void{
        if($this->id_user!=null){//update user
            $request=$GLOBALS['database']->prepare(
                "UPDATE user 
                SET `nick`=:nick, 
                    `email`=:email, 
                    `password`=:pwd, 
                    `last_seen`=:last_seen 
                WHERE `id_user`=:id_user");
            $request->execute([
                ":id_user"=>$this->id_user,
                ":nick"=>$this->nick,
                ":email"=>$this->email, 
                ":pwd"=>$this->password,
                ":last_seen"=>$this->last_seen
            ]);            
        }
        else{//create user
            $request=$GLOBALS['database']->prepare(
                "INSERT INTO user (
                    `nick`, 
                    `email`, 
                    `password`, 
                    `signed_up`,
                    `last_seen`
                ) VALUES(
                    :nick, 
                    :email, 
                    :pwd, 
                    :signed_up, 
                    :last_seen
                )");
            $success=$request->execute([
                ":nick"=>$this->nick,
                ":email"=>$this->email, 
                ":pwd"=>$this->password,
                ":signed_up"=>$this->signed_up->format("Y-m-d H:i:s"),
                ":last_seen"=>$this->last_seen->format("Y-m-d H:i:s")
            ]);
            if($success){
                $this->id_user=$GLOBALS['database']->lastInsertId();
            }
        }
    }

    /**
     * Fetch a User by email and password
     * 
     * @param string $email mail of the user to fetch
     * @param string $password unhashed password of the user to fetch
     * 
     * @return User found User or a new User if there is no match
     */
    public static function loadByEmailAndPassword(string $email, string $password):User{
        $request = $GLOBALS['database']->prepare(
            "SELECT * FROM user 
            WHERE   `email`=:email AND 
                    `password`= SHA1(CONCAT(:salt,:pwd,`signed_up`))
            LIMIT 1"
        );
        $request->execute([':salt'=>self::SALT,':email'=> $email,':pwd'=>$password]);
        $user = $request->fetchAll(PDO::FETCH_CLASS, "User");
        return array_shift($user) ?? new User();
    }

    
    /**
     * Checks User validity
     * 
     * Nick must be at least 8 characters long
     * Password must be at least 8 characters long
     * Password must contain a lowercase character
     * Password must contain an Uppercase character
     * Password must contain a number
     * Password must contain a special character
     * Mail must validate default php mail filter
     * @param string password the tested password
     * @return Bool
     */
    public function isValid(string $password):Bool{
        //TODO check if mail is already taken
        if(!isset($_SESSION['toastError'])) $_SESSION['toastError']=[];
        if(!preg_match("/\w[\w]{2,}/",$this->nick)){
            $_SESSION['toastError'][]="nick must be at least 3 characters long.";
        }
        if(!preg_match("/.{8,}/",$password)){
            $_SESSION['toastError'][]="Password must be at least 8 characters long.";
        }
        if(!preg_match("/[a-z]/",$password)){
            $_SESSION['toastError'][]="Password must contain a lowercase character.";
        }
        if(!preg_match("/[A-Z]/",$password)){
            $_SESSION['toastError'][]="Password must contain an Uppercase character.";
        }
        if(!preg_match("/[0-9]/",$password)){
            $_SESSION['toastError'][]="Password must contain a number.";
        }
        if(!preg_match("/\W/",$password)){
            $_SESSION['toastError'][]="Password must contain a special character.";
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){ 
            $_SESSION['toastError'][]="Wrong email.";
        }
        return !(Bool)count($_SESSION['toastError']);
    }


    /**
     * send confirmation mail on sign up
     *
     * @return void
     */
    public function sendSignUpMail():void{
        //TODO send mail with validation token
    }
}