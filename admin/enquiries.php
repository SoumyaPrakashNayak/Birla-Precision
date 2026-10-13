<?php
$active_tab = 'enquiries';
$page_title = 'Quotation Enquiries — Birla Precision Admin';

require_once __DIR__ . '/header.php';

$pdo = get_db();

// Handle status change
if (isset($_GET['action']) && $_GET['action'] === 'status' && isset($_GET['id']) && isset($_GET['val'])) {
    $eq_id = (int)$_GET['id'];
    $new_status = trim($_GET['val']);
    $stmt = $pdo->prepare("UPDATE enquiries SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $eq_id]);
    header('Location: enquiries.php?msg=Status+updated');
    exit;
}

// Handle delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $eq_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->execute([$eq_id]);
    header('Location: enquiries.php?msg=Enquiry+deleted');
    exit;
}

$enquiries = $pdo->query("SELECT * FROM enquiries ORDER BY id DESC")->fetchAll();

// If DB table is empty, fallback load from enquiries_log.json
$json_enquiries = [];
if (empty($enquiries)) {
    $log_path = __DIR__ . '/../enquiries_log.json';
    if (file_exists($log_path)) {
        $raw = file_get_contents($log_path);
        $json_enquiries = json_decode($raw, true) ?: [];
    }
}
?>

<div class="admin-page-header">
  <div>
    <h1 class="admin-page-title">Quotation Requests &amp; Enquiries</h1>
    <p class="admin-page-subtitle">Customer tool requests submitted through the configurator and official quotation form.</p>
  </div>
</div>

<?php if (!empty($_GET['msg'])): ?>
  <div class="admin-alert admin-alert-success">
    <span><?= htmlspecialchars($_GET['msg']) ?></span>
  </div>
<?php endif; ?>

<div class="admin-card">
  <div class="admin-card-header">
    <h2 class="admin-card-title">Received Inquiries (<?= count($enquiries) ?: count($json_enquiries) ?>)</h2>
  </div>

  <div class="admin-table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Ref / Date</th>
          <th>Customer</th>
          <th>Product &amp; Specification</th>
          <th>Quantity</th>
          <th>Address &amp; Remarks</th>
          <th>Status</th>
          <th style="text-align:right;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($enquiries)): ?>
          <?php foreach ($enquiries as $eq): ?>
            <tr>
              <td>
                <strong style="font-family:monospace;"><?= htmlspecialchars($eq['enquiry_ref']) ?></strong>
                <div style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($eq['created_at']) ?></div>
              </td>
              <td>
                <strong style="color:var(--admin-gray-900);"><?= htmlspecialchars($eq['customer_name']) ?></strong>
                <?php if (!empty($eq['company_name'])): ?>
                  <div style="font-size:12px;color:var(--admin-gray-700);"><?= htmlspecialchars($eq['company_name']) ?></div>
                <?php endif; ?>
                <div style="font-size:11px;color:var(--admin-gray-500);margin-top:2px;">
                  <a href="mailto:<?= htmlspecialchars($eq['email']) ?>"><?= htmlspecialchars($eq['email']) ?></a> &bull;
                  <a href="tel:<?= htmlspecialchars($eq['phone']) ?>"><?= htmlspecialchars($eq['phone']) ?></a>
                </div>
              </td>
              <td>
                <div style="font-size:13px;font-weight:600;"><?= htmlspecialchars($eq['product_family']) ?></div>
                <div style="font-size:11px;color:var(--admin-primary);font-weight:600;">
                  Size: <?= htmlspecialchars($eq['metric_dia']) ?> mm <?= !empty($eq['inch_equiv']) ? '(' . htmlspecialchars($eq['inch_equiv']) . ')' : '' ?> &bull; Variant: <?= htmlspecialchars($eq['variant_name']) ?>
                </div>
              </td>
              <td>
                <span class="admin-badge admin-badge-red" style="font-size:12px;"><?= (int)$eq['quantity'] ?> pcs</span>
              </td>
              <td>
                <div style="max-width:240px;font-size:12px;color:var(--admin-gray-700);line-height:1.4;">
                  <?php if (!empty($eq['address'])): ?>
                    <div><strong>Address:</strong> <?= htmlspecialchars($eq['address']) ?></div>
                  <?php endif; ?>
                  <?php if (!empty($eq['message'])): ?>
                    <div style="color:var(--admin-gray-500);"><?= htmlspecialchars($eq['message']) ?></div>
                  <?php endif; ?>
                </div>
              </td>
              <td>
                <span class="admin-badge <?= $eq['status'] === 'Quoted' ? 'admin-badge-active' : 'admin-badge-gray' ?>">
                  <?= htmlspecialchars($eq['status'] ?? 'New') ?>
                </span>
              </td>
              <td style="text-align:right;">
                <div style="display:flex;gap:4px;justify-content:flex-end;">
                  <?php if ($eq['status'] !== 'Quoted'): ?>
                    <a href="enquiries.php?action=status&id=<?= $eq['id'] ?>&val=Quoted" class="admin-btn admin-btn-secondary admin-btn-sm" style="color:#059669;">Mark Quoted</a>
                  <?php endif; ?>
                  <a href="enquiries.php?action=delete&id=<?= $eq['id'] ?>" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Delete this enquiry record?');">&times;</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

        <?php elseif (!empty($json_enquiries)): ?>
          <?php foreach (array_reverse($json_enquiries) as $jq): ?>
            <tr>
              <td>
                <strong style="font-family:monospace;"><?= htmlspecialchars($jq['enquiry_ref']) ?></strong>
                <div style="font-size:11px;color:var(--admin-gray-500);"><?= htmlspecialchars($jq['timestamp']) ?></div>
              </td>
              <td>
                <strong style="color:var(--admin-gray-900);"><?= htmlspecialchars($jq['customer_name']) ?></strong>
                <?php if (!empty($jq['company_name'])): ?>
                  <div style="font-size:12px;color:var(--admin-gray-700);"><?= htmlspecialchars($jq['company_name']) ?></div>
                <?php endif; ?>
                <div style="font-size:11px;color:var(--admin-gray-500);margin-top:2px;">
                  <?= htmlspecialchars($jq['email']) ?> &bull; <?= htmlspecialchars($jq['phone']) ?>
                </div>
              </td>
              <td>
                <div style="font-size:13px;font-weight:600;"><?= htmlspecialchars($jq['product_family']) ?></div>
                <div style="font-size:11px;color:var(--admin-primary);font-weight:600;">
                  Size: <?= htmlspecialchars($jq['metric_dia']) ?> mm &bull; <?= htmlspecialchars($jq['variant_name']) ?>
                </div>
              </td>
              <td>
                <span class="admin-badge admin-badge-red" style="font-size:12px;"><?= (int)$jq['quantity'] ?> pcs</span>
              </td>
              <td>
                <div style="max-width:240px;font-size:12px;color:var(--admin-gray-700);">
                  <?= htmlspecialchars($jq['address'] ?? $jq['message'] ?? 'None') ?>
                </div>
              </td>
              <td><span class="admin-badge admin-badge-gray">JSON Log</span></td>
              <td style="text-align:right;">&mdash;</td>
            </tr>
          <?php endforeach; ?>

        <?php else: ?>
          <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--admin-gray-500);">No quotation requests received yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
