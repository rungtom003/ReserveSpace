<!-- start: Sidebar -->
<div class="sidebar position-fixed top-0 bottom-0 bg-white border-end">
    <div class="d-flex align-items-center p-3">
        <a href="#" class="sidebar-logo text-uppercase fw-bold text-decoration-none text-indigo fs-4">ระบบจองพื้นที่</a>
        <i class="sidebar-toggle ri-arrow-left-circle-line ms-auto fs-5 d-none d-md-block"></i>
    </div>
    <ul class="sidebar-menu p-3 m-0 mb-0">
        <li class="sidebar-menu-item <?=isset($active_index)?$active_index:""?>">
            <a href="/ReserveSpace/index.php">
                <i class="ri-dashboard-line sidebar-menu-item-icon"></i>
                จองพื้นที่ขาย
            </a>
        </li>
        <li class="sidebar-menu-item <?=isset($active_reserveData)?$active_reserveData:""?>">
            <a href="/ReserveSpace/reserveData.php">
                <i class="ri-file-mark-line sidebar-menu-item-icon"></i>
                ข้อมูลการจอง
            </a>
        </li>
        <?php if($user["ur_Id"] == "R002"){ ?>
        <li class="sidebar-menu-divider mt-3 mb-1 text-uppercase">Admin</li>
        <li class="sidebar-menu-item <?=isset($active_signup)?$active_signup:""?>">
            <a href="/ReserveSpace/signup.php">
                <i class="ri-user-add-line sidebar-menu-item-icon"></i>
                เพิ่มชื่อผู้ใช้
            </a>
        </li>
        <li class="sidebar-menu-item <?=isset($active_approve)?$active_approve:""?>">
            <a href="/ReserveSpace/approveUser.php">
                <i class="ri-shield-check-line sidebar-menu-item-icon"></i>
                Approve User
            </a>
        </li>
        <li class="sidebar-menu-item <?=isset($active_reserveOrder)?$active_reserveOrder:""?>">
            <a href="/ReserveSpace/reserveOrder.php">
                <i class="ri-file-list-3-line sidebar-menu-item-icon"></i>
                รายการจอง
            </a>
        </li>
        <?php } ?>
    </ul>
</div>
<div class="sidebar-overlay"></div>
<!-- end: Sidebar -->