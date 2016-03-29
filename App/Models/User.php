<?php namespace App\Models;

use App\DataAccess\RoleRepository;

class User extends BaseModel {
    private $username;
    private $first_name;
    private $last_name;
    private $email;
    private $password;
    private $roles;

    public function getUsername() {
        return $this->username;
    }
    
    public function getFirstName() {
        return $this->first_name;
    }
    
    public function getLastName() {
        return $this->last_name;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function setUsername($username) {
        $this->username = (string)$username;
    }
    
    public function setFirstName($firstName) {
        $this->first_name = (string)$firstName;
    }

    public function setLastName($lastName) {
        $this->last_name = (string)$lastName;
    }
    
    public function setEmail($email) {
        $this->email = (string)$email;
    }
    
    public function setPassword($password) {
        $this->password = (string)$password;
    }

    public function getRoles() {
        if ($this->roles != null) {
            return $this->roles;
        }

        $roleRepo = new RoleRepository();
        $this->roles = $roleRepo->getRolesForUser($this);

        return $this->roles;
    }

    protected function validate() {
        
        if (empty($this->first_name)) {
            $this->setError('first_name', 'First name is required.');
        } else {
            $this->setError('first_name', NULL);
        }
        
        if (empty($this->last_name)) {
            $this->setError('last_name', 'Last name is required.');
        } else {
            $this->setError('last_name', NULL);
        }
        
        if (empty($this->username)) {
            $this->setError('username', 'Username is required.');
        } else if (strlen($this->username) < 6) {
            $this->setError('username', 'Username must be at least 6 characters long.');
        } else {
            $this->setError('username', NULL);
        }
        
        if (empty($this->email)) {
            $this->setError('email', 'Email is required.');
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->setError('email', 'Email is invalid.');
        } else {
            $this->setError('email', NULL);
        }
        
        if (empty($this->password)) {
            $this->setError('password', 'Password is required.');
        } else {
            $this->setError('password', NULL);
        }

        if (empty($this->role_id)) {
            $this->setError('role_id', 'Role id is required.');
        } else {
            $this->setError('role_id', NULL);
        }
    }
}
