<?php

use \PHPUnit\Framework\TestCase;
require __DIR__.'\..\..\jobhub\PHP\account_class.php';
class AccountTest extends TestCase
{

    public function testGetName()
    {   
        
        $Account = new Account;
        
        $Account->name="Applicant1";

        $this->assertEquals($Account->getName(), 'Applicant1');

    }

    public function testGetID()
    {   
        
        $Account = new Account;
        
        $Account->id=10;

        $this->assertEquals($Account->getID(), 10);

    }

    public function testUserIsAuthenticated()
    {   
        
        $Account = new Account;
        
        $Account->authenticated=TRUE;

        $this->assertEquals($Account->isAuthenticated(), TRUE);

    }

    public function testIsNameValid()
    {   
        
        $Account = new Account;

        $this->assertEquals($Account->isNameValid("Applicant1"), TRUE);

    }

    public function testIsPasswordValid()
    {   
        
        $Account = new Account;

        $this->assertEquals($Account->isPasswdValid("Applicant1"), TRUE);

    }

    public function testIsEmailValid()
    {   
        
        $Account = new Account;
        $email = "Applicant1@mail.com";
        $this->assertEquals($Account->isEmailValid($email), TRUE);

    }

    public function testIsPhoneValid()
    {   
        
        $Account = new Account;
        $phone = "0412555235";
        $this->assertEquals($Account->isPhoneValid($phone), TRUE);

    }



}



?>