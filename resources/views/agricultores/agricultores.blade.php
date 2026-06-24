<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Agricultores</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap"
    rel="stylesheet" />

  <style>
    :root {
      --sidebar-bg: #1B5E20;
      --sidebar-hover: #2E7D32;
      --sidebar-active: #2E7D32;
      --accent: #66BB6A;
      --accent-lt: #E8F5E9;
      --primary: #2E7D32;
      --text-dark: #1C2B1E;
      --text-mid: #4A6350;
      --text-light: #8FA894;
      --border: rgba(0, 0, 0, .07);
      --card-bg: #ffffff;
      --page-bg: #F4F6F4;
      --sidebar-w: 240px;
      --sidebar-w-icons: 68px;
      --topbar-h: 64px;
      --danger: #C62828;
      --warning: #F57F17;
      --info: #1565C0;
    }

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--page-bg);
      color: var(--text-dark);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ═══════════════════════════════════════════
       SIDEBAR
    ═══════════════════════════════════════════ */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      transition: width .3s ease;
      z-index: 1000;
      overflow: hidden;
    }

    body.icons-only #sidebar {
      width: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #sidebar {
      width: 0;
    }

    .sidebar-logo {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 14px 15px;
      border-bottom: 1px solid rgba(255, 255, 255, .1);
      white-space: nowrap;
      min-height: var(--topbar-h);
      overflow: hidden;
    }

    body.icons-only .sidebar-logo {
      justify-content: center;
      padding: 14px 0;
    }

    body.icons-only .sidebar-logo .logo-text-wrap {
      opacity: 0;
      pointer-events: none;
      width: 0;
      overflow: hidden;
    }

    .sidebar-nav {
      flex: 1;
      padding: 12px 0;
      overflow-y: auto;
      overflow-x: hidden;
    }

    .sidebar-nav::-webkit-scrollbar {
      width: 4px;
    }

    .sidebar-nav::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .18);
      border-radius: 10px;
    }

    .sidebar-nav {
      scrollbar-width: thin;
      scrollbar-color: rgba(255, 255, 255, .18) transparent;
    }

    .nav-section-title {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: rgba(255, 255, 255, .4);
      padding: 18px 20px 6px;
      white-space: nowrap;
      transition: opacity .2s;
    }

    body.icons-only .nav-section-title {
      opacity: 0;
      height: 0;
      padding: 0;
      overflow: hidden;
    }

    .nav-item-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 18px;
      color: rgba(255, 255, 255, .75);
      text-decoration: none;
      border-radius: 10px;
      margin: 2px 8px;
      transition: background .2s, color .15s;
      white-space: nowrap;
      position: relative;
    }

    .nav-item-link i {
      font-size: 18px;
      flex-shrink: 0;
      width: 22px;
      text-align: center;
    }

    .nav-item-link .nav-label {
      font-size: 14px;
      font-weight: 500;
      opacity: 1;
      transition: opacity .2s;
    }

    body.icons-only .nav-item-link .nav-label {
      opacity: 0;
      pointer-events: none;
      width: 0;
      overflow: hidden;
    }

    body.icons-only .nav-item-link {
      justify-content: center;
      padding: 11px 0;
      margin: 2px 6px;
    }

    .nav-item-link:hover {
      background: rgba(255, 255, 255, .1);
      color: #fff;
    }

    .nav-item-link.active {
      background: var(--accent);
      color: #fff;
      box-shadow: 0 4px 14px rgba(102, 187, 106, .35);
    }

    .sidebar-tooltip .tooltip-inner {
      background: #0f3d14;
      color: #fff;
      font-size: 12.5px;
      font-weight: 500;
      padding: 5px 12px;
      border-radius: 8px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .3);
    }

    .sidebar-tooltip.bs-tooltip-end .tooltip-arrow::before {
      border-right-color: #0f3d14;
    }

    .sidebar-user {
      padding: 14px 10px;
      border-top: 1px solid rgba(255, 255, 255, .1);
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      transition: background .2s;
      border-radius: 10px;
      margin: 4px 6px;
      white-space: nowrap;
    }

    .sidebar-user:hover {
      background: rgba(255, 255, 255, .08);
    }

    .sidebar-user .avatar {
      width: 34px;
      height: 34px;
      background: var(--accent);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      overflow: hidden;
    }

    .sidebar-user .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .sidebar-user .avatar i {
      color: #fff;
      font-size: 16px;
    }

    .sidebar-user .user-info {
      opacity: 1;
      transition: opacity .2s;
    }

    .sidebar-user .user-info .u-name {
      font-size: 13px;
      font-weight: 600;
      color: #fff;
    }

    .sidebar-user .user-info .u-role {
      font-size: 11px;
      color: rgba(255, 255, 255, .5);
    }

    body.icons-only .sidebar-user .user-info {
      opacity: 0;
      pointer-events: none;
    }

    /* ═══════════════════════════════════════════
       TOPBAR
    ═══════════════════════════════════════════ */
    #topbar {
      position: fixed;
      top: 0;
      left: var(--sidebar-w);
      right: 0;
      height: var(--topbar-h);
      background: #fff;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 28px;
      gap: 16px;
      z-index: 900;
      transition: left .3s ease;
    }

    body.icons-only #topbar {
      left: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #topbar {
      left: 0;
    }

    .topbar-toggle {
      background: none;
      border: none;
      font-size: 20px;
      color: var(--text-mid);
      cursor: pointer;
      padding: 6px;
      border-radius: 8px;
      transition: background .2s, color .2s;
    }

    .topbar-toggle:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .topbar-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .topbar-right {
      margin-left: auto;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .topbar-icon-btn {
      width: 38px;
      height: 38px;
      border: none;
      background: var(--accent-lt);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--primary);
      font-size: 17px;
      cursor: pointer;
      transition: background .2s, color .2s;
      position: relative;
    }

    .topbar-icon-btn:hover {
      background: var(--primary);
      color: #fff;
    }

    /* Ícones Bootstrap — cor verde primária por defeito */
    .bi {
      color: var(--primary);
    }

    .nav-item-link .bi,
    .sidebar-logo .bi,
    .sidebar-user .bi,
    .modal-header .bi,
    .modal-header-icon .bi,
    .btn-green .bi,
    .topbar-icon-btn:hover .bi,
    .action-btn.edit:hover .bi,
    .action-btn.print:hover .bi,
    .action-btn.delete:hover .bi,
    .action-btn.view:hover .bi {
      color: inherit;
    }

    .topbar-title .bi,
    .table-card-header .bi,
    .cfg-card-title .bi,
    .modal-section-title .bi {
      color: var(--primary);
    }

    .badge-status .bi,
    .badge-cargo .bi,
    .stat-badge .bi {
      color: inherit;
    }

    .search-wrap .bi {
      color: var(--text-light);
    }

    .notif-badge {
      position: absolute;
      top: 6px;
      right: 6px;
      width: 8px;
      height: 8px;
      background: #E53935;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .topbar-user {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 12px;
      background: var(--accent-lt);
      border-radius: 30px;
      cursor: pointer;
      transition: background .2s;
    }

    .topbar-user:hover {
      background: #C8E6C9;
    }

    .topbar-user .t-avatar {
      width: 30px;
      height: 30px;
      background: var(--primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    .topbar-user .t-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .avatar-md {
      width: 30px !important;
      height: 30px;
      object-fit: cover;
      border-radius: 50%;
    }

    .topbar-user .t-avatar i {
      color: #fff;
      font-size: 14px;
    }

    .topbar-user span {
      font-size: 13px;
      font-weight: 500;
      color: var(--primary);
    }

    .dropdown-menu-user {
      min-width: 200px;
      border: 1px solid var(--border);
      border-radius: 14px;
      box-shadow: 0 12px 36px rgba(0, 0, 0, .12);
      padding: 6px;
      margin-top: 8px !important;
    }

    .dropdown-menu-user .dropdown-header {
      font-size: 11px;
      font-weight: 600;
      letter-spacing: .8px;
      text-transform: uppercase;
      color: var(--text-light);
      padding: 6px 12px 4px;
    }

    .dropdown-menu-user .dropdown-item {
      font-size: 13.5px;
      color: var(--text-mid);
      border-radius: 8px;
      padding: 9px 12px;
      display: flex;
      align-items: center;
      gap: 9px;
      transition: background .15s, color .15s;
    }

    .dropdown-menu-user .dropdown-item i {
      font-size: 15px;
      color: var(--text-light);
    }

    .dropdown-menu-user .dropdown-item:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .dropdown-menu-user .dropdown-item:hover i {
      color: var(--primary);
    }

    .dropdown-menu-user .dropdown-divider {
      margin: 4px 6px;
      border-color: var(--border);
    }

    .dropdown-menu-user .item-logout {
      color: #C62828;
    }

    .dropdown-menu-user .item-logout i {
      color: #C62828;
    }

    .dropdown-menu-user .item-logout:hover {
      background: #FFEBEE;
      color: #C62828;
    }

    .dropdown-menu-user form {
      margin: 0;
    }

    .dropdown-menu-user form button {
      background: none;
      border: none;
      font-size: 13.5px;
      color: #C62828;
      border-radius: 8px;
      padding: 9px 12px;
      width: 100%;
      text-align: left;
      display: flex;
      align-items: center;
      gap: 9px;
      cursor: pointer;
      transition: background .15s;
    }

    .dropdown-menu-user form button:hover {
      background: #FFEBEE;
    }

    .dropdown-menu-user form button i {
      font-size: 15px;
      color: #C62828;
    }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    #main {
      margin-left: var(--sidebar-w);
      padding-top: var(--topbar-h);
      transition: margin-left .3s ease;
      min-height: 100vh;
    }

    body.icons-only #main {
      margin-left: var(--sidebar-w-icons);
    }

    body.sidebar-hidden #main {
      margin-left: 0;
    }

    .content-inner {
      padding: 28px;
    }

    /* ═══════════════════════════════════════════
       PAGE HEADER
    ═══════════════════════════════════════════ */
    .page-header {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 28px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .page-header h1 {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 3px;
    }

    .page-header p {
      font-size: 13.5px;
      color: var(--text-light);
    }

    .btn-green {
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 9px 18px;
      font-size: 13.5px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background .2s, transform .1s;
      text-decoration: none;
    }

    .btn-green:hover {
      background: var(--accent);
      color: #fff;
    }

    .btn-green:active {
      transform: scale(.97);
    }

    .btn-outline-green {
      background: transparent;
      color: var(--primary);
      border: 1.5px solid var(--primary);
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 13.5px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      cursor: pointer;
      transition: background .2s, color .2s;
      text-decoration: none;
    }

    .btn-outline-green:hover {
      background: var(--accent-lt);
      color: var(--primary);
    }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stat-card {
      background: var(--card-bg);
      border-radius: 16px;
      padding: 22px 20px;
      border: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 16px;
      transition: box-shadow .2s, transform .2s;
    }

    .stat-card:hover {
      box-shadow: 0 8px 28px rgba(46, 125, 50, .1);
      transform: translateY(-2px);
    }

    .stat-icon {
      width: 52px;
      height: 52px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      font-size: 22px;
    }

    .stat-icon.green {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .stat-icon.blue {
      background: #E3F2FD;
      color: #1565C0;
    }

    .stat-icon.amber {
      background: #FFF8E1;
      color: #F57F17;
    }

    .stat-icon.purple {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .stat-info .s-label {
      font-size: 12.5px;
      color: var(--text-light);
      margin-bottom: 4px;
    }

    .stat-info .s-value {
      font-family: 'Sora', sans-serif;
      font-size: 22px;
      font-weight: 700;
      color: var(--text-dark);
      line-height: 1;
      margin-bottom: 5px;
    }

    .stat-badge {
      font-size: 11.5px;
      font-weight: 600;
      padding: 3px 8px;
      border-radius: 30px;
      display: inline-flex;
      align-items: center;
      gap: 3px;
    }

    .stat-badge.up {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .stat-badge.info {
      background: #E3F2FD;
      color: #1565C0;
    }

    /* ═══════════════════════════════════════════
       TABLE CARD
    ═══════════════════════════════════════════ */
    .table-card {
      background: var(--card-bg);
      border-radius: 16px;
      border: 1px solid var(--border);
      overflow: hidden;
    }

    .table-card-header {
      padding: 18px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid var(--border);
      flex-wrap: wrap;
      gap: 12px;
    }

    .table-card-header h5 {
      font-family: 'Sora', sans-serif;
      font-size: 15px;
      font-weight: 600;
      color: var(--text-dark);
    }

    /* Search bar */
    .search-filter-bar {
      padding: 14px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
    }

    .search-wrap {
      flex: 1;
      min-width: 220px;
      position: relative;
    }

    .search-wrap i {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      font-size: 14px;
      pointer-events: none;
    }

    .search-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 14px 10px 36px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      outline: none;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s, box-shadow .2s;
    }

    .search-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
      background: #fff;
    }

    .search-input::placeholder {
      color: #C3B8B4;
    }

    .filter-select {
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 32px 10px 14px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      appearance: none;
      cursor: pointer;
      outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      transition: border-color .2s;
      min-width: 150px;
    }

    .filter-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    /* Agricultores Table */
    .ag-table {
      width: 100%;
      border-collapse: collapse;
    }

    .ag-table th {
      font-size: 11px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: var(--text-light);
      padding: 12px 20px;
      background: #FAFBFA;
      border-bottom: 1px solid var(--border);
      text-align: left;
      white-space: nowrap;
    }

    .ag-table td {
      font-size: 13.5px;
      color: var(--text-dark);
      padding: 14px 20px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    .ag-table tr:last-child td {
      border-bottom: none;
    }

    .ag-table tbody tr:hover td {
      background: #F8FBF8;
    }

    /* Avatar circular do agricultor */
    .person-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 12px;
      font-weight: 800;
      color: #fff;
      flex-shrink: 0;
      letter-spacing: -.5px;
      overflow: hidden;
    }

    .person-avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .ag-cell {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .ag-cell .ag-name {
      font-weight: 600;
      font-size: 14px;
    }

    .ag-cell .ag-bi {
      font-size: 11.5px;
      color: var(--text-light);
      margin-top: 1px;
    }

    /* Badges — texto neutro, sem fundo/borda */
    .badge-status,
    .badge-cargo {
      font-size: 12px;
      font-weight: 500;
      padding: 0;
      background: none;
      border-radius: 0;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .badge-status.activo {
      color: #2E7D32;
    }

    .badge-status.inactivo {
      color: #C62828;
    }

    .badge-status.pendente {
      color: #F57F17;
    }

    .badge-status .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }

    .badge-status.activo .dot {
      background: #2E7D32;
    }

    .badge-status.inactivo .dot {
      background: #C62828;
    }

    .badge-status.pendente .dot {
      background: #F57F17;
    }

    .badge-cargo {
      color: var(--text-mid);
    }

    .text-muted-coop {
      color: var(--text-light);
      font-size: 12.5px;
    }

    /* Action buttons in table */
    .action-btn {
      width: 32px;
      height: 32px;
      border: none;
      border-radius: 9px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      cursor: pointer;
      transition: background .15s, color .15s;
      text-decoration: none;
    }

    .action-btn.edit {
      background: var(--accent-lt);
      color: var(--primary);
    }

    .action-btn.edit:hover {
      background: var(--primary);
      color: #fff;
    }

    .action-btn.delete {
      background: #FFEBEE;
      color: #C62828;
    }

    .action-btn.delete:hover {
      background: #C62828;
      color: #fff;
    }

    .action-btn.view {
      background: #EDE7F6;
      color: #6A1B9A;
    }

    .action-btn.view:hover {
      background: #6A1B9A;
      color: #fff;
    }

    /* Pagination */
    .table-footer {
      padding: 14px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid var(--border);
      flex-wrap: wrap;
      gap: 10px;
    }

    .table-footer span {
      font-size: 12.5px;
      color: var(--text-light);
    }

    .pagination-btns {
      display: flex;
      gap: 6px;
    }

    .page-btn {
      min-width: 34px;
      height: 34px;
      padding: 0 10px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      background: #fff;
      font-size: 13px;
      color: var(--text-mid);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all .15s;
      font-family: 'DM Sans', sans-serif;
    }

    .page-btn:hover {
      border-color: var(--primary);
      color: var(--primary);
    }

    .page-btn.active {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }

    /* ═══════════════════════════════════════════
       EMPTY STATE
    ═══════════════════════════════════════════ */
    .empty-state {
      text-align: center;
      padding: 60px 20px;
    }

    .empty-state i {
      font-size: 52px;
      color: var(--accent);
      opacity: .5;
      display: block;
      margin-bottom: 16px;
    }

    .empty-state h6 {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      color: var(--text-dark);
      margin-bottom: 6px;
    }

    .empty-state p {
      font-size: 13px;
      color: var(--text-light);
    }

    /* ═══════════════════════════════════════════
       MODAL
    ═══════════════════════════════════════════ */
    .modal-coop {
      max-width: 780px;
    }

    .modal-coop .modal-content {
      height: 620px;
      display: flex;
      flex-direction: column;
    }

    /* O scroll está apenas no modal-body — as tabs não têm scroll próprio */
    .modal-coop .modal-body {
      flex: 1;
      overflow-y: auto;
      overflow-x: hidden;
      padding: 0;
      background: var(--page-bg);
      scrollbar-width: thin;
      scrollbar-color: rgba(0, 0, 0, .15) transparent;
    }

    .modal-coop .modal-body::-webkit-scrollbar {
      width: 5px;
    }

    .modal-coop .modal-body::-webkit-scrollbar-track {
      background: transparent;
    }

    .modal-coop .modal-body::-webkit-scrollbar-thumb {
      background: rgba(0, 0, 0, .12);
      border-radius: 10px;
    }

    .modal-coop .modal-body::-webkit-scrollbar-thumb:hover {
      background: rgba(0, 0, 0, .22);
    }

    body.dark-mode .modal-coop .modal-body {
      scrollbar-color: rgba(255, 255, 255, .15) transparent;
    }

    body.dark-mode .modal-coop .modal-body::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, .15);
    }

    /* Tabs: sem altura fixa, sem scroll próprio */
    .modal-tab-panel {
      display: none;
      padding: 22px;
    }

    .modal-tab-panel.active {
      display: block;
    }

    .modal-content {
      border: none;
      border-radius: 18px;
      box-shadow: 0 24px 64px rgba(0, 0, 0, .15);
      overflow: hidden;
    }

    .modal-header {
      padding: 11px 20px;
      border-bottom: 1px solid var(--border);
      background: linear-gradient(135deg, var(--sidebar-bg) 0%, var(--primary) 100%);
      flex-shrink: 0;
    }

    .modal-header .modal-title {
      font-family: 'Sora', sans-serif;
      font-size: 16px;
      font-weight: 700;
      color: #fff;
    }

    .modal-header .btn-close {
      filter: brightness(0) invert(1);
      opacity: .8;
    }

    .modal-header .btn-close:hover {
      opacity: 1;
    }

    .modal-header-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: rgba(255, 255, 255, .2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      color: #fff;
      flex-shrink: 0;
    }

    .modal-body {
      background: var(--page-bg);
    }

    .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
    }

    .modal-section-title {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--text-light);
      margin-bottom: 14px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .modal-section-title i {
      font-size: 13px;
      color: var(--primary);
    }

    .modal-form-card {
      background: var(--card-bg);
      border-radius: 14px;
      border: 1px solid var(--border);
      padding: 20px 22px;
      margin-bottom: 16px;
    }

    .cfg-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-mid);
      margin-bottom: 5px;
      letter-spacing: .2px;
    }

    .cfg-input {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }

    .cfg-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
      background: #fff;
    }

    .cfg-input::placeholder {
      color: #C3B8B4;
    }

    .cfg-input[readonly] {
      background: #F5F5F5;
      color: var(--text-light);
      cursor: not-allowed;
    }

    .cfg-select {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 32px 10px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      appearance: none;
      cursor: pointer;
      outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      transition: border-color .2s;
      font-family: 'DM Sans', sans-serif;
    }

    .cfg-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    .cfg-textarea {
      width: 100%;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 10px 13px;
      font-size: 13.5px;
      color: var(--text-dark);
      background: #FAFAF9;
      resize: vertical;
      min-height: 80px;
      outline: none;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s;
    }

    .cfg-textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46, 125, 50, .1);
    }

    .cfg-helper {
      font-size: 11.5px;
      color: var(--text-light);
      margin-top: 4px;
    }

    /* ── MODAL TABS ─── */
    .modal-tabs {
      display: flex;
      gap: 0;
      border-bottom: 2px solid var(--border);
      background: var(--page-bg);
      padding: 0 24px;
      overflow-x: auto;
    }

    .modal-tabs::-webkit-scrollbar {
      height: 0;
    }

    .modal-tab-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 14px 18px;
      font-size: 13px;
      font-weight: 500;
      color: var(--text-mid);
      background: none;
      border: none;
      border-bottom: 2px solid transparent;
      margin-bottom: -2px;
      cursor: pointer;
      transition: color .15s, border-color .15s;
      white-space: nowrap;
    }

    .modal-tab-btn .bi {
      color: var(--text-light);
      transition: color .15s;
      font-size: 15px;
    }

    .modal-tab-btn:hover {
      color: var(--primary);
    }

    .modal-tab-btn:hover .bi {
      color: var(--primary);
    }

    .modal-tab-btn.active {
      color: var(--primary);
      font-weight: 600;
      border-bottom-color: var(--primary);
    }

    .modal-tab-btn.active .bi {
      color: var(--primary);
    }

    /* Foto upload */
    .foto-upload-zone {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 2px dashed var(--border);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      font-size: 11px;
      color: var(--text-light);
      text-align: center;
      gap: 4px;
      flex-shrink: 0;
      overflow: hidden;
    }

    .foto-upload-zone:hover {
      border-color: var(--primary);
      background: var(--accent-lt);
    }

    .foto-upload-zone i {
      font-size: 24px;
      color: var(--text-light);
    }

    /* Aviso info */
    .info-alert {
      background: #FFF8E1;
      border: 1px solid #FFE082;
      border-radius: 12px;
      padding: 14px 18px;
      margin-bottom: 16px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
    }

    .info-alert i {
      color: #F57F17;
      font-size: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }

    .info-alert .ia-title {
      font-size: 13.5px;
      font-weight: 600;
      color: #7f5000;
    }

    .info-alert .ia-sub {
      font-size: 12.5px;
      color: #9a6000;
      margin-top: 2px;
    }

    /* Toast */
    .save-toast {
      position: fixed;
      bottom: 28px;
      right: 28px;
      z-index: 9999;
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px 20px;
      box-shadow: 0 12px 36px rgba(0, 0, 0, .12);
      display: flex;
      align-items: center;
      gap: 12px;
      transform: translateY(80px);
      opacity: 0;
      transition: all .35s cubic-bezier(.34, 1.56, .64, 1);
      pointer-events: none;
    }

    .save-toast.show {
      transform: translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    .save-toast .toast-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .save-toast .toast-icon.success {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .save-toast .toast-icon.danger {
      background: #FFEBEE;
      color: #C62828;
    }

    .save-toast .toast-text .t-title {
      font-size: 13.5px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .save-toast .toast-text .t-sub {
      font-size: 12px;
      color: var(--text-light);
    }

    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(14px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .anim {
      animation: fadeUp .4s ease both;
    }

    .anim-d1 {
      animation-delay: .05s;
    }

    .anim-d2 {
      animation-delay: .10s;
    }

    .anim-d3 {
      animation-delay: .15s;
    }

    .anim-d4 {
      animation-delay: .20s;
    }

    /* Dark mode */
    body.dark-mode {
      --card-bg: #1e2a20;
      --page-bg: #141d15;
      --text-dark: #e8f0e9;
      --text-mid: #9ab89e;
      --text-light: #6a8a6e;
      --border: rgba(255, 255, 255, .07);
    }

    body.dark-mode #topbar {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .06);
    }

    body.dark-mode .topbar-title {
      color: #e8f0e9;
    }

    body.dark-mode .topbar-user {
      background: rgba(102, 187, 106, .15);
    }

    body.dark-mode .topbar-user span {
      color: #66BB6A;
    }

    body.dark-mode .topbar-icon-btn {
      background: rgba(102, 187, 106, .12);
    }

    body.dark-mode .ag-table th {
      background: #172518;
    }

    body.dark-mode .ag-table tbody tr:hover td {
      background: #1a2a1c;
    }

    body.dark-mode .search-input,
    body.dark-mode .filter-select,
    body.dark-mode .cfg-input,
    body.dark-mode .cfg-select,
    body.dark-mode .cfg-textarea {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255, 255, 255, .1);
    }

    body.dark-mode .modal-body {
      background: #1a2a1c;
    }

    body.dark-mode .modal-form-card {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .07);
    }

    body.dark-mode .modal-footer {
      background: #1e2a20;
      border-color: rgba(255, 255, 255, .07);
    }

    /* Responsive */
    @media (max-width: 768px) {
      :root {
        --sidebar-w: 240px;
      }

      body:not(.sidebar-hidden) #sidebar {
        box-shadow: 4px 0 20px rgba(0, 0, 0, .2);
      }

      body.default #sidebar {
        width: 0;
      }

      body.default #main {
        margin-left: 0;
      }

      body.default #topbar {
        left: 0;
      }

      .content-inner {
        padding: 16px;
      }
    }
  </style>
</head>

<body>

  <!-- ══════════════════════════════════════
     SIDEBAR
══════════════════════════════════════ -->
  <nav id="sidebar">
    <div class="sidebar-logo">
      <div class="logo-svg-wrap">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 340 340" width="38" height="38" style="flex-shrink:0;">
          <circle cx="170" cy="170" r="145" fill="#66BB6A" />
          <g fill="#ffffff" stroke="#ffffff" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round">
            <circle cx="118" cy="188" r="48" fill="none" stroke-width="6" />
            <circle cx="118" cy="188" r="35" fill="none" stroke-width="4.5" />
            <circle cx="118" cy="188" r="16" fill="#ffffff" />
            <path
              d="M 118 135 L 118 144 M 118 232 L 118 241 M 65 188 L 74 188 M 162 188 L 171 188 M 81 151 L 88 157 M 155 219 L 162 225 M 81 225 L 88 219 M 155 151 L 162 157"
              stroke-width="6" />
            <path d="M 68 185 C 68 140, 108 120, 160 128 C 171 132, 174 144, 174 151" fill="none" stroke-width="6" />
            <circle cx="231" cy="204" r="26" fill="none" stroke-width="5" />
            <circle cx="231" cy="204" r="10" fill="#ffffff" />
            <path
              d="M 231 174 L 231 180 M 231 228 L 231 234 M 201 204 L 207 204 M 255 204 L 261 204 M 210 183 L 214 187 M 248 221 L 252 225 M 210 225 L 214 221 M 248 183 L 252 187"
              stroke-width="4" />
            <path
              d="M 117 125 L 117 105 C 117 102, 120 99, 125 99 L 176 99 C 181 99, 184 102, 185 107 L 202 157 L 176 157"
              fill="none" stroke-width="6" />
            <path d="M 144 99 L 144 128 L 187 128" fill="none" stroke-width="4" />
            <path d="M 176 99 L 188 128" fill="none" stroke-width="4" />
            <path d="M 174 151 L 246 156 C 252 156, 254 159, 254 165 L 254 197 L 202 197 Z" fill="#ffffff" />
            <rect x="168" y="173" width="18" height="9" fill="none" stroke-width="4.5" />
            <rect x="168" y="185" width="18" height="7" fill="none" stroke-width="4.5" />
            <path d="M 223 156 L 223 125 C 223 119, 219 117, 219 113 L 220 107" fill="none" stroke-width="4.5" />
            <ellipse cx="239" cy="171" rx="6" ry="4" fill="#66BB6A" stroke="none" />
            <line x1="212" y1="170" x2="212" y2="188" stroke="#66BB6A" stroke-width="4" />
            <line x1="220" y1="170" x2="220" y2="188" stroke="#66BB6A" stroke-width="4" />
            <line x1="228" y1="170" x2="228" y2="188" stroke="#66BB6A" stroke-width="4" />
          </g>
        </svg>
      </div>
      <div class="logo-text-wrap" style="opacity:1;transition:opacity .2s;white-space:nowrap;">
        <div
          style="font-family:'Sora',sans-serif;font-size:17px;font-weight:700;color:#fff;letter-spacing:1px;line-height:1.1;">
          SIAG</div>
        <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:.5px;">Agrícola Cooperativas</div>
      </div>
    </div>

    <div class="sidebar-nav">
      <div class="nav-section-title">Principal</div>
      <a href="{{ route('dashboard') }}" class="nav-item-link" data-label="Dashboard"><i
          class="bi bi-grid-1x2-fill"></i><span class="nav-label">Dashboard</span></a>
      <a href="{{route('cooperativas')}}" class="nav-item-link" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index') }}" class="nav-item-link active" data-label="Agricultores"><i
          class="bi bi-people-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="{{route('talhoes.index')}}" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="#" class="nav-item-link" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span
          class="nav-label">Insumos</span></a>

      <div class="nav-section-title">Financeiro</div>
      <a href="#" class="nav-item-link" data-label="Contas a Pagar"><i class="bi bi-arrow-down-circle-fill"></i><span
          class="nav-label">Contas a Pagar</span></a>
      <a href="#" class="nav-item-link" data-label="Contas a Receber"><i class="bi bi-arrow-up-circle-fill"></i><span
          class="nav-label">Contas a Receber</span></a>
      <a href="#" class="nav-item-link" data-label="Fluxo de Caixa"><i class="bi bi-cash-stack"></i><span
          class="nav-label">Fluxo de Caixa</span></a>

      <div class="nav-section-title">Comercial</div>
      <a href="#" class="nav-item-link" data-label="Vendas"><i class="bi bi-cart-fill"></i><span
          class="nav-label">Vendas</span></a>
      <a href="#" class="nav-item-link" data-label="Contratos"><i class="bi bi-file-earmark-text-fill"></i><span
          class="nav-label">Contratos</span></a>

      <div class="nav-section-title">Sistema</div>
      <a href="#" class="nav-item-link" data-label="Relatórios"><i class="bi bi-bar-chart-fill"></i><span
          class="nav-label">Relatórios</span></a>
      <a href="{{ route('configuracoes') }}" class="nav-item-link" data-label="Configurações"><i
          class="bi bi-gear-fill"></i><span class="nav-label">Configurações</span></a>
    </div>

    <div class="sidebar-user">

      <div class="avatar">
        @if(!empty(Auth::user()->foto))
          <img id="dropdownAvatarLarge"
            src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}" alt="Foto-perfil"
            width="20" class="avatar-md">
        @else
          <span style="color:#fff;font-weight:700;font-size:15px;">{{ substr(Auth::user()->name, 0, 1) }}</span>
        @endif
      </div>
      <div class="user-info">
        <div class="u-name">{{ Auth::user()->name }}</div>
        <div class="u-role">Minha Conta</div>
      </div>
    </div>
  </nav>

  <!-- ══════════════════════════════════════
     TOPBAR
══════════════════════════════════════ -->
  <header id="topbar">
    <button class="topbar-toggle" id="sidebarToggle" title="Toggle Sidebar">
      <i class="bi bi-list"></i>
    </button>
    <span class="topbar-title">Agricultores</span>
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Agricultores</li>
      </ol>
    </nav>
    <div class="topbar-right">
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra 2024/25
      </span>
      <button class="topbar-icon-btn" title="Notificações">
        <i class="bi bi-bell-fill"></i><span class="notif-badge"></span>
      </button>
      <button class="topbar-icon-btn" title="Mensagens">
        <i class="bi bi-chat-dots-fill"></i>
      </button>
      <div class="dropdown d-none d-sm-flex">
        <div class="topbar-user" data-bs-toggle="dropdown" data-bs-offset="0,4" role="button">
          <div class="t-avatar">
            <img id="dropdownAvatarLarge"
              src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
              alt="Foto-perfil" width="20" class="avatar-md">
          </div>

          <span> {{ Auth::check() ? Auth::user()->name : 'Utilizador' }}</span>
          <i class="bi bi-chevron-down" style="font-size:11px;color:var(--primary);"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
          <li><span class="dropdown-header"> Nível: {{ Auth::user()->nivel }}</li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li><a class="dropdown-item" href="#"><i class="bi bi-person-gear"></i> Minha Conta</a></li>
          <li>
            <a class="dropdown-item" href="#" id="themeToggle">
              <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
              <span id="themeLabel">Modo Escuro</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <div class="dropdown-item item-logout p-0">
              <form method="POST" action="/logout">
                @csrf
                <button type="submit"><i class="bi bi-box-arrow-right"></i> Sair</button>
              </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <!-- ══════════════════════════════════════
     MAIN
══════════════════════════════════════ -->
  <main id="main">
    <div class="content-inner">

      <!-- Page Header -->
      <div class="page-header anim">
        <div>
          <h1>Gestão de Agricultores</h1>
          <p>Registo e administração dos agricultores associados às cooperativas da região de Viana</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <button class="btn-outline-green" id="btnExportar">
            <i class="bi bi-download"></i> Exportar
          </button>
          <button class="btn-green" id="btnNovoAgricultor" data-bs-toggle="modal" data-bs-target="#modalAgricultor">
            <i class="bi bi-plus-lg"></i> Novo Agricultor
          </button>
        </div>
      </div>

      <!-- Stat Cards - Total de Agricultores, Associados, Técnicos, Activos -->
      <div class="row g-3 mb-4 anim anim-d1">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-person-badge-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total de Agricultores</div>
              <div class="s-value" id="totalAgricultoresCount">{{ $totalAgricultores ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-building"></i></div>
            <div class="stat-info">
              <div class="s-label">Associados a Cooperativa</div>
              <div class="s-value" id="associadosCoopCount">{{ $associadosCoop ?? 0 }}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-hourglass"></i></div>
            <div class="stat-info">
              <div class="s-label">Pedentes</div>
              <div class="s-value" id="tecnicosCount">{{ $pedentes ?? 0}}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-person-check-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Activos</div>
              <div class="s-value" id="activosCount">{{ $activos ?? 0 }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Card -->
      <div class="table-card anim anim-d2">

        <!-- Header -->
        <div class="table-card-header">
          <div style="display:flex;align-items:center;gap:12px;">
            <h5><i class="bi bi-person-badge-fill me-2" style="color:var(--primary);"></i>Lista de Agricultores</h5>
          </div>
          <div style="display:flex;gap:8px;align-items:center;">
            {{-- <span style="font-size:12.5px;color:var(--text-light);" id="tableCountTop">4 registos</span> --}}
          </div>
        </div>

        <form action="{{ route('agricultores.index') }}" method="GET" class="search-filter-bar" id="filterForm">

          <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" name="search" class="search-input" id="searchAgricultor"
              placeholder="Pesquisar por nome, BI ou cooperativa…" value="{{ request('search') }}">
          </div>

          <select class="filter-select" name="estado" id="filterEstado" onchange="this.form.submit()">
            <option value="">Todos os estados</option>
            <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            <option value="pendente" {{ request('estado') == 'pendente' ? 'selected' : '' }}>Pendente</option>
          </select>

          <select class="filter-select" name="cooperativa_id" id="filterCooperativa" onchange="this.form.submit()">
            <option value="">Todas as cooperativas</option>
            @foreach($cooperativas as $cooperativa)
              <option value="{{ $cooperativa->id }}" {{ request('cooperativa_id') == $cooperativa->id ? 'selected' : '' }}>
                {{ $cooperativa->nome }}
              </option>
            @endforeach
          </select>

          {{-- <select class="filter-select" name="tipo_membro" id="filterCargo" onchange="this.form.submit()"> --}}
            <select class="filter-select" id="filterCargo" name="cargo" class="form-select"
              onchange="document.getElementById('filterForm').submit();">
              <option value="">Todos os cargos</option>
              <option value="Nenhum" {{ request('cargo') == 'Nenhum' ? 'selected' : '' }}>Nenhum - Apenas Membro</option>
              <option value="Presidente" {{ request('cargo') == 'Presidente' ? 'selected' : '' }}>Presidente</option>
              <option value="Vice-Presidente" {{ request('cargo') == 'Vice-Presidente' ? 'selected' : '' }}>
                Vice-Presidente</option>
              <option value="Secretário" {{ request('cargo') == 'Secretário' ? 'selected' : '' }}>Secretário</option>
              <option value="Tesoureiro" {{ request('cargo') == 'Tesoureiro' ? 'selected' : '' }}>Tesoureiro</option>
              <option value="Técnico" {{ request('cargo') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
              <option value="Dirigente" {{ request('cargo') == 'Dirigente' ? 'selected' : '' }}>Dirigente</option>
            </select>
      </div>
      </select>

      </form>

      <!-- Table2 -->
      <div style="overflow-x:auto;">
        <table class="ag-table" id="agTable">
          <thead>
            <tr>
              <th style="width:40px;">
                <input type="checkbox" id="selectAll"
                  style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
              </th>
              <th>Agricultor</th>
              <th>Contacto</th>
              <th>Cooperativa</th>
              <th>Cargo</th>
              <th>Estado</th>
              <th style="text-align:center;">Acções</th>
            </tr>
          </thead>


          <tbody id="agTableBody">
            
            @foreach($agricultores as $agricultor)
              @php
                $vinculoAtivo = $agricultor->associacoes->where('activo', true)->first();
                $cooperativaNome = $vinculoAtivo && $vinculoAtivo->cooperativa ? $vinculoAtivo->cooperativa->nome : 'Sem cooperativa';
                $cooperativaId = $vinculoAtivo ? $vinculoAtivo->cooperativa_id : '';
                $cargoCooperativa = $vinculoAtivo ? $vinculoAtivo->cargo : 'Nenhum';
              @endphp

              <tr id="agricultor-row-{{ $agricultor->id }}" data-estado="{{ $agricultor->estado }}"
                data-cooperativa="{{ $cooperativaNome }}">
                <td><input type="checkbox" class="row-check"
                    style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;"></td>
                <td>
                  <div class="ag-cell">
                    @if($agricultor->foto)
                      <img src="{{ asset('storage/' . $agricultor->foto) }}" alt="Foto de {{ $agricultor->nome_completo }}"
                        class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                    @else
                      <div
                        class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-person-fill"></i>
                      </div>
                    @endif

                    <div>
                      <div class="ag-name">{{ $agricultor->nome_completo }}</div>
                      <div class="ag-bi">BI: {{ $agricultor->bilhete }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <div style="font-size:13px;">{{ $agricultor->telefone_principal }}</div>
                  <div style="font-size:12px;color:var(--text-light);">{{ $agricultor->email }}</div>
                </td>

                <td>{{ $cooperativaNome }}</td>

                <td><span class="badge-cargo">{{ $cargoCooperativa }}</span></td>

                <td>
                  <span class="badge-status {{ $agricultor->estado }}">
                    <span class="dot"></span>
                    {{ ucfirst($agricultor->estado) }}
                  </span>
                </td>
                <td style="text-align:center;">
                  <div style="display:flex;gap:6px;justify-content:center;">

                    <a href="{{ route('agricultores.show', $agricultor->id) }}" class="action-btn view"
                      title="Ver detalhes"
                      style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                      <i class="bi bi-eye-fill"></i>
                    </a>

                    <button class="action-btn edit btn-editar-ag" title="Editar" data-id="{{ $agricultor->id }}"
                      data-nome_completo="{{ $agricultor->nome_completo }}" data-sexo="{{ $agricultor->sexo ?? '' }}"
                      data-nascimento="{{ $agricultor->data_nascimento ?? '' }}"
                      data-bilhete="{{ $agricultor->bilhete ?? '' }}" data-nif="{{ $agricultor->nif ?? '' }}"
                      data-telefone="{{ $agricultor->telefone_principal ?? '' }}"
                      data-telefone_alt="{{ $agricultor->telefone_alternativo ?? '' }}"
                      data-email="{{ $agricultor->email ?? '' }}" data-endereco="{{ $agricultor->endereco ?? '' }}"
                      data-estado="{{ $agricultor->estado ?? 'activo' }}" data-cooperativa_id="{{ $cooperativaId }}"
                      data-cargo_cooperativa="{{ $cargoCooperativa }}" data-foto="{{ $agricultor->foto }}">

                      <i class="bi bi-pencil-fill"></i>
                    </button>

                    <button class="action-btn delete btn-eliminar-ag" title="Apagar" data-id="{{ $agricultor->id }}"
                      data-nome="{{ $agricultor->nome_completo }}">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach

            
          </tbody>

        </table>
      </div>

      <!-- Empty state (hidden by default) -->
      <div class="empty-state" id="emptyState" style="display:none;">
        <i class="bi bi-person-x"></i>
        <h6>Nenhum agricultor encontrado</h6>
        <p>Tente ajustar os filtros ou registe um novo agricultor.</p>
      </div>

      <div class="table-footer">
        <span id="tableCount">
          MostrandoA {{ $agricultores->firstItem() ?? 0 }} até {{ $agricultores->lastItem() ?? 0 }} de
          {{ $agricultores->total() }} agricultores
        </span>

        <div class="pagination-btns">

          {{-- Botão Anterior --}}
          @if ($agricultores->onFirstPage())
            <button class="page-btn" disabled><i class="bi bi-chevron-left"></i></button>
          @else
            <a href="{{ $agricultores->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
          @endif

          {{-- Números das Páginas --}}
          @foreach ($agricultores->getUrlRange(1, $agricultores->lastPage()) as $page => $url)
            @if ($page == $agricultores->currentPage())
              <button class="page-btn active">{{ $page }}</button>
            @else
              <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
            @endif
          @endforeach

          {{-- Botão Próximo --}}
          @if ($agricultores->hasMorePages())
            <a href="{{ $agricultores->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
          @else
            <button class="page-btn" disabled><i class="bi bi-chevron-right"></i></button>
          @endif

        </div>
      </div>

    </div>
    <!-- /table-card -->

    </div><!-- /content-inner -->
  </main>


  <!-- ══════════════════════════════════════
     MODAL — NOVO / EDITAR AGRICULTOR
══════════════════════════════════════ -->
  <div class="modal fade" id="modalAgricultor" tabindex="-1" aria-labelledby="modalAgricultorLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-coop modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon">
              <i class="bi bi-person-badge-fill" id="modalHeaderIcon"></i>
            </div>
            <div>
              <div class="modal-title" id="modalAgricultorLabel">Novo Agricultor</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>

        <!-- Modal Tabs nav (nova ordem: Dados Pessoais, Contactos & Endereços, Estados & Tipos, Cooperativa) -->
        <div class="modal-tabs" id="modalTabsNav">
          <button class="modal-tab-btn active" data-modal-tab="pessoais">
            <i class="bi bi-person-vcard-fill"></i> Dados Pessoais
          </button>
          <button class="modal-tab-btn" data-modal-tab="contactos">
            <i class="bi bi-geo-alt-fill"></i> Contactos & Endereços
          </button>
          <button class="modal-tab-btn" data-modal-tab="estados_tipos">
            <i class="bi bi-toggle-on"></i> Estados & Tipos
          </button>
          <button class="modal-tab-btn" data-modal-tab="cooperativa">
            <i class="bi bi-building"></i> Cooperativa
          </button>
        </div>

        <!-- Modal Body (tabs content) -->
        <div class="modal-body">
          <form id="formAgricultor" novalidate>
            @csrf
            <input type="hidden" id="agId" name="id" value="">

            <!-- ── TAB 1: Dados Pessoais ── -->
            <div class="modal-tab-panel active" id="mtab-pessoais">

              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-camera-fill"></i> Fotografia
                </div>

                <div style="display:flex;align-items:center;gap:22px;">
                  <div class="foto-upload-zone" onclick="document.getElementById('agFotoInput').click()"
                    id="agFotoZone">
                    <i class="bi bi-person-circle"></i>
                    <span>Carregar foto</span>
                  </div>
                  <input type="file" id="agFotoInput" name="foto" accept="image/*" style="display:none;">
                  <div>
                    <div style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:4px;">Foto do
                      agricultor (opcional)</div>
                    <div style="font-size:12px;color:var(--text-light);margin-bottom:10px;">JPG ou PNG · Máx. 2 MB ·
                      200×200 px recomendado</div>
                    <button type="button" class="btn-outline-green" style="padding:6px 14px;font-size:12.5px;"
                      onclick="document.getElementById('agFotoInput').click()">
                      <i class="bi bi-upload"></i> Seleccionar ficheiro
                    </button>
                  </div>
                </div>
              </div>
              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-person-vcard-fill"></i> Identificação
                </div>
                <div class="row g-3">
                  <div class="col-12 col-md-8">
                    <label class="cfg-label" for="agNome">Nome Completo *</label>
                    <input class="cfg-input" type="text" id="agNome" name="nome_completo" required
                      placeholder="Ex: João Manuel Ferreira">
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label" for="agSexo">Sexo *</label>
                    <select class="cfg-select" id="agSexo" name="sexo" required>
                      <option value="">Seleccione…</option>
                      <option value="Masculino">Masculino</option>
                      <option value="Feminino">Feminino</option>
                    </select>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label" for="agNascimento">Data de Nascimento *</label>
                    <input class="cfg-input" type="date" id="agNascimento" name="data_nascimento" required>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label" for="agBI">Bilhete de Identidade *</label>
                    <input class="cfg-input" type="text" id="agBI" name="bi" placeholder="Ex: 004512378LA041" required>
                  </div>
                  <div class="col-12 col-md-4">
                    <label class="cfg-label" for="agNIF">NIF <span class="cfg-helper"
                        style="display:inline;">(opcional)</span></label>
                    <input class="cfg-input" type="text" id="agNIF" name="nif" placeholder="Ex: 004512378">
                  </div>
                </div>
              </div>
            </div>

            <!-- ── TAB 2: Contactos & Endereços ── -->
            <div class="modal-tab-panel" id="mtab-contactos">
              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-telephone-fill"></i> Contactos
                </div>
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="agTelefone">Telefone Principal *</label>
                    <input class="cfg-input" type="tel" id="agTelefone" name="telefone" placeholder="+244 9XX XXX XXX"
                      required>
                  </div>
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="agTelefoneAlt">Telefone Alternativo</label>
                    <input class="cfg-input" type="tel" id="agTelefoneAlt" name="telefone_alt"
                      placeholder="+244 9XX XXX XXX">
                  </div>
                  <div class="col-12">
                    <label class="cfg-label" for="agEmail">E-mail</label>
                    <input class="cfg-input" type="email" id="agEmail" name="email" placeholder="agricultor@email.ao">
                  </div>
                </div>
              </div>
              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-geo-alt-fill"></i> Endereço
                </div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="agEndereco">Endereço Completo</label>
                    <textarea class="cfg-textarea" id="agEndereco" name="endereco" rows="3"
                      placeholder="Ex: Bairro Viana, Rua 5, Município de Viana, Luanda"></textarea>
                  </div>
                </div>
              </div>
            </div>

            <!-- ── TAB 3: Estados ── -->
            <div class="modal-tab-panel" id="mtab-estados_tipos">
              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-toggle-on"></i> Estado
                </div>
                <div class="row g-3">
                  <div class="col-12">
                    <label class="cfg-label" for="agEstado">Estado *</label>
                    <select class="cfg-select" id="agEstado" name="estado" required>
                      <option value="activo">Activo </option>
                      <option value="inactivo">Inactivo</option>
                      <option value="pendente">Pendente</option>
                    </select>
                    <div class="cfg-helper">Define se o agricultor está em actividade no sistema</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- ── TAB 4: Cooperativa ── -->
            <div class="modal-tab-panel" id="mtab-cooperativa">
              <div id="agSemCoopAlert" class="info-alert">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                  <div class="ia-title">Agricultor sem cooperativa associada</div>
                  <div class="ia-sub">Seleccione uma cooperativa abaixo para registar o cargo.</div>
                </div>
              </div>
              <div class="modal-form-card">
                <div class="modal-section-title">
                  <i class="bi bi-building"></i> Associação Cooperativa
                </div>
                <div class="row g-3">
                  <div class="col-12 col-md-6">
                    <label class="cfg-label" for="agCooperativa">Cooperativa</label>
                    <select class="cfg-select" id="agCooperativa" name="cooperativa_id">
                      <option value="">Nenhuma (sem associação)</option>
                      @foreach($cooperativas as $coop)
                        <option value="{{ $coop->id }}">{{ $coop->nome }}</option>
                      @endforeach
                    </select>
                    <div class="cfg-helper">Cooperativa à qual o agricultor está associado</div>
                  </div>
                  <div class="col-12 col-md-6 ag-coop-field" style="display:none;">
                    <label class="cfg-label" for="agCargoCooperativa">Cargo</label>
                    <select class="cfg-select" id="agCargoCooperativa" name="cargo_cooperativa">
                      <option value="Nenhum">Sem Cargo</option>
                      <option value="Presidente">Presidente</option>
                      <option value="Vice-Presidente">Vice-Presidente</option>
                      <option value="Secretário">Secretário</option>
                      <option value="Tesoureiro">Tesoureiro</option>
                      <option value="Técnico">Técnico</option>
                      <option value="Dirigente">Dirigente</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>

          </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
          <div
            style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
            <div style="font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
            </div>
            <div style="display:flex;gap:10px;">
              <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i> Cancelar
              </button>
              <button type="button" class="btn-green" id="btnGuardarAg">
                <i class="bi bi-check2-circle"></i> <span id="btnGuardarAgLabel">Registar Agricultor</span>
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════
     MODAL — CONFIRMAR ELIMINAÇÃO
══════════════════════════════════════ -->
  <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
      <div class="modal-content">
        <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div>
              <div class="modal-title">Confirmar Eliminação</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body" style="background:#fff;padding:28px;">
          <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
            Tem a certeza que deseja eliminar o agricultor:
          </p>
          <div
            style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
            <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;" id="deleteAgName">—
            </div>
            <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão
              removidos permanentemente.</div>
          </div>
        </div>
        <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn-green" id="btnConfirmDelete" style="background:#C62828;box-shadow:none;">
            <i class="bi bi-trash-fill"></i> Eliminar Definitivamente
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="save-toast" id="saveToast">
    <div class="toast-icon success" id="toastIcon"><i class="bi bi-check-lg" id="toastIconI"></i></div>
    <div class="toast-text">
      <div class="t-title" id="toastTitle">Operação concluída</div>
      <div class="t-sub" id="toastSub">Acção realizada com sucesso.</div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    /* ══════════════════════════════════════
       SIDEBAR TOGGLE (3 estados)
    ══════════════════════════════════════ */
    const body = document.body;
    let sideState = 0;

    function applyTooltips() {
      document.querySelectorAll('.nav-item-link').forEach(el => {
        const tip = bootstrap.Tooltip.getInstance(el);
        if (tip) tip.dispose();
      });
      if (body.classList.contains('icons-only')) {
        document.querySelectorAll('.nav-item-link').forEach(el => {
          new bootstrap.Tooltip(el, {
            title: el.dataset.label || '',
            placement: 'right',
            trigger: 'hover',
            customClass: 'sidebar-tooltip'
          });
        });
      }
    }

    document.getElementById('sidebarToggle').addEventListener('click', () => {
      sideState = (sideState + 1) % 3;
      body.classList.remove('icons-only', 'sidebar-hidden');
      if (sideState === 1) body.classList.add('icons-only');
      if (sideState === 2) body.classList.add('sidebar-hidden');
      applyTooltips();
    });

    /* ══════════════════════════════════════
       DARK MODE
    ══════════════════════════════════════ */
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeLabel = document.getElementById('themeLabel');
    let darkMode = false;

    themeToggle.addEventListener('click', function (e) {
      e.preventDefault();
      darkMode = !darkMode;
      body.classList.toggle('dark-mode', darkMode);
      themeIcon.className = darkMode ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
      themeLabel.textContent = darkMode ? 'Modo Claro' : 'Modo Escuro';
    });

    /* ══════════════════════════════════════
       NAV ACTIVE SIDEBAR
    ══════════════════════════════════════ */
    document.querySelectorAll('.nav-item-link').forEach(link => {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (!href || href === '#') {
          e.preventDefault();
        }
        document.querySelectorAll('.nav-item-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        const label = this.dataset.label || this.querySelector('.nav-label')?.textContent || '';
        document.querySelector('.topbar-title').textContent = label;
      });
    });

    /* ══════════════════════════════════════
       TOAST
    ══════════════════════════════════════ */
    function showToast(title, sub, type = 'success') {
      const toast = document.getElementById('saveToast');
      const icon = document.getElementById('toastIcon');
      const iconI = document.getElementById('toastIconI');
      document.getElementById('toastTitle').textContent = title;
      document.getElementById('toastSub').textContent = sub;
      icon.className = 'toast-icon ' + (type === 'danger' ? 'danger' : 'success');
      iconI.className = type === 'danger' ? 'bi bi-x-lg' : 'bi bi-check-lg';
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 3500);
    }

    /* ══════════════════════════════════════
       MODAL TABS (nova ordem)
    ══════════════════════════════════════ */
    function switchModalTab(tabName) {
      document.querySelectorAll('.modal-tab-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.modalTab === tabName);
      });
      document.querySelectorAll('.modal-tab-panel').forEach(panel => {
        panel.classList.toggle('active', panel.id === 'mtab-' + tabName);
      });
    }
    document.querySelectorAll('.modal-tab-btn').forEach(btn => {
      btn.addEventListener('click', () => switchModalTab(btn.dataset.modalTab));
    });

    /* ══════════════════════════════════════
       TOGGLE CAMPOS COOPERATIVA (cargo)
    ══════════════════════════════════════ */
    function toggleCooperativaFields() {
      const val = document.getElementById('agCooperativa').value;
      const fields = document.querySelectorAll('.ag-coop-field');
      const alertBox = document.getElementById('agSemCoopAlert');
      if (val) {
        fields.forEach(f => f.style.display = '');
        alertBox.style.display = 'none';
      } else {
        fields.forEach(f => f.style.display = 'none');
        alertBox.style.display = 'flex';
      }
    }
    document.getElementById('agCooperativa').addEventListener('change', toggleCooperativaFields);

    /* ══════════════════════════════════════
       FUNÇÃO UTILITÁRIA — Formatar datas
    ══════════════════════════════════════ */
    function formatDateDisplay(dateStr) {
      if (!dateStr) return '';
      dateStr = String(dateStr).trim();
      const iso = dateStr.match(/^(\d{4})-(\d{2})-(\d{2})/);
      if (iso) return `${iso[3]}/${iso[2]}/${iso[1]}`;
      const dmy = dateStr.match(/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/);
      if (dmy) return `${dmy[1]}/${dmy[2]}/${dmy[3]}`;
      const d = new Date(dateStr);
      if (!isNaN(d)) {
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();
        return `${day}/${month}/${year}`;
      }
      return dateStr;
    }

    function normalizeToISO(dateStr) {
      if (!dateStr) return '';
      dateStr = String(dateStr).trim();
      if (/^\d{4}-\d{2}-\d{2}/.test(dateStr)) return dateStr.substring(0, 10);
      const isoMatch = dateStr.match(/^(\d{4}-\d{2}-\d{2})/);
      if (isoMatch) return isoMatch[1];
      const dmy = dateStr.match(/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/);
      if (dmy) return `${dmy[3]}-${dmy[2]}-${dmy[1]}`;
      return '';
    }

    function parseDateForInput(dateStr) {
      return normalizeToISO(dateStr);
    }


    /* ══════════════════════════════════════
       AGRICULTOR — reset modal ao abrir (novo)
    ══════════════════════════════════════ */
    document.getElementById('modalAgricultor').addEventListener('show.bs.modal', function (e) {
      if (e.relatedTarget && e.relatedTarget.id === 'btnNovoAgricultor') {
        document.getElementById('formAgricultor').reset();
        document.getElementById('agId').value = '';
        document.getElementById('modalAgricultorLabel').textContent = 'Novo Agricultor';
        document.getElementById('btnGuardarAgLabel').textContent = 'Registar Agricultor';
        document.getElementById('modalHeaderIcon').className = 'bi bi-person-badge-fill';
        document.getElementById('agFotoZone').innerHTML = '<i class="bi bi-person-circle"></i><span>Carregar foto</span>';
        document.getElementById('agFotoZone').style.border = '';
        document.getElementById('agEstado').value = 'activo';
        document.getElementById('agCooperativa').value = '';
        document.getElementById('agCargoCooperativa').value = 'Nenhum';
        toggleCooperativaFields();
        switchModalTab('pessoais');
      }
    });


    /* ══════════════════════════════════════
       AGRICULTOR — botão editar (carrega dados)
    ══════════════════════════════════════ */
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-editar-ag');
      if (!btn) return;

      // 1. Mapeamento exato baseado no dataset gerado pelos underscores do seu HTML
      document.getElementById('agId').value = btn.dataset.id || '';
      document.getElementById('agNome').value = btn.dataset.nome_completo || btn.dataset.nomeCompleto || '';
      document.getElementById('agSexo').value = btn.dataset.sexo || '';
      document.getElementById('agNascimento').value = parseDateForInput(btn.dataset.nascimento || '');
      document.getElementById('agBI').value = btn.dataset.bilhete || '';
      document.getElementById('agNIF').value = btn.dataset.nif || '';

      // Forçar o estado em minúsculas para coincidir com o "value" do select
      const estado = btn.dataset.estado ? btn.dataset.estado.toLowerCase() : 'activo';
      document.getElementById('agEstado').value = estado;

      // Aqui o seu HTML diz "data-telefone", por isso mapeamos para dataset.telefone
      document.getElementById('agTelefone').value = btn.dataset.telefone || '';
      document.getElementById('agTelefoneAlt').value = btn.dataset.telefone_alt || btn.dataset.telefoneAlt || '';

      document.getElementById('agEmail').value = btn.dataset.email || '';
      document.getElementById('agEndereco').value = btn.dataset.endereco || '';

      document.getElementById('agCooperativa').value = btn.dataset.cooperativa_id || btn.dataset.cooperativaId || '';
      document.getElementById('agCargoCooperativa').value = btn.dataset.cargo_cooperativa || btn.dataset.cargoCooperativa || 'Nenhum';

      // 2. Mudar Textos e Ícones do Modal para Modo Edição
      document.getElementById('modalAgricultorLabel').textContent = 'Editar Agricultor';
      document.getElementById('btnGuardarAgLabel').textContent = 'Guardar Alterações';
      document.getElementById('modalHeaderIcon').className = 'bi bi-pencil-fill';

      // 3. Tratar a Visualização  no botão mais tarde)
      const fotoZone = document.getElementById('agFotoZone');
      const fotoUrl = btn.dataset.foto;

      if (fotoUrl && fotoUrl !== 'null' && fotoUrl !== '') {
        fotoZone.innerHTML = `<img src="/storage/${fotoUrl}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
      } else {
        fotoZone.innerHTML = '<i class="bi bi-person-circle"></i><span>Carregar foto</span>';
      }
      fotoZone.style.border = '';

      // 4. Chamar as funções de interface do seu painel
      toggleCooperativaFields();
      switchModalTab('pessoais');

      // 5. Abrir o Modal de forma limpa via Bootstrap 5
      const modalEl = document.getElementById('modalAgricultor');
      const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
      modalInstance.show();
    });

    /* ══════════════════════════════════════
       PREVIEW FOTO
    ══════════════════════════════════════ */
    document.getElementById('agFotoInput').addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function (ev) {
        const zone = document.getElementById('agFotoZone');
        zone.innerHTML = `<img src="${ev.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
        zone.style.border = '2px solid var(--primary)';
      };
      reader.readAsDataURL(file);
    });


    /* ══════════════════════════════════════
       AGRICULTOR — guardar (criar / editar)
    ══════════════════════════════════════ */
    document.getElementById('btnGuardarAg').addEventListener('click', () => {
      const id = document.getElementById('agId').value;
      const nome_completo = document.getElementById('agNome').value.trim();
      const sexo = document.getElementById('agSexo').value;
      const nascimento = document.getElementById('agNascimento').value;
      const bilhete = document.getElementById('agBI').value.trim();
      const nif = document.getElementById('agNIF').value.trim();
      const estado = document.getElementById('agEstado').value;
      const telefone_principal = document.getElementById('agTelefone').value.trim();
      const telefoneAlt = document.getElementById('agTelefoneAlt').value.trim();
      const email = document.getElementById('agEmail').value.trim();
      const endereco = document.getElementById('agEndereco').value.trim();
      const cooperativaId = document.getElementById('agCooperativa').value;
      const cargoCooperativa = document.getElementById('agCargoCooperativa').value;

      // Capturar o arquivo de foto
      const fotoInput = document.getElementById('agFotoInput');
      const fotoFile = fotoInput && fotoInput.files.length > 0 ? fotoInput.files[0] : null;

      if (!nome_completo || !sexo || !nascimento || !bilhete) {
        switchModalTab('pessoais');
        showToast('Campos obrigatórios em falta', 'Preencha Nome, Sexo, Data de Nascimento e BI.', 'danger');
        return;
      }
      if (!telefone_principal) {
        switchModalTab('contactos');
        showToast('Campo obrigatório em falta', 'Preencha o Telefone Principal.', 'danger');
        return;
      }

      const btn = document.getElementById('btnGuardarAg');
      const orig = btn.innerHTML;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> A guardar…';
      btn.disabled = true;

      // IMPORTANTE: Para envio de arquivos (PUT simulado), o Laravel exige _method POST com campo _method=PUT
      const url = id ? `/agricultores/${id}` : '/agricultores';

      // Usamos FormData para empacotar texto e arquivos juntos
      const formData = new FormData();
      if (id) {
        formData.append('_method', 'PUT'); // Truque do Laravel para aceitar arquivos via PUT
      }

      formData.append('nome_completo', nome_completo);
      formData.append('sexo', sexo);
      formData.append('data_nascimento', nascimento);
      formData.append('bilhete', bilhete);
      formData.append('nif', nif || '');
      formData.append('estado', estado);
      formData.append('telefone_principal', telefone_principal);
      formData.append('telefone_alternativo', telefoneAlt || '');
      formData.append('email', email || '');
      formData.append('endereco', endereco || '');
      formData.append('cooperativa_id', cooperativaId || '');
      formData.append('cargo_cooperativa', cargoCooperativa || '');

      if (fotoFile) {
        formData.append('foto', fotoFile);
      }

      fetch(url, {
        method: 'POST', // Sempre POST aqui na requisição por causa do FormData
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          // NOTA: NÃO defina 'Content-Type' aqui. O navegador faz isso automaticamente para FormData!
        },
        body: formData
      })
        .then(r => r.json())
        .then(data => {
          btn.innerHTML = orig;
          btn.disabled = false;

          if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalAgricultor')).hide();
            location.reload();
          } else {
            showToast('Erro ao guardar', data.message || 'Verifique os dados.', 'danger');
          }
        })
        .catch((err) => {
          console.error(err);
          btn.innerHTML = orig;
          btn.disabled = false;
          showToast('Erro de ligação', 'Verifique a sua conexão.', 'danger');
        });
    });

    /* ══════════════════════════════════════
       AGRICULTOR — eliminar
    ══════════════════════════════════════ */
    let deleteTargetId = null;
    let deleteTargetName = '';

    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-eliminar-ag');
      if (!btn) return;

      deleteTargetId = btn.dataset.id;
      deleteTargetName = btn.dataset.nome;
      document.getElementById('deleteAgName').textContent = deleteTargetName;
      new bootstrap.Modal(document.getElementById('modalDelete')).show();
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', () => {
      if (!deleteTargetId) return;

      const btn = document.getElementById('btnConfirmDelete');
      const orig = btn.innerHTML;
      btn.innerHTML = '<i class="bi bi-hourglass-split"></i> A eliminar…';
      btn.disabled = true;

      fetch(`/agricultores/${deleteTargetId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
        .then(r => r.json())
        .then(data => {
          btn.innerHTML = orig;
          btn.disabled = false;
          bootstrap.Modal.getInstance(document.getElementById('modalDelete')).hide();
          if (data.success) {
            document.getElementById(`agricultor-row-${deleteTargetId}`)?.remove();
            showToast('Agricultor eliminado', deleteTargetName + ' foi removido do sistema.', 'danger');

          } else {
            showToast('Erro', data.message || 'Não foi possível eliminar.', 'danger');
          }
        })
        .catch(() => {
          btn.innerHTML = orig;
          btn.disabled = false;
          bootstrap.Modal.getInstance(document.getElementById('modalDelete')).hide();
          showToast('Erro de ligação', 'Verifique a sua conexão.', 'danger');
        });
    });

    /* ══════════════════════════════════════
       SEARCH & FILTER
    ══════════════════════════════════════ */

    // O seu código existente para a tecla Enter na barra de pesquisa:
    document.getElementById('searchAgricultor').addEventListener('keypress', function (e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
      }
    });

    // Detetar quando o utilizador muda o Estado ou a Cooperativa para submeter a página:
    const filterEstado = document.getElementById('filterEstado');
    if (filterEstado) {
      filterEstado.addEventListener('change', () => document.getElementById('filterForm').submit());
    }

    const filterCooperativa = document.getElementById('filterCooperativa');
    if (filterCooperativa) {
      filterCooperativa.addEventListener('change', () => document.getElementById('filterForm').submit());
    }

    /* ══════════════════════════════════════
       SELECT ALL CHECKBOXES
    ══════════════════════════════════════ */
    document.getElementById('selectAll').addEventListener('change', function () {
      document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
    });

    /* ══════════════════════════════════════
       EXPORTAR
    ══════════════════════════════════════ */
    document.getElementById('btnExportar').addEventListener('click', () => {
      showToast('A exportar…', 'O ficheiro será gerado e descarregado em breve.');
    });


  </script>

</body>

</html>