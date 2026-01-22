<style>
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        transition: width 0.3s ease;
        overflow: hidden;
        z-index: 100;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar-content {
        transition: padding 0.3s ease;
    }

    .sidebar.collapsed .sidebar-content {
        padding: 1rem 0.5rem;
    }

    /* Logo Container */
    .logo-container {
        transition: all 0.3s ease;
        min-height: 48px;
    }

    .logo-link {
        transition: all 0.3s ease;
        flex: 1;
    }

    .sidebar.collapsed .logo-link {
        justify-content: center;
        width: 100%;
        flex: 0;
    }

    .logo-text-container {
        transition: all 0.3s ease;
        overflow: hidden;
        white-space: nowrap;
    }

    .sidebar.collapsed .logo-text-container {
        width: 0;
        opacity: 0;
        margin: 0;
        padding: 0;
        max-width: 0;
    }

    .logo-text,
    .admin-badge {
        transition: all 0.3s ease;
    }

    .sidebar.collapsed .logo-text,
    .sidebar.collapsed .admin-badge {
        display: none;
    }

    .sidebar-toggle-btn {
        transition: all 0.3s ease;
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sidebar-toggle-btn:hover {
        background: rgba(236, 104, 42, 0.1);
        border-radius: 0.375rem;
    }

    .sidebar.collapsed .sidebar-toggle-btn {
        position: absolute;
        top: 0.75rem;
        right: 0.5rem;
        z-index: 10;
    }

    /* Navigation Items */
    .sidebar-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        position: relative;
        display: flex;
        align-items: center;
    }

    .sidebar.collapsed .sidebar-item {
        justify-content: center;
        padding: 0.75rem !important;
    }

    .sidebar-item i {
        transition: all 0.3s ease;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
    }

    .sidebar.collapsed .sidebar-item i {
        margin: 0 !important;
        font-size: 1.25rem;
    }

    .nav-text {
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .sidebar.collapsed .nav-text {
        width: 0;
        opacity: 0;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .sidebar-item:hover {
        background: rgba(236, 104, 42, 0.1);
        border-left-color: #ec682a;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);
        color: white !important;
        border-left-color: #ec682a;
    }

    .sidebar-item.active i {
        color: white !important;
    }

    /* Tooltips for collapsed state */
    .sidebar.collapsed .sidebar-item:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        left: calc(100% + 0.5rem);
        top: 50%;
        transform: translateY(-50%);
        background: #5c5c5c;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        white-space: nowrap;
        font-size: 0.875rem;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        pointer-events: none;
    }

    .sidebar.collapsed .sidebar-item:hover::before {
        content: '';
        position: absolute;
        left: 100%;
        top: 50%;
        transform: translateY(-50%);
        border: 6px solid transparent;
        border-right-color: #5c5c5c;
        z-index: 1001;
        pointer-events: none;
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        transition: margin-left 0.3s ease;
    }

    .main-content.expanded {
        margin-left: 80px;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            position: fixed;
            left: -260px;
            z-index: 1000;
        }

        .sidebar.show {
            left: 0;
        }

        .main-content {
            margin-left: 0;
        }
    }
</style>
