[file name]: estoque.blade.php
[file content begin]
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Gestão de Estoque</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --sidebar-bg:       #1B5E20;
      --sidebar-hover:    #2E7D32;
      --sidebar-active:   #2E7D32;
      --accent:           #66BB6A;
      --accent-lt:        #E8F5E9;
      --primary:          #2E7D32;
      --text-dark:        #1C2B1E;
      --text-mid:         #4A6350;
      --text-light:       #8FA894;
      --border:           rgba(0,0,0,.07);
      --card-bg:          #ffffff;
      --page-bg:          #F4F6F4;
      --sidebar-w:        240px;
      --sidebar-w-icons:  68px;
      --topbar-h:         64px;
      --danger:           #C62828;
      --warning:          #F57F17;
      --info:             #1565C0;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
      position: fixed; top: 0; left: 0;
      width: var(--sidebar-w); height: 100vh;
      background: var(--sidebar-bg);
      display: flex; flex-direction: column;
      transition: width .3s ease; z-index: 1000; overflow: hidden;
    }
    body.icons-only  #sidebar { width: var(--sidebar-w-icons); }
    body.sidebar-hidden #sidebar { width: 0; }

    .sidebar-logo {
      display: flex; align-items: center; gap: 12px;
      padding: 14px 15px; border-bottom: 1px solid rgba(255,255,255,.1);
      white-space: nowrap; min-height: var(--topbar-h); overflow: hidden;
    }
    body.icons-only .sidebar-logo { justify-content: center; padding: 14px 0; }
    body.icons-only .sidebar-logo .logo-text-wrap { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }

    .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; overflow-x: hidden; }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 10px; }
    .sidebar-nav { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.18) transparent; }

    .nav-section-title {
      font-size: 10px; font-weight: 600; letter-spacing: 1.2px;
      text-transform: uppercase; color: rgba(255,255,255,.4);
      padding: 18px 20px 6px; white-space: nowrap; transition: opacity .2s;
    }
    body.icons-only .nav-section-title { opacity: 0; height: 0; padding: 0; overflow: hidden; }

    .nav-item-link {
      display: flex; align-items: center; gap: 12px;
      padding: 11px 18px; color: rgba(255,255,255,.75);
      text-decoration: none; border-radius: 10px; margin: 2px 8px;
      transition: background .2s, color .15s; white-space: nowrap; position: relative;
    }
    .nav-item-link i { font-size: 18px; flex-shrink: 0; width: 22px; text-align: center; }
    .nav-item-link .nav-label { font-size: 14px; font-weight: 500; opacity: 1; transition: opacity .2s; }
    body.icons-only .nav-item-link .nav-label { opacity: 0; pointer-events: none; width: 0; overflow: hidden; }
    body.icons-only .nav-item-link { justify-content: center; padding: 11px 0; margin: 2px 6px; }
    .nav-item-link:hover { background: rgba(255,255,255,.1); color: #fff; }
    .nav-item-link.active { background: var(--accent); color: #fff; box-shadow: 0 4px 14px rgba(102,187,106,.35); }

    .sidebar-tooltip .tooltip-inner {
      background: #0f3d14; color: #fff; font-size: 12.5px; font-weight: 500;
      padding: 5px 12px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,.3);
    }
    .sidebar-tooltip.bs-tooltip-end .tooltip-arrow::before { border-right-color: #0f3d14; }

    .sidebar-user {
      padding: 14px 10px; border-top: 1px solid rgba(255,255,255,.1);
      display: flex; align-items: center; gap: 10px;
      cursor: pointer; transition: background .2s;
      border-radius: 10px; margin: 4px 6px; white-space: nowrap;
    }
    .sidebar-user:hover { background: rgba(255,255,255,.08); }
    .sidebar-user .avatar {
      width: 34px; height: 34px; background: var(--accent);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; overflow: hidden;
    }
    .sidebar-user .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .sidebar-user .avatar i { color: #fff; font-size: 16px; }
    .sidebar-user .user-info { opacity: 1; transition: opacity .2s; }
    .sidebar-user .user-info .u-name { font-size: 13px; font-weight: 600; color: #fff; }
    .sidebar-user .user-info .u-role { font-size: 11px; color: rgba(255,255,255,.5); }
    body.icons-only .sidebar-user .user-info { opacity: 0; pointer-events: none; }

    /* ═══════════════════════════════════════════
       TOPBAR
    ═══════════════════════════════════════════ */
    #topbar {
      position: fixed; top: 0; left: var(--sidebar-w); right: 0;
      height: var(--topbar-h); background: #fff;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; padding: 0 28px; gap: 16px;
      z-index: 900; transition: left .3s ease;
    }
    body.icons-only  #topbar { left: var(--sidebar-w-icons); }
    body.sidebar-hidden #topbar { left: 0; }

    .topbar-toggle {
      background: none; border: none; font-size: 20px; color: var(--text-mid);
      cursor: pointer; padding: 6px; border-radius: 8px; transition: background .2s, color .2s;
    }
    .topbar-toggle:hover { background: var(--accent-lt); color: var(--primary); }

    .topbar-title-wrap { display: flex; flex-direction: column; line-height: 1.15; }
    .topbar-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 600; color: var(--text-dark); }
    .topbar-subtitle { font-size: 11.5px; color: var(--text-light); }

    .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }

    .topbar-icon-btn {
      width: 38px; height: 38px; border: none; background: var(--accent-lt);
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
      color: var(--primary); font-size: 17px; cursor: pointer;
      transition: background .2s, color .2s; position: relative;
    }
    .topbar-icon-btn:hover { background: var(--primary); color: #fff; }

    .bi { color: var(--primary); }
    .nav-item-link .bi, .sidebar-logo .bi, .sidebar-user .bi,
    .modal-header .bi, .modal-header-icon .bi, .btn-green .bi,
    .topbar-icon-btn:hover .bi, .action-btn.edit:hover .bi,
    .action-btn.delete:hover .bi, .action-btn.view:hover .bi,
    .action-btn.move:hover .bi { color: inherit; }
    .topbar-title .bi, .table-card-header .bi,
    .cfg-card-title .bi, .modal-section-title .bi { color: var(--primary); }
    .badge-status .bi, .stat-badge .bi { color: inherit; }
    .search-wrap .bi { color: var(--text-light); }

    .notif-badge {
      position: absolute; top: 6px; right: 6px; width: 8px; height: 8px;
      background: #E53935; border-radius: 50%; border: 2px solid #fff;
    }

    .topbar-user {
      display: flex; align-items: center; gap: 8px; padding: 6px 12px;
      background: var(--accent-lt); border-radius: 30px; cursor: pointer; transition: background .2s;
    }
    .topbar-user:hover { background: #C8E6C9; }
    .topbar-user .t-avatar {
      width: 30px; height: 30px; background: var(--primary);
      border-radius: 50%; display: flex; align-items: center; justify-content: center;
      overflow: hidden;
    }
    .topbar-user .t-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-md { width: 30px !important; height: 30px; object-fit: cover; border-radius: 50%; }
    .topbar-user .t-avatar i { color: #fff; font-size: 14px; }
    .topbar-user span { font-size: 13px; font-weight: 500; color: var(--primary); }

    .dropdown-menu-user {
      min-width: 200px; border: 1px solid var(--border); border-radius: 14px;
      box-shadow: 0 12px 36px rgba(0,0,0,.12); padding: 6px; margin-top: 8px !important;
    }
    .dropdown-menu-user .dropdown-header {
      font-size: 11px; font-weight: 600; letter-spacing: .8px;
      text-transform: uppercase; color: var(--text-light); padding: 6px 12px 4px;
    }
    .dropdown-menu-user .dropdown-item {
      font-size: 13.5px; color: var(--text-mid); border-radius: 8px;
      padding: 9px 12px; display: flex; align-items: center; gap: 9px;
      transition: background .15s, color .15s;
    }
    .dropdown-menu-user .dropdown-item i { font-size: 15px; color: var(--text-light); }
    .dropdown-menu-user .dropdown-item:hover { background: var(--accent-lt); color: var(--primary); }
    .dropdown-menu-user .dropdown-item:hover i { color: var(--primary); }
    .dropdown-menu-user .dropdown-divider { margin: 4px 6px; border-color: var(--border); }
    .dropdown-menu-user .item-logout { color: #C62828; }
    .dropdown-menu-user .item-logout i { color: #C62828; }
    .dropdown-menu-user .item-logout:hover { background: #FFEBEE; color: #C62828; }
    .dropdown-menu-user form { margin: 0; }
    .dropdown-menu-user form button {
      background: none; border: none; font-size: 13.5px; color: #C62828;
      border-radius: 8px; padding: 9px 12px; width: 100%; text-align: left;
      display: flex; align-items: center; gap: 9px; cursor: pointer; transition: background .15s;
    }
    .dropdown-menu-user form button:hover { background: #FFEBEE; }
    .dropdown-menu-user form button i { font-size: 15px; color: #C62828; }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    #main {
      margin-left: var(--sidebar-w); padding-top: var(--topbar-h);
      transition: margin-left .3s ease; min-height: 100vh;
    }
    body.icons-only  #main { margin-left: var(--sidebar-w-icons); }
    body.sidebar-hidden #main { margin-left: 0; }

    .content-inner { padding: 28px; }

    /* ═══════════════════════════════════════════
       PAGE HEADER
    ═══════════════════════════════════════════ */
    .page-header {
      display: flex; align-items: flex-start; justify-content: space-between;
      margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
    }
    .page-header-back {
      display: flex; align-items: center; gap: 8px;
      font-size: 12.5px; color: var(--text-light); text-decoration: none;
      margin-bottom: 8px; transition: color .15s;
    }
    .page-header-back:hover { color: var(--primary); }
    .page-header h1 {
      font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700;
      color: var(--text-dark); margin-bottom: 3px;
    }
    .page-header p { font-size: 13.5px; color: var(--text-light); }

    .btn-green {
      background: var(--primary); color: #fff; border: none; border-radius: 10px;
      padding: 9px 18px; font-size: 13.5px; font-weight: 600;
      display: inline-flex; align-items: center; gap: 6px; cursor: pointer;
      transition: background .2s, transform .1s; text-decoration: none;
    }
    .btn-green:hover { background: var(--accent); color: #fff; }
    .btn-green:active { transform: scale(.97); }

    .btn-outline-green {
      background: transparent; color: var(--primary); border: 1.5px solid var(--primary);
      border-radius: 10px; padding: 8px 16px; font-size: 13.5px; font-weight: 600;
      display: inline-flex; align-items: center; gap: 6px; cursor: pointer;
      transition: background .2s, color .2s; text-decoration: none;
    }
    .btn-outline-green:hover { background: var(--accent-lt); color: var(--primary); }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stat-card {
      background: var(--card-bg); border-radius: 16px; padding: 22px 20px;
      border: 1px solid var(--border); display: flex; align-items: center; gap: 16px;
      transition: box-shadow .2s, transform .2s;
    }
    .stat-card:hover { box-shadow: 0 8px 28px rgba(46,125,50,.1); transform: translateY(-2px); }

    .stat-icon {
      width: 52px; height: 52px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px;
    }
    .stat-icon.green  { background: var(--accent-lt); color: var(--primary); }
    .stat-icon.blue   { background: #E3F2FD; color: #1565C0; }
    .stat-icon.amber  { background: #FFF8E1; color: #F57F17; }
    .stat-icon.purple { background: #EDE7F6; color: #6A1B9A; }

    .stat-info .s-label { font-size: 12.5px; color: var(--text-light); margin-bottom: 4px; }
    .stat-info .s-value {
      font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700;
      color: var(--text-dark); line-height: 1; margin-bottom: 5px;
    }
    .stat-badge {
      font-size: 11.5px; font-weight: 600; padding: 3px 8px; border-radius: 30px;
      display: inline-flex; align-items: center; gap: 3px;
    }
    .stat-badge.up   { background: #E8F5E9; color: #2E7D32; }
    .stat-badge.info { background: #E3F2FD; color: #1565C0; }
    .stat-badge.down { background: #FFEBEE; color: #C62828; }

    /* ═══════════════════════════════════════════
       SETTINGS-STYLE LAYOUT — tabs laterais
    ═══════════════════════════════════════════ */
    .settings-wrap { display: flex; gap: 24px; align-items: flex-start; }

    .settings-nav {
      flex-shrink: 0; width: 230px;
      background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border);
      padding: 10px; position: sticky; top: calc(var(--topbar-h) + 28px);
    }
    .settings-nav-item {
      display: flex; align-items: center; gap: 11px;
      padding: 11px 14px; border-radius: 10px; cursor: pointer;
      color: var(--text-mid); font-size: 13.5px; font-weight: 500;
      transition: background .15s, color .15s; border: none; background: none;
      width: 100%; text-align: left; white-space: nowrap;
    }
    .settings-nav-item i { font-size: 16px; color: var(--text-light); transition: color .15s; }
    .settings-nav-item:hover { background: var(--accent-lt); color: var(--primary); }
    .settings-nav-item:hover i { color: var(--primary); }
    .settings-nav-item.active { background: var(--accent-lt); color: var(--primary); font-weight: 600; }
    .settings-nav-item.active i { color: var(--primary); }
    .settings-nav-item .nav-count {
      margin-left: auto; font-size: 10.5px; font-weight: 700; color: var(--text-light);
      background: var(--page-bg); padding: 1px 7px; border-radius: 20px;
    }
    .settings-nav-item.active .nav-count { background: #fff; color: var(--primary); }

    .settings-content { flex: 1; min-width: 0; }
    .settings-panel { display: none; }
    .settings-panel.active { display: block; }

    /* ── CARDS GERAIS ─── */
    .cfg-card {
      background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border);
      margin-bottom: 20px; overflow: hidden;
    }
    .cfg-card-header {
      padding: 18px 24px; border-bottom: 1px solid var(--border);
      display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
    }
    .cfg-card-header-left { display: flex; align-items: center; gap: 12px; }
    .cfg-card-icon {
      width: 40px; height: 40px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;
    }
    .cfg-card-icon.green  { background: var(--accent-lt); color: var(--primary); }
    .cfg-card-icon.blue   { background: #E3F2FD; color: #1565C0; }
    .cfg-card-icon.amber  { background: #FFF8E1; color: #F57F17; }
    .cfg-card-icon.red    { background: #FFEBEE; color: #C62828; }
    .cfg-card-icon.purple { background: #EDE7F6; color: #6A1B9A; }
    .cfg-card-icon.teal   { background: #E0F2F1; color: #00695C; }
    .cfg-card-title { font-family: 'Sora', sans-serif; font-size: 14.5px; font-weight: 600; color: var(--text-dark); }
    .cfg-card-sub { font-size: 12px; color: var(--text-light); margin-top: 2px; }

    /* ── BARRA DE AÇÕES ─── */
    .action-bar {
      padding: 16px 24px;
      border-bottom: 1px solid var(--border);
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      align-items: center;
    }
    .action-bar .search-wrap {
      flex: 1;
      min-width: 200px;
      position: relative;
    }
    .action-bar .search-wrap i {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-light);
      font-size: 14px;
      pointer-events: none;
    }
    .action-bar .search-input {
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
    .action-bar .search-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
      background: #fff;
    }
    .action-bar .filter-select {
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
    .action-bar .filter-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
    }

    /* ── TABELAS ─── */
    .table-wrap { overflow-x: auto; }
    .estoque-table {
      width: 100%; border-collapse: collapse; font-size: 13.5px;
    }
    .estoque-table th {
      font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px;
      color: var(--text-light); padding: 12px 16px; background: #FAFBFA;
      border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap;
      cursor: pointer;
      user-select: none;
    }
    .estoque-table th i { font-size: 12px; margin-left: 4px; }
    .estoque-table td {
      font-size: 13.5px; color: var(--text-dark); padding: 13px 16px;
      border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .estoque-table tr:last-child td { border-bottom: none; }
    .estoque-table tbody tr:hover td { background: #F8FBF8; }

    /* Badges */
    .badge-tipo {
      font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px;
      display: inline-block;
    }
    .badge-tipo.semente   { background: #E3F2FD; color: #1565C0; }
    .badge-tipo.fertilizante { background: #E8F5E9; color: #2E7D32; }
    .badge-tipo.mecanico  { background: #FFF8E1; color: #F57F17; }

    .badge-estoque {
      font-size: 12px; font-weight: 500; padding: 0; background: none; border-radius: 0;
      display: inline-flex; align-items: center; gap: 4px;
    }
    .badge-estoque.normal  { color: #2E7D32; }
    .badge-estoque.baixo   { color: #F57F17; }
    .badge-estoque.critico { color: #C62828; }
    .badge-estoque .dot {
      width: 7px; height: 7px; border-radius: 50%; display: inline-block;
    }
    .badge-estoque.normal .dot  { background: #2E7D32; }
    .badge-estoque.baixo .dot   { background: #F57F17; }
    .badge-estoque.critico .dot { background: #C62828; }

    /* Movimento badges */
    .badge-movimento.entrada  { color: #2E7D32; }
    .badge-movimento.saida    { color: #C62828; }
    .badge-movimento .dot {
      width: 7px; height: 7px; border-radius: 50%; display: inline-block;
    }
    .badge-movimento.entrada .dot { background: #2E7D32; }
    .badge-movimento.saida .dot   { background: #C62828; }

    /* Action buttons */
    .action-btn {
      width: 32px; height: 32px; border: none; border-radius: 9px;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 14px; cursor: pointer; transition: background .15s, color .15s; text-decoration: none;
    }
    .action-btn.edit   { background: var(--accent-lt); color: var(--primary); }
    .action-btn.edit:hover   { background: var(--primary); color: #fff; }
    .action-btn.delete { background: #FFEBEE; color: #C62828; }
    .action-btn.delete:hover { background: #C62828; color: #fff; }
    .action-btn.view   { background: #EDE7F6; color: #6A1B9A; }
    .action-btn.view:hover   { background: #6A1B9A; color: #fff; }
    .action-btn.move   { background: #E0F2F1; color: #00695C; }
    .action-btn.move:hover   { background: #00695C; color: #fff; }

    /* Pagination */
    .table-footer {
      padding: 14px 24px;
      display: flex; align-items: center; justify-content: space-between;
      border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px;
    }
    .table-footer span {
      font-size: 12.5px; color: var(--text-light);
    }
    .pagination-btns {
      display: flex; gap: 6px;
    }
    .page-btn {
      min-width: 34px; height: 34px; padding: 0 10px;
      border: 1.5px solid var(--border); border-radius: 9px;
      background: #fff; font-size: 13px; color: var(--text-mid);
      cursor: pointer; display: flex; align-items: center; justify-content: center;
      transition: all .15s; font-family: 'DM Sans', sans-serif;
    }
    .page-btn:hover {
      border-color: var(--primary); color: var(--primary);
    }
    .page-btn.active {
      background: var(--primary); color: #fff; border-color: var(--primary);
    }
    .page-btn:disabled {
      opacity: .4; cursor: not-allowed;
    }

    /* ── MODAL (estilo já definido anteriormente) ─── */
    .modal-coop {
      max-width: 780px;
    }
    .modal-coop .modal-content {
      max-height: 90vh; display: flex; flex-direction: column;
    }
    .modal-coop .modal-body {
      flex: 1; overflow-y: auto; overflow-x: hidden; padding: 0;
      background: var(--page-bg);
      scrollbar-width: thin;
      scrollbar-color: rgba(0,0,0,.15) transparent;
    }
    .modal-coop .modal-body::-webkit-scrollbar { width: 5px; }
    .modal-coop .modal-body::-webkit-scrollbar-track { background: transparent; }
    .modal-coop .modal-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 10px; }
    .modal-coop .modal-body::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.22); }

    .modal-content {
      border: none; border-radius: 18px;
      box-shadow: 0 24px 64px rgba(0,0,0,.15); overflow: hidden;
    }
    .modal-header {
      padding: 11px 20px; border-bottom: 1px solid var(--border);
      background: linear-gradient(135deg, var(--sidebar-bg) 0%, var(--primary) 100%);
      flex-shrink: 0;
    }
    .modal-header .modal-title {
      font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: #fff;
    }
    .modal-header .btn-close {
      filter: brightness(0) invert(1); opacity: .8;
    }
    .modal-header .btn-close:hover { opacity: 1; }
    .modal-header-icon {
      width: 36px; height: 36px; border-radius: 10px;
      background: rgba(255,255,255,.2);
      display: flex; align-items: center; justify-content: center;
      font-size: 17px; color: #fff; flex-shrink: 0;
    }
    .modal-body { background: var(--page-bg); }
    .modal-footer {
      padding: 14px 20px; border-top: 1px solid var(--border);
      background: #fff; flex-shrink: 0;
    }

    .modal-section-title {
      font-size: 11px; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; color: var(--text-light);
      margin-bottom: 14px; padding-bottom: 8px;
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center; gap: 8px;
    }
    .modal-section-title i { font-size: 13px; color: var(--primary); }
    .modal-form-card {
      background: var(--card-bg); border-radius: 14px; border: 1px solid var(--border);
      padding: 20px 22px; margin-bottom: 16px;
    }
    .cfg-label {
      display: block; font-size: 12px; font-weight: 600;
      color: var(--text-mid); margin-bottom: 5px; letter-spacing: .2px;
    }
    .cfg-input {
      width: 100%; border: 1.5px solid var(--border);
      border-radius: 10px; padding: 10px 13px; font-size: 13.5px;
      color: var(--text-dark); background: #FAFAF9;
      font-family: 'DM Sans', sans-serif; outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .cfg-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
      background: #fff;
    }
    .cfg-select {
      width: 100%; border: 1.5px solid var(--border);
      border-radius: 10px; padding: 10px 32px 10px 13px; font-size: 13.5px;
      color: var(--text-dark); background: #FAFAF9;
      appearance: none; cursor: pointer; outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 12px center;
      transition: border-color .2s; font-family: 'DM Sans', sans-serif;
    }
    .cfg-select:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
    }
    .cfg-textarea {
      width: 100%; border: 1.5px solid var(--border);
      border-radius: 10px; padding: 10px 13px; font-size: 13.5px;
      color: var(--text-dark); background: #FAFAF9;
      resize: vertical; min-height: 80px; outline: none;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s;
    }
    .cfg-textarea:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(46,125,50,.1);
    }
    .cfg-helper {
      font-size: 11.5px; color: var(--text-light); margin-top: 4px;
    }

    /* Toast */
    .save-toast {
      position: fixed; bottom: 28px; right: 28px; z-index: 9999;
      background: #fff; border: 1px solid var(--border); border-radius: 14px;
      padding: 14px 20px; box-shadow: 0 12px 36px rgba(0,0,0,.12);
      display: flex; align-items: center; gap: 12px;
      transform: translateY(80px); opacity: 0;
      transition: all .35s cubic-bezier(.34,1.56,.64,1);
      pointer-events: none; max-width: 400px;
    }
    .save-toast.show { transform: translateY(0); opacity: 1; pointer-events: all; }
    .save-toast .toast-icon {
      width: 36px; height: 36px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center; font-size: 18px;
      flex-shrink: 0;
    }
    .save-toast .toast-icon.success { background: #E8F5E9; color: #2E7D32; }
    .save-toast .toast-icon.danger { background: #FFEBEE; color: #C62828; }
    .save-toast .toast-icon.warning { background: #FFF8E1; color: #F57F17; }
    .save-toast .toast-text .t-title { font-size: 13.5px; font-weight: 600; color: var(--text-dark); }
    .save-toast .toast-text .t-sub { font-size: 12px; color: var(--text-light); }

    /* Dark mode */
    body.dark-mode {
      --card-bg: #1e2a20; --page-bg: #141d15; --text-dark: #e8f0e9;
      --text-mid: #9ab89e; --text-light: #6a8a6e; --border: rgba(255,255,255,.07);
    }
    body.dark-mode #topbar { background: #1e2a20; border-color: rgba(255,255,255,.06); }
    body.dark-mode .topbar-title { color: #e8f0e9; }
    body.dark-mode .topbar-user  { background: rgba(102,187,106,.15); }
    body.dark-mode .topbar-user span { color: #66BB6A; }
    body.dark-mode .topbar-icon-btn { background: rgba(102,187,106,.12); }
    body.dark-mode .estoque-table th { background: #172518; }
    body.dark-mode .estoque-table tbody tr:hover td { background: #1a2a1c; }
    body.dark-mode .action-bar .search-input,
    body.dark-mode .action-bar .filter-select,
    body.dark-mode .cfg-input,
    body.dark-mode .cfg-select,
    body.dark-mode .cfg-textarea {
      background: #172518;
      color: #e8f0e9;
      border-color: rgba(255,255,255,.1);
    }
    body.dark-mode .modal-body { background: #1a2a1c; }
    body.dark-mode .modal-form-card { background: #1e2a20; border-color: rgba(255,255,255,.07); }
    body.dark-mode .modal-footer { background: #1e2a20; border-color: rgba(255,255,255,.07); }

    /* Responsive */
    @media (max-width: 900px) {
      .settings-wrap { flex-direction: column; }
      .settings-nav { width: 100%; position: static; display: flex; flex-wrap: wrap; gap: 4px; padding: 8px; }
      .settings-nav-item { width: auto; padding: 8px 12px; font-size: 12.5px; }
    }
    @media (max-width: 768px) {
      :root { --sidebar-w: 240px; }
      body:not(.sidebar-hidden) #sidebar { box-shadow: 4px 0 20px rgba(0,0,0,.2); }
      body.default #sidebar { width: 0; }
      body.default #main    { margin-left: 0; }
      body.default #topbar  { left: 0; }
      .content-inner { padding: 16px; }
      .modal-coop { max-width: 100%; margin: 10px; }
    }

    /* Animations */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .anim { animation: fadeUp .4s ease both; }
    .anim-d1 { animation-delay: .05s; }
    .anim-d2 { animation-delay: .10s; }
    .anim-d3 { animation-delay: .15s; }
    .anim-d4 { animation-delay: .20s; }
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
        <circle cx="170" cy="170" r="145" fill="#66BB6A"/>
        <g fill="#ffffff" stroke="#ffffff" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round">
          <circle cx="118" cy="188" r="48" fill="none" stroke-width="6"/>
          <circle cx="118" cy="188" r="35" fill="none" stroke-width="4.5"/>
          <circle cx="118" cy="188" r="16" fill="#ffffff"/>
          <path d="M 118 135 L 118 144 M 118 232 L 118 241 M 65 188 L 74 188 M 162 188 L 171 188 M 81 151 L 88 157 M 155 219 L 162 225 M 81 225 L 88 219 M 155 151 L 162 157" stroke-width="6"/>
          <path d="M 68 185 C 68 140, 108 120, 160 128 C 171 132, 174 144, 174 151" fill="none" stroke-width="6"/>
          <circle cx="231" cy="204" r="26" fill="none" stroke-width="5"/>
          <circle cx="231" cy="204" r="10" fill="#ffffff"/>
          <path d="M 231 174 L 231 180 M 231 228 L 231 234 M 201 204 L 207 204 M 255 204 L 261 204 M 210 183 L 214 187 M 248 221 L 252 225 M 210 225 L 214 221 M 248 183 L 252 187" stroke-width="4"/>
          <path d="M 117 125 L 117 105 C 117 102, 120 99, 125 99 L 176 99 C 181 99, 184 102, 185 107 L 202 157 L 176 157" fill="none" stroke-width="6"/>
          <path d="M 144 99 L 144 128 L 187 128" fill="none" stroke-width="4"/>
          <path d="M 176 99 L 188 128" fill="none" stroke-width="4"/>
          <path d="M 174 151 L 246 156 C 252 156, 254 159, 254 165 L 254 197 L 202 197 Z" fill="#ffffff"/>
          <rect x="168" y="173" width="18" height="9" fill="none" stroke-width="4.5"/>
          <rect x="168" y="185" width="18" height="7" fill="none" stroke-width="4.5"/>
          <path d="M 223 156 L 223 125 C 223 119, 219 117, 219 113 L 220 107" fill="none" stroke-width="4.5"/>
          <ellipse cx="239" cy="171" rx="6" ry="4" fill="#66BB6A" stroke="none"/>
          <line x1="212" y1="170" x2="212" y2="188" stroke="#66BB6A" stroke-width="4"/>
          <line x1="220" y1="170" x2="220" y2="188" stroke="#66BB6A" stroke-width="4"/>
          <line x1="228" y1="170" x2="228" y2="188" stroke="#66BB6A" stroke-width="4"/>
        </g>
      </svg>
    </div>
    <div class="logo-text-wrap" style="opacity:1;transition:opacity .2s;white-space:nowrap;">
      <div style="font-family:'Sora',sans-serif;font-size:17px;font-weight:700;color:#fff;letter-spacing:1px;line-height:1.1;">SIAG</div>
      <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:.5px;">Agrícola Cooperativas</div>
    </div>
  </div>

  <div class="sidebar-nav">
    <div class="nav-section-title">Principal</div>
    <a href="{{ route('dashboard') }}" class="nav-item-link" data-label="Dashboard"><i class="bi bi-grid-1x2-fill"></i><span class="nav-label">Dashboard</span></a>
    <a href="{{ route('cooperativas') }}" class="nav-item-link" data-label="Cooperativa"><i class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
    <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i class="bi bi-person-badge-fill"></i><span class="nav-label">Agricultores</span></a>

    <div class="nav-section-title">Agrícola</div>
    <a href="#" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span class="nav-label">Safras</span></a>
    <a href="#" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span class="nav-label">Talhões</span></a>
    <a href="#" class="nav-item-link active" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span class="nav-label">Insumos</span></a>

    <div class="nav-section-title">Financeiro</div>
    <a href="#" class="nav-item-link" data-label="Contas a Pagar"><i class="bi bi-arrow-down-circle-fill"></i><span class="nav-label">Contas a Pagar</span></a>
    <a href="#" class="nav-item-link" data-label="Contas a Receber"><i class="bi bi-arrow-up-circle-fill"></i><span class="nav-label">Contas a Receber</span></a>
    <a href="#" class="nav-item-link" data-label="Fluxo de Caixa"><i class="bi bi-cash-stack"></i><span class="nav-label">Fluxo de Caixa</span></a>

    <div class="nav-section-title">Comercial</div>
    <a href="#" class="nav-item-link" data-label="Vendas"><i class="bi bi-cart-fill"></i><span class="nav-label">Vendas</span></a>
    <a href="#" class="nav-item-link" data-label="Contratos"><i class="bi bi-file-earmark-text-fill"></i><span class="nav-label">Contratos</span></a>

    <div class="nav-section-title">Sistema</div>
    <a href="#" class="nav-item-link" data-label="Relatórios"><i class="bi bi-bar-chart-fill"></i><span class="nav-label">Relatórios</span></a>
    <a href="{{ route('configuracoes') }}" class="nav-item-link" data-label="Configurações"><i class="bi bi-gear-fill"></i><span class="nav-label">Configurações</span></a>
  </div>

  <div class="sidebar-user">
    <div class="avatar">
      @if(!empty(Auth::user()->foto))
        <img src="{{ asset('storage/users/' . Auth::user()->foto) }}" alt="Foto"
          onerror="this.onerror=null;this.parentElement.innerHTML='{{ substr(Auth::user()->name,0,1) }}';this.parentElement.style.color='#fff';this.parentElement.style.fontWeight='700';this.parentElement.style.fontSize='15px';">
      @else
        <span style="color:#fff;font-weight:700;font-size:15px;">{{ substr(Auth::user()->name,0,1) }}</span>
      @endif
    </div>
    <div class="user-info">
      <div class="u-name">{{ Auth::user()->name }}</div>
      <div class="u-role">{{ Auth::user()->nivel }} · Viana</div>
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
  <div class="topbar-title-wrap">
    <span class="topbar-title">{{ $cooperativa->nome ?? 'Cooperativa Agrícola Esperança' }}</span>
    <span class="topbar-subtitle">
      <i class="bi bi-geo-alt-fill" style="font-size:10px;"></i>
      {{ $cooperativa->endereco ?? 'Rua Principal nº 45, Município do Cazenga, Luanda' }}
    </span>
  </div>
  <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
    <ol class="breadcrumb mb-0" style="font-size:12.5px;">
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">Insumos</a></li>
      <li class="breadcrumb-item active" style="color:var(--text-light);">Estoque</li>
    </ol>
  </nav>
  <div class="topbar-right">
    <span class="badge rounded-pill d-none d-md-inline-flex align-items-center gap-1"
      style="background:var(--accent-lt);color:var(--primary);font-size:12px;padding:7px 13px;font-weight:600;">
      <i class="bi bi-calendar3"></i> Safra {{ $cooperativa->safra ?? '2024/25' }}
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
          <img src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
            alt="Foto-perfil" class="avatar-md">
        </div>
        <span>{{ Auth::check() ? Auth::user()->name : 'Utilizador' }}</span>
        <i class="bi bi-chevron-down" style="font-size:11px;color:var(--primary);"></i>
      </div>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
        <li><span class="dropdown-header">Nível: {{ Auth::user()->nivel }}</span></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#"><i class="bi bi-person-gear"></i> Minha Conta</a></li>
        <li>
          <a class="dropdown-item" href="#" id="themeToggle">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            <span id="themeLabel">Modo Escuro</span>
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
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
        <a href="#" class="page-header-back" onclick="history.back();return false;">
          <i class="bi bi-arrow-left"></i> Voltar
        </a>
        <h1>Gestão de Estoque</h1>
        <p>Registo e administração do estoque da cooperativa</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn-outline-green" id="btnExportarEstoque">
          <i class="bi bi-download"></i> Exportar
        </button>
        <button class="btn-green" id="btnAdicionarInsumo">
          <i class="bi bi-plus-lg"></i> Adicionar Insumo
        </button>
      </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4 anim anim-d1">
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon green"><i class="bi bi-box-seam-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Total em Estoque</div>
            <div class="s-value" id="totalEstoque">0</div>
            <span class="stat-badge info"><i class="bi bi-info-circle"></i> Itens disponíveis</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="bi bi-droplet-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Fertilizantes</div>
            <div class="s-value" id="totalFertilizantes">0</div>
            <span class="stat-badge info"><i class="bi bi-box-arrow-in-down"></i> Em stock</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon amber"><i class="bi bi-seedling-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Sementes</div>
            <div class="s-value" id="totalSementes">0</div>
            <span class="stat-badge info"><i class="bi bi-flower2"></i> Em stock</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon purple"><i class="bi bi-tools"></i></div>
          <div class="stat-info">
            <div class="s-label">Materiais Mecânicos</div>
            <div class="s-value" id="totalMecanico">0</div>
            <span class="stat-badge info"><i class="bi bi-gear"></i> Em stock</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings-style layout com tabs na esquerda -->
    <div class="settings-wrap anim anim-d2">

      <!-- ── VERTICAL NAV ── -->
      <nav class="settings-nav">
        <button class="settings-nav-item active" data-tab="disponiveis">
          <i class="bi bi-box-seam-fill"></i> Insumos Disponíveis <span class="nav-count" id="countInsumos">0</span>
        </button>
        <button class="settings-nav-item" data-tab="historico">
          <i class="bi bi-clock-history"></i> Histórico <span class="nav-count" id="countHistorico">0</span>
        </button>
      </nav>

      <!-- ── CONTENT PANELS ── -->
      <div class="settings-content">

        <!-- ════════════════════════
             TAB 1 — INSUMOS DISPONÍVEIS
        ════════════════════════ -->
        <div class="settings-panel active" id="tab-disponiveis">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon green"><i class="bi bi-box-seam-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Estoque de Insumos</div>
                  <div class="cfg-card-sub">Todos os insumos disponíveis na cooperativa</div>
                </div>
              </div>
              <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <button class="btn-green" id="btnMovimentarEstoque" style="padding:8px 14px;font-size:12.5px;">
                  <i class="bi bi-arrow-left-right"></i> Movimentar Estoque
                </button>
              </div>
            </div>

            <!-- Barra de Ações -->
            <div class="action-bar">
              <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" id="searchInsumo" placeholder="Pesquisar por nome do insumo...">
              </div>
              <select class="filter-select" id="filterTipo">
                <option value="">Todos os tipos</option>
                <option value="Semente">Semente</option>
                <option value="Fertilizante">Fertilizante</option>
                <option value="Mecânico">Mecânico</option>
              </select>
              <button class="btn-green" id="btnAplicarFiltros" style="padding:8px 18px;"><i class="bi bi-search"></i> Filtrar</button>
              <button class="btn-outline-green" id="btnLimparFiltros" style="padding:8px 18px;"><i class="bi bi-eraser"></i> Limpar</button>
            </div>

            <!-- Tabela -->
            <div class="table-wrap">
              <table class="estoque-table" id="tabelaInsumos">
                <thead>
                  <tr>
                    <th data-col="id" style="width:60px;">ID <i class="bi bi-arrow-up-short"></i></th>
                    <th data-col="nome">Nome</th>
                    <th data-col="tipo">Tipo</th>
                    <th data-col="preco_custo">Preço de Custo</th>
                    <th data-col="stock_atual">Stock Atual</th>
                    <th style="text-align:center;">Ações</th>
                  </tr>
                </thead>
                <tbody id="tabelaInsumosBody">
                  <!-- Renderizado via JavaScript -->
                </tbody>
              </table>
            </div>

            <!-- Paginação -->
            <div class="table-footer">
              <span id="infoInsumos">Mostrando 0 - 0 de 0 registos</span>
              <div class="pagination-btns" id="paginacaoInsumos">
                <!-- Renderizado via JavaScript -->
              </div>
            </div>
          </div>
        </div>

        <!-- ════════════════════════
             TAB 2 — HISTÓRICO
        ════════════════════════ -->
        <div class="settings-panel" id="tab-historico">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon blue"><i class="bi bi-clock-history"></i></div>
                <div>
                  <div class="cfg-card-title">Histórico de Movimentações</div>
                  <div class="cfg-card-sub">Todas as entradas e saídas de insumos</div>
                </div>
              </div>
            </div>

            <!-- Filtros Histórico -->
            <div class="action-bar">
              <div style="display:flex;gap:10px;flex-wrap:wrap;width:100%;align-items:center;">
                <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                  <label style="font-size:12.5px;color:var(--text-mid);">Data Inicial</label>
                  <input type="date" class="search-input" id="filtroDataIni" style="width:160px;padding:8px 12px;">
                  <label style="font-size:12.5px;color:var(--text-mid);">Data Final</label>
                  <input type="date" class="search-input" id="filtroDataFim" style="width:160px;padding:8px 12px;">
                </div>
                <select class="filter-select" id="filtroMovTipo" style="width:150px;">
                  <option value="">Todos os movimentos</option>
                  <option value="Entrada">Entrada</option>
                  <option value="Saída">Saída</option>
                </select>
                <select class="filter-select" id="filtroMovInsumo" style="width:180px;">
                  <option value="">Todos os insumos</option>
                </select>
                <button class="btn-green" id="btnFiltrarHistorico" style="padding:8px 18px;"><i class="bi bi-search"></i> Filtrar</button>
                <button class="btn-outline-green" id="btnLimparFiltrosHistorico" style="padding:8px 18px;"><i class="bi bi-eraser"></i> Limpar</button>
              </div>
            </div>

            <!-- Tabela Histórico -->
            <div class="table-wrap">
              <table class="estoque-table" id="tabelaHistorico">
                <thead>
                  <tr>
                    <th data-col="data">Data</th>
                    <th data-col="insumo_nome">Insumo</th>
                    <th data-col="tipo_movimento">Tipo Movimento</th>
                    <th data-col="quantidade">Quantidade</th>
                    <th data-col="stock_anterior">Stock Anterior</th>
                    <th data-col="stock_atual">Stock Atual</th>
                    <th data-col="utilizador">Utilizador</th>
                  </tr>
                </thead>
                <tbody id="tabelaHistoricoBody">
                  <!-- Renderizado via JavaScript -->
                </tbody>
              </table>
            </div>

            <!-- Paginação Histórico -->
            <div class="table-footer">
              <span id="infoHistorico">Mostrando 0 - 0 de 0 registos</span>
              <div class="pagination-btns" id="paginacaoHistorico">
                <!-- Renderizado via JavaScript -->
              </div>
            </div>
          </div>
        </div>

      </div><!-- /settings-content -->
    </div><!-- /settings-wrap -->

  </div><!-- /content-inner -->
</main>

<!-- ══════════════════════════════════════
     MODALS
══════════════════════════════════════ -->

<!-- ─── MODAL ADICIONAR INSUMO ─── -->
<div class="modal fade modal-coop" id="modalAdicionarInsumo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon"><i class="bi bi-box-seam-fill"></i></div>
          <div>
            <div class="modal-title">Adicionar Insumo</div>
            <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Registar novo insumo no estoque</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="formAdicionarInsumo">
          @csrf
          <div class="modal-form-card">
            <div class="modal-section-title"><i class="bi bi-box-seam-fill"></i> Dados do Insumo</div>
            <div class="row g-3">
              <div class="col-12">
                <label class="cfg-label">Nome *</label>
                <input type="text" class="cfg-input" id="insumoNome" required placeholder="Ex: Ureia 46%">
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Tipo *</label>
                <select class="cfg-select" id="insumoTipo" required>
                  <option value="">Seleccione</option>
                  <option value="Semente">Semente</option>
                  <option value="Fertilizante">Fertilizante</option>
                  <option value="Mecânico">Mecânico</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Unidade de Medida *</label>
                <input type="text" class="cfg-input" id="insumoUnidade" required placeholder="Ex: kg, L, unidade">
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Preço de Custo (Kz) *</label>
                <input type="number" class="cfg-input" id="insumoPreco" required placeholder="0" step="0.01">
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Quantidade Inicial *</label>
                <input type="number" class="cfg-input" id="insumoQuantidade" required placeholder="0" step="1">
              </div>
              <div class="col-12">
                <label class="cfg-label">Descrição</label>
                <textarea class="cfg-textarea" id="insumoDescricao" rows="3" placeholder="Descrição opcional do insumo"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
          <div style="font-size:12px;color:var(--text-light);">
            <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
          </div>
          <div style="display:flex;gap:10px;">
            <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cancelar</button>
            <button type="button" class="btn-green" id="btnSalvarInsumo"><i class="bi bi-check2-circle"></i> Salvar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ─── MODAL MOVIMENTAR ESTOQUE ─── -->
<div class="modal fade modal-coop" id="modalMovimentarEstoque" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon"><i class="bi bi-arrow-left-right"></i></div>
          <div>
            <div class="modal-title">Movimentar Estoque</div>
            <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Registrar entrada ou saída de insumo</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="formMovimentarEstoque">
          @csrf
          <div class="modal-form-card">
            <div class="modal-section-title"><i class="bi bi-arrow-left-right"></i> Dados da Movimentação</div>
            <div class="row g-3">
              <div class="col-12">
                <label class="cfg-label">Insumo *</label>
                <select class="cfg-select" id="movInsumo" required>
                  <option value="">Seleccione um insumo</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Tipo de Movimento *</label>
                <select class="cfg-select" id="movTipo" required>
                  <option value="">Seleccione</option>
                  <option value="Entrada">Entrada</option>
                  <option value="Saída">Saída</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Quantidade *</label>
                <input type="number" class="cfg-input" id="movQuantidade" required placeholder="0" step="1">
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Data *</label>
                <input type="date" class="cfg-input" id="movData" required>
              </div>
              <div class="col-12">
                <label class="cfg-label">Observação</label>
                <textarea class="cfg-textarea" id="movObservacao" rows="3" placeholder="Observação opcional"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
          <div style="font-size:12px;color:var(--text-light);">
            <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
          </div>
          <div style="display:flex;gap:10px;">
            <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cancelar</button>
            <button type="button" class="btn-green" id="btnSalvarMovimento"><i class="bi bi-check2-circle"></i> Salvar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ─── MODAL VISUALIZAR INSUMO ─── -->
<div class="modal fade modal-coop" id="modalVisualizarInsumo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon"><i class="bi bi-eye-fill"></i></div>
          <div>
            <div class="modal-title">Detalhes do Insumo</div>
            <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;" id="visualizarInsumoNome">—</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" style="padding:24px;">
        <div class="row g-3">
          <div class="col-6"><strong>ID:</strong> <span id="visualizarId">—</span></div>
          <div class="col-6"><strong>Tipo:</strong> <span id="visualizarTipo">—</span></div>
          <div class="col-6"><strong>Unidade:</strong> <span id="visualizarUnidade">—</span></div>
          <div class="col-6"><strong>Preço de Custo:</strong> <span id="visualizarPreco">—</span></div>
          <div class="col-6"><strong>Stock Atual:</strong> <span id="visualizarStock">—</span></div>
          <div class="col-12"><strong>Descrição:</strong> <span id="visualizarDescricao">—</span></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- ─── MODAL EDITAR INSUMO ─── -->
<div class="modal fade modal-coop" id="modalEditarInsumo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon"><i class="bi bi-pencil-fill"></i></div>
          <div>
            <div class="modal-title">Editar Insumo</div>
            <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Atualizar dados do insumo</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarInsumo">
          @csrf
          @method('PUT')
          <input type="hidden" id="editarInsumoId">
          <div class="modal-form-card">
            <div class="modal-section-title"><i class="bi bi-pencil-fill"></i> Dados do Insumo</div>
            <div class="row g-3">
              <div class="col-12">
                <label class="cfg-label">Nome *</label>
                <input type="text" class="cfg-input" id="editarInsumoNome" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Tipo *</label>
                <select class="cfg-select" id="editarInsumoTipo" required>
                  <option value="Semente">Semente</option>
                  <option value="Fertilizante">Fertilizante</option>
                  <option value="Mecânico">Mecânico</option>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Unidade de Medida *</label>
                <input type="text" class="cfg-input" id="editarInsumoUnidade" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label">Preço de Custo (Kz) *</label>
                <input type="number" class="cfg-input" id="editarInsumoPreco" required step="0.01">
              </div>
              <div class="col-12">
                <label class="cfg-label">Descrição</label>
                <textarea class="cfg-textarea" id="editarInsumoDescricao" rows="3"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
          <div style="font-size:12px;color:var(--text-light);">
            <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
          </div>
          <div style="display:flex;gap:10px;">
            <button type="button" class="btn-outline-green" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Cancelar</button>
            <button type="button" class="btn-green" id="btnSalvarEditarInsumo"><i class="bi bi-check2-circle"></i> Salvar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ─── MODAL EXCLUIR INSUMO ─── -->
<div class="modal fade" id="modalExcluirInsumo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content">
      <div class="modal-header" style="background:linear-gradient(135deg, #7f0000, #C62828);">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
          <div>
            <div class="modal-title">Confirmar Exclusão</div>
            <div style="font-size:12px;color:rgba(255,255,255,.65);margin-top:2px;">Esta acção é irreversível</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body" style="background:#fff;padding:28px;">
        <p style="font-size:13.5px;color:var(--text-mid);margin-bottom:10px;">
          Tem a certeza que deseja excluir o insumo:
        </p>
        <div style="background:#FFF8F8;border:1px solid #FFCDD2;border-radius:10px;padding:14px 18px;margin-bottom:16px;">
          <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:#C62828;" id="excluirInsumoNome">—</div>
          <div style="font-size:12px;color:var(--text-light);margin-top:3px;">Todos os dados associados serão removidos permanentemente.</div>
        </div>
        <input type="hidden" id="excluirInsumoId">
      </div>
      <div class="modal-footer" style="border-top:1px solid #FFCDD2;">
        <button type="button" class="btn-outline-green" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn-green" id="btnConfirmarExcluir" style="background:#C62828;box-shadow:none;">
          <i class="bi bi-trash-fill"></i> Excluir Definitivamente
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

<!-- ══════════════════════════════════════
     SCRIPT PRINCIPAL
══════════════════════════════════════ -->
<script>
/* ══════════════════════════════════════
   SIDEBAR TOGGLE
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
const themeIcon   = document.getElementById('themeIcon');
const themeLabel  = document.getElementById('themeLabel');
let darkMode = false;

themeToggle.addEventListener('click', function(e) {
  e.preventDefault();
  darkMode = !darkMode;
  body.classList.toggle('dark-mode', darkMode);
  themeIcon.className  = darkMode ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
  themeLabel.textContent = darkMode ? 'Modo Claro' : 'Modo Escuro';
});

/* ══════════════════════════════════════
   TOAST
══════════════════════════════════════ */
function showToast(title, sub, type = 'success') {
  const toast  = document.getElementById('saveToast');
  const icon   = document.getElementById('toastIcon');
  const iconI  = document.getElementById('toastIconI');
  document.getElementById('toastTitle').textContent = title;
  document.getElementById('toastSub').textContent   = sub;
  icon.className = 'toast-icon ' + type;
  iconI.className = type === 'danger' ? 'bi bi-x-lg' : type === 'warning' ? 'bi bi-exclamation-triangle-fill' : 'bi bi-check-lg';
  toast.classList.add('show');
  clearTimeout(toast._timeout);
  toast._timeout = setTimeout(() => toast.classList.remove('show'), 3500);
}

/* ══════════════════════════════════════
   TABS LATERAIS
══════════════════════════════════════ */
document.querySelectorAll('.settings-nav-item').forEach(btn => {
  btn.addEventListener('click', () => {
    const tab = btn.dataset.tab;

    document.querySelectorAll('.settings-nav-item').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    document.querySelectorAll('.settings-panel').forEach(p => {
      p.classList.remove('active');
    });
    const panel = document.getElementById('tab-' + tab);
    if (panel) {
      panel.classList.add('active');
      panel.querySelectorAll('.anim').forEach(el => {
        el.style.animation = 'none';
        el.offsetHeight;
        el.style.animation = '';
      });
    }

    if (tab === 'disponiveis') renderInsumos();
    else if (tab === 'historico') renderHistorico();
  });
});

/* ══════════════════════════════════════
   DADOS MOCKADOS
══════════════════════════════════════ */
let insumos = [
  { id: 1, nome: 'Ureia 46%', tipo: 'Fertilizante', unidade: 'kg', preco_custo: 3200, stock_atual: 150, descricao: 'Fertilizante nitrogenado' },
  { id: 2, nome: 'Semente de Milho Híbrida', tipo: 'Semente', unidade: 'kg', preco_custo: 450, stock_atual: 80, descricao: 'Variedade resistente à seca' },
  { id: 3, nome: 'Trator MF 290', tipo: 'Mecânico', unidade: 'unidade', preco_custo: 3500000, stock_atual: 2, descricao: 'Trator para preparo do solo' },
  { id: 4, nome: 'Fertilizante NPK 12-24-12', tipo: 'Fertilizante', unidade: 'kg', preco_custo: 4500, stock_atual: 200, descricao: 'Fertilizante completo' },
  { id: 5, nome: 'Semente de Feijão', tipo: 'Semente', unidade: 'kg', preco_custo: 300, stock_atual: 45, descricao: 'Feijão comum' },
  { id: 6, nome: 'Arado de Disco', tipo: 'Mecânico', unidade: 'unidade', preco_custo: 120000, stock_atual: 5, descricao: 'Arado para preparo do solo' },
  { id: 7, nome: 'Herbicida Glifosato', tipo: 'Fertilizante', unidade: 'L', preco_custo: 800, stock_atual: 60, descricao: 'Herbicida de amplo espectro' },
  { id: 8, nome: 'Semente de Mandioca', tipo: 'Semente', unidade: 'kg', preco_custo: 200, stock_atual: 30, descricao: 'Variedade de mesa' },
  { id: 9, nome: 'Pulverizador Costal', tipo: 'Mecânico', unidade: 'unidade', preco_custo: 15000, stock_atual: 12, descricao: 'Pulverizador manual' },
  { id: 10, nome: 'Fertilizante Potássico', tipo: 'Fertilizante', unidade: 'kg', preco_custo: 2800, stock_atual: 0, descricao: 'Fertilizante rico em potássio' },
];

let movimentos = [
  { id: 1, insumo_id: 1, tipo_movimento: 'Entrada', quantidade: 50, stock_anterior: 100, stock_atual: 150, data: '2025-01-10', utilizador: 'João Silva', observacao: 'Compra realizada' },
  { id: 2, insumo_id: 2, tipo_movimento: 'Saída', quantidade: 20, stock_anterior: 100, stock_atual: 80, data: '2025-01-12', utilizador: 'Maria Santos', observacao: 'Distribuição para agricultores' },
  { id: 3, insumo_id: 3, tipo_movimento: 'Entrada', quantidade: 1, stock_anterior: 1, stock_atual: 2, data: '2025-01-15', utilizador: 'Carlos Ferreira', observacao: 'Aquisição de novo trator' },
  { id: 4, insumo_id: 4, tipo_movimento: 'Entrada', quantidade: 200, stock_anterior: 0, stock_atual: 200, data: '2025-01-20', utilizador: 'Ana Rodrigues', observacao: 'Compra em grande lote' },
  { id: 5, insumo_id: 2, tipo_movimento: 'Entrada', quantidade: 30, stock_anterior: 80, stock_atual: 110, data: '2025-01-22', utilizador: 'João Silva', observacao: 'Reabastecimento' },
  { id: 6, insumo_id: 1, tipo_movimento: 'Saída', quantidade: 25, stock_anterior: 150, stock_atual: 125, data: '2025-01-25', utilizador: 'Maria Santos', observacao: 'Uso em campo' },
  { id: 7, insumo_id: 5, tipo_movimento: 'Entrada', quantidade: 45, stock_anterior: 0, stock_atual: 45, data: '2025-02-01', utilizador: 'Carlos Ferreira', observacao: 'Nova semente adquirida' },
  { id: 8, insumo_id: 6, tipo_movimento: 'Entrada', quantidade: 5, stock_anterior: 0, stock_atual: 5, data: '2025-02-05', utilizador: 'Ana Rodrigues', observacao: 'Compra de arados' },
  { id: 9, insumo_id: 3, tipo_movimento: 'Saída', quantidade: 1, stock_anterior: 2, stock_atual: 1, data: '2025-02-10', utilizador: 'João Silva', observacao: 'Empréstimo para outra cooperativa' },
  { id: 10, insumo_id: 7, tipo_movimento: 'Entrada', quantidade: 60, stock_anterior: 0, stock_atual: 60, data: '2025-02-12', utilizador: 'Maria Santos', observacao: 'Aquisição de herbicida' },
];

let nextInsumoId = 11;
let nextMovimentoId = 11;

/* ══════════════════════════════════════
   TABELA INSUMOS — Renderização, Filtros, Ordenação, Paginação
══════════════════════════════════════ */
let insumosData = [...insumos];
let insumosFiltrados = [...insumosData];
let insumosPagina = 1;
const insumosPorPagina = 5;
let insumosOrdenacao = { col: 'id', dir: 'asc' };

function renderInsumos() {
  // Aplicar filtros
  const search = document.getElementById('searchInsumo').value.toLowerCase().trim();
  const tipo = document.getElementById('filterTipo').value;

  insumosFiltrados = insumosData.filter(i => {
    const matchNome = i.nome.toLowerCase().includes(search);
    const matchTipo = tipo ? i.tipo === tipo : true;
    return matchNome && matchTipo;
  });

  // Ordenar
  const col = insumosOrdenacao.col;
  const dir = insumosOrdenacao.dir;
  insumosFiltrados.sort((a, b) => {
    let valA = a[col] ?? '';
    let valB = b[col] ?? '';
    if (typeof valA === 'string') valA = valA.toLowerCase();
    if (typeof valB === 'string') valB = valB.toLowerCase();
    if (valA < valB) return dir === 'asc' ? -1 : 1;
    if (valA > valB) return dir === 'asc' ? 1 : -1;
    return 0;
  });

  // Paginar
  const total = insumosFiltrados.length;
  const totalPages = Math.ceil(total / insumosPorPagina) || 1;
  if (insumosPagina > totalPages) insumosPagina = totalPages;
  const start = (insumosPagina - 1) * insumosPorPagina;
  const end = Math.min(start + insumosPorPagina, total);
  const pageItems = insumosFiltrados.slice(start, end);

  // Atualizar corpo da tabela
  const tbody = document.getElementById('tabelaInsumosBody');
  if (pageItems.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhum insumo encontrado.</td></tr>`;
  } else {
    tbody.innerHTML = pageItems.map(i => {
      const nivelEstoque = i.stock_atual > 50 ? 'normal' : i.stock_atual > 10 ? 'baixo' : 'critico';
      return `
        <tr>
          <td>${i.id}</td>
          <td><strong>${i.nome}</strong></td>
          <td><span class="badge-tipo ${i.tipo.toLowerCase()}">${i.tipo}</span></td>
          <td>${(i.preco_custo || 0).toLocaleString('pt-AO')} Kz</td>
          <td>
            ${i.stock_atual} ${i.unidade || ''}
            <span class="badge-estoque ${nivelEstoque}"><span class="dot"></span> ${nivelEstoque.charAt(0).toUpperCase() + nivelEstoque.slice(1)}</span>
          </td>
          <td style="text-align:center;">
            <div style="display:flex;gap:6px;justify-content:center;">
              <button class="action-btn view" title="Visualizar" onclick="visualizarInsumo(${i.id})"><i class="bi bi-eye-fill"></i></button>
              <button class="action-btn edit" title="Editar" onclick="editarInsumo(${i.id})"><i class="bi bi-pencil-fill"></i></button>
              <button class="action-btn move" title="Movimentar" onclick="movimentarInsumo(${i.id})"><i class="bi bi-arrow-left-right"></i></button>
              <button class="action-btn delete" title="Excluir" onclick="excluirInsumo(${i.id}, '${i.nome}')"><i class="bi bi-trash-fill"></i></button>
            </div>
          </td>
        </tr>
      `;
    }).join('');
  }

  // Atualizar info e paginação
  document.getElementById('infoInsumos').textContent = `Mostrando ${total === 0 ? 0 : start + 1} - ${end} de ${total} registos`;
  const pagContainer = document.getElementById('paginacaoInsumos');
  let pagHtml = '';
  pagHtml += `<button class="page-btn" ${insumosPagina <= 1 ? 'disabled' : ''} onclick="insumosPagina--;renderInsumos();"><i class="bi bi-chevron-left"></i></button>`;
  for (let p = 1; p <= totalPages; p++) {
    pagHtml += `<button class="page-btn ${p === insumosPagina ? 'active' : ''}" onclick="insumosPagina=${p};renderInsumos();">${p}</button>`;
  }
  pagHtml += `<button class="page-btn" ${insumosPagina >= totalPages ? 'disabled' : ''} onclick="insumosPagina++;renderInsumos();"><i class="bi bi-chevron-right"></i></button>`;
  pagContainer.innerHTML = pagHtml;

  // Atualizar cards e contagem
  const totalItens = insumosData.reduce((acc, i) => acc + i.stock_atual, 0);
  document.getElementById('totalEstoque').textContent = totalItens;
  document.getElementById('totalFertilizantes').textContent = insumosData.filter(i => i.tipo === 'Fertilizante').reduce((acc, i) => acc + i.stock_atual, 0);
  document.getElementById('totalSementes').textContent = insumosData.filter(i => i.tipo === 'Semente').reduce((acc, i) => acc + i.stock_atual, 0);
  document.getElementById('totalMecanico').textContent = insumosData.filter(i => i.tipo === 'Mecânico').reduce((acc, i) => acc + i.stock_atual, 0);
  document.getElementById('countInsumos').textContent = insumosData.length;
}

/* Ordenação das colunas */
document.querySelectorAll('#tabelaInsumos thead th[data-col]').forEach(th => {
  th.addEventListener('click', () => {
    const col = th.dataset.col;
    if (insumosOrdenacao.col === col) {
      insumosOrdenacao.dir = insumosOrdenacao.dir === 'asc' ? 'desc' : 'asc';
    } else {
      insumosOrdenacao.col = col;
      insumosOrdenacao.dir = 'asc';
    }
    renderInsumos();
  });
});

/* Eventos de filtro */
document.getElementById('btnAplicarFiltros').addEventListener('click', () => {
  insumosPagina = 1;
  renderInsumos();
});
document.getElementById('btnLimparFiltros').addEventListener('click', () => {
  document.getElementById('searchInsumo').value = '';
  document.getElementById('filterTipo').value = '';
  insumosPagina = 1;
  renderInsumos();
});
document.getElementById('searchInsumo').addEventListener('keyup', (e) => {
  if (e.key === 'Enter') {
    insumosPagina = 1;
    renderInsumos();
  }
});

/* ══════════════════════════════════════
   MODAL ADICIONAR INSUMO
══════════════════════════════════════ */
const modalAdicionar = new bootstrap.Modal(document.getElementById('modalAdicionarInsumo'));

document.getElementById('btnAdicionarInsumo').addEventListener('click', () => {
  document.getElementById('formAdicionarInsumo').reset();
  modalAdicionar.show();
});

document.getElementById('btnSalvarInsumo').addEventListener('click', () => {
  const nome = document.getElementById('insumoNome').value.trim();
  const tipo = document.getElementById('insumoTipo').value;
  const unidade = document.getElementById('insumoUnidade').value.trim();
  const preco = parseFloat(document.getElementById('insumoPreco').value);
  const qtd = parseInt(document.getElementById('insumoQuantidade').value);
  const descricao = document.getElementById('insumoDescricao').value.trim();

  if (!nome || !tipo || !unidade || isNaN(preco) || isNaN(qtd) || qtd < 0) {
    showToast('Campos inválidos', 'Preencha todos os campos obrigatórios corretamente.', 'danger');
    return;
  }

  const novo = {
    id: nextInsumoId++,
    nome,
    tipo,
    unidade,
    preco_custo: preco,
    stock_atual: qtd,
    descricao
  };
  insumosData.push(novo);
  // Registrar movimentação de entrada
  movimentos.push({
    id: nextMovimentoId++,
    insumo_id: novo.id,
    tipo_movimento: 'Entrada',
    quantidade: qtd,
    stock_anterior: 0,
    stock_atual: qtd,
    data: new Date().toISOString().split('T')[0],
    utilizador: 'Sistema',
    observacao: 'Cadastro inicial'
  });
  modalAdicionar.hide();
  renderInsumos();
  carregarSelectInsumos();
  carregarSelectHistorico();
  showToast('Insumo adicionado', `${nome} foi registado com sucesso.`);
});

/* ══════════════════════════════════════
   MODAL MOVIMENTAR ESTOQUE
══════════════════════════════════════ */
const modalMovimentar = new bootstrap.Modal(document.getElementById('modalMovimentarEstoque'));

function carregarSelectInsumos() {
  const select = document.getElementById('movInsumo');
  select.innerHTML = '<option value="">Seleccione um insumo</option>' +
    insumosData.map(i => `<option value="${i.id}">${i.nome} (${i.stock_atual} ${i.unidade})</option>`).join('');
}
carregarSelectInsumos();

document.getElementById('btnMovimentarEstoque').addEventListener('click', () => {
  document.getElementById('formMovimentarEstoque').reset();
  document.getElementById('movData').valueAsDate = new Date();
  modalMovimentar.show();
});

function movimentarInsumo(id) {
  const select = document.getElementById('movInsumo');
  select.value = id;
  document.getElementById('formMovimentarEstoque').reset();
  document.getElementById('movData').valueAsDate = new Date();
  modalMovimentar.show();
}

document.getElementById('btnSalvarMovimento').addEventListener('click', () => {
  const insumoId = parseInt(document.getElementById('movInsumo').value);
  const tipo = document.getElementById('movTipo').value;
  const qtd = parseInt(document.getElementById('movQuantidade').value);
  const data = document.getElementById('movData').value;
  const obs = document.getElementById('movObservacao').value.trim();

  if (!insumoId || !tipo || isNaN(qtd) || qtd <= 0 || !data) {
    showToast('Campos inválidos', 'Preencha todos os campos obrigatórios.', 'danger');
    return;
  }

  const insumo = insumosData.find(i => i.id === insumoId);
  if (!insumo) {
    showToast('Erro', 'Insumo não encontrado.', 'danger');
    return;
  }

  const stockAnterior = insumo.stock_atual;
  let novoStock = stockAnterior;
  if (tipo === 'Entrada') {
    novoStock += qtd;
  } else if (tipo === 'Saída') {
    if (qtd > stockAnterior) {
      showToast('Erro', 'Quantidade de saída excede o stock atual.', 'danger');
      return;
    }
    novoStock -= qtd;
  }

  insumo.stock_atual = novoStock;
  movimentos.push({
    id: nextMovimentoId++,
    insumo_id: insumoId,
    tipo_movimento: tipo,
    quantidade: qtd,
    stock_anterior: stockAnterior,
    stock_atual: novoStock,
    data: data,
    utilizador: 'Sistema',
    observacao: obs
  });

  modalMovimentar.hide();
  renderInsumos();
  carregarSelectInsumos();
  carregarSelectHistorico();
  showToast('Movimento registado', `${tipo} de ${qtd} ${insumo.unidade} de ${insumo.nome} realizada com sucesso.`);
});

/* ══════════════════════════════════════
   MODAL VISUALIZAR INSUMO
══════════════════════════════════════ */
const modalVisualizar = new bootstrap.Modal(document.getElementById('modalVisualizarInsumo'));

function visualizarInsumo(id) {
  const insumo = insumosData.find(i => i.id === id);
  if (!insumo) return;
  document.getElementById('visualizarInsumoNome').textContent = insumo.nome;
  document.getElementById('visualizarId').textContent = insumo.id;
  document.getElementById('visualizarTipo').textContent = insumo.tipo;
  document.getElementById('visualizarUnidade').textContent = insumo.unidade || '—';
  document.getElementById('visualizarPreco').textContent = (insumo.preco_custo || 0).toLocaleString('pt-AO') + ' Kz';
  document.getElementById('visualizarStock').textContent = insumo.stock_atual + ' ' + (insumo.unidade || '');
  document.getElementById('visualizarDescricao').textContent = insumo.descricao || '—';
  modalVisualizar.show();
}

/* ══════════════════════════════════════
   MODAL EDITAR INSUMO
══════════════════════════════════════ */
const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarInsumo'));

function editarInsumo(id) {
  const insumo = insumosData.find(i => i.id === id);
  if (!insumo) return;
  document.getElementById('editarInsumoId').value = insumo.id;
  document.getElementById('editarInsumoNome').value = insumo.nome;
  document.getElementById('editarInsumoTipo').value = insumo.tipo;
  document.getElementById('editarInsumoUnidade').value = insumo.unidade || '';
  document.getElementById('editarInsumoPreco').value = insumo.preco_custo || '';
  document.getElementById('editarInsumoDescricao').value = insumo.descricao || '';
  modalEditar.show();
}

document.getElementById('btnSalvarEditarInsumo').addEventListener('click', () => {
  const id = parseInt(document.getElementById('editarInsumoId').value);
  const insumo = insumosData.find(i => i.id === id);
  if (!insumo) return;

  const nome = document.getElementById('editarInsumoNome').value.trim();
  const tipo = document.getElementById('editarInsumoTipo').value;
  const unidade = document.getElementById('editarInsumoUnidade').value.trim();
  const preco = parseFloat(document.getElementById('editarInsumoPreco').value);
  const descricao = document.getElementById('editarInsumoDescricao').value.trim();

  if (!nome || !tipo || !unidade || isNaN(preco)) {
    showToast('Campos inválidos', 'Preencha todos os campos obrigatórios.', 'danger');
    return;
  }

  insumo.nome = nome;
  insumo.tipo = tipo;
  insumo.unidade = unidade;
  insumo.preco_custo = preco;
  insumo.descricao = descricao;

  modalEditar.hide();
  renderInsumos();
  carregarSelectInsumos();
  carregarSelectHistorico();
  showToast('Insumo atualizado', `${nome} foi atualizado com sucesso.`);
});

/* ══════════════════════════════════════
   MODAL EXCLUIR INSUMO
══════════════════════════════════════ */
const modalExcluir = new bootstrap.Modal(document.getElementById('modalExcluirInsumo'));
let excluirInsumoId = null;

function excluirInsumo(id, nome) {
  excluirInsumoId = id;
  document.getElementById('excluirInsumoNome').textContent = nome;
  document.getElementById('excluirInsumoId').value = id;
  modalExcluir.show();
}

document.getElementById('btnConfirmarExcluir').addEventListener('click', () => {
  const id = parseInt(document.getElementById('excluirInsumoId').value);
  const idx = insumosData.findIndex(i => i.id === id);
  if (idx === -1) return;
  const nome = insumosData[idx].nome;
  insumosData.splice(idx, 1);
  modalExcluir.hide();
  renderInsumos();
  carregarSelectInsumos();
  carregarSelectHistorico();
  showToast('Insumo excluído', `${nome} foi removido permanentemente.`, 'danger');
});

/* ══════════════════════════════════════
   TAB HISTÓRICO — Renderização
══════════════════════════════════════ */
let historicoData = [...movimentos];
let historicoFiltrados = [...historicoData];
let historicoPagina = 1;
const historicoPorPagina = 5;
let historicoOrdenacao = { col: 'data', dir: 'desc' };

function renderHistorico() {
  // Aplicar filtros
  const dataIni = document.getElementById('filtroDataIni').value;
  const dataFim = document.getElementById('filtroDataFim').value;
  const tipoMov = document.getElementById('filtroMovTipo').value;
  const insumoId = parseInt(document.getElementById('filtroMovInsumo').value) || null;

  historicoFiltrados = historicoData.filter(m => {
    if (dataIni && m.data < dataIni) return false;
    if (dataFim && m.data > dataFim) return false;
    if (tipoMov && m.tipo_movimento !== tipoMov) return false;
    if (insumoId && m.insumo_id !== insumoId) return false;
    return true;
  });

  // Ordenar
  const col = historicoOrdenacao.col;
  const dir = historicoOrdenacao.dir;
  historicoFiltrados.sort((a, b) => {
    let valA = a[col] ?? '';
    let valB = b[col] ?? '';
    if (typeof valA === 'string') valA = valA.toLowerCase();
    if (typeof valB === 'string') valB = valB.toLowerCase();
    if (valA < valB) return dir === 'asc' ? -1 : 1;
    if (valA > valB) return dir === 'asc' ? 1 : -1;
    return 0;
  });

  // Paginar
  const total = historicoFiltrados.length;
  const totalPages = Math.ceil(total / historicoPorPagina) || 1;
  if (historicoPagina > totalPages) historicoPagina = totalPages;
  const start = (historicoPagina - 1) * historicoPorPagina;
  const end = Math.min(start + historicoPorPagina, total);
  const pageItems = historicoFiltrados.slice(start, end);

  // Tabela
  const tbody = document.getElementById('tabelaHistoricoBody');
  if (pageItems.length === 0) {
    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;padding:40px;color:var(--text-light);">
      <i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:8px;"></i>Nenhuma movimentação encontrada.</td></tr>`;
  } else {
    tbody.innerHTML = pageItems.map(m => {
      const insumo = insumosData.find(i => i.id === m.insumo_id);
      const nomeInsumo = insumo ? insumo.nome : 'Insumo removido';
      const badgeClass = m.tipo_movimento === 'Entrada' ? 'entrada' : 'saida';
      return `
        <tr>
          <td>${new Date(m.data).toLocaleDateString('pt-PT')}</td>
          <td>${nomeInsumo}</td>
          <td><span class="badge-movimento ${badgeClass}"><span class="dot"></span> ${m.tipo_movimento}</span></td>
          <td>${m.quantidade}</td>
          <td>${m.stock_anterior}</td>
          <td>${m.stock_atual}</td>
          <td>${m.utilizador || '—'}</td>
        </tr>
      `;
    }).join('');
  }

  // Info e paginação
  document.getElementById('infoHistorico').textContent = `Mostrando ${total === 0 ? 0 : start + 1} - ${end} de ${total} registos`;
  const pagContainer = document.getElementById('paginacaoHistorico');
  let pagHtml = '';
  pagHtml += `<button class="page-btn" ${historicoPagina <= 1 ? 'disabled' : ''} onclick="historicoPagina--;renderHistorico();"><i class="bi bi-chevron-left"></i></button>`;
  for (let p = 1; p <= totalPages; p++) {
    pagHtml += `<button class="page-btn ${p === historicoPagina ? 'active' : ''}" onclick="historicoPagina=${p};renderHistorico();">${p}</button>`;
  }
  pagHtml += `<button class="page-btn" ${historicoPagina >= totalPages ? 'disabled' : ''} onclick="historicoPagina++;renderHistorico();"><i class="bi bi-chevron-right"></i></button>`;
  pagContainer.innerHTML = pagHtml;

  document.getElementById('countHistorico').textContent = historicoData.length;
}

/* Ordenação histórico */
document.querySelectorAll('#tabelaHistorico thead th[data-col]').forEach(th => {
  th.addEventListener('click', () => {
    const col = th.dataset.col;
    if (historicoOrdenacao.col === col) {
      historicoOrdenacao.dir = historicoOrdenacao.dir === 'asc' ? 'desc' : 'asc';
    } else {
      historicoOrdenacao.col = col;
      historicoOrdenacao.dir = 'asc';
    }
    renderHistorico();
  });
});

/* Filtros histórico */
function carregarSelectHistorico() {
  const select = document.getElementById('filtroMovInsumo');
  select.innerHTML = '<option value="">Todos os insumos</option>' +
    insumosData.map(i => `<option value="${i.id}">${i.nome}</option>`).join('');
}
carregarSelectHistorico();

document.getElementById('btnFiltrarHistorico').addEventListener('click', () => {
  historicoPagina = 1;
  renderHistorico();
});
document.getElementById('btnLimparFiltrosHistorico').addEventListener('click', () => {
  document.getElementById('filtroDataIni').value = '';
  document.getElementById('filtroDataFim').value = '';
  document.getElementById('filtroMovTipo').value = '';
  document.getElementById('filtroMovInsumo').value = '';
  historicoPagina = 1;
  renderHistorico();
});

/* ══════════════════════════════════════
   NAV ACTIVE SIDEBAR
══════════════════════════════════════ */
document.querySelectorAll('.nav-item-link').forEach(link => {
  link.addEventListener('click', function(e) {
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
   INICIALIZAÇÃO
══════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  renderInsumos();
  renderHistorico();
});
</script>

</body>
</html>
[file content end] 