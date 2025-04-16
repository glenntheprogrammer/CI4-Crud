<?php
public function index()
{
    $model = new UserModel();
    $data['users'] = $model->findAll();
    return view('users/index', $data);
}

public function fetch()
{
    $model = new UserModel();
    $users = $model->findAll();
    $data = [];
    
    foreach ($users as $user) {
        $data[] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'created_at' => $user['created_at'],
        ];
    }
    
    return $this->response->setJSON(['data' => $data]);
}
