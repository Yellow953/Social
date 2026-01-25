<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileSidebarToggle = document.getElementById('mobile-sidebar-toggle');
    const navTexts = document.querySelectorAll('.nav-text, .logo-text, .admin-badge');

    // Check localStorage for saved sidebar state
    function loadSidebarState() {
        const savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            updateToggleIcon(true);
        }
    }

    // Save sidebar state to localStorage
    function saveSidebarState(isCollapsed) {
        localStorage.setItem('sidebarCollapsed', isCollapsed ? 'true' : 'false');
    }

    // Update toggle icon
    function updateToggleIcon(isCollapsed) {
        const icon = sidebarToggle?.querySelector('#toggle-icon');
        if (icon) {
            if (isCollapsed) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
            }
        }
    }

    // Load saved state on page load
    if (sidebar && mainContent) {
        loadSidebarState();
        // Update tooltip positions after loading state
        setTimeout(updateTooltipPositions, 100);
    }

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            const isCollapsed = sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');

            // Save state to localStorage
            saveSidebarState(isCollapsed);

            // Update toggle icon
            updateToggleIcon(isCollapsed);
        });
    }

    if (mobileSidebarToggle) {
        mobileSidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Close sidebar on mobile when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !mobileSidebarToggle.contains(event.target) && sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Update tooltip positions dynamically when collapsed
    function updateTooltipPositions() {
        if (sidebar && sidebar.classList.contains('collapsed')) {
            const items = sidebar.querySelectorAll('.sidebar-item');
            items.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    const rect = this.getBoundingClientRect();
                    const top = rect.top + (rect.height / 2);

                    // Create or update dynamic style
                    let style = document.getElementById('dynamic-tooltip-style');
                    if (!style) {
                        style = document.createElement('style');
                        style.id = 'dynamic-tooltip-style';
                        document.head.appendChild(style);
                    }

                    style.textContent = `
                        .sidebar.collapsed .sidebar-item:hover::after {
                            top: ${top}px !important;
                        }
                        .sidebar.collapsed .sidebar-item:hover::before {
                            top: ${top}px !important;
                        }
                    `;
                });
            });
        }
    }

    // Update tooltip positions on toggle and scroll
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            setTimeout(updateTooltipPositions, 300);
        });
    }

    // Update on scroll
    if (sidebar) {
        sidebar.addEventListener('scroll', updateTooltipPositions);
    }

    // Initial update
    updateTooltipPositions();
</script>
