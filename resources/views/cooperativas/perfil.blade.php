<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Perfil da Cooperativa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

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
    .profile-logo-icon .bi { color: inherit; }
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
       PROFILE CARD — Cooperativa
    ═══════════════════════════════════════════ */
    .profile-card {
      background: var(--card-bg); border-radius: 18px; border: 1px solid var(--border);
      padding: 26px 28px; margin-bottom: 22px;
      display: flex; align-items: flex-start; gap: 24px; flex-wrap: wrap;
    }

    /* Logo da cooperativa — quadrada com iniciais */
    .profile-logo-icon {
      width: 86px; height: 86px; border-radius: 18px;
      background: var(--primary); color: #fff;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; font-weight: 800; flex-shrink: 0;
      overflow: hidden; border: 3px solid var(--accent-lt);
      letter-spacing: -1px; font-family: 'Sora', sans-serif;
    }
    .profile-logo-icon img { width: 100%; height: 100%; object-fit: cover; }

    .profile-main { flex: 1; min-width: 260px; }
    .profile-main .p-name {
      font-family: 'Sora', sans-serif; font-size: 19px; font-weight: 700; color: var(--text-dark);
      display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .profile-main .p-sub {
      font-size: 12.5px; color: var(--text-light); margin-top: 3px;
      display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
    }
    .profile-main .p-sub span { display: flex; align-items: center; gap: 4px; }
    .profile-main .p-sub a { color: var(--primary); text-decoration: none; font-weight: 600; }

    .profile-meta {
      display: flex; gap: 22px; flex-wrap: wrap; margin-top: 16px;
    }
    .profile-meta-item { display: flex; align-items: flex-start; gap: 10px; }
    .profile-meta-item i { font-size: 15px; color: var(--primary); margin-top: 2px; }
    .profile-meta-item .pm-label { font-size: 10.5px; color: var(--text-light); text-transform: uppercase; letter-spacing: .5px; }
    .profile-meta-item .pm-value { font-size: 13px; font-weight: 600; color: var(--text-dark); margin-top: 1px; }

    /* Divisor vertical entre contactos */
    .profile-contacts {
      display: flex; flex-direction: column; justify-content: center; gap: 10px;
      padding-left: 24px; border-left: 1px solid var(--border);
      min-width: 200px; flex-shrink: 0;
    }
    .contact-row { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--text-dark); }
    .contact-row i { font-size: 14px; color: var(--primary); flex-shrink: 0; }
    .contact-row a { color: var(--primary); text-decoration: none; }
    .contact-row a:hover { text-decoration: underline; }

    .profile-actions { display: flex; gap: 10px; flex-shrink: 0; align-self: flex-start; }

    /* ═══════════════════════════════════════════
       BADGE ESTADO
    ═══════════════════════════════════════════ */
    .badge-estado {
      font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px;
      display: inline-flex; align-items: center; gap: 5px;
    }
    .badge-estado.activa   { background: #E8F5E9; color: #2E7D32; }
    .badge-estado.inactiva { background: #FFEBEE; color: #C62828; }
    .badge-estado.pendente { background: #FFF8E1; color: #F57F17; }
    .badge-estado .estado-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; }
    .badge-estado.activa .estado-dot   { background: #2E7D32; }
    .badge-estado.inactiva .estado-dot { background: #C62828; }
    .badge-estado.pendente .estado-dot { background: #F57F17; }

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
    .cfg-card-body { padding: 22px 24px; }

    /* ── TABELAS ─── */
    .mini-table-wrap { overflow-x: auto; }
    .mini-table { width: 100%; border-collapse: collapse; }
    .mini-table th {
      font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px;
      color: var(--text-light); padding: 12px 16px; background: #FAFBFA;
      border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap;
    }
    .mini-table td {
      font-size: 13.5px; color: var(--text-dark); padding: 13px 16px;
      border-bottom: 1px solid var(--border); vertical-align: middle;
    }
    .mini-table tr:last-child td { border-bottom: none; }
    .mini-table tbody tr:hover td { background: #F8FBF8; }

    /* Badges texto neutro (padrão SIAG) */
    .badge-status {
      font-size: 12px; font-weight: 500; padding: 0; background: none; border-radius: 0;
      display: inline-flex; align-items: center; gap: 4px;
    }
    .badge-status.activo, .badge-status.pago, .badge-status.disponivel,
    .badge-status.concluida, .badge-status.em_cultivo { color: #2E7D32; }
    .badge-status.inactivo, .badge-status.esgotado, .badge-status.em_atraso { color: #C62828; }
    .badge-status.pendente, .badge-status.baixo, .badge-status.pousio { color: #F57F17; }
    .badge-status .dot { width: 7px; height: 7px; border-radius: 50%; display: inline-block; }
    .badge-status.activo .dot, .badge-status.pago .dot, .badge-status.disponivel .dot,
    .badge-status.concluida .dot, .badge-status.em_cultivo .dot { background: #2E7D32; }
    .badge-status.inactivo .dot, .badge-status.esgotado .dot,
    .badge-status.em_atraso .dot { background: #C62828; }
    .badge-status.pendente .dot, .badge-status.baixo .dot,
    .badge-status.pousio .dot { background: #F57F17; }

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

    /* Avatar agricultor na tabela */
    .ag-avatar-sm {
      width: 32px; height: 32px; border-radius: 50%;
      display: inline-flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    /* Empty state pequeno */
    .mini-empty { text-align: center; padding: 36px 20px; }
    .mini-empty i { font-size: 38px; color: var(--accent); opacity: .5; display: block; margin-bottom: 10px; }
    .mini-empty p { font-size: 12.5px; color: var(--text-light); }

    /* ── CHART CARD ─── */
    .chart-card {
      background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border);
      padding: 22px 24px; margin-bottom: 20px;
    }
    .chart-card-header {
      display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;
    }
    .chart-card-header h5 {
      font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 600; color: var(--text-dark);
    }
    .chart-card-header span { font-size: 12px; color: var(--text-light); }

    /* ── Animations ─── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .anim { animation: fadeUp .4s ease both; }
    .anim-d1 { animation-delay: .05s; }
    .anim-d2 { animation-delay: .10s; }
    .anim-d3 { animation-delay: .15s; }
    .anim-d4 { animation-delay: .20s; }

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
    body.dark-mode .mini-table th { background: #172518; }
    body.dark-mode .mini-table tbody tr:hover td { background: #1a2a1c; }
    body.dark-mode .profile-contacts { border-color: rgba(255,255,255,.07); }

    /* Responsive */
    @media (max-width: 900px) {
      .settings-wrap { flex-direction: column; }
      .settings-nav { width: 100%; position: static; display: flex; flex-wrap: wrap; gap: 4px; padding: 8px; }
      .settings-nav-item { width: auto; padding: 8px 12px; font-size: 12.5px; }
      .profile-contacts { border-left: none; border-top: 1px solid var(--border); padding-left: 0; padding-top: 16px; width: 100%; }
    }
    @media (max-width: 768px) {
      :root { --sidebar-w: 240px; }
      body:not(.sidebar-hidden) #sidebar { box-shadow: 4px 0 20px rgba(0,0,0,.2); }
      body.default #sidebar { width: 0; }
      body.default #main    { margin-left: 0; }
      body.default #topbar  { left: 0; }
      .content-inner { padding: 16px; }
      .profile-card { padding: 20px; }
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
    <a href="#" class="nav-item-link active" data-label="Cooperativa"><i class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
    <a href="{{ route('agricultores.index') }}" class="nav-item-link" data-label="Agricultores"><i class="bi bi-person-badge-fill"></i><span class="nav-label">Agricultores</span></a>

    <div class="nav-section-title">Agrícola</div>
    <a href="#" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span class="nav-label">Safras</span></a>
    <a href="#" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span class="nav-label">Talhões</span></a>
    <a href="#" class="nav-item-link" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span class="nav-label">Insumos</span></a>

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
    <span class="topbar-title">{{ $cooperativa->nome ?? 'Cooperativa Agrícola de Viana' }}</span>
    <span class="topbar-subtitle">
      <i class="bi bi-geo-alt-fill" style="font-size:10px;"></i>
      {{ $cooperativa->municipio ?? 'Viana' }}, {{ $cooperativa->provincia ?? 'Luanda' }}
    </span>
  </div>
  <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
    <ol class="breadcrumb mb-0" style="font-size:12.5px;">
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">Cooperativas</a></li>
      <li class="breadcrumb-item active" style="color:var(--text-light);">Perfil</li>
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
          <i class="bi bi-arrow-left"></i> Voltar à lista de Cooperativas
        </a>
        <h1>Gestão da Cooperativa</h1>
        <p>Dados completos, agricultores, produção e histórico financeiro da cooperativa</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn-outline-green" id="btnImprimirFicha">
          <i class="bi bi-printer-fill"></i> Imprimir Ficha
        </button>
        <button class="btn-green" id="btnEditarCooperativa">
          <i class="bi bi-pencil-fill"></i> Editar Cooperativa
        </button>
      </div>
    </div>

    <!-- ══ PROFILE CARD — Cooperativa ══ -->
    <div class="profile-card anim anim-d1">

      <!-- Logomarca / iniciais -->
      <div class="profile-logo-icon" id="coopLogo">
        @if(!empty($cooperativa->foto ?? null))
          <img src="{{ asset('storage/cooperativas/' . $cooperativa->foto) }}" alt="Logo">
        @else
          CAV
        @endif
      </div>

      <!-- Dados principais -->
      <div class="profile-main">
        <div class="p-name">
          <span>{{ $cooperativa->nome ?? 'Cooperativa Agrícola de Viana' }}</span>
          <span class="badge-estado activa" id="coopEstadoBadge">
            <span class="estado-dot"></span>Activa
          </span>
        </div>
        <div class="p-sub">
          <span><i class="bi bi-hash" style="font-size:12px;"></i> NIF: {{ $cooperativa->nif ?? '5401234567' }}</span>
          <span style="color:var(--border);">|</span>
          <span><i class="bi bi-calendar3" style="font-size:12px;"></i> Fundada em {{ isset($cooperativa->data_fundacao) ? \Carbon\Carbon::parse($cooperativa->data_fundacao)->format('d/m/Y') : '15/03/2018' }}</span>
          <span style="color:var(--border);">|</span>
          <span><i class="bi bi-flower2" style="font-size:12px;"></i> Safra: {{ $cooperativa->safra ?? '2024/2025' }}</span>
        </div>

        <div class="profile-meta">
          <div class="profile-meta-item">
            <i class="bi bi-people-fill"></i>
            <div>
              <div class="pm-label">Total de Agricultores</div>
              <div class="pm-value">{{ $cooperativa->numero_socios ?? '348' }}</div>
            </div>
          </div>
          <div class="profile-meta-item">
            <i class="bi bi-map-fill"></i>
            <div>
              <div class="pm-label">Área Cultivável (ha)</div>
              <div class="pm-value">{{ $cooperativa->area_total_cultivada ?? '1.240' }} ha</div>
            </div>
          </div>
          <div class="profile-meta-item">
            <i class="bi bi-flower2"></i>
            <div>
              <div class="pm-label">Principal Cultura</div>
              <div class="pm-value">{{ $cooperativa->principal_cultura ?? 'Milho' }}</div>
            </div>
          </div>
          <div class="profile-meta-item">
            <i class="bi bi-grid-3x3-gap-fill"></i>
            <div>
              <div class="pm-label">Nº de Talhões</div>
              <div class="pm-value">{{ $cooperativa->numero_talhoes ?? '86' }}</div>
            </div>
          </div>
          <div class="profile-meta-item">
            <i class="bi bi-geo-alt-fill"></i>
            <div>
              <div class="pm-label">Localização</div>
              <div class="pm-value">{{ $cooperativa->municipio ?? 'Viana' }}, {{ $cooperativa->provincia ?? 'Luanda' }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contactos -->
      <div class="profile-contacts">
        <div class="contact-row">
          <i class="bi bi-telephone-fill"></i>
          <span>{{ $cooperativa->telefone ?? '+244 923 456 789' }}</span>
        </div>
        <div class="contact-row">
          <i class="bi bi-envelope-fill"></i>
          <a href="mailto:{{ $cooperativa->email ?? 'geral@coop-viana.ao' }}">
            {{ $cooperativa->email ?? 'geral@coop-viana.ao' }}
          </a>
        </div>
        @if(!empty($cooperativa->website ?? 'https://coop-viana.ao'))
        <div class="contact-row">
          <i class="bi bi-globe2"></i>
          <a href="{{ $cooperativa->website ?? 'https://coop-viana.ao' }}" target="_blank" rel="noopener">
            {{ $cooperativa->website ?? 'coop-viana.ao' }}
          </a>
        </div>
        @endif
        <div class="contact-row" style="margin-top:4px;font-size:12px;color:var(--text-light);">
          <i class="bi bi-geo-alt" style="color:var(--text-light);"></i>
          <span>{{ $cooperativa->endereco ?? 'Km 12, Estrada de Viana, Luanda Sul' }}</span>
        </div>
      </div>

    </div>
    <!-- /profile-card -->

    <!-- Stat Cards -->
    <div class="row g-3 mb-4 anim anim-d2">
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon green"><i class="bi bi-people-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Total de Agricultores</div>
            <div class="s-value">{{ $cooperativa->numero_socios ?? '348' }}</div>
            <span class="stat-badge up"><i class="bi bi-arrow-up"></i> +12 este mês</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon amber"><i class="bi bi-box-seam-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Produção Total (ton)</div>
            <div class="s-value">{{ $cooperativa->producao_estimada ?? '1.153' }}</div>
            <span class="stat-badge up"><i class="bi bi-arrow-up"></i> Safra 24/25</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="bi bi-cart-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Vendas Totais (Kz)</div>
            <div class="s-value">4.2M</div>
            <span class="stat-badge info"><i class="bi bi-info-circle"></i> Acumulado 24/25</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon purple"><i class="bi bi-droplet-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Insumos Distribuídos</div>
            <div class="s-value">142</div>
            <span class="stat-badge info"><i class="bi bi-box-arrow-in-down"></i> Última: 12 Mai</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings-style layout -->
    <div class="settings-wrap anim anim-d3">

      <!-- ── VERTICAL NAV ── -->
      <nav class="settings-nav">
        <button class="settings-nav-item active" data-tab="agricultores">
          <i class="bi bi-person-badge-fill"></i> Agricultores <span class="nav-count">348</span>
        </button>
        <button class="settings-nav-item" data-tab="colheitas">
          <i class="bi bi-flower2"></i> Colheitas <span class="nav-count">24</span>
        </button>
        <button class="settings-nav-item" data-tab="insumos">
          <i class="bi bi-box-seam-fill"></i> Insumos <span class="nav-count">142</span>
        </button>
        <button class="settings-nav-item" data-tab="talhoes">
          <i class="bi bi-map-fill"></i> Talhões <span class="nav-count">86</span>
        </button>
        <button class="settings-nav-item" data-tab="receitas">
          <i class="bi bi-cash-coin"></i> Receitas <span class="nav-count">38</span>
        </button>
        <button class="settings-nav-item" data-tab="vendas">
          <i class="bi bi-cart-fill"></i> Vendas <span class="nav-count">52</span>
        </button>
        <button class="settings-nav-item" data-tab="saidas">
          <i class="bi bi-arrow-down-circle-fill"></i> Saídas / Despesas <span class="nav-count">19</span>
        </button>
      </nav>

      <!-- ── CONTENT PANELS ── -->
      <div class="settings-content">

        <!-- ════════════════════════
             TAB 1 — AGRICULTORES
        ════════════════════════ -->
        <div class="settings-panel active" id="tab-agricultores">

          <!-- Mini gráfico de distribuição por cargo -->
          <div class="chart-card anim">
            <div class="chart-card-header">
              <h5><i class="bi bi-bar-chart-fill me-2" style="color:var(--primary);"></i>Distribuição por Cargo</h5>
              <span>Safra 2024/25</span>
            </div>
            <div id="chart-cargos" style="min-height:160px;"></div>
          </div>

          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon green"><i class="bi bi-person-badge-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Agricultores Associados</div>
                  <div class="cfg-card-sub">Todos os agricultores vinculados a esta cooperativa</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoAgricultor">
                <i class="bi bi-person-plus-fill"></i> Associar Agricultor
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Agricultor</th>
                    <th>BI / Contacto</th>
                    <th>Cargo</th>
                    <th>Talhões</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <div style="display:flex;align-items:center;gap:10px;">
                        <div class="ag-avatar-sm" style="background:#1B5E20;">JF</div>
                        <div>
                          <div style="font-weight:600;">João Manuel Ferreira</div>
                          <div style="font-size:11px;color:var(--text-light);">Assoc. desde 10/03/2019</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div style="font-size:13px;">004512378LA041</div>
                      <div style="font-size:11.5px;color:var(--text-light);">+244 923 111 222</div>
                    </td>
                    <td><span style="font-size:12px;font-weight:500;color:var(--text-mid);">Agricultor</span></td>
                    <td><strong>3</strong> talhões · 2.4 ha</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Activo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver perfil" onclick="showToast('Perfil do Agricultor','Navegue até ao perfil completo do agricultor.')"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar" onclick="showToast('Editar Agricultor','Funcionalidade em desenvolvimento.')"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Desassociar" onclick="showToast('Desassociar','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-person-dash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div style="display:flex;align-items:center;gap:10px;">
                        <div class="ag-avatar-sm" style="background:#1565C0;">MS</div>
                        <div>
                          <div style="font-weight:600;">Maria das Dores Silva</div>
                          <div style="font-size:11px;color:var(--text-light);">Assoc. desde 22/06/2018</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div style="font-size:13px;">006234890LA042</div>
                      <div style="font-size:11.5px;color:var(--text-light);">+244 912 333 444</div>
                    </td>
                    <td><span style="font-size:12px;font-weight:500;color:var(--text-mid);">Dirigente</span></td>
                    <td><strong>2</strong> talhões · 1.8 ha</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Activo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver perfil" onclick="showToast('Perfil do Agricultor','Navegue até ao perfil completo.')"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar" onclick="showToast('Editar Agricultor','Funcionalidade em desenvolvimento.')"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Desassociar" onclick="showToast('Desassociar','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-person-dash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <div style="display:flex;align-items:center;gap:10px;">
                        <div class="ag-avatar-sm" style="background:#F57F17;">AL</div>
                        <div>
                          <div style="font-weight:600;">António Lopes Costa</div>
                          <div style="font-size:11px;color:var(--text-light);">Assoc. desde 14/02/2021</div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div style="font-size:13px;">009871230LA043</div>
                      <div style="font-size:11.5px;color:var(--text-light);">+244 935 555 666</div>
                    </td>
                    <td><span style="font-size:12px;font-weight:500;color:var(--text-mid);">Sócio</span></td>
                    <td><strong>1</strong> talhão · 0.6 ha</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Activo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver perfil" onclick="showToast('Perfil do Agricultor','Navegue até ao perfil completo.')"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar" onclick="showToast('Editar Agricultor','Funcionalidade em desenvolvimento.')"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Desassociar" onclick="showToast('Desassociar','Funcionalidade em desenvolvimento.','danger')"><i class="bi bi-person-dash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div style="padding:12px 24px;border-top:1px solid var(--border);font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i>
              A mostrar 3 de 348 agricultores. Para gestão completa aceda ao módulo <a href="{{ route('agricultores.index') }}" style="color:var(--primary);font-weight:600;">Agricultores</a>.
            </div>
          </div>
        </div>
        <!-- /TAB AGRICULTORES -->

        <!-- ════════════════════════
             TAB 2 — COLHEITAS
        ════════════════════════ -->
        <div class="settings-panel" id="tab-colheitas">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon green"><i class="bi bi-flower2"></i></div>
                <div>
                  <div class="cfg-card-title">Colheitas da Cooperativa</div>
                  <div class="cfg-card-sub">Total agregado de todas as colheitas dos agricultores associados</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaColheita">
                <i class="bi bi-plus-lg"></i> Nova Colheita
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Cultura</th>
                    <th>Agricultor</th>
                    <th>Talhão</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Qualidade</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>Milho</td>
                    <td>João Ferreira</td>
                    <td>Talhão A1</td>
                    <td>02/05/2026</td>
                    <td><strong>1.250 kg</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Boa</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>Feijão</td>
                    <td>Maria Silva</td>
                    <td>Talhão B2</td>
                    <td>18/04/2026</td>
                    <td><strong>890 kg</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Razoável</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>Mandioca</td>
                    <td>António Costa</td>
                    <td>Talhão C1</td>
                    <td>05/03/2026</td>
                    <td><strong>2.100 kg</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Boa</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>Milho</td>
                    <td>Rosa Neto</td>
                    <td>Talhão D3</td>
                    <td>28/02/2026</td>
                    <td><strong>980 kg</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Boa</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-flower2 me-1" style="color:var(--primary);"></i>Hortícolas</td>
                    <td>Paulo Dias</td>
                    <td>Talhão E2</td>
                    <td>10/02/2026</td>
                    <td><strong>450 kg</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Razoável</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /TAB COLHEITAS -->

        <!-- ════════════════════════
             TAB 3 — INSUMOS
        ════════════════════════ -->
        <div class="settings-panel" id="tab-insumos">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon amber"><i class="bi bi-box-seam-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Insumos Agrícolas</div>
                  <div class="cfg-card-sub">Entradas e distribuição de insumos pelos agricultores da cooperativa</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoInsumo">
                <i class="bi bi-plus-lg"></i> Registar Insumo
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Insumo</th>
                    <th>Categoria</th>
                    <th>Agricultor</th>
                    <th>Data de Entrada</th>
                    <th>Quantidade</th>
                    <th>Stock Actual</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-seedling me-1" style="color:var(--primary);"></i>Semente de Milho Híbrida</td>
                    <td>Sementes</td>
                    <td>João Ferreira</td>
                    <td>12/05/2026</td>
                    <td>25 kg</td>
                    <td><strong>25 kg</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Disponível</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-droplet-fill me-1" style="color:var(--primary);"></i>Fertilizante NPK 12-24-12</td>
                    <td>Fertilizantes</td>
                    <td>Maria Silva</td>
                    <td>02/04/2026</td>
                    <td>100 kg</td>
                    <td><strong>50 kg</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Stock Baixo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-bug-fill me-1" style="color:var(--primary);"></i>Defensivo Cipermetrina</td>
                    <td>Defensivos</td>
                    <td>Cooperativa (Geral)</td>
                    <td>20/03/2026</td>
                    <td>20 L</td>
                    <td><strong>0 L</strong></td>
                    <td><span class="badge-status inactivo"><span class="dot"></span>Esgotado</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-droplet-fill me-1" style="color:var(--primary);"></i>Ureia 46%</td>
                    <td>Fertilizantes</td>
                    <td>António Costa</td>
                    <td>28/01/2026</td>
                    <td>60 kg</td>
                    <td><strong>30 kg</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Disponível</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /TAB INSUMOS -->

        <!-- ════════════════════════
             TAB 4 — TALHÕES
        ════════════════════════ -->
        <div class="settings-panel" id="tab-talhoes">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon green"><i class="bi bi-map-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Talhões da Cooperativa</div>
                  <div class="cfg-card-sub">Todas as parcelas de terra registadas sob gestão desta cooperativa</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovoTalhao">
                <i class="bi bi-plus-lg"></i> Novo Talhão
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Designação</th>
                    <th>Agricultor</th>
                    <th>Área (ha)</th>
                    <th>Cultura Actual</th>
                    <th>Localização</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i>Talhão A1</td>
                    <td>João Ferreira</td>
                    <td><strong>1.2 ha</strong></td>
                    <td>Milho</td>
                    <td>Km 12, Viana</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Em Cultivo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i>Talhão B2</td>
                    <td>Maria Silva</td>
                    <td><strong>0.8 ha</strong></td>
                    <td>Feijão</td>
                    <td>Km 14, Viana</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Em Cultivo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i>Talhão C1</td>
                    <td>António Costa</td>
                    <td><strong>0.6 ha</strong></td>
                    <td>Mandioca</td>
                    <td>Km 10, Viana</td>
                    <td><span class="badge-status activo"><span class="dot"></span>Em Cultivo</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-map-fill me-1" style="color:var(--primary);"></i>Talhão D3</td>
                    <td>Rosa Neto</td>
                    <td><strong>0.9 ha</strong></td>
                    <td>Em pousio</td>
                    <td>Km 16, Viana</td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Pousio</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div style="padding:12px 24px;border-top:1px solid var(--border);font-size:12px;color:var(--text-light);">
              <i class="bi bi-info-circle me-1"></i>
              A mostrar 4 de 86 talhões registados nesta cooperativa.
            </div>
          </div>
        </div>
        <!-- /TAB TALHÕES -->

        <!-- ════════════════════════
             TAB 5 — RECEITAS
        ════════════════════════ -->
        <div class="settings-panel" id="tab-receitas">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon blue"><i class="bi bi-cash-coin"></i></div>
                <div>
                  <div class="cfg-card-title">Receitas da Cooperativa</div>
                  <div class="cfg-card-sub">Total de entradas financeiras — vendas, subsídios e apoios recebidos</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaReceita">
                <i class="bi bi-plus-lg"></i> Nova Receita
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Descrição</th>
                    <th>Origem</th>
                    <th>Agricultor</th>
                    <th>Data</th>
                    <th>Valor (Kz)</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-cash-coin me-1" style="color:var(--primary);"></i>Venda de Milho (Lote Mai)</td>
                    <td>Comercial</td>
                    <td>João Ferreira</td>
                    <td>03/05/2026</td>
                    <td><strong>96.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-cash-coin me-1" style="color:var(--primary);"></i>Venda de Feijão</td>
                    <td>Comercial</td>
                    <td>Maria Silva</td>
                    <td>22/04/2026</td>
                    <td><strong>55.500</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-gift-fill me-1" style="color:var(--primary);"></i>Subsídio Agrícola Estatal</td>
                    <td>Apoio Público</td>
                    <td>Cooperativa (Geral)</td>
                    <td>10/03/2026</td>
                    <td><strong>250.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-cash-coin me-1" style="color:var(--primary);"></i>Venda de Mandioca</td>
                    <td>Comercial</td>
                    <td>António Costa</td>
                    <td>08/03/2026</td>
                    <td><strong>18.900</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Pendente</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-bank2 me-1" style="color:var(--primary);"></i>Crédito Bancário Agricola</td>
                    <td>Financiamento</td>
                    <td>Cooperativa (Geral)</td>
                    <td>15/01/2026</td>
                    <td><strong>500.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /TAB RECEITAS -->

        <!-- ════════════════════════
             TAB 6 — VENDAS
        ════════════════════════ -->
        <div class="settings-panel" id="tab-vendas">
          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon amber"><i class="bi bi-cart-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Histórico de Vendas</div>
                  <div class="cfg-card-sub">Todas as vendas de produtos realizadas pela cooperativa e seus agricultores</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaVenda">
                <i class="bi bi-plus-lg"></i> Nova Venda
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Produto</th>
                    <th>Agricultor</th>
                    <th>Comprador</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Valor Total (Kz)</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i>Milho (saco 50kg)</td>
                    <td>João Ferreira</td>
                    <td>Mercado de Viana</td>
                    <td>03/05/2026</td>
                    <td>8 sacos</td>
                    <td><strong>96.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Concluída</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver detalhes"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i>Feijão (saco 25kg)</td>
                    <td>Maria Silva</td>
                    <td>Comerciante Local</td>
                    <td>22/04/2026</td>
                    <td>3 sacos</td>
                    <td><strong>55.500</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Concluída</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver detalhes"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-basket-fill me-1" style="color:var(--primary);"></i>Mandioca (saco 30kg)</td>
                    <td>António Costa</td>
                    <td>Cooperativa Viana</td>
                    <td>08/03/2026</td>
                    <td>2 sacos</td>
                    <td><strong>18.900</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Pendente</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn view" title="Ver detalhes"><i class="bi bi-eye-fill"></i></button>
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /TAB VENDAS -->

        <!-- ════════════════════════
             TAB 7 — SAÍDAS / DESPESAS
        ════════════════════════ -->
        <div class="settings-panel" id="tab-saidas">

          <!-- Resumo de despesas -->
          <div class="chart-card anim">
            <div class="chart-card-header">
              <h5><i class="bi bi-pie-chart-fill me-2" style="color:var(--primary);"></i>Distribuição de Despesas</h5>
              <span>Safra 2024/25</span>
            </div>
            <div id="chart-despesas" style="min-height:200px;"></div>
          </div>

          <div class="cfg-card anim">
            <div class="cfg-card-header">
              <div class="cfg-card-header-left">
                <div class="cfg-card-icon red"><i class="bi bi-arrow-down-circle-fill"></i></div>
                <div>
                  <div class="cfg-card-title">Saídas e Despesas</div>
                  <div class="cfg-card-sub">Registo de todas as despesas operacionais e financeiras da cooperativa</div>
                </div>
              </div>
              <button class="btn-green" style="padding:8px 14px;font-size:12.5px;" id="btnNovaSaida">
                <i class="bi bi-plus-lg"></i> Registar Despesa
              </button>
            </div>
            <div class="mini-table-wrap">
              <table class="mini-table">
                <thead>
                  <tr>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Fornecedor</th>
                    <th>Data</th>
                    <th>Valor (Kz)</th>
                    <th>Estado</th>
                    <th style="text-align:center;">Acções</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><i class="bi bi-droplet-fill me-1" style="color:#F57F17;"></i>Compra de Fertilizantes NPK</td>
                    <td>Insumos</td>
                    <td>AgroViana Lda.</td>
                    <td>28/04/2026</td>
                    <td><strong>85.400</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-truck-fill me-1" style="color:#F57F17;"></i>Transporte de Produtos</td>
                    <td>Logística</td>
                    <td>TransViana S.A.</td>
                    <td>15/04/2026</td>
                    <td><strong>45.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-gear-fill me-1" style="color:#F57F17;"></i>Manutenção de Maquinaria</td>
                    <td>Equipamentos</td>
                    <td>MecAgro Luanda</td>
                    <td>02/03/2026</td>
                    <td><strong>62.800</strong></td>
                    <td><span class="badge-status inactivo"><span class="dot"></span>Em Atraso</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-archive-fill me-1" style="color:#F57F17;"></i>Arrendamento de Armazém</td>
                    <td>Instalações</td>
                    <td>ImóViana Lda.</td>
                    <td>01/01/2026</td>
                    <td><strong>33.200</strong></td>
                    <td><span class="badge-status pendente"><span class="dot"></span>Pendente</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><i class="bi bi-person-workspace me-1" style="color:#F57F17;"></i>Pagamento de Técnicos Agrícolas</td>
                    <td>Recursos Humanos</td>
                    <td>—</td>
                    <td>28/02/2026</td>
                    <td><strong>195.000</strong></td>
                    <td><span class="badge-status activo"><span class="dot"></span>Pago</span></td>
                    <td style="text-align:center;">
                      <div style="display:flex;gap:6px;justify-content:center;">
                        <button class="action-btn edit" title="Editar"><i class="bi bi-pencil-fill"></i></button>
                        <button class="action-btn delete" title="Apagar"><i class="bi bi-trash-fill"></i></button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Resumo rodapé -->
            <div style="padding:16px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
              <div style="font-size:12px;color:var(--text-light);">
                <i class="bi bi-info-circle me-1"></i>A mostrar 5 de 19 despesas registadas nesta cooperativa.
              </div>
              <div style="display:flex;gap:24px;">
                <div style="text-align:right;">
                  <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">Total Pago</div>
                  <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#2E7D32;">Kz 325.400</div>
                </div>
                <div style="text-align:right;">
                  <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">Total Pendente</div>
                  <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#F57F17;">Kz 33.200</div>
                </div>
                <div style="text-align:right;">
                  <div style="font-size:11px;color:var(--text-light);text-transform:uppercase;letter-spacing:.5px;">Total em Atraso</div>
                  <div style="font-family:'Sora',sans-serif;font-size:16px;font-weight:700;color:#C62828;">Kz 62.800</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /TAB SAÍDAS -->

      </div>
      <!-- /settings-content -->

    </div>
    <!-- /settings-wrap -->

  </div><!-- /content-inner -->
</main>

<!-- Toast -->
<div class="save-toast" id="saveToast"
  style="position:fixed;bottom:28px;right:28px;z-index:9999;background:#fff;border:1px solid var(--border);border-radius:14px;padding:14px 20px;box-shadow:0 12px 36px rgba(0,0,0,.12);display:flex;align-items:center;gap:12px;transform:translateY(80px);opacity:0;transition:all .35s cubic-bezier(.34,1.56,.64,1);pointer-events:none;">
  <div class="toast-icon success" id="toastIcon" style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;background:#E8F5E9;color:#2E7D32;">
    <i class="bi bi-check-lg" id="toastIconI"></i>
  </div>
  <div class="toast-text">
    <div class="t-title" id="toastTitle" style="font-size:13.5px;font-weight:600;color:var(--text-dark);">Operação concluída</div>
    <div class="t-sub" id="toastSub" style="font-size:12px;color:var(--text-light);">Acção realizada com sucesso.</div>
  </div>
</div>

<style>
  .save-toast.show { transform: translateY(0); opacity: 1; pointer-events: all; }
  .save-toast .toast-icon.danger { background: #FFEBEE !important; color: #C62828 !important; }
</style>

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
   TOAST
══════════════════════════════════════ */
function showToast(title, sub, type = 'success') {
  const toast  = document.getElementById('saveToast');
  const icon   = document.getElementById('toastIcon');
  const iconI  = document.getElementById('toastIconI');
  document.getElementById('toastTitle').textContent = title;
  document.getElementById('toastSub').textContent   = sub;
  icon.className = 'toast-icon ' + (type === 'danger' ? 'danger' : 'success');
  iconI.className = type === 'danger' ? 'bi bi-x-lg' : 'bi bi-check-lg';
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3500);
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
      p.querySelectorAll('.anim').forEach(el => {
        el.style.animation = 'none';
        el.offsetHeight;
        el.style.animation = '';
      });
    });
    const panel = document.getElementById('tab-' + tab);
    if (panel) panel.classList.add('active');
  });
});

/* ══════════════════════════════════════
   BOTÕES DE TOPO — Placeholder
══════════════════════════════════════ */
document.getElementById('btnEditarCooperativa').addEventListener('click', () => {
  showToast('Editar Cooperativa', 'Abra a lista de Cooperativas para editar os dados completos.');
});
document.getElementById('btnImprimirFicha').addEventListener('click', () => {
  showToast('Ficha da Cooperativa', 'Geração de PDF será implementada na próxima sprint.');
});

/* Botões de acção nas tabs — placeholder */
['btnNovoAgricultor','btnNovaColheita','btnNovoInsumo','btnNovoTalhao',
 'btnNovaReceita','btnNovaVenda','btnNovaSaida'].forEach(id => {
  const el = document.getElementById(id);
  if (el) el.addEventListener('click', () => {
    showToast('Funcionalidade em desenvolvimento', 'Este módulo será implementado na próxima sprint.');
  });
});

/* ══════════════════════════════════════
   APEXCHARTS — Gráfico de cargos
══════════════════════════════════════ */
new ApexCharts(document.getElementById('chart-cargos'), {
  chart: { type: 'bar', height: 160, toolbar: { show: false }, fontFamily: 'DM Sans, sans-serif' },
  series: [{ name: 'Agricultores', data: [198, 62, 55, 33] }],
  xaxis: { categories: ['Agricultores', 'Sócios', 'Dirigentes', 'Técnicos'],
    labels: { style: { fontSize: '11px', colors: '#8FA894' } }, axisBorder: { show: false }, axisTicks: { show: false } },
  yaxis: { labels: { style: { fontSize: '11px', colors: '#8FA894' } } },
  colors: ['#2E7D32'],
  plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
  dataLabels: { enabled: false },
  grid: { borderColor: '#F0F4F0', strokeDashArray: 4 },
  tooltip: { y: { formatter: v => v + ' agricultores' } }
}).render();

/* ══════════════════════════════════════
   APEXCHARTS — Gráfico de despesas (donut)
══════════════════════════════════════ */
new ApexCharts(document.getElementById('chart-despesas'), {
  chart: { type: 'donut', height: 200, fontFamily: 'DM Sans, sans-serif' },
  series: [195000, 85400, 62800, 45000, 33200],
  labels: ['Recursos Humanos', 'Insumos', 'Equipamentos', 'Logística', 'Instalações'],
  colors: ['#1B5E20','#2E7D32','#66BB6A','#F57F17','#C62828'],
  plotOptions: { pie: { donut: { size: '62%',
    labels: { show: true, total: { show: true, label: 'Total', color: '#4A6350',
      formatter: () => 'Kz 421,4K' } }
  } } },
  dataLabels: { enabled: false },
  legend: { position: 'right', fontSize: '11px', labels: { colors: '#4A6350' } },
  tooltip: { y: { formatter: v => 'Kz ' + v.toLocaleString('pt-AO') } }
}).render();
</script>

</body>
</html>
