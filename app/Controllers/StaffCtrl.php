<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StaffCtrl extends BaseController
{
    protected $computerModel;
    protected $memberModel;
    protected $operatorModel;
    protected $billingModel;


    public function __construct()
    {
        $this->computerModel = new \App\Models\ComputerModel();
        $this->memberModel = new \App\Models\MemberModel();
        $this->operatorModel = new \App\Models\OperatorModel();
        $this->billingModel = new \App\Models\BillingSessionModel();

    }

    public function index(): string
    {
        $data = [ 'page'=>'Dashboard' ];
        return view('dashboard', $data);
    }

    public function login(): string
    {
        $data = [ 'page'=>'Login' ];
        return view('login', $data);
    }

    // ============ COMPUTER CRUD ============
    public function computer(): string
    {
        $data = [
            'page'      => 'Computer',
            'computers' => $this->computerModel->findAll(),
        ];
        return view('computer', $data);
    }

    public function addcomputer(): string
    {
        $data = [ 'page'=>'Computer' ];
        return view('addcomputer', $data);
    }

    public function storeComputer()
    {
        $validated = $this->validate([
            'spec'       => 'required|string',
            'tariff'     => 'required|numeric',
            'status'     => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->computerModel->save([
            'spec'    => $this->request->getPost('spec'),
            'tariff'  => $this->request->getPost('tariff'),
            'status'  => $this->request->getPost('status'),
        ]);

        return redirect()->to('/computer')->with('message', 'Computer added successfully');
    }

    public function editcomputer(): string
    {
        $id = $this->request->getGet('id');
        $computer = $this->computerModel->find($id);

        if (!$computer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Computer not found');
        }

        $data = [
            'page'     => 'Computer',
            'computer' => $computer,
        ];
        return view('editcomputer', $data);
    }

    public function updateComputer()
    {
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'spec'   => 'required|string',
            'tariff' => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->computerModel->update($id, [
            'spec'   => $this->request->getPost('spec'),
            'tariff' => $this->request->getPost('tariff'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/computer')->with('message', 'Computer updated successfully');
    }

    public function deleteComputer()
    {
        $id = $this->request->getPost('id');
        $this->computerModel->delete($id);
        return redirect()->to('/computer')->with('message', 'Computer deleted successfully');
    }

    public function detailcomputer(): string
    {
        $id = $this->request->getGet('id');
        $computer = $this->computerModel->find($id);

        if (!$computer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Computer not found');
        }

        $data = [
            'page'     => 'Computer',
            'computer' => $computer,
        ];
        return view('detailcomputer', $data);
    }

    // ============ MEMBER CRUD ============
    public function member(): string
    {
        $data = [
            'page'    => 'Member',
            'members' => $this->memberModel->findAll(),
        ];
        return view('member', $data);
    }

    public function addmember(): string
    {
        $data = [ 'page'=>'Member' ];
        return view('addmember', $data);
    }

    public function storeMember()
    {
        $validated = $this->validate([
            'name'          => 'required|string',
            'phone_number'  => 'required|numeric',
            'email'         => 'permit_empty|valid_email',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->memberModel->save([
            'name'          => $this->request->getPost('name'),
            'phone_number'  => $this->request->getPost('phone_number'),
            'email'         => $this->request->getPost('email'),
            'status'        => 0,
        ]);

        return redirect()->to('/member')->with('message', 'Member added successfully');
    }

    public function editmember(): string
    {
        $id = $this->request->getGet('id');
        $member = $this->memberModel->find($id);

        if (!$member) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Member not found');
        }

        $data = [
            'page'   => 'Member',
            'member' => $member,
        ];
        return view('editmember', $data);
    }

    public function updateMember()
    {
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'name'          => 'required|string',
            'phone_number'  => 'required|numeric',
            'email'         => 'permit_empty|valid_email',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->memberModel->update($id, [
            'name'          => $this->request->getPost('name'),
            'phone_number'  => $this->request->getPost('phone_number'),
            'email'         => $this->request->getPost('email'),
        ]);

        return redirect()->to('/member')->with('message', 'Member updated successfully');
    }

    public function deleteMember()
    {
        $id = $this->request->getPost('id');
        $this->memberModel->delete($id);
        return redirect()->to('/member')->with('message', 'Member deleted successfully');
    }

    // ============ OPERATOR/STAFF CRUD ============
    public function staff(): string
    {
        $data = [
            'page'      => 'Staff',
            'operators' => $this->operatorModel->findAll(),
        ];
        return view('staff', $data);
    }

    public function addstaff(): string
    {
        $data = [ 'page'=>'Staff' ];
        return view('addstaff', $data);
    }

    public function storeStaff()
    {
        $validated = $this->validate([
            'username'  => 'required|string|is_unique[operators.username]',
            'password'  => 'required|string|min_length[6]',
            'full_name' => 'required|string',
            'email'     => 'permit_empty|valid_email',
            'role'      => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->operatorModel->save([
            'username'  => $this->request->getPost('username'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
            'status'    => 0,
        ]);

        return redirect()->to('/staff')->with('message', 'Staff added successfully');
    }

    public function editstaff(): string
    {
        $id = $this->request->getGet('id');
        $operator = $this->operatorModel->find($id);

        if (!$operator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Staff not found');
        }

        $data = [
            'page'     => 'Staff',
            'operator' => $operator,
        ];
        return view('editstaff', $data);
    }

    public function updateStaff()
    {
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'full_name' => 'required|string',
            'email'     => 'permit_empty|valid_email',
            'role'      => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $updateData = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role'),
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->operatorModel->update($id, $updateData);

        return redirect()->to('/staff')->with('message', 'Staff updated successfully');
    }

    public function deleteStaff()
    {
        $id = $this->request->getPost('id');
        $this->operatorModel->delete($id);
        return redirect()->to('/staff')->with('message', 'Staff deleted successfully');
    }

    // ============ RENTAL & PAYMENT ============
public function rental(): string
{
    $active = $this->billingModel
        ->where('status', 0) // 0 = active session
        ->findAll();

    $data = [
        'page'   => 'Rental',
        'active' => $active
    ];

    return view('rental', $data);
}


public function addrental(): string
{
    $availablePCs = $this->computerModel
        ->where('status', 0)
        ->findAll();

    $searchBy = $this->request->getGet('search_by');
    $keyword  = $this->request->getGet('keyword');

    if ($keyword && $searchBy) {
        $members = $this->memberModel
            ->like($searchBy, $keyword)
            ->findAll();
    } else {
        $members = $this->memberModel->findAll();
    }

    $data = [
        'page'    => 'Rental',
        'pcs'     => $availablePCs,
        'members' => $members
    ];

    return view('addrental', $data);
}



public function storeRental()
{
    $pcId = $this->request->getPost('pcno');
    $memberId = $this->request->getPost('member_id');

    $this->billingModel->save([
        'computer_id' => $pcId,
        'customer_id' => $memberId ?: null,
        'start_time'  => date('Y-m-d H:i:s'),
        'status'      => 0,
        'operator_id' => 1 // temporary (replace with session later)
    ]);

    // Change computer status to used
    $this->computerModel->update($pcId, ['status' => 1]);

    return redirect()->to('/rental')->with('message', 'Rental started');
}



    public function payment($id)
{
    $session = $this->billingModel->find($id);

    if (!$session) {
        return redirect()->to('/rental');
    }

    $computer = $this->computerModel->find($session['computer_id']);

    $member = null;
    if ($session['customer_id']) {
        $member = $this->memberModel->find($session['customer_id']);
    }

    $start = strtotime($session['start_time']);
    $end   = time();

    $hours = ceil(($end - $start) / 3600);
    $total = $hours * $computer['tariff'];

    return view('payment', [
        'session'  => $session,
        'computer' => $computer,
        'member'   => $member,
        'total'    => $total,
        'hours'    => $hours
    ]);
}

public function completePayment($id)
{
    $session = $this->billingModel->find($id);

    if (!$session) {
        return redirect()->to('/rental');
    }

    $this->billingModel->update($id, [
        'end_time'     => date('Y-m-d H:i:s'),
        'total_amount' => $this->request->getPost('payment'),
        'status'       => 1
    ]);

    // Free the PC
    $this->computerModel->update(
        $session['computer_id'],
        ['status' => 0]
    );

    return redirect()->to('/rental')
        ->with('message', 'Payment completed successfully');
}

}
