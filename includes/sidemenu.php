<?php if($showBadgeNumbersInMenu=="yes"){?> 
<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-container=".sidemenu-navigation" title="Chats">
    <a class="nav-link <?php if($page=="crm-chats"||$page=="chat-room"){?>active<?php }?>" href="/crm-chats" role="tab">
        <i class='bx bx-conversation'></i>
    </a>
</li>
<?php }?>

<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-container=".sidemenu-navigation" title="Customer">
    <a class="nav-link <?php if($page=="crm-customer"){?>active<?php }?>" href="/crm-customer" role="tab">
        <i class='bx bxs-user-detail'></i>
    </a>
</li>

<?php if($_SESSION['user_type']==""){?> 
<li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-trigger="hover" data-bs-container=".sidemenu-navigation" title="Agents">
    <a class="nav-link <?php if($page=="crm-agents"){?>active<?php }?>" href="/crm-agents" role="tab">
        <i class='bx bxs-user-voice'></i>
    </a>
</li>
<?php }?>

<li class="nav-item dropdown profile-user-dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="/assets/logo.jpg" alt="" class="profile-user rounded-circle">
    </a>
    <div class="dropdown-menu">
        
        <?php if($_SESSION['user_type']==""){?> 
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="whatsapp_manage.html">Manage WhatsApp</a>
        <?php }?>

        <div class="dropdown-divider"></div>
        
        <a class="dropdown-item d-flex align-items-center justify-content-between" href="auth-logout.html">Log out <i class="bx bx-log-out-circle text-muted ms-1"></i></a>
    </div>
</li>