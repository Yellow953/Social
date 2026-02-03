<style>
    .sidebar {
        width: 260px;
        height: 100vh;
        background: #1a2744;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
        transition: width 0.3s ease;
        overflow-y: auto;
        overflow-x: visible;
        z-index: 100;
        display: flex;
        flex-direction: column;
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(236, 104, 42, 0.3);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 104, 42, 0.5);
    }

    .sidebar.collapsed {
        width: 90px;
    }

    .sidebar-content {
        transition: padding 0.3s ease;
    }

    .sidebar.collapsed .sidebar-content {
        padding: 1rem 0 !important;
    }

    /* Logo Container */
    .logo-container {
        transition: all 0.3s ease;
        min-height: 48px;
        position: relative;
    }

    .sidebar.collapsed .logo-container {
        justify-content: center;
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
        color: #e0e0e0 !important;
    }

    .sidebar-toggle-btn i {
        color: #e0e0e0 !important;
    }

    .sidebar-toggle-btn:hover {
        background: rgba(236, 104, 42, 0.2);
        border-radius: 0.375rem;
        color: #ec682a !important;
    }

    .sidebar-toggle-btn:hover i {
        color: #ec682a !important;
    }

    .sidebar.collapsed .logo-container {
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar.collapsed .logo-link {
        width: 100%;
        justify-content: center;
    }

    .sidebar.collapsed .sidebar-toggle-btn {
        position: relative;
        margin-top: 0.5rem;
        width: 100%;
        justify-content: center;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 0.25rem;
        padding: 0.5rem;
        color: #e0e0e0 !important;
    }

    .sidebar.collapsed .sidebar-toggle-btn i {
        color: #e0e0e0 !important;
    }

    .sidebar.collapsed .sidebar-toggle-btn:hover {
        background: rgba(236, 104, 42, 0.3);
        color: #ec682a !important;
    }

    .sidebar.collapsed .sidebar-toggle-btn:hover i {
        color: #ec682a !important;
    }

    /* Navigation */
    nav {
        flex: 1;
        overflow-y: auto;
        overflow-x: visible;
        padding-right: 0.5rem;
    }

    nav::-webkit-scrollbar {
        width: 4px;
    }

    nav::-webkit-scrollbar-track {
        background: transparent;
    }

    nav::-webkit-scrollbar-thumb {
        background: rgba(236, 104, 42, 0.3);
        border-radius: 2px;
    }

    nav::-webkit-scrollbar-thumb:hover {
        background: rgba(236, 104, 42, 0.5);
    }

    /* Navigation Items */
    .sidebar-item {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        position: relative;
        display: flex;
        align-items: center;
        color: #e0e0e0 !important;
    }

    .sidebar.collapsed .sidebar-item {
        justify-content: center;
        align-items: center;
        padding: 0 !important;
        margin-bottom: 0.75rem;
        width: 48px;
        height: 48px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
    }

    .sidebar-item i {
        transition: all 0.3s ease;
        flex-shrink: 0;
        width: 20px;
        text-align: center;
        color: #b0b0b0;
    }

    .sidebar.collapsed .sidebar-item i {
        margin: 0 !important;
        font-size: 1.25rem;
        width: auto;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-text {
        transition: all 0.3s ease;
        white-space: nowrap;
        color: #e0e0e0 !important;
    }

    .sidebar.collapsed .nav-text {
        width: 0;
        opacity: 0;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    .sidebar-item:hover {
        background: rgba(236, 104, 42, 0.2);
        border-left-color: #ec682a;
        color: #ffffff !important;
    }

    .sidebar.collapsed .sidebar-item:hover {
        background: rgba(236, 104, 42, 0.3);
        border-left-color: transparent;
    }

    .sidebar-item:hover i {
        color: #ec682a !important;
    }

    .sidebar.collapsed .sidebar-item:hover i {
        color: #ec682a !important;
    }

    .sidebar-item:hover .nav-text {
        color: #ffffff !important;
    }

    .sidebar-item.active {
        background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);
        color: white !important;
        border-left-color: #ec682a;
    }

    .sidebar.collapsed .sidebar-item.active {
        background: linear-gradient(135deg, #ec682a 0%, #d45a20 100%);
        border-left-color: transparent;
    }

    .sidebar-item.active i {
        color: white !important;
    }

    .sidebar.collapsed .sidebar-item.active i {
        color: white !important;
    }

    .sidebar-item.active .nav-text {
        color: white !important;
    }

    /* Tooltips for collapsed state */
    .sidebar.collapsed .sidebar-item {
        z-index: 1;
    }

    .sidebar.collapsed .sidebar-item:hover {
        z-index: 10000;
    }

    .sidebar.collapsed .sidebar-item:hover::after {
        content: attr(data-tooltip);
        position: fixed;
        left: 70px;
        top: 50%;
        transform: translateY(-50%);
        background: #243b55;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        white-space: nowrap;
        font-size: 0.875rem;
        z-index: 99999 !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        pointer-events: none;
        border: 1px solid rgba(236, 104, 42, 0.3);
    }

    .sidebar.collapsed .sidebar-item:hover::before {
        content: '';
        position: fixed;
        left: 90px;
        top: 50%;
        transform: translateY(-50%);
        margin-left: -6px;
        border: 6px solid transparent;
        border-right-color: #243b55;
        z-index: 99998 !important;
        pointer-events: none;
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        transition: margin-left 0.3s ease;
    }

    .main-content.expanded {
        margin-left: 90px;
    }

    /* Mobile sidebar overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 999;
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .sidebar-overlay.show {
        display: block;
        opacity: 1;
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .sidebar {
            position: fixed;
            left: -260px;
            z-index: 1000;
            transition: left 0.3s ease, transform 0.3s ease;
        }

        .sidebar.show {
            left: 0;
        }

        .main-content {
            margin-left: 0;
        }
    }

    /* Action Cards Hover Effect */
    .action-card-link {
        display: block;
    }

    .action-card {
        transition: all 0.3s ease;
    }

    .action-card-link:hover .action-card {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15) !important;
    }

    /* Recent Courses Hover Effect */
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>
