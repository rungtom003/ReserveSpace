<!-- start: Sidebar -->
<div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3">
        <a href="#" class="sidebar-logo text-uppercase fw-bold text-decoration-none text-indigo fs-4">ระบบจองพื้นที่</a>
        <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">
        <?php if ($user["ur_Id"] == "R001") { ?>
            <li class="sidebar-menu-item <?= isset($active_index) ? $active_index : "" ?>">
                <a href="<?=$host_path?>/index.php">
                    <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
                    จองพื้นที่ขาย
                </a>
            </li>
        <?php } ?>

        <?php if ($user["ur_Id"] == "R002") { ?>
            <li class="sidebar-menu-item <?= isset($active_Dashboard) ? $active_Dashboard : "" ?>">
                <a href="<?=$host_path?>/dashboard.php">
                    <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
                    หน้าแรก
                </a>
            </li>
        <?php } ?>

        <li class="sidebar-menu-item <?= isset($active_real) ? $active_real : "" ?>">
            <a href="<?=$host_path?>/real.php">
                <i class="ri-image-line sidebar-menu-item-icon"></i>
                รูปพื้นที่จริง
            </a>
        </li>
        <?php if ($user["ur_Id"] == "R001") { ?>
            <li class="sidebar-menu-item <?= isset($active_reserveData) ? $active_reserveData : "" ?>">
                <a href="<?=$host_path?>/reserveData.php">
                    <i class="ri-file-mark-line sidebar-menu-item-icon"></i>
                    ข้อมูลการจอง
                </a>
            </li>
        <?php } ?>
        <li class="sidebar-menu-item <?= isset($active_persionData) ? $active_persionData : "" ?>">
            <a href="<?=$host_path?>/persionData.php">
                <i class="ri-file-user-line sidebar-menu-item-icon"></i>
                ข้อมูลส่วนตัว
            </a>
        </li>
        <?php if ($user["ur_Id"] == "R002") { ?>
            <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Admin</li>
            <li class="sidebar-menu-item <?= isset($active_signup) ? $active_signup : "" ?>">
                <a href="<?=$host_path?>/signup.php">
                    <i class="ri-user-add-line sidebar-menu-item-icon"></i>
                    เพิ่มชื่อผู้ใช้
                </a>
            </li>
            <li class="sidebar-menu-item <?= isset($active_approve) ? $active_approve : "" ?>">
                <a href="<?=$host_path?>/approveUser.php">
                    <i class="ri-shield-check-line sidebar-menu-item-icon"></i>
                    Approve User
                </a>
            </li>
            <li class="sidebar-menu-item <?= isset($active_reserveOrder) ? $active_reserveOrder : "" ?>">
                <a href="<?=$host_path?>/reserveOrder.php">
                    <i class="ri-file-list-3-line sidebar-menu-item-icon"></i>
                    รายการจอง
                </a>
            </li>
            <li class="sidebar-menu-item <?= isset($active_area) ? $active_area : "" ?>">
                <a href="<?=$host_path?>/area.php">
                    <i class="ri-pencil-line sidebar-menu-item-icon"></i>
                    การจัดการล็อก
                </a>
            </li>
            <li class="sidebar-menu-item <?= isset($active_reserve_history) ? $active_reserve_history : "" ?>">
                <a href="<?=$host_path?>/history_reserve.php">
                    <i class="ri-history-line sidebar-menu-item-icon"></i>
                    ประวัติการจอง
                </a>
            </li>
            <li class="sidebar-menu-item <?= isset($active_opensystem) ? $active_opensystem : "" ?>">
                <a href="<?=$host_path?>/settime_opensystem.php">
                    <i class="ri-timer-line sidebar-menu-item-icon"></i>
                    ตั้งเวลา เปิด/ปิด ระบบ
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
<div class="sidebar-overlay"></div>
<!-- end: Sidebar -->