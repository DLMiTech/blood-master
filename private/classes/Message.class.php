<?php
class Message extends Database {
    private string $table = 'message';

    public function addMessage(mixed $form_data): array
    {
        $name = $form_data["name"];
        $email = $form_data["email"];
        $phone = $form_data["phone"];
        $title = $form_data["title"];
        $message = $form_data["message"];

        $columns = ['name', 'email', 'phone', 'title', 'message'];
        $values = [$name, $email, $phone, $title, $message];
        try {
            $result = $this->insertData($this->table, $columns, $values);
            if ($result){
                return [
                    'status' => 200,
                    'message' => 'Message added successfully'
                ];
            }else{
                return [
                    'status' => 400,
                    'message' => 'Something went wrong'
                ];
            }
        }catch (Exception $e){
            return [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
    }


    public function getAllMessages(): false|array
    {
        return $this->selectData($this->table, "*", array(), null, 10, "id", "DESC");

    }
}
