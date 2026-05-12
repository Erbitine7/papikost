<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class StaffCtrl extends BaseController
{
    protected $computerModel;
    protected $memberModel;
    protected $operatorModel;
    protected $billingModel;
    protected $paymentModel;


    public function __construct()
    {
        $this->computerModel = new \App\Models\ComputerModel();
        $this->memberModel = new \App\Models\MemberModel();
        $this->operatorModel = new \App\Models\OperatorModel();
        $this->billingModel = new \App\Models\BillingSessionModel();
        $this->paymentModel = new \App\Models\PaymentModel();

    }

    public function index(): ResponseInterface|string
{
    // Require login
    if ($redirect = $this->ensureLoggedIn()) {
        return $redirect;
    }

    // KPI counts
    $activeCount = $this->billingModel
        ->where('status', 0) // active sessions
        ->countAllResults();

    $availablePcCount = $this->computerModel
        ->where('status', 0) // available (your rental/add uses status=0)
        ->countAllResults();

    $memberCount = $this->memberModel->countAllResults();

    // Revenue today (sum from finished sessions)
    $todayStart    = date('Y-m-d 00:00:00');
    $tomorrowStart = date('Y-m-d 00:00:00', strtotime('+1 day'));

    $db = \Config\Database::connect();
    $revRow = $db->table('billing_sessions')
        ->select('COALESCE(SUM(total_amount), 0) AS total', false)
        ->where('status', 1) // finished sessions
        ->where('end_time >=', $todayStart)
        ->where('end_time <', $tomorrowStart)
        ->get()
        ->getRowArray();

    $todayRevenue = (int)($revRow['total'] ?? 0);

    // Recent sessions (last 5)
    $recentSessions = $db->table('billing_sessions bs')
        ->select([
            'bs.start_time',
            'bs.end_time',
            'bs.total_amount',
            'c.id AS computer_id',
            'm.name AS member_name',
            'CONCAT("PC-", c.id) AS computer_label',
        ], false)
        ->join('computers c', 'c.id = bs.computer_id', 'left')
        ->join('members m', 'm.id = bs.customer_id', 'left')
        ->orderBy('bs.start_time', 'DESC')
        ->limit(5)
        ->get()
        ->getResultArray();

    return view('dashboard', [
        'page'             => 'Dashboard',
        'activeCount'      => $activeCount,
        'availablePcCount' => $availablePcCount,
        'memberCount'      => $memberCount,
        'todayRevenue'     => $todayRevenue,
        'recentSessions'   => $recentSessions,
    ]);
}

    public function login(): string
    {
        $data = ['page' => 'Login'];
        return view('login', $data);
    }

    // ...

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Basic validation
        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()
                ->with('error', 'Email and password are required.');
        }

        // Find operator by email
        $operator = $this->operatorModel
            ->where('email', $email)
            ->first();

        if (!$operator || !password_verify($password, $operator['password'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Store minimal user info in session
        $session = session();
        $session->set([
            'staff_id' => $operator['id'],
            'staff_name' => $operator['full_name'],
            'staff_email' => $operator['email'],
            'staff_role' => $operator['role'],
            'is_staff_logged_in' => true,
        ]);

        return redirect()->to('/dashboard');

    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/staff-login');
    }

    private function ensureLoggedIn()
    {
        if (!session()->get('is_staff_logged_in')) {
            return redirect()->to('/staff-login');
        }
        return null;
    }

    private function ensureAdmin()
    {
        if (!session()->get('is_staff_logged_in')) {
            return redirect()->to('/staff-login');
        }

        if ((int) session()->get('staff_role') !== 0) {
            // Not admin → block access
            return redirect()->to('/dashboard')
                ->with('error', 'You are not allowed to manage staff.');
        }

        return null;
    }

    // ============ COMPUTER CRUD ============
    public function computer(): string
    {
        $data = [
            'page' => 'Computer',
            'computers' => $this->computerModel->findAll(),
        ];
        return view('computer', $data);
    }


    public function addcomputer(): string
    {
        $data = ['page' => 'Computer'];
        return view('addcomputer', $data);
    }

    public function storeComputer()
    {
        $validated = $this->validate([
            'spec' => 'required|string',
            'tariff' => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->computerModel->save([
            'spec' => $this->request->getPost('spec'),
            'tariff' => $this->request->getPost('tariff'),
            'status' => $this->request->getPost('status'),
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
            'page' => 'Computer',
            'computer' => $computer,
        ];
        return view('editcomputer', $data);
    }

    public function updateComputer()
    {
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'spec' => 'required|string',
            'tariff' => 'required|numeric',
            'status' => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->computerModel->update($id, [
            'spec' => $this->request->getPost('spec'),
            'tariff' => $this->request->getPost('tariff'),
            'status' => $this->request->getPost('status'),
        ]);

        return redirect()->to('/computer')->with('message', 'Computer updated successfully');
    }

    public function deleteComputer()
    {
        $id = $this->request->getPost('id');

        if (empty($id)) {
            return redirect()->back()->with('error', 'Invalid computer id');
        }

        // 1) Delete all billing sessions for this computer
        $this->billingModel
            ->where('computer_id', $id)
            ->delete();

        // 2) Now delete the computer itself
        $this->computerModel->delete($id);

        return redirect()->to('/computer')
            ->with('message', 'Computer deleted successfully');
    }

    public function detailcomputer(): string
    {
        $id = $this->request->getGet('id');
        $computer = $this->computerModel->find($id);

        if (!$computer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Computer not found');
        }

        $data = [
            'page' => 'Computer',
            'computer' => $computer,
        ];
        return view('detailcomputer', $data);
    }

    // ============ MEMBER CRUD ============
    public function member(): string
    {
        // All members as before
        $members = $this->memberModel->findAll();

        // Get latest end_time per member from billing_sessions
        $sessions = $this->billingModel
            ->select('customer_id, MAX(end_time) AS last_rent')
            ->where('customer_id IS NOT NULL', null, false)
            ->where('end_time IS NOT NULL', null, false)
            ->groupBy('customer_id')
            ->findAll();

        // Build map: member_id => last_rent datetime string
        $lastRent = [];
        foreach ($sessions as $row) {
            $lastRent[$row['customer_id']] = $row['last_rent'];
        }

        $data = [
            'page' => 'Member',
            'members' => $members,
            'lastRent' => $lastRent,  // pass map to view
        ];

        return view('member', $data);
    }

    public function addmember(): string
    {
        $data = ['page' => 'Member'];
        return view('addmember', $data);
    }

    public function storeMember()
    {
        $validated = $this->validate([
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
            'email' => 'permit_empty|valid_email',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->memberModel->save([
            'name' => $this->request->getPost('name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email' => $this->request->getPost('email'),
            'status' => 0,
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
            'page' => 'Member',
            'member' => $member,
        ];
        return view('editmember', $data);
    }

    public function updateMember()
    {
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
            'email' => 'permit_empty|valid_email',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->memberModel->update($id, [
            'name' => $this->request->getPost('name'),
            'phone_number' => $this->request->getPost('phone_number'),
            'email' => $this->request->getPost('email'),
        ]);

        return redirect()->to('/member')->with('message', 'Member updated successfully');
    }

    public function deleteMember()
    {
        $id = $this->request->getPost('id');

        if (empty($id)) {
            return redirect()->back()->with('error', 'Invalid member id');
        }

        $this->memberModel->delete($id);
        return redirect()->to('/member')->with('message', 'Member deleted successfully');
    }


    public function staff(): ResponseInterface|string
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }

        $data = [
            'page' => 'Staff',
            'operators' => $this->operatorModel->findAll(),
        ];
        return view('staff', $data);
    }
    public function addstaff(): ResponseInterface|string
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        $data = ['page' => 'Staff'];

        return view('addstaff', $data);
    }

    public function storeStaff()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        $validated = $this->validate([
            'username' => 'required|string|is_unique[operators.username]',
            'password' => 'required|string|min_length[6]',
            'full_name' => 'required|string',
            'email' => 'permit_empty|valid_email',
            'role' => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $this->operatorModel->save([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'status' => 0,
        ]);

        return redirect()->to('/staff')->with('message', 'Staff added successfully');
    }

    public function editstaff(): string
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        $id = $this->request->getGet('id');
        $operator = $this->operatorModel->find($id);

        if (!$operator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Staff not found');
        }

        $data = [
            'page' => 'Staff',
            'operator' => $operator,
        ];
        return view('editstaff', $data);
    }

    public function updateStaff()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        $id = $this->request->getPost('id');
        $validated = $this->validate([
            'full_name' => 'required|string',
            'email' => 'permit_empty|valid_email',
            'role' => 'required|numeric',
        ]);

        if (!$validated) {
            return redirect()->back()->withInput();
        }

        $updateData = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
        ];

        
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->operatorModel->update($id, $updateData);

        return redirect()->to('/staff')->with('message', 'Staff updated successfully');
    }

    public function deleteStaff()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        $id = $this->request->getPost('id');

        if (empty($id)) {
            return redirect()->back()->with('error', 'Invalid staff id');
        }

        $this->operatorModel->delete($id);
        return redirect()->to('/staff')->with('message', 'Staff deleted successfully');
    }

    
    public function rental(): string
    {
     
        $active = $this->billingModel
            ->select('billing_sessions.*, members.name AS member_name, computers.tariff AS computer_tariff')
            ->join('members', 'members.id = billing_sessions.customer_id', 'left')
            ->join('computers', 'computers.id = billing_sessions.computer_id', 'left')
            ->where('billing_sessions.status', 0)
            ->findAll();

        $inactive = $this->billingModel
            ->select('billing_sessions.*, members.name AS member_name, computers.tariff AS computer_tariff, payments.payment_method')
            ->join('members', 'members.id = billing_sessions.customer_id', 'left')
            ->join('computers', 'computers.id = billing_sessions.computer_id', 'left')
            ->join('payments', 'payments.billing_session_id = billing_sessions.id', 'left')
            ->where('billing_sessions.status', 1)
            ->findAll();



        $data = [
            'page' => 'Rental',
            'active' => $active,
            'inactive' => $inactive,
        ];

        return view('rental', $data);
    }


    public function addrental(): string
    {
        $availablePCs = $this->computerModel
            ->where('status', 0)
            ->findAll();

        $searchBy = $this->request->getGet('search_by');
        $keyword = $this->request->getGet('keyword');

        if ($keyword && $searchBy) {
            $members = $this->memberModel
                ->like($searchBy, $keyword)
                ->findAll();
        } else {
            $members = $this->memberModel->findAll();
        }

        $data = [
            'page' => 'Rental',
            'pcs' => $availablePCs,
            'members' => $members
        ];

        return view('addrental', $data);
    }



    public function storeRental()
    {
        if ($redirect = $this->ensureLoggedIn()) {
            return $redirect;
        }

        $pcId = $this->request->getPost('pcno');
        $memberId = $this->request->getPost('member_id');
        $operatorId = (int) session()->get('staff_id');

        $this->billingModel->save([
            'computer_id' => $pcId,
            'customer_id' => $memberId ?: null,
            'start_time' => date('Y-m-d H:i:s'),
            'end_time' => null,
            'status' => 0,
            'operator_id' => $operatorId,
        ]);

        
        $this->computerModel->update($pcId, ['status' => 1]);

        return redirect()->to('/rental')->with('message', 'Rental started');
    }


    public function payment($id)
    {
        $session = $this->billingModel->find($id);

        if (!$session) {
            return redirect()->to('/rental');
        }


        $now = date('Y-m-d H:i:s');
        $this->billingModel->update($id, [
            'end_time' => $now,
        ]);

        
        $session = $this->billingModel->find($id);

        $computer = $this->computerModel->find($session['computer_id']);

        $member = null;
        if ($session['customer_id']) {
            $member = $this->memberModel->find($session['customer_id']);
        }

        
        $start = strtotime($session['start_time']);
        $end = strtotime($session['end_time']); 

        $hours = ceil(($end - $start) / 3600);
        $total = $hours * $computer['tariff'];

        return view('payment', [
            'page' => 'Payment',
            'session' => $session,
            'computer' => $computer,
            'member' => $member,
            'total' => $total,
            'hours' => $hours,
        ]);
    }

    public function completePayment($id)
    {
        $session = $this->billingModel->find($id);

        if (!$session) {
            return redirect()->to('/rental');
        }

        
        $computer = $this->computerModel->find($session['computer_id']);

        $start = strtotime($session['start_time']);
        $end = strtotime($session['end_time'] ?? date('Y-m-d H:i:s'));

        $hours = ceil(($end - $start) / 3600);
        $calculatedTotal = $hours * $computer['tariff'];



        $amount = $calculatedTotal;
        $method = $this->request->getPost('payment_method') ?? 'cash';
        $operatorId = (int) ($this->request->getPost('operator_id') ?? 1);

        
        $this->billingModel->update($id, [
            'end_time' => date('Y-m-d H:i:s'),
            'total_amount' => $amount,
            'status' => 1,
        ]);

        
        $this->paymentModel->insert([
            'billing_session_id' => $id,
            'payment_method' => $method,
            'amount_paid' => $amount,
            'operator_id' => $operatorId,
        ]);

        
        $this->computerModel->update(
            $session['computer_id'],
            ['status' => 0]
        );

        return redirect()->to('/rental')
            ->with('message', 'Payment completed successfully');
    }
}
