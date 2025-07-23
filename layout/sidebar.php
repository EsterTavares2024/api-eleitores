<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <span class="brand-text font-weight-light">Meu Painel</span>
  </a>

  <div class="sidebar">
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="/admin/dashboard/index.php"
             class="nav-link <?= $current == 'index.php' && strpos($_SERVER['REQUEST_URI'], '/dashboard/') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/admin/customer/index.php"
             class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/customer/') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>Eleitores</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/admin/candidates/index.php"
             class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/candidates/') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-tie"></i>
            <p>Candidatos</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/admin/api/token.php"
             class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/token.php') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-key"></i>
            <p>Token API</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/admin/docs-api/docs.php" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/docs-api/docs.php') !== false ? 'active' : '' ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>Documentação API</p>
          </a>
        </li>


        <li class="nav-item">
          <a href="/logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Sair</p>
          </a>
        </li>

      </ul>
    </nav>
  </div>
</aside>
