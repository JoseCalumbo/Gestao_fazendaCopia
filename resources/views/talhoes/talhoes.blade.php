<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Talhões</title>

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

    /* Talhões Table */
    .talhao-table {
      width: 100%;
      border-collapse: collapse;
    }

    .talhao-table th {
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

    .talhao-table td {
      font-size: 13.5px;
      color: var(--text-dark);
      padding: 14px 20px;
      border-bottom: 1px solid var(--border);
      vertical-align: middle;
    }

    .talhao-table tr:last-child td {
      border-bottom: none;
    }

    .talhao-table tbody tr:hover td {
      background: #F8FBF8;
    }

    /* Badges */
    .badge-status {
      font-size: 12px;
      font-weight: 500;
      padding: 0;
      background: none;
      border-radius: 0;
      display: inline-flex;
      align-items: center;
      gap: 4px;
    }

    .badge-status.em_cultivo {
      color: #2E7D32;
    }

    .badge-status.pousio {
      color: #F57F17;
    }

    .badge-status.preparacao {
      color: #1565C0;
    }

    .badge-status.inactivo {
      color: #C62828;
    }

    .badge-status .dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      display: inline-block;
    }

    .badge-status.em_cultivo .dot {
      background: #2E7D32;
    }

    .badge-status.pousio .dot {
      background: #F57F17;
    }

    .badge-status.preparacao .dot {
      background: #1565C0;
    }

    .badge-status.inactivo .dot {
      background: #C62828;
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
       MODAL — VISUALIZAR TALHÃO
    ═══════════════════════════════════════════ */
    .modal-coop {
      max-width: 2000px;
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
      background: #fff;
      padding: 28px;
    }

    .modal-footer {
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      background: #fff;
      flex-shrink: 0;
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

    body.dark-mode .talhao-table th {
      background: #172518;
    }

    body.dark-mode .talhao-table tbody tr:hover td {
      background: #1a2a1c;
    }

    body.dark-mode .search-input,
    body.dark-mode .filter-select {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255, 255, 255, .1);
    }

    body.dark-mode .modal-body {
      background: #1a2a1c;
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

      .modal-coop {
        max-width: 100%;
        margin: 10px;
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
      <a href="{{ route('cooperativas') }}" class="nav-item-link" data-label="Cooperativa"><i
          class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
      <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i
          class="bi bi-people-fill"></i><span class="nav-label">Agricultores</span></a>

      <div class="nav-section-title">Agrícola</div>
      <a  href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span
          class="nav-label">Safras</span></a>
      <a href="#" class="nav-item-link active" data-label="Talhões"><i class="bi bi-map-fill"></i><span
          class="nav-label">Talhões</span></a>
      <a href="{{route('insumos.index')}}" class="nav-item-link" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span
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
    <span class="topbar-title">Talhões</span>
    <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
      <ol class="breadcrumb mb-0" style="font-size:12.5px;">
        <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
        <li class="breadcrumb-item active" style="color:var(--text-light);">Talhões</li>
      </ol>
    </nav>
    <div class="topbar-right">
      <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
        style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
        <i class="bi bi-calendar3"></i> Safra {{ date('Y') }}
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
          <h1>Gestão de Talhões</h1>
          <p>Registo e administração das parcelas de terra cultivadas</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
          <button class="btn-outline-green" id="btnExportar">
            <i class="bi bi-download"></i> Exportar
          </button>
        </div>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4 anim anim-d1">
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-map-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Total de Talhões</div>
              <div class="s-value">{{ $stats['total'] ?? 0}}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Em Cultivo</div>
              <div class="s-value">{{ $stats['em_cultivo'] ?? 0}}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon amber"><i class="bi bi-clock-fill"></i></div>
            <div class="stat-info">
              <div class="s-label">Pousio</div>
              <div class="s-value">{{ $stats['pousio'] ?? 0}}</div>
            </div>
          </div>
        </div>
        <div class="col-6 col-xl-3">
          <div class="stat-card">
            <div class="stat-icon purple"><i class="bi bi-tools"></i></div>
            <div class="stat-info">
              <div class="s-label">Colhido</div>
              <div class="s-value">{{ $stats['colhido'] }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Table Card -->
      <div class="table-card anim anim-d2">

        <!-- Header -->
        <div class="table-card-header">
          <div style="display:flex;align-items:center;gap:12px;">
            <h5><i class="bi bi-map-fill me-2" style="color:var(--primary);"></i>Lista de Talhões</h5>
          </div>
          <div style="display:flex;gap:8px;align-items:center;">
            <span style="font-size:12.5px;color:var(--text-light);">{{ $talhoes->total() ?? 0 }} registos</span>
          </div>
        </div>

        <div class="search-filter-bar">
          <div class="search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="search-input" id="searchTalhao" placeholder="Pesquisar por designação...">
          </div>
          <select class="filter-select" id="filterEstado">
            <option value="">Todos os estados</option>
            <option value="Em cultivo">Em Cultivo</option>
            <option value="Pousio">Pousio</option>
            <option value="Colhido">Colhido</option>
            <option value="activo">Activo</option>
            <option value="inactivo">Inactivo</option>
          </select>
          <select class="filter-select" id="filterAgricultor">
            <option value="">Todos os agricultores</option>
            @foreach($agricultores as $ag)
              <option value="{{ $ag->id }}" {{ request('filterAgricultor') == $ag->id ? 'selected' : '' }}>
                {{ $ag->nome_completo }}
              </option>
            @endforeach
          </select>
          <button class="btn-green" id="btnFiltrar" style="padding:8px 18px;"><i class="bi bi-search"></i>
            Filtrar</button>
          <button class="btn-outline-green" id="btnLimparFiltros" style="padding:8px 18px; display: none;"><i class="bi bi-eraser"></i>
            Limpar</button>
        </div>

        <!-- Table -->
        <div style="overflow-x:auto;">
          <table class="talhao-table" id="talhaoTable">
            <thead>
              <tr>
                <th style="width:40px;">
                  <input type="checkbox" id="selectAll"
                    style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
                </th>
                <th>Designação</th>
                <th>Agricultor</th>
                <th>Área (ha)</th>
                <th>Cultura Actual</th>
                <th>Localização</th>
                <th>Estado</th>
                <th style="text-align:center;">Acções</th>
              </tr>
            </thead>

            <tbody id="talhaoTableBody">
              @forelse($talhoes as $talhao)
                <tr id="talhao-row-{{ $talhao->id }}" data-estado="{{ $talhao->estado }}"
                  data-agricultor="{{ $talhao->agricultor->nome_completo ?? 'Sem agricultor' }}">
                  <td>
                    <input type="checkbox" class="row-check"
                      style="accent-color:var(--primary);width:15px;height:15px;cursor:pointer;">
                  </td>
                  <td>
                    <div>
                      <div style="font-weight:600;font-size:14px;">
                        {{ $talhao->designacao }}
                        <p style="color: #16a34a; font-size: 12px; font-weight: 500;">{{ $talhao->cooperativa->nome }}</p>
                      </div>
                    </div>
                  </td>
                  <td>{{ $talhao->agricultor->nome_completo ?? 'Sem agricultor' }}</td>
                  <td><strong>{{ number_format($talhao->area, 1) }}</strong></td>
                  <td>{{ $talhao->cultura_actual ?? '—' }}</td>
                  <td>{{ $talhao->localizacao ?? '—' }}</td>
                  <td>
                    <span class="badge-status {{ $talhao->estado }}">
                      <span class="dot"></span>
                      {{ ucfirst(str_replace('_', ' ', $talhao->estado)) }}
                    </span>
                  </td>
                  <td style="text-align:center;">
                    <div style="display:flex;gap:6px;justify-content:center;">
                      <button class="action-btn view btn-ver-talhao" title="Ver detalhes" data-id="{{ $talhao->id }}"
                        data-designacao="{{ $talhao->designacao }}" data-area="{{ $talhao->area }}"
                        data-cultura="{{ $talhao->cultura_actual }}" data-localizacao="{{ $talhao->localizacao }}"
                        data-estado="{{ $talhao->estado }}"
                        data-agricultor="{{ $talhao->agricultor->nome_completo ?? 'Sem agricultor' }}">
                        <i class="bi bi-eye-fill"></i>
                      </button>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="8" style="text-align:center;padding:40px;color:var(--text-light);">
                    <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
                    Nenhum talhão encontrado.
                  </td>
                </tr>
              @endforelse
            </tbody>

          </table>
        </div>

        <div class="table-footer">
          <span id="tableCount">
            Mostrando {{ $talhoes->firstItem() ?? 0 }} até {{ $talhoes->lastItem() ?? 0 }} de
            {{ $talhoes->total() }} talhões
          </span>

          <div class="pagination-btns">

            {{-- Botão Anterior --}}
            @if ($talhoes->onFirstPage())
              <button class="page-btn" disabled><i class="bi bi-chevron-left"></i></button>
            @else
              <a href="{{ $talhoes->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
            @endif

            {{-- Números das Páginas --}}
            @foreach ($talhoes->getUrlRange(1, $talhoes->lastPage()) as $page => $url)
              @if ($page == $talhoes->currentPage())
                <button class="page-btn active">{{ $page }}</button>
              @else
                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
              @endif
            @endforeach

            {{-- Botão Próximo --}}
            @if ($talhoes->hasMorePages())
              <a href="{{ $talhoes->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
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
     MODAL — VER TALHÃO
══════════════════════════════════════ -->
  <div class="modal fade modal-coop" id="modalVerTalhao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div style="display:flex;align-items:center;gap:14px;flex:1;">
            <div class="modal-header-icon"><i class="bi bi-eye-fill"></i></div>
            <div>
              <div class="modal-title">Detalhes do Talhão</div>
              <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="verTalhaoDesignacao">—</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-6"><strong>ID:</strong> <span id="verTalhaoId">—</span></div>
            <div class="col-6"><strong>Designação:</strong> <span id="verTalhaoDesignacao2">—</span></div>
            <div class="col-6"><strong>Agricultor:</strong> <span id="verTalhaoAgricultor">—</span></div>
            <div class="col-6"><strong>Área (ha):</strong> <span id="verTalhaoArea">—</span></div>
            <div class="col-6"><strong>Cultura Actual:</strong> <span id="verTalhaoCultura">—</span></div>
            <div class="col-6"><strong>Localização:</strong> <span id="verTalhaoLocalizacao">—</span></div>
            <div class="col-12"><strong>Estado:</strong> <span id="verTalhaoEstado">—</span></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Fechar</button>
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
       FILTROS (apenas front-end)
    ══════════════════════════════════════ */
    document.getElementById('btnFiltrar').addEventListener('click', function () {
      const search = document.getElementById('searchTalhao').value.toLowerCase().trim();
      const estado = document.getElementById('filterEstado').value;
      const agricultorId = document.getElementById('filterAgricultor').value;

      const rows = document.querySelectorAll('#talhaoTableBody tr');
      let visibleCount = 0;

      rows.forEach(row => {
        const designacao = row.querySelector('td:nth-child(2) div div:first-child')?.textContent?.toLowerCase() || '';
        const rowEstado = row.dataset.estado || '';
        const rowAgricultor = row.dataset.agricultor || '';

        let show = true;

        if (search && !designacao.includes(search)) show = false;
        if (estado && rowEstado !== estado) show = false;
        if (agricultorId && rowAgricultor !== agricultorId) show = false;

        row.style.display = show ? '' : 'none';
        if (show) visibleCount++;
      });

      // Atualizar contagem
      const total = rows.length;
      const info = document.getElementById('tableCount');
      if (info) {
        info.textContent = `Mostrando ${visibleCount} de ${total} talhões`;
      }

      // Mostrar/ocultar mensagem vazia
      const empty = document.querySelector('.empty-state-visible');
      if (empty) empty.remove();

      if (visibleCount === 0 && rows.length > 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.className = 'empty-state-visible';
        emptyRow.innerHTML = `
          <td colspan="8" style="text-align:center;padding:40px;color:var(--text-light);">
            <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>
            Nenhum talhão encontrado com os filtros aplicados.
          </td>
        `;
        document.getElementById('talhaoTableBody').appendChild(emptyRow);
      }
    });

    document.getElementById('btnLimparFiltros').addEventListener('click', function () {
      document.getElementById('searchTalhao').value = '';
      document.getElementById('filterEstado').value = '';
      document.getElementById('filterAgricultor').value = '';

      const rows = document.querySelectorAll('#talhaoTableBody tr');
      rows.forEach(row => {
        row.style.display = '';
      });

      const info = document.getElementById('tableCount');
      if (info) {
        const total = document.querySelectorAll('#talhaoTableBody tr:not(.empty-state-visible)').length;
        info.textContent = `Mostrando ${total} de ${total} talhões`;
      }

      const empty = document.querySelector('.empty-state-visible');
      if (empty) empty.remove();
    });

    /* ══════════════════════════════════════
       TALHÃO — botão ver (visualizar)
    ══════════════════════════════════════ */
    document.addEventListener('click', function (e) {
      const btn = e.target.closest('.btn-ver-talhao');
      if (!btn) return;

      document.getElementById('verTalhaoDesignacao').textContent = btn.dataset.designacao || '—';
      document.getElementById('verTalhaoDesignacao2').textContent = btn.dataset.designacao || '—';
      document.getElementById('verTalhaoId').textContent = btn.dataset.id || '—';
      document.getElementById('verTalhaoAgricultor').textContent = btn.dataset.agricultor || '—';
      document.getElementById('verTalhaoArea').textContent = btn.dataset.area ? Number(btn.dataset.area).toFixed(1) + ' ha' : '—';
      document.getElementById('verTalhaoCultura').textContent = btn.dataset.cultura || '—';
      document.getElementById('verTalhaoLocalizacao').textContent = btn.dataset.localizacao || '—';

      const estadoMap = {
        'em_cultivo': 'Em Cultivo',
        'pousio': 'Pousio',
        'preparacao': 'Preparação',
        'inactivo': 'Inactivo'
      };
      document.getElementById('verTalhaoEstado').textContent = estadoMap[btn.dataset.estado] || btn.dataset.estado || '—';

      const modalEl = document.getElementById('modalVerTalhao');
      const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
      modalInstance.show();
    });

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

    /* ══════════════════════════════════════
       PESQUISA EM TEMPO REAL (filtro por digitação)
    ══════════════════════════════════════ */
    document.getElementById('searchTalhao').addEventListener('input', function () {
      document.getElementById('btnFiltrar').click();
    });

    document.getElementById('filterEstado').addEventListener('change', function () {
      document.getElementById('btnFiltrar').click();
    });

    document.getElementById('filterAgricultor').addEventListener('change', function () {
      document.getElementById('btnFiltrar').click();
    });
  </script>

</body>

</html>