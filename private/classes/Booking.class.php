<?php
class Booking extends Database
{
    private string $tableName = "booking";

    public function bookNow(mixed $form_data): array
    {
        $id = $form_data['id'];
        $name = $form_data['name'];
        $email = $form_data['email'];
        $phone = $form_data['phone'];
        $blood_group = $form_data['group'];
        $date = $form_data['date'];
        $time = $form_data['time'];

        if ($date < date('Y-m-d')){
            return [
                'status' => 400,
                'message' => 'Select a valid date'
            ];
        }
        $values = [$id, $name, $email, $phone, $blood_group, $date, $time];
        $columns = ['user_id', 'name', 'email', 'phone', 'blood_group', 'date', 'time'];
        try {
            $result = $this->insertData($this->tableName, $columns, $values);
            if (!$result){
                return [
                    'status' => 400,
                    'message' => 'Error booking.'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Booking successful.'
            ];
        }catch (Exception $e){
            return [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
    }

    public function allBooking(): false|array
    {

        return $this->selectData($this->tableName, '*', array(), null, null, 'id', "DESC");
    }


    public function myBooking($myId): false|array
    {
        $condition = [
            'user_id' => $myId
        ];

        return $this->selectData($this->tableName, '*', $condition);
    }

    public function changeBookingStatus(mixed $form_data): array
    {
        $id = $form_data['id'];
        $group = $form_data['group'];

        $condition = [
            'id' => $id
        ];
        $updateData = [
            'status' => $group
        ];

        try {
            $result = $this->updateData($this->tableName, $updateData, $condition);
            if (!$result){
                return [
                    'status' => 400,
                    'message' => 'Error updating booking.'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Status updated successfully.'
            ];
        }catch (Exception $e){
            return [
                'status' => 200,
                'message' => $e->getMessage()
            ];
        }
    }




    public function totalBlood()
    {
        $condition = [
            'status' => 2
        ];
        return $this->countRows($this->tableName, $condition);
    }

    public function totalGroup($group)
    {
        $condition = [
            'blood_group' => $group,
            'status' => 2
        ];
        return $this->countRows($this->tableName, $condition);
    }


}
