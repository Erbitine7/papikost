<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
  $role = (int) (session()->get('staff_role') ?? 1);
  $roleLabel = ($role === 0) ? 'ADMIN' : 'OPERATOR';
  $name  = session()->get('staff_name') ?? '-';
  $email = session()->get('staff_email') ?? '-';

  $activeCount      = $activeCount ?? 0;
  $availablePcCount = $availablePcCount ?? 0;
  $memberCount      = $memberCount ?? 0;
  $todayRevenue     = $todayRevenue ?? 0;
  $recentSessions   = $recentSessions ?? [];
?>

<div class="flex flex-row items-center mb-5 px-5">
  <h3 class="font-semibold text-slate-900 bg-slate-200 px-1 rounded-md mr-2"><?= esc($roleLabel) ?></h3>
  <h1 class="text-2xl mx-1"><?= esc($name) ?></h1>
  <span class="text-sm text-slate-400 self-end">(<?= esc($email) ?>)</span>
</div>

<hr class="text-slate-600 mb-6">

<div class="px-5">
  <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>

  <!-- KPI Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
    <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800">
      <p class="text-slate-400 text-sm">Active rentals</p>
      <p class="text-3xl font-semibold mt-2"><?= esc($activeCount) ?></p>
      <p class="text-slate-500 text-xs mt-2">Sessions currently running</p>
    </div>

    <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800">
      <p class="text-slate-400 text-sm">Available PCs</p>
      <p class="text-3xl font-semibold mt-2"><?= esc($availablePcCount) ?></p>
      <p class="text-slate-500 text-xs mt-2">Ready for new rentals</p>
    </div>

    <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800">
      <p class="text-slate-400 text-sm">Members</p>
      <p class="text-3xl font-semibold mt-2"><?= esc($memberCount) ?></p>
      <p class="text-slate-500 text-xs mt-2">Registered customers</p>
    </div>

    <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800">
      <p class="text-slate-400 text-sm">Revenue (today)</p>
      <p class="text-3xl font-semibold mt-2">Rp <?= number_format((int)$todayRevenue, 0, ',', '.') ?></p>
      <p class="text-slate-500 text-xs mt-2">From completed payments</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800 mb-8">
    <h2 class="text-lg font-semibold mb-3">Quick actions</h2>
    <div class="flex flex-wrap gap-3">
      <a href="<?= base_url('rental/add') ?>" class="bg-cyan-500 text-slate-900 font-semibold px-4 py-2 rounded-lg hover:bg-cyan-400">
        + Start rental
      </a>
      <a href="<?= base_url('computer/add') ?>" class="bg-slate-800 px-4 py-2 rounded-lg hover:bg-slate-700">
        + Add PC
      </a>

      <?php if ($role === 0): ?>
        <a href="<?= base_url('member/add') ?>" class="bg-slate-800 px-4 py-2 rounded-lg hover:bg-slate-700">
          + Add member
        </a>
        <a href="<?= base_url('staff/add') ?>" class="bg-slate-800 px-4 py-2 rounded-lg hover:bg-slate-700">
          + Add staff
        </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- Recent Sessions -->
  <div class="bg-slate-950 rounded-2xl p-5 shadow-lg outline outline-1 outline-slate-800">
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-lg font-semibold">Recent sessions</h2>
      <a href="<?= base_url('rental') ?>" class="text-cyan-300 hover:text-cyan-200">View all</a>
    </div>

    <div class="overflow-auto">
      <table class="w-full text-left outline outline-slate-800 rounded-sm">
        <thead class="border-b border-slate-800 bg-slate-950">
          <tr>
            <th class="p-2 pl-4">PC</th>
            <th class="p-2">User</th>
            <th class="p-2">Start</th>
            <th class="p-2">End</th>
            <th class="p-2 text-right pr-4">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($recentSessions) && is_array($recentSessions)): ?>
            <?php foreach ($recentSessions as $s): ?>
              <tr class="border-b border-slate-800 hover:bg-slate-900">
                <td class="p-3 pl-4"><?= esc($s['computer_label'] ?? $s['computer_id'] ?? '-') ?></td>
                <td class="p-3"><?= esc($s['member_name'] ?? 'Guest') ?></td>
                <td class="p-3"><?= esc($s['start_time'] ?? '-') ?></td>
                <td class="p-3"><?= esc($s['end_time'] ?? '-') ?></td>
                <td class="p-3 text-right pr-4">Rp <?= number_format((int)($s['total_amount'] ?? 0), 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="p-4 text-center text-slate-400">No recent sessions yet.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>