<?php
    class Authentication extends Database {
        use Validate;
        private string $tableName = "users_tb";
        private string $allColumns = "*";
        private string $conditionColumn = "username";


        public function registerUser($form_data): array
        {
            $name = $form_data['name'];
            $username = $form_data["username"];
            $email = $form_data['email'];
            $phone = $form_data['phone'];
            $password = $form_data['password'];
            $confirm_password = $form_data['confirm_password'];


            if (empty($name) || empty($username) || empty($phone) || empty($password) || empty($confirm_password)) {
                return [
                    'status' => 400,
                    'message' => "Please all inputs are required"
                ];
            }elseif (!$this->validateName($name)){
                return [
                    'status' => 400,
                    'message' => "Please enter a valid name"
                ];
            }elseif (!empty($email) && !$this->validateEmail($email)){
                return [
                    'status' => 400,
                    'message' => "please enter a valid email"
                ];
            } elseif (!$this->validatePhoneNumber($phone)){
                return [
                    'status' => 400,
                    'message' => "Please enter a valid phone number"
                ];
            }elseif (!$this->validatePassword($password)){
                return [
                    'status' => 400,
                    'message' => "Please enter a password more than 6 characters"
                ];
            }elseif ($password !== $confirm_password) {
                return [
                    'status' => 400,
                    'message' => "Passwords do not match!"
                ];
            }else{
                $condition = [
                    'username' => $username
                ];
                $result = $this->selectData($this->tableName, '*', $condition);
                if ($result){
                    return [
                        'status' => 400,
                        'message' => "Username already exists with this name ".$username
                    ];
                }
                $columns = ['name', 'username', 'email', 'phone', 'password'];
                $values = [$name, $username, $email, $phone, password_hash($password, PASSWORD_DEFAULT)];

                $result = $this->insertData($this->tableName, $columns, $values);
                if ($result){
                    return [
                        'status' => 200,
                        'message' => "User created successfully"
                    ];
                }else{
                    return [
                        'status' => 400,
                        'message' => "Error creating user"
                    ];
                }
            }

        }

        public function loginUser($form_data): array
        {
            $username = $form_data['username'];
            $password = $form_data['password'];

            if (empty($username) || empty($password)){
                sleep(1);
                return [
                    'status' => 400,
                    'message' => 'Username and password required to login.'
                ];
            }else{
                $condition = [
                    $this->conditionColumn => $username
                ];
                $result = $this->selectData($this->tableName, $this->allColumns, $condition);
                if (!$result){
                    sleep(1);
                    return [
                        'status' => 400,
                        'message' => 'Invalid username or password.'
                    ];
                }
                if (!password_verify($password, $result[0]['password'])){
                    sleep(1);
                    return [
                        'status' => 400,
                        'message' => 'Invalid username or password.'
                    ];
                }

                $_SESSION['user_id'] = $result[0]['user_id'];
                $_SESSION['role'] = $result[0]['role'];
                $_SESSION['username'] = $result[0]['username'];
                sleep(1);
                return [
                    'status' => 200,
                    'message' => 'Your login is successfully.'
                ];
            }
        }

        public function logoutUser(): array
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['role']);
            unset($_SESSION['username']);
            return [
                'status' => 200,
                'message' => 'Your logout is successfully.'
            ];
        }


        public function passwordRest(mixed $form_data): array
        {
            $password1 = $form_data['password1'];
            $password2 = $form_data['password2'];

            if (empty($password1) || empty($password2)){
                return [
                    'status' => 400,
                    'message' => 'Password and confirm password required.'
                ];
            }elseif (!$this->validatePassword($password1)){
                return [
                    'status' => 400,
                    'message' => 'Password required at least 6 characters.'
                ];
            }elseif ($password1 !== $password2){
                return [
                    'status' => 400,
                    'message' => 'Password and confirm password not matching.'
                ];
            }else{
                $condition = [
                    'contact' => $_SESSION['codeSent']
                ];
                $updateData = [
                    'password' => password_hash($password1, PASSWORD_DEFAULT)
                ];
                $result = $this->updateData($this->tableName, $updateData, $condition);

                if (!$result){
                    return [
                        'status' => 400,
                        'message' => 'Error updating password. Retry.'
                    ];
                }

                unset($_SESSION['codeSent']);
                return [
                    'status' => 200,
                    'message' => 'Password reset successful. Login'
                ];

            }
        }

        public function changePassword(mixed $form_data): array
        {
            $user_id = $form_data['user_id'];
            $old_password = $form_data['old_password'];
            $new_password = $form_data['new_password'];
            $c_new_password = $form_data['c_new_password'];

            if (empty($old_password) || empty($new_password) || empty($c_new_password)){
                return [
                    'status' => 400,
                    'message' => 'All inputs are required to change password'
                ];
            }elseif (!$this->validatePassword($new_password)){
                return [
                    'status' => 400,
                    'message' => 'Password required at least 6 characters.'
                ];
            }elseif ($new_password !== $c_new_password){
                return [
                    'status' => 400,
                    'message' => 'Password and confirm password not matching.'
                ];
            }

            $condition = [
                'user_id' => $user_id
            ];
            $result = $this->selectData($this->tableName, '*', $condition);
            if (!$result){
                return [
                    'status' => 400,
                    'message' => 'Error'
                ];
            }
            if (!password_verify($old_password, $result[0]['password'])){
                return [
                    'status' => 400,
                    'message' => 'Wrong old password.'
                ];
            }
            $updateData = [
                'password' => password_hash($new_password, PASSWORD_DEFAULT)
            ];
            $this->updateData($this->tableName, $updateData, $condition);
            sleep(1);
            return [
                'status' => 200,
                'message' => 'Password changed successfully.'
            ];
        }

        public function getMe(mixed $user_id): false|array
        {
            $condition = [
                'user_id' => $user_id
            ];

            return $this->selectData($this->tableName, '*', $condition);
        }

        public function getByIdUser(mixed $form_data): array
        {
            $user_id = $form_data['getUserById'];

            $condition = [
                'user_id' => $user_id
            ];

            $data = $this->selectData($this->tableName, '*', $condition);
            if ($data){
                return [
                    'status' => 200,
                    'data' => $data[0]
                ];
            }

            return [
                'status' => 400,
                'message' => 'External error'
            ];
        }

        public function putUserProfile(mixed $form_data): array
        {
            $user_id = $form_data['user_id'];
            $name = $form_data['name'];
            $phone = $form_data['phone'];

            if (empty($name) || empty($phone)){
                return [
                    'status' => 400,
                    'message' => 'All input files are required.'
                ];
            }elseif (!$this->validateName($name)){
                return [
                    'status' => 400,
                    'message' => 'Name allows characters, hyphens, and spaces.'
                ];
            }elseif (!$this->validatePhoneNumber($phone)){
                return [
                    'status' => 400,
                    'message' => 'Phone number allows 10 to 13 digits.'
                ];
            }else{
                $condition = [
                    'user_id' => $user_id
                ];
                $data = [
                    'name' => $name,
                    'contact' => $phone,
                ];
                $result = $this->updateData($this->tableName, $data, $condition);
                if (!$result){
                    return [
                        'status' => 400,
                        'message' => 'Error update user.'
                    ];
                }

                return [
                    'status' => 200,
                    'message' => 'User updated successfully.'
                ];
            }
        }


        public function getAllUser(): false|array
        {
            $condition = [
                'role' => 0
            ];
            return $this->selectData($this->tableName, "*", $condition, null, null, "user_id", "DESC");
        }

        public function verifyUser(mixed $form_data): array
        {
            $id = $form_data['id'];
            $group = $form_data['group'];

            $updateDate = [
                'blood_group' => $group,
                'status' => 1
            ];
            $condition = [
                'user_id' => $id
            ];
            try {
                $result = $this->updateData($this->tableName, $updateDate, $condition);
                if (!$result){
                    return [
                        'status' => 200,
                        'message' => 'Error verifying user.'
                    ];
                }
                return [
                    'status' => 200,
                    'message' => 'User verified successfully.'
                ];
            }catch (Exception $e){
                return [
                    'status' => 200,
                    'message' => $e->getMessage()
                ];
            }

        }
    }
