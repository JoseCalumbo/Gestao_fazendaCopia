<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>SIAG – Insumos</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>

  <style>
    :root {
      --sidebar-bg:      #1B5E20;
      --sidebar-hover:   #2E7D32;
      --sidebar-active:  #2E7D32;
      --accent:          #66BB6A;
      --accent-lt:       #E8F5E9;
      --primary:         #2E7D32;
      --text-dark:       #1C2B1E;
      --text-mid:        #4A6350;
      --text-light:      #8FA894;
      --border:          rgba(0,0,0,.07);
      --card-bg:         #ffffff;
      --page-bg:         #F4F6F4;
      --sidebar-w:       240px;
      --sidebar-w-icons: 68px;
      --topbar-h:        64px;
      --danger:          #C62828;
      --warning:         #F57F17;
      --info:            #1565C0;
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
    .sidebar-user .avatar { width: 34px; height: 34px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
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

    .topbar-toggle { background: none; border: none; font-size: 20px; color: var(--text-mid); cursor: pointer; padding: 6px; border-radius: 8px; transition: background .2s, color .2s; }
    .topbar-toggle:hover { background: var(--accent-lt); color: var(--primary); }

    .topbar-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 600; color: var(--text-dark); }

    .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 10px; }

    .topbar-icon-btn {
      width: 38px; height: 38px; border: none; background: var(--accent-lt);
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
      color: var(--primary); font-size: 17px; cursor: pointer;
      transition: background .2s, color .2s; position: relative;
    }
    .topbar-icon-btn:hover { background: var(--primary); color: #fff; }

    .notif-badge { position: absolute; top: 6px; right: 6px; width: 8px; height: 8px; background: #E53935; border-radius: 50%; border: 2px solid #fff; }

    .topbar-user {
      display: flex; align-items: center; gap: 8px; padding: 6px 12px;
      background: var(--accent-lt); border-radius: 30px; cursor: pointer; transition: background .2s;
    }
    .topbar-user:hover { background: #C8E6C9; }
    .topbar-user .t-avatar { width: 30px; height: 30px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .topbar-user .t-avatar i { color: #fff; font-size: 14px; }
    .topbar-user span { font-size: 13px; font-weight: 500; color: var(--primary); }

    .dropdown-menu-user {
      min-width: 200px; border: 1px solid var(--border); border-radius: 14px;
      box-shadow: 0 12px 36px rgba(0,0,0,.12); padding: 6px; margin-top: 8px !important;
    }
    .dropdown-menu-user .dropdown-header { font-size: 11px; font-weight: 600; letter-spacing: .8px; text-transform: uppercase; color: var(--text-light); padding: 6px 12px 4px; }
    .dropdown-menu-user .dropdown-item { font-size: 13.5px; color: var(--text-mid); border-radius: 8px; padding: 9px 12px; display: flex; align-items: center; gap: 9px; transition: background .15s, color .15s; }
    .dropdown-menu-user .dropdown-item i { font-size: 15px; color: var(--text-light); }
    .dropdown-menu-user .dropdown-item:hover { background: var(--accent-lt); color: var(--primary); }
    .dropdown-menu-user .dropdown-item:hover i { color: var(--primary); }
    .dropdown-menu-user .dropdown-divider { margin: 4px 6px; border-color: var(--border); }
    .dropdown-menu-user .item-logout { color: #C62828; }
    .dropdown-menu-user .item-logout i { color: #C62828; }
    .dropdown-menu-user .item-logout:hover { background: #FFEBEE; color: #C62828; }
    .dropdown-menu-user form { margin: 0; }
    .dropdown-menu-user form button { background: none; border: none; font-size: 13.5px; color: #C62828; border-radius: 8px; padding: 9px 12px; width: 100%; text-align: left; display: flex; align-items: center; gap: 9px; cursor: pointer; transition: background .15s; }
    .dropdown-menu-user form button:hover { background: #FFEBEE; }
    .dropdown-menu-user form button i { font-size: 15px; color: #C62828; }

    /* ═══════════════════════════════════════════
       MAIN CONTENT
    ═══════════════════════════════════════════ */
    #main { margin-left: var(--sidebar-w); padding-top: var(--topbar-h); transition: margin-left .3s ease; min-height: 100vh; }
    body.icons-only  #main { margin-left: var(--sidebar-w-icons); }
    body.sidebar-hidden #main { margin-left: 0; }

    .content-inner { padding: 28px; }

    /* ═══════════════════════════════════════════
       PAGE HEADER
    ═══════════════════════════════════════════ */
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 12px; }
    .page-header h1 { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-dark); margin-bottom: 3px; }
    .page-header p { font-size: 13.5px; color: var(--text-light); }

    .btn-green { background: var(--primary); color: #fff; border: none; border-radius: 10px; padding: 9px 18px; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: background .2s, transform .1s; text-decoration: none; }
    .btn-green:hover { background: var(--accent); color: #fff; }
    .btn-green:active { transform: scale(.97); }

    .btn-outline-green { background: transparent; color: var(--primary); border: 1.5px solid var(--primary); border-radius: 10px; padding: 8px 16px; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; transition: background .2s, color .2s; text-decoration: none; }
    .btn-outline-green:hover { background: var(--accent-lt); color: var(--primary); }

    /* ═══════════════════════════════════════════
       STAT CARDS
    ═══════════════════════════════════════════ */
    .stat-card { background: var(--card-bg); border-radius: 16px; padding: 22px 20px; border: 1px solid var(--border); display: flex; align-items: center; gap: 16px; transition: box-shadow .2s, transform .2s; }
    .stat-card:hover { box-shadow: 0 8px 28px rgba(46,125,50,.1); transform: translateY(-2px); }

    .stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 22px; }
    .stat-icon.green  { background: var(--accent-lt); color: var(--primary); }
    .stat-icon.blue   { background: #E3F2FD; color: #1565C0; }
    .stat-icon.amber  { background: #FFF8E1; color: #F57F17; }
    .stat-icon.purple { background: #EDE7F6; color: #6A1B9A; }
    .stat-icon.teal   { background: #E0F2F1; color: #00695C; }

    .stat-info .s-label { font-size: 12.5px; color: var(--text-light); margin-bottom: 4px; }
    .stat-info .s-value { font-family: 'Sora', sans-serif; font-size: 22px; font-weight: 700; color: var(--text-dark); line-height: 1; margin-bottom: 5px; }
    .stat-badge { font-size: 11.5px; font-weight: 600; padding: 3px 8px; border-radius: 30px; display: inline-flex; align-items: center; gap: 3px; }
    .stat-badge.up   { background: #E8F5E9; color: #2E7D32; }
    .stat-badge.info { background: #E3F2FD; color: #1565C0; }
    .stat-badge.warn { background: #FFF8E1; color: #F57F17; }
    .stat-badge.purple { background: #EDE7F6; color: #6A1B9A; }

    /* ═══════════════════════════════════════════
       TABLE CARD
    ═══════════════════════════════════════════ */
    .table-card { background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border); overflow: hidden; }
    .table-card-header { padding: 18px 24px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); flex-wrap: wrap; gap: 12px; }
    .table-card-header h5 { font-family: 'Sora', sans-serif; font-size: 15px; font-weight: 600; color: var(--text-dark); }

    .search-filter-bar { padding: 14px 24px; border-bottom: 1px solid var(--border); display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
    .search-wrap { flex: 1; min-width: 220px; position: relative; }
    .search-wrap i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-light); font-size: 14px; pointer-events: none; }
    .search-input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 14px 10px 36px; font-size: 13.5px; color: var(--text-dark); background: #FAFAF9; outline: none; font-family: 'DM Sans', sans-serif; transition: border-color .2s, box-shadow .2s; }
    .search-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(46,125,50,.1); background: #fff; }
    .search-input::placeholder { color: #C3B8B4; }

    .filter-select { border: 1.5px solid var(--border); border-radius: 10px; padding: 10px 32px 10px 14px; font-size: 13.5px; color: var(--text-dark); background: #FAFAF9; appearance: none; cursor: pointer; outline: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; transition: border-color .2s; min-width: 150px; }
    .filter-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(46,125,50,.1); }

    /* Insumos Table */
    .insumo-table { width: 100%; border-collapse: collapse; }
    .insumo-table th { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: var(--text-light); padding: 12px 20px; background: #FAFBFA; border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
    .insumo-table td { font-size: 13.5px; color: var(--text-dark); padding: 14px 20px; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .insumo-table tr:last-child td { border-bottom: none; }
    .insumo-table tbody tr:hover td { background: #F8FBF8; }

    /* Insumo icon avatar */
    .insumo-avatar { width: 40px; height: 40px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
    .insumo-cell { display: flex; align-items: center; gap: 12px; }
    .insumo-cell .insumo-nome { font-weight: 600; font-size: 14px; }
    .insumo-cell .insumo-id  { font-size: 11.5px; color: var(--text-light); margin-top: 1px; }

    /* Badges */
    .badge-tipo {
      font-size: 11px; font-weight: 600; padding: 4px 11px; border-radius: 30px; display: inline-flex; align-items: center; gap: 5px;
    }
    .badge-tipo.fertilizante { background: var(--accent-lt); color: var(--primary); }
    .badge-tipo.semente      { background: #FFF8E1; color: #F57F17; }
    .badge-tipo.mecanico     { background: #E3F2FD; color: #1565C0; }
    .badge-tipo.outro        { background: #EDE7F6; color: #6A1B9A; }

    .badge-estado { font-size: 11px; font-weight: 600; padding: 4px 11px; border-radius: 30px; }
    .badge-estado.activo   { background: #E8F5E9; color: #2E7D32; }
    .badge-estado.inactivo { background: #FFEBEE; color: #C62828; }

    /* Stock indicator */
    .stock-bar { height: 5px; border-radius: 5px; background: var(--border); overflow: hidden; margin-top: 5px; min-width: 80px; }
    .stock-fill { height: 100%; border-radius: 5px; transition: width .3s; }
    .stock-fill.ok      { background: #66BB6A; }
    .stock-fill.warning { background: #F57F17; }
    .stock-fill.critical{ background: #C62828; }

    /* Action buttons */
    .action-btn { width: 32px; height: 32px; border: none; border-radius: 9px; display: inline-flex; align-items: center; justify-content: center; font-size: 14px; cursor: pointer; transition: background .15s, color .15s; }
    .action-btn.edit   { background: var(--accent-lt); color: var(--primary); }
    .action-btn.edit:hover   { background: var(--primary); color: #fff; }
    .action-btn.delete { background: #FFEBEE; color: #C62828; }
    .action-btn.delete:hover { background: #C62828; color: #fff; }
    .action-btn.view   { background: #EDE7F6; color: #6A1B9A; }
    .action-btn.view:hover   { background: #6A1B9A; color: #fff; }

    /* Pagination */
    .table-footer { padding: 14px 24px; display: flex; align-items: center; justify-content: space-between; border-top: 1px solid var(--border); flex-wrap: wrap; gap: 10px; }
    .table-footer span { font-size: 12.5px; color: var(--text-light); }
    .pagination-btns { display: flex; gap: 6px; }
    .page-btn { min-width: 34px; height: 34px; padding: 0 10px; border: 1.5px solid var(--border); border-radius: 9px; background: #fff; font-size: 13px; color: var(--text-mid); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all .15s; font-family: 'DM Sans', sans-serif; }
    .page-btn:hover { border-color: var(--primary); color: var(--primary); }
    .page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); }

    /* ═══════════════════════════════════════════
       EMPTY STATE
    ═══════════════════════════════════════════ */
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 52px; color: var(--accent); opacity: .5; display: block; margin-bottom: 16px; }
    .empty-state h6 { font-family: 'Sora', sans-serif; font-size: 16px; color: var(--text-dark); margin-bottom: 6px; }
    .empty-state p { font-size: 13px; color: var(--text-light); }

    /* ═══════════════════════════════════════════
       MODAL
    ═══════════════════════════════════════════ */
    .modal-insumo { max-width: 680px; }
    .modal-insumo .modal-content { border: none; border-radius: 18px; box-shadow: 0 24px 64px rgba(0,0,0,.15); overflow: hidden; }

    .modal-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: linear-gradient(135deg, var(--sidebar-bg) 0%, var(--primary) 100%); }
    .modal-header .modal-title { font-family: 'Sora', sans-serif; font-size: 16px; font-weight: 700; color: #fff; }
    .modal-header .btn-close { filter: brightness(0) invert(1); opacity: .8; }
    .modal-header .btn-close:hover { opacity: 1; }
    .modal-header-icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,.2); display: flex; align-items: center; justify-content: center; font-size: 17px; color: #fff; flex-shrink: 0; }

    .modal-body { background: var(--page-bg); padding: 22px; overflow-y: auto; max-height: calc(100vh - 220px); }
    .modal-body::-webkit-scrollbar { width: 4px; }
    .modal-body::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 4px; }

    .modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); background: #fff; }

    .mf-card { background: var(--card-bg); border-radius: 14px; border: 1px solid var(--border); padding: 20px 22px; margin-bottom: 16px; }
    .mf-section-title { font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--text-light); margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 8px; }
    .mf-section-title i { font-size: 13px; color: var(--primary); }

    .cfg-label { display: block; font-size: 12.5px; font-weight: 600; color: var(--text-mid); margin-bottom: 6px; letter-spacing: .2px; }
    .cfg-input { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 11px 14px; font-size: 13.5px; color: var(--text-dark); background: #FAFAF9; transition: border-color .2s, box-shadow .2s; font-family: 'DM Sans', sans-serif; outline: none; }
    .cfg-input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(46,125,50,.1); background: #fff; }
    .cfg-input::placeholder { color: #C3B8B4; }
    .cfg-input[readonly] { background: #F5F5F5; color: var(--text-light); cursor: not-allowed; }

    .cfg-select { width: 100%; border: 1.5px solid var(--border); border-radius: 10px; padding: 11px 32px 11px 14px; font-size: 13.5px; color: var(--text-dark); background: #FAFAF9; appearance: none; cursor: pointer; outline: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238FA894' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; transition: border-color .2s; font-family: 'DM Sans', sans-serif; }
    .cfg-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(46,125,50,.1); }

    .cfg-helper { font-size: 11.5px; color: var(--text-light); margin-top: 5px; }

    /* Toast */
    .save-toast { position: fixed; bottom: 28px; right: 28px; z-index: 9999; background: #fff; border: 1px solid var(--border); border-radius: 14px; padding: 14px 20px; box-shadow: 0 12px 36px rgba(0,0,0,.12); display: flex; align-items: center; gap: 12px; transform: translateY(80px); opacity: 0; transition: all .35s cubic-bezier(.34,1.56,.64,1); pointer-events: none; }
    .save-toast.show { transform: translateY(0); opacity: 1; pointer-events: all; }
    .save-toast .toast-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .save-toast .toast-icon.success { background: #E8F5E9; color: #2E7D32; }
    .save-toast .toast-icon.danger  { background: #FFEBEE; color: #C62828; }
    .save-toast .toast-text .t-title { font-size: 13.5px; font-weight: 600; color: var(--text-dark); }
    .save-toast .toast-text .t-sub   { font-size: 12px; color: var(--text-light); }

    /* Animations */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .anim    { animation: fadeUp .4s ease both; }
    .anim-d1 { animation-delay: .05s; }
    .anim-d2 { animation-delay: .10s; }
    .anim-d3 { animation-delay: .15s; }
    .anim-d4 { animation-delay: .20s; }

    /* Dark mode */
    body.dark-mode { --card-bg: #1e2a20; --page-bg: #141d15; --text-dark: #e8f0e9; --text-mid: #9ab89e; --text-light: #6a8a6e; --border: rgba(255,255,255,.07); }
    body.dark-mode #topbar { background: #1e2a20; border-color: rgba(255,255,255,.06); }
    body.dark-mode .topbar-title { color: #e8f0e9; }
    body.dark-mode .topbar-user { background: rgba(102,187,106,.15); }
    body.dark-mode .topbar-user span { color: #66BB6A; }
    body.dark-mode .topbar-icon-btn { background: rgba(102,187,106,.12); }
    body.dark-mode .insumo-table th { background: #172518; }
    body.dark-mode .insumo-table tbody tr:hover td { background: #1a2a1c; }
    body.dark-mode .search-input, body.dark-mode .filter-select, body.dark-mode .cfg-input, body.dark-mode .cfg-select { background: #172518; color: #e8f0e9; border-color: rgba(255,255,255,.1); }
    body.dark-mode .modal-body { background: #1a2a1c; }
    body.dark-mode .mf-card { background: #1e2a20; border-color: rgba(255,255,255,.07); }
    body.dark-mode .modal-footer { background: #1e2a20; border-color: rgba(255,255,255,.07); }

    /* Responsive */
    @media (max-width: 768px) {
      :root { --sidebar-w: 240px; }
      body:not(.sidebar-hidden) #sidebar { box-shadow: 4px 0 20px rgba(0,0,0,.2); }
      body.default #sidebar { width: 0; }
      body.default #main    { margin-left: 0; }
      body.default #topbar  { left: 0; }
      .content-inner { padding: 16px; }
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
        <g fill="#fff" stroke="#fff" stroke-width="1.5" stroke-linejoin="round" stroke-linecap="round">
          <circle cx="118" cy="188" r="48" fill="none" stroke-width="6" />
          <circle cx="118" cy="188" r="35" fill="none" stroke-width="4.5" />
          <circle cx="118" cy="188" r="16" fill="#fff" />
          <path d="M118 135L118 144M118 232L118 241M65 188L74 188M162 188L171 188M81 151L88 157M155 219L162 225M81 225L88 219M155 151L162 157" stroke-width="6" />
          <path d="M68 185C68 140,108 120,160 128C171 132,174 144,174 151" fill="none" stroke-width="6" />
          <circle cx="231" cy="204" r="26" fill="none" stroke-width="5" />
          <circle cx="231" cy="204" r="10" fill="#fff" />
          <path d="M117 125L117 105C117 102,120 99,125 99L176 99C181 99,184 102,185 107L202 157L176 157" fill="none" stroke-width="6" />
          <path d="M144 99L144 128L187 128" fill="none" stroke-width="4" />
          <path d="M174 151L246 156C252 156,254 159,254 165L254 197L202 197Z" fill="#fff" />
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
    <a href="/dashboard" class="nav-item-link" data-label="Dashboard"><i class="bi bi-grid-1x2-fill"></i><span class="nav-label">Dashboard</span></a>
    <a href="{{ route('cooperativas') }}" class="nav-item-link" data-label="Cooperativa"><i class="bi bi-building"></i><span class="nav-label">Cooperativa</span></a>
    <a href="{{ route('agricultores.index')}}" class="nav-item-link" data-label="Agricultores"><i class="bi bi-people-fill"></i><span class="nav-label">Agricultores</span></a>

    <div class="nav-section-title">Agrícola</div>
    <a href="{{route('safras.painel')}}" class="nav-item-link" data-label="Safras"><i class="bi bi-flower2"></i><span class="nav-label">Safras</span></a>
    <a href="#" class="nav-item-link" data-label="Talhões"><i class="bi bi-map-fill"></i><span class="nav-label">Talhões</span></a>
    <a href="{{ route('insumos.index')}}" class="nav-item-link active" data-label="Insumos"><i class="bi bi-box-seam-fill"></i><span class="nav-label">Insumos</span></a>

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
    <div class="avatar"><i class="bi bi-person-fill"></i></div>
    <div class="user-info">
      <div class="u-name">{{ Auth::check() ? Auth::user()->name : 'Admin SIAG' }}</div>
      <div class="u-role">{{ Auth::check() ? Auth::user()->nivel : 'Gestor' }} · Viana</div>
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
  <span class="topbar-title">Insumos</span>
  <nav aria-label="breadcrumb" class="d-none d-md-flex ms-3">
    <ol class="breadcrumb mb-0" style="font-size:12.5px;">
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">SIAG</a></li>
      <li class="breadcrumb-item"><a href="#" style="color:var(--primary);text-decoration:none;">Agrícola</a></li>
      <li class="breadcrumb-item active" style="color:var(--text-light);">Insumos</li>
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
          <img src="{{ Auth::check() ? Auth::user()->foto_url : asset('uploads/users/default-user.png') }}"
               alt="Foto-perfil" width="20" style="border-radius:50%;">
        </div>
        <span>{{ Auth::check() ? Auth::user()->name : 'Utilizador' }}</span>
        <i class="bi bi-chevron-down" style="font-size:11px;color:var(--primary);"></i>
      </div>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-user">
        <li><span class="dropdown-header">Nível: {{ Auth::check() ? Auth::user()->nivel : '—' }}</span></li>
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
        <h1>Gestão de Insumos</h1>
        <p>Controlo de entrada, saída e stock de insumos agrícolas</p>
      </div>
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn-outline-green" id="btnExportar">
          <i class="bi bi-download"></i> Exportar
        </button>
        <button class="btn-green" id="btnNovoInsumo" data-bs-toggle="modal" data-bs-target="#modalInsumo">
          <i class="bi bi-plus-lg"></i> Novo Insumo
        </button>
      </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 mb-4 anim anim-d1">
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon green"><i class="bi bi-box-seam-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Total de Insumos</div>
            <div class="s-value" id="statTotal">{{ $insumos->count() ?? 0 }}</div>
            <span class="stat-badge info"><i class="bi bi-info-circle"></i> Registados</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon green"><i class="bi bi-droplet-fill"></i></div>
          <div class="stat-info">
            <div class="s-label">Fertilizantes</div>
            <div class="s-value" id="statFertilizante">{{ $insumos->where('tipo','fertilizante')->count() ?? 0 }}</div>
            <span class="stat-badge up"><i class="bi bi-check-circle"></i> Em stock</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon amber"><i class="bi bi-flower2"></i></div>
          <div class="stat-info">
            <div class="s-label">Sementes</div>
            <div class="s-value" id="statSemente">{{ $insumos->where('tipo','semente')->count() ?? 0 }}</div>
            <span class="stat-badge warn"><i class="bi bi-calendar3"></i> Safra 24/25</span>
          </div>
        </div>
      </div>
      <div class="col-6 col-xl-3">
        <div class="stat-card">
          <div class="stat-icon blue"><i class="bi bi-tools"></i></div>
          <div class="stat-info">
            <div class="s-label">Mecânicos / Outros</div>
            <div class="s-value" id="statOutros">{{ $insumos->whereIn('tipo',['mecanico','outro'])->count() ?? 0 }}</div>
            <span class="stat-badge purple"><i class="bi bi-wrench"></i> Equipamentos</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Table Card -->
    <div class="table-card anim anim-d2">

      <!-- Header -->
      <div class="table-card-header">
        <div style="display:flex;align-items:center;gap:12px;">
          <h5><i class="bi bi-box-seam-fill me-2" style="color:var(--primary);"></i>Lista de Insumos</h5>
        </div>
        <span id="tableCount" style="font-size:12.5px;color:var(--text-light);">0 registos</span>
      </div>

      <!-- Search & Filters -->
      <div class="search-filter-bar">
        <div class="search-wrap">
          <i class="bi bi-search"></i>
          <input type="text" class="search-input" id="searchInsumo" placeholder="Pesquisar por nome ou tipo…">
        </div>
        <select class="filter-select" id="filterTipo">
          <option value="">Todos os tipos</option>
          <option value="fertilizante">Fertilizante</option>
          <option value="semente">Semente</option>
          <option value="mecanico">Mecânico</option>
          <option value="outro">Outro</option>
        </select>
        <select class="filter-select" id="filterEstado">
          <option value="">Todos os estados</option>
          <option value="activo">Activo</option>
          <option value="inactivo">Inactivo</option>
        </select>
      </div>

      <!-- Table -->
      <div style="overflow-x:auto;">
        <table class="insumo-table" id="insumoTable">
          <thead>
            <tr>
              <th>Insumo</th>
              <th>Tipo</th>
              <th>Quantidade / Stock</th>
              <th>Unidade</th>
              <th>Preço Unitário</th>
              <th>Data de Entrada</th>
              <th>Estado</th>
              <th style="text-align:center;">Acções</th>
            </tr>
          </thead>
          <tbody id="tabela-insumos">

            @forelse($insumos as $insumo)
            <tr id="insumo-row-{{ $insumo->id }}"
                data-tipo="{{ strtolower($insumo->tipo) }}"
                data-estado="{{ strtolower($insumo->estado) }}">
              <td>
                <div class="insumo-cell">
                  <div class="insumo-avatar {{ $insumo->tipo == 'fertilizante' ? 'bg-success bg-opacity-10 text-success' : ($insumo->tipo == 'semente' ? 'bg-warning bg-opacity-10 text-warning' : ($insumo->tipo == 'mecanico' ? 'bg-primary bg-opacity-10 text-primary' : 'bg-secondary bg-opacity-10 text-secondary')) }}">
                    @if($insumo->tipo == 'fertilizante') 
                    @elseif($insumo->tipo == 'semente') 
                    @elseif($insumo->tipo == 'mecanico')
                    @else @endif
                  </div>
                  <div>
                    <div class="insumo-nome">{{ $insumo->nome }}</div>
                    <div class="insumo-id">ID #{{ $insumo->id }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge-tipo {{ strtolower($insumo->tipo) }}">
                  {{ ucfirst($insumo->tipo) }}
                </span>
              </td>
              <td>
                <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:var(--text-dark);">
                  {{ number_format($insumo->quantidade, 0, ',', '.') }}
                </div>
                @php
                  $pct = min(100, ($insumo->quantidade / max(1, $insumo->quantidade_maxima ?? 500)) * 100);
                  $cls = $pct > 50 ? 'ok' : ($pct > 20 ? 'warning' : 'critical');
                @endphp
                <div class="stock-bar">
                  <div class="stock-fill {{ $cls }}" style="width:{{ $pct }}%;"></div>
                </div>
              </td>
              <td>{{ $insumo->unidade }}</td>
              <td>
                <span style="font-weight:600;color:var(--primary);">
                  Kz {{ number_format($insumo->preco_unitario, 2, ',', '.') }}
                </span>
              </td>
              <td>{{ \Carbon\Carbon::parse($insumo->data_entrada)->format('d/m/Y') }}</td>
              <td>
                <span class="badge-estado {{ strtolower($insumo->estado) }}">
                  {{ $insumo->estado == 'activo' ? 'Activo' : 'Inactivo' }}
                </span>
              </td>
              <td style="text-align:center;">
                <div style="display:flex;gap:6px;justify-content:center;">
                  <button class="action-btn edit btn-editar-insumo" title="Editar"
                    data-id="{{ $insumo->id }}"
                    data-nome="{{ $insumo->nome }}"
                    data-tipo="{{ $insumo->tipo }}"
                    data-quantidade="{{ $insumo->quantidade }}"
                    data-unidade="{{ $insumo->unidade }}"
                    data-preco="{{ $insumo->preco_unitario }}"
                    data-entrada="{{ $insumo->data_entrada }}"
                    data-estado="{{ $insumo->estado }}">
                    <i class="bi bi-pencil-fill"></i>
                  </button>
                  <button class="action-btn delete btn-eliminar-insumo" title="Eliminar">
                    <i class="bi bi-trash-fill"></i>
                  </button>
                </div>
              </td>
            </tr>
            @empty
            <tr id="trEmpty">
              <td colspan="8">
                <div class="empty-state">
                  <i class="bi bi-box-seam"></i>
                  <h6>Nenhum insumo registado</h6>
                  <p>Clique em "Novo Insumo" para adicionar o primeiro registo.</p>
                </div>
              </td>
            </tr>
            @endforelse

          </tbody>
        </table>
      </div>

      <!-- Empty state (hidden by default, shown via JS filter) -->
      <div class="empty-state" id="emptyState" style="display:none;">
        <i class="bi bi-box-seam"></i>
        <h6>Nenhum insumo encontrado</h6>
        <p>Tente ajustar os filtros ou adicione um novo insumo.</p>
      </div>

      <!-- Footer / Pagination -->
      <div class="table-footer">
        <span id="tableCountBottom">Mostrando {{ $insumos->count() ?? 0 }} insumos</span>
        <div class="pagination-btns">
          {{ $insumos->links() ?? '' }}
        </div>
      </div>

    </div>
    <!-- /table-card -->

  </div><!-- /content-inner -->
</main>


<!-- ══════════════════════════════════════
     MODAL — NOVO / EDITAR INSUMO
══════════════════════════════════════ -->
<div class="modal fade" id="modalInsumo" tabindex="-1" aria-labelledby="modalInsumoLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-insumo modal-dialog-centered">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <div style="display:flex;align-items:center;gap:14px;flex:1;">
          <div class="modal-header-icon">
            <i class="bi bi-box-seam-fill"></i>
          </div>
          <div>
            <div class="modal-title" id="modalInsumoLabel">Novo Insumo</div>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>

      <!-- Body -->
      <div class="modal-body">
        <form id="formInsumo" novalidate>
          @csrf
          <input type="hidden" id="insumoId" name="id" value="">

          <!-- Informação do Insumo -->
          <div class="mf-card">
            <div class="mf-section-title">
              <i class="bi bi-box-fill"></i> Identificação do Insumo
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-8">
                <label class="cfg-label" for="insumoNome">Nome do Insumo *</label>
                <input class="cfg-input" type="text" id="insumoNome" name="nome"
                       placeholder="Ex: Ureia 46%, Milho Híbrido DK515…" required>
              </div>
              <div class="col-12 col-md-4">
                <label class="cfg-label" for="insumoTipo">Tipo / Categoria *</label>
                <select class="cfg-select" id="insumoTipo" name="tipo" required>
                  <option value="">Seleccione…</option>
                  <option value="fertilizante">Fertilizante</option>
                  <option value="semente">Semente</option>
                  <option value="mecanico">Mecânico</option>
                  <option value="outro">Outro</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Stock & Preço -->
          <div class="mf-card">
            <div class="mf-section-title">
              <i class="bi bi-archive-fill"></i> Stock & Valores
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-4">
                <label class="cfg-label" for="insumoQuantidade">Quantidade *</label>
                <input class="cfg-input" type="number" id="insumoQuantidade" name="quantidade"
                       placeholder="0" min="0" step="0.01" required>
                <div class="cfg-helper">Stock disponível actualmente</div>
              </div>
              <div class="col-12 col-md-4">
                <label class="cfg-label" for="insumoUnidade">Unidade de Medida *</label>
                <select class="cfg-select" id="insumoUnidade" name="unidade" required>
                  <option value="">Seleccione…</option>
                  <option value="kg">kg — Quilograma</option>
                  <option value="g">g — Grama</option>
                  <option value="t">t — Tonelada</option>
                  <option value="L">L — Litro</option>
                  <option value="mL">mL — Mililitro</option>
                  <option value="un">un — Unidade</option>
                  <option value="cx">cx — Caixa</option>
                  <option value="sc">sc — Saco</option>
                </select>
              </div>
              <div class="col-12 col-md-4">
                <label class="cfg-label" for="insumoPreco">Preço Unitário (Kz) *</label>
                <input class="cfg-input" type="number" id="insumoPreco" name="preco_unitario"
                       placeholder="0.00" min="0" step="0.01" required>
                <div class="cfg-helper">Custo por unidade em Kwanzas</div>
              </div>
            </div>
          </div>

          <!-- Data e Estado -->
          <div class="mf-card">
            <div class="mf-section-title">
              <i class="bi bi-calendar-event-fill"></i> Data & Estado
            </div>
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="cfg-label" for="insumoDataEntrada">Data de Entrada *</label>
                <input class="cfg-input" type="date" id="insumoDataEntrada" name="data_entrada" required>
                <div class="cfg-helper">Quando este lote entrou no stock</div>
              </div>
              <div class="col-12 col-md-6">
                <label class="cfg-label" for="insumoEstado">Estado *</label>
                <select class="cfg-select" id="insumoEstado" name="estado" required>
                  <option value="activo">Ativo</option>
                  <option value="inactivo">Desativado</option>
                </select>
                <div class="cfg-helper">Insumos inactivos não aparecem nas saídas</div>
              </div>
            </div>
          </div>

        </form>
      </div>

      <!-- Footer -->
      <div class="modal-footer">
        <div style="display:flex;align-items:center;gap:10px;width:100%;justify-content:space-between;flex-wrap:wrap;">
          <div style="font-size:12px;color:var(--text-light);">
            <i class="bi bi-info-circle me-1"></i> Os campos marcados com * são obrigatórios.
          </div>
          <div style="display:flex;gap:10px;">
            <button type="button" class="btn-outline-green" data-bs-dismiss="modal">
              <i class="bi bi-x-lg"></i> Cancelar
            </button>
            <button type="button" class="btn-green" id="btnGuardarInsumo">
              <i class="bi bi-check2-circle"></i>
              <span id="btnGuardarInsumoLabel">Registar Insumo</span>
            </button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- /MODAL INSUMO -->

<!-- Toast Feedback -->
<div class="save-toast" id="saveToast">
  <div class="toast-icon success" id="toastIcon"><i class="bi bi-check-lg" id="toastIconI"></i></div>
  <div class="toast-text">
    <div class="t-title" id="toastTitle">Operação concluída</div>
    <div class="t-sub"   id="toastSub">Acção realizada com sucesso.</div>
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
const themeIcon   = document.getElementById('themeIcon');
const themeLabel  = document.getElementById('themeLabel');
let darkMode = false;

themeToggle.addEventListener('click', function(e) {
  e.preventDefault();
  darkMode = !darkMode;
  body.classList.toggle('dark-mode', darkMode);
  themeIcon.className    = darkMode ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
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
  const toast = document.getElementById('saveToast');
  const icon  = document.getElementById('toastIcon');
  const iconI = document.getElementById('toastIconI');
  document.getElementById('toastTitle').textContent = title;
  document.getElementById('toastSub').textContent   = sub;
  icon.className  = 'toast-icon ' + (type === 'danger' ? 'danger' : 'success');
  iconI.className = type === 'danger' ? 'bi bi-x-lg' : 'bi bi-check-lg';
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3500);
}

/* ══════════════════════════════════════
   SEARCH & FILTER
══════════════════════════════════════ */
function filtrarInsumos() {
  const texto  = document.getElementById('searchInsumo').value.toLowerCase();
  const tipo   = document.getElementById('filterTipo').value.toLowerCase();
  const estado = document.getElementById('filterEstado').value.toLowerCase();
  const linhas = document.querySelectorAll('#tabela-insumos tr[id^="insumo-row-"]');
  let visible  = 0;

  linhas.forEach(linha => {
    const conteudo     = linha.textContent.toLowerCase();
    const tipoLinha    = linha.dataset.tipo    || '';
    const estadoLinha  = linha.dataset.estado  || '';

    const ok = (!texto  || conteudo.includes(texto))
            && (!tipo   || tipoLinha  === tipo)
            && (!estado || estadoLinha === estado);

    linha.style.display = ok ? '' : 'none';
    if (ok) visible++;
  });

  document.getElementById('emptyState').style.display = visible === 0 ? 'block' : 'none';
  document.getElementById('tableCount').textContent       = visible + ' registo' + (visible !== 1 ? 's' : '');
  document.getElementById('tableCountBottom').textContent = 'Mostrando ' + visible + ' insumo' + (visible !== 1 ? 's' : '');
}

document.getElementById('searchInsumo').addEventListener('input', filtrarInsumos);
document.getElementById('filterTipo').addEventListener('change', filtrarInsumos);
document.getElementById('filterEstado').addEventListener('change', filtrarInsumos);

/* Conta inicial ao carregar */
document.addEventListener('DOMContentLoaded', () => {
  const total = document.querySelectorAll('#tabela-insumos tr[id^="insumo-row-"]').length;
  document.getElementById('tableCount').textContent       = total + ' registo' + (total !== 1 ? 's' : '');
  document.getElementById('tableCountBottom').textContent = 'Mostrando ' + total + ' insumo' + (total !== 1 ? 's' : '');
});

/* ══════════════════════════════════════
   MODAL — NOVO INSUMO (reset ao abrir)
══════════════════════════════════════ */
let modoInsumo = 'create';

document.getElementById('btnNovoInsumo').addEventListener('click', () => {
  modoInsumo = 'create';
  document.getElementById('formInsumo').reset();
  document.getElementById('insumoId').value = '';
  document.getElementById('modalInsumoLabel').textContent    = 'Novo Insumo';
  document.getElementById('btnGuardarInsumoLabel').textContent = 'Registar Insumo';
  // Data de entrada: hoje por omissão
  document.getElementById('insumoDataEntrada').value = new Date().toISOString().split('T')[0];
});

/* ══════════════════════════════════════
   MODAL — EDITAR INSUMO
══════════════════════════════════════ */
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.btn-editar-insumo');
  if (!btn) return;

  modoInsumo = 'edit';

  document.getElementById('insumoId').value              = btn.dataset.id      || '';
  document.getElementById('insumoNome').value            = btn.dataset.nome     || '';
  document.getElementById('insumoTipo').value            = btn.dataset.tipo     || '';
  document.getElementById('insumoQuantidade').value      = btn.dataset.quantidade || '';
  document.getElementById('insumoUnidade').value         = btn.dataset.unidade  || '';
  document.getElementById('insumoPreco').value           = btn.dataset.preco    || '';
  document.getElementById('insumoDataEntrada').value     = normalizarDataISO(btn.dataset.entrada || '');
  document.getElementById('insumoEstado').value          = btn.dataset.estado   || 'activo';

  document.getElementById('modalInsumoLabel').textContent     = 'Editar Insumo';
  document.getElementById('btnGuardarInsumoLabel').textContent = 'Guardar Alterações';

  new bootstrap.Modal(document.getElementById('modalInsumo')).show();
});

/* ══════════════════════════════════════
   GUARDAR INSUMO (criar / editar)
══════════════════════════════════════ */
document.getElementById('btnGuardarInsumo').addEventListener('click', () => {
  // 1. Recolha de Dados do Formulário
  const id         = document.getElementById('insumoId').value;
  const nome       = document.getElementById('insumoNome').value.trim();
  const tipo       = document.getElementById('insumoTipo').value;
  const quantidade = document.getElementById('insumoQuantidade').value;
  const unidade    = document.getElementById('insumoUnidade').value;
  const preco      = document.getElementById('insumoPreco').value;
  const entrada    = document.getElementById('insumoDataEntrada').value;
  const estado     = document.getElementById('insumoEstado').value;

  // 2. Validação básica no Frontend (Campos Obrigatórios)
  if (!nome || !tipo || !quantidade || !unidade || !preco || !entrada) {
    showToast('Campos obrigatórios em falta', 'Preencha todos os campos marcados com *.', 'danger');
    return;
  }

  // 3. Estado de Carregamento (Loading) do Botão
  const btn  = document.getElementById('btnGuardarInsumo');
  const orig = btn.innerHTML;
  btn.innerHTML = '<i class="bi bi-hourglass-split"></i> A guardar…';
  btn.disabled  = true;

  // 4. Definição Dinâmica de URL e Configuração do FormData
  const url  = id ? `/insumos/${id}` : '/insumos';
  
  const formData = new FormData();
  formData.append('nome',           nome);
  formData.append('tipo',           tipo);
  formData.append('quantidade',     quantidade);
  formData.append('unidade',        unidade);
  formData.append('preco_unitario', preco);
  formData.append('data_entrada',   entrada);
  formData.append('estado',         estado);
  
  // Se existir ID, simulamos o método PUT para o Laravel através do FormData
  if (id) {
    formData.append('_method', 'PUT');
  }

  // 5. Envio dos dados via Fetch (Sempre POST para suporte correto a FormData/PUT no Laravel)
  fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json', // Força o Laravel a responder em JSON (mesmo em erros de validação)
    },
    body: formData
  })
    .then(response => {
      // Se o Laravel devolver um erro de validação (422) ou outro erro, capturamos o JSON da mesma forma
      return response.json().then(data => {
        if (!response.ok) {
          // Lança o objeto de erro capturado para o bloco .catch() tratar
          throw data;
        }
        return data;
      });
    })
    .then(data => {
      // Restaurar botão ao estado original
      btn.innerHTML = orig;
      btn.disabled  = false;

      // Resposta de sucesso do servidor
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('modalInsumo')).hide();
        document.getElementById('formInsumo').reset();

        // O 'modoInsumo' deve ser definido ao abrir o modal (ex: 'create' ou 'edit')
        if (modoInsumo === 'create') {
          inserirLinhaTabela(data.insumo); // Corrigido para data.insumo conforme o Controller
          showToast('Insumo registado', data.insumo.nome + ' foi adicionado ao stock.');
        } else {
          atualizarLinhaTabela(data.insumo); // Corrigido para data.insumo conforme o Controller
          showToast('Insumo actualizado', data.insumo.nome + ' foi actualizado com sucesso.');
        }
        atualizarContadores();
      } else {
        showToast('Erro ao guardar', data.message || 'Verifique os dados e tente novamente.', 'danger');
      }
    })
    .catch(error => {
      // Restaurar botão ao estado original em caso de erro
      btn.innerHTML = orig;
      btn.disabled  = false;

      // Se o erro vier da validação do Laravel (Status 422), extraímos a mensagem amigável
      if (error.errors) {
        const primeiroErro = Object.values(error.errors)[0][0];
        showToast('Erro de validação', primeiroErro, 'danger');
      } else {
        showToast('Erro de ligação', error.message || 'Não foi possível comunicar com o servidor.', 'danger');
      }
    });
});

  

/* ══════════════════════════════════════
   ELIMINAR INSUMO
══════════════════════════════════════ */

document.addEventListener('click', function(e) {
  const btn = e.target.closest('.btn-eliminar-insumo');
  if (!btn) return;

  const id = btn.dataset.id;
  if (!confirm('Tem a certeza que deseja eliminar este insumo? Esta acção é irreversível.')) return;

  fetch(`/insumos/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      'Accept': 'application/json'
    }
  })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            btn.closest('tr').remove();
            showToast('Ano Agrícola eliminado', 'O registo foi removido do sistema.');
          } else {
            showToast('Erro', data.message || 'Não foi possível eliminar2.');
          }
        })
        .catch(() => showToast('Erro de ligação', 'Verifique a sua conexão.'));
});

/* ══════════════════════════════════════
   FUNÇÕES AUXILIARES
══════════════════════════════════════ */
function normalizarDataISO(dateStr) {
  if (!dateStr) return '';
  dateStr = String(dateStr).trim();
  if (/^\d{4}-\d{2}-\d{2}/.test(dateStr)) return dateStr.substring(0, 10);
  const m = dateStr.match(/^(\d{2})[\/\-](\d{2})[\/\-](\d{4})$/);
  if (m) return `${m[3]}-${m[2]}-${m[1]}`;
  return '';
}

function formatarData(dateStr) {
  if (!dateStr) return '—';
  dateStr = String(dateStr).trim();
  const iso = dateStr.match(/^(\d{4})-(\d{2})-(\d{2})/);
  if (iso) return `${iso[3]}/${iso[2]}/${iso[1]}`;
  return dateStr;
}

function iconeInsumo(tipo) {
  const icons = { fertilizante: '💧', semente: '🌱', mecanico: '🔧', outro: '📦' };
  return icons[tipo] || '📦';
}

function badgeTipo(tipo) {
  const map = {
    fertilizante: ['fertilizante', 'Fertilizante'],
    semente:      ['semente',      'Semente'],
    mecanico:     ['mecanico',     'Mecânico'],
    outro:        ['outro',        'Outro'],
  };
  const [cls, label] = map[tipo] || ['outro', 'Outro'];
  return `<span class="badge-tipo ${cls}">${label}</span>`;
}

function badgeEstado(estado) {
  return estado === 'activo'
    ? '<span class="badge-estado activo">Activo</span>'
    : '<span class="badge-estado inactivo">Inactivo</span>';
}

function stockBar(qty) {
  // Stock máx estimado: 500 por omissão para novos registos
  const pct = Math.min(100, (qty / 500) * 100);
  const cls = pct > 50 ? 'ok' : (pct > 20 ? 'warning' : 'critical');
  return `<div class="stock-bar"><div class="stock-fill ${cls}" style="width:${pct}%;"></div></div>`;
}

function inserirLinhaTabela(insumo) {
  // Remove linha "sem registos" se existir
  const trEmpty = document.getElementById('trEmpty');
  if (trEmpty) trEmpty.remove();

  const tbody = document.getElementById('tabela-insumos');
  const qty   = parseFloat(insumo.quantidade) || 0;
  const preco = parseFloat(insumo.preco_unitario) || 0;

  const tr = document.createElement('tr');
  tr.id = `insumo-row-${insumo.id}`;
  tr.dataset.tipo   = (insumo.tipo   || '').toLowerCase();
  tr.dataset.estado = (insumo.estado || '').toLowerCase();

  tr.innerHTML = `
    <td>
      <div class="insumo-cell">
        <div class="insumo-avatar">${iconeInsumo(insumo.tipo)}</div>
        <div>
          <div class="insumo-nome">${insumo.nome}</div>
          <div class="insumo-id">ID #${insumo.id}</div>
        </div>
      </div>
    </td>
    <td>${badgeTipo(insumo.tipo)}</td>
    <td>
      <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:var(--text-dark);">
        ${qty.toLocaleString('pt-PT')}
      </div>
      ${stockBar(qty)}
    </td>
    <td>${insumo.unidade}</td>
    <td><span style="font-weight:600;color:var(--primary);">Kz ${preco.toLocaleString('pt-PT', {minimumFractionDigits:2})}</span></td>
    <td>${formatarData(insumo.data_entrada)}</td>
    <td>${badgeEstado(insumo.estado)}</td>
    <td style="text-align:center;">
      <div style="display:flex;gap:6px;justify-content:center;">
        <button class="action-btn edit btn-editar-insumo" title="Editar"
          data-id="${insumo.id}"
          data-nome="${insumo.nome}"
          data-tipo="${insumo.tipo}"
          data-quantidade="${insumo.quantidade}"
          data-unidade="${insumo.unidade}"
          data-preco="${insumo.preco_unitario}"
          data-entrada="${normalizarDataISO(insumo.data_entrada)}"
          data-estado="${insumo.estado}">
          <i class="bi bi-pencil-fill"></i>
        </button>
        <button class="action-btn delete btn-eliminar-insumo" title="Eliminar" data-id="${insumo.id}">
          <i class="bi bi-trash-fill"></i>
        </button>
      </div>
    </td>
  `;

  tbody.insertAdjacentElement('afterbegin', tr);
}

function atualizarLinhaTabela(insumo) {
  const tr = document.getElementById(`insumo-row-${insumo.id}`);
  if (!tr) return;

  const qty   = parseFloat(insumo.quantidade) || 0;
  const preco = parseFloat(insumo.preco_unitario) || 0;

  tr.dataset.tipo   = (insumo.tipo   || '').toLowerCase();
  tr.dataset.estado = (insumo.estado || '').toLowerCase();

  tr.innerHTML = `
    <td>
      <div class="insumo-cell">
        <div class="insumo-avatar">${iconeInsumo(insumo.tipo)}</div>
        <div>
          <div class="insumo-nome">${insumo.nome}</div>
          <div class="insumo-id">ID #${insumo.id}</div>
        </div>
      </div>
    </td>
    <td>${badgeTipo(insumo.tipo)}</td>
    <td>
      <div style="font-family:'Sora',sans-serif;font-weight:700;font-size:15px;color:var(--text-dark);">
        ${qty.toLocaleString('pt-PT')}
      </div>
      ${stockBar(qty)}
    </td>
    <td>${insumo.unidade}</td>
    <td><span style="font-weight:600;color:var(--primary);">Kz ${preco.toLocaleString('pt-PT', {minimumFractionDigits:2})}</span></td>
    <td>${formatarData(insumo.data_entrada)}</td>
    <td>${badgeEstado(insumo.estado)}</td>
    <td style="text-align:center;">
      <div style="display:flex;gap:6px;justify-content:center;">
        <button class="action-btn edit btn-editar-insumo" title="Editar"
          data-id="${insumo.id}"
          data-nome="${insumo.nome}"
          data-tipo="${insumo.tipo}"
          data-quantidade="${insumo.quantidade}"
          data-unidade="${insumo.unidade}"
          data-preco="${insumo.preco_unitario}"
          data-entrada="${normalizarDataISO(insumo.data_entrada)}"
          data-estado="${insumo.estado}">
          <i class="bi bi-pencil-fill"></i>
        </button>
        <button class="action-btn delete btn-eliminar-insumo" title="Eliminar" data-id="${insumo.id}">
          <i class="bi bi-trash-fill"></i>
        </button>
      </div>
    </td>
  `;
}

function atualizarContadores() {
  const rows = document.querySelectorAll('#tabela-insumos tr[id^="insumo-row-"]');
  let total = 0, fert = 0, sem = 0, outros = 0;

  rows.forEach(r => {
    total++;
    const t = r.dataset.tipo || '';
    if (t === 'fertilizante') fert++;
    else if (t === 'semente') sem++;
    else outros++;
  });

  document.getElementById('statTotal').textContent        = total;
  document.getElementById('statFertilizante').textContent = fert;
  document.getElementById('statSemente').textContent      = sem;
  document.getElementById('statOutros').textContent       = outros;
}

/* ══════════════════════════════════════
   EXPORTAR
══════════════════════════════════════ */
document.getElementById('btnExportar').addEventListener('click', () => {
  showToast('A exportar…', 'O ficheiro será gerado e descarregado em breve.');
});
</script>

</body>
</html>
