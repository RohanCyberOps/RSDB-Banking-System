<?php
namespace php-login-form\class;

use form\class\DataSource;

class Member
{

    private $dbConn;

    private $ds;

    function __construct()
    {
        require_once "DataSource.php";
        $this->ds = new form\class\DataSource();
    }

    function getMemberById($memberId)
    {
        $query = "select * FROM userlogin WHERE userlogin.user_id = ?";
        $paramType = "i";
        $paramArray = array($memberId);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        
        return $memberResult;
    }
    
    public function processLogin($username, $password) {
        $query = "select * FROM userlogin WHERE username = ? OR email = ?";
        $paramType = "ss";
        $paramArray = array($username, $username);
        $memberResult = $this->ds->select($query, $paramType, $paramArray);
        if(!empty($memberResult)) {
            $hashedPassword = $memberResult[0]["password"];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION["userId"] = $memberResult[0]["id"];
                return true;
            }
        }
        return false;
    }
}
