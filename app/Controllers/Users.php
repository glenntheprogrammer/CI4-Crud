<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        return view('users/index', $data);
    }

    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        $model = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];
        $model->insert($data);
        return redirect()->to('/users');
    }

   public function edit($id)
{
    $model = new UserModel();
    $user = $model->find($id); // Fetch user by ID

    if ($user) {
        return $this->response->setJSON(['data' => $user]); // Return user data as JSON
    } else {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
    }
}



 public function delete($id)
{
    $model = new UserModel();
    
    $user = $model->find($id);
    if (!$user) {
        return $this->response->setJSON(['success' => false, 'message' => 'User not found.']);
    }

    $deleted = $model->delete($id);

    if ($deleted) {
        return $this->response->setJSON(['success' => true, 'message' => 'User deleted successfully.']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete user.']);
    }
}



public function fetchUsers()
{
    $model = new UserModel();
    $users = $model->findAll();
    $data = [];
    $counter = 1;

    foreach ($users as $user) {
        $data[] = [
            'row_number' => $counter++, // This will be used for display only
            'id' => $user['id'],        // Keep the actual ID for operations
            'email' => $user['email'],
            'created_at' => $user['created_at'],
        ];
    }

    return $this->response->setJSON(['data' => $data]);
}



public function save()
{
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    if (!$email || !$password) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Email and password are required']);
    }

    $userModel = new \App\Models\UserModel();

    // Check if email already exists
    $existingUser = $userModel->where('email', $email)->first();
    if ($existingUser) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Email is already in use']);
    }

    $data = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ];

    if ($userModel->insert($data)) {
        return $this->response->setJSON(['status' => 'success']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save user']);
    }
}


public function update()
{
    $model = new UserModel();
    $userId = $this->request->getPost('id');
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Validate the input
    if (empty($email)) {
        return $this->response->setJSON(['success' => false, 'message' => 'Email is required']);
    }

    // Check if email already exists for another user
    $existingUser = $model->where('email', $email)
                          ->where('id !=', $userId)
                          ->first();

    if ($existingUser) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Email is already in use by another user.'
        ]);
    }

    $userData = [
        'email' => $email
    ];

    if (!empty($password)) {
        $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    $updated = $model->update($userId, $userData);

    if ($updated) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'User updated successfully.'
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Error updating user.'
        ]);
    }
}



}
