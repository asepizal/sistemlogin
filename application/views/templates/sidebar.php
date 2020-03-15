  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">AR ADMIN</div>
      </a>

      <!-- query menu -->
      <?php
        $id_role = $this->session->userdata('id_role');
        $queryMenu = "SELECT `user_menu`.`id`,`menu` 
                      FROM `user_menu` JOIN `user_access_menu`
                      ON `user_menu`.`id` = `user_access_menu`.`id_menu`
                      WHERE `user_access_menu`.`id_role` = $id_role
                      ORDER BY `user_access_menu`.`id_menu` ASC
                      ";

        $menu = $this->db->query($queryMenu)->result_array();
      ?>
      
      <hr class="sidebar-divider">

      <!-- Heading -->
      <?php foreach ($menu as $m) : ?>
        <div class="sidebar-heading">
          <?= $m['menu']; ?>
        </div>
        
      <?php 
        $menuId = $m['id'];
        $querySubMenu = "SELECT *
                        FROM `user_sub_menu` JOIN `user_menu`
                        ON `user_sub_menu`.`id_menu` = `user_menu`.`id`
                        WHERE `user_sub_menu`.`id_menu` = $menuId
                        ORDER BY `user_sub_menu`.`title` ASC
                        ";          

        $subMenu = $this->db->query($querySubMenu)->result_array();
      ?>  

        <?php foreach ($subMenu as $sm) : ?>
          <?php if ($sm['title'] == $title) : ?>
          <li class="nav-item active">
          <?php else :?>
          <li class="nav-item">
          <?php endif ; ?>
            <a class="nav-link pb-0" href="<?= base_url().$sm['url'] ?>">
              <i class="<?= $sm['icon'] ?>"></i>
              <span><?= $sm['title'] ?></span></a>
          </li>
        <?php endforeach ; ?>    

      <hr class="sidebar-divider mt-3">
      <?php endforeach ; ?>

      <!-- Divider -->

      <!-- nav item logout -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->