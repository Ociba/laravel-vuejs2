<!-- <template>

<router-view/>

</template> -->
<template>
    <div id="app">
      <router-view />
    </div>
  </template>
  
  <script>
  export default {
    name: 'App'
  }
  </script>
  
  <style>
  /* Global styles */
  :root {
    --primary-color: #007bff;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
    --light-color: #f8f9fa;
    --dark-color: #343a40;
  }
  
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f5f5f5;
    padding-top: 0; /* Navbar handles this */
    margin: 0;
  }
  
  /* Smooth scroll behavior */
  html {
    scroll-behavior: smooth;
  }
  
  /* Custom scrollbar */
  ::-webkit-scrollbar {
    width: 10px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 5px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
  
  /* Bootstrap icon font */
  @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css");
  
  /* Custom utility classes */
  .text-gradient {
    background: linear-gradient(135deg, var(--primary-color), #00bfff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }
  .welcome-banner {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-purple {
    background-color: #6f42c1;
}

.quick-action-card {
    display: block;
    padding: 1.5rem;
    text-align: center;
    border-radius: 10px;
    background: #f8f9fa;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    height: 100%;
}

.quick-action-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.action-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
}

.badge {
    padding: 0.25em 0.6em;
    font-weight: 500;
    font-size: 0.75rem;
}

.text-truncate {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
  .shadow-hover {
    transition: box-shadow 0.3s ease;
  }
  
  .shadow-hover:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
  }
  
  /* Animation classes */
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  
  .slide-up-enter-active,
  .slide-up-leave-active {
    transition: all 0.3s ease;
  }
  
  .slide-up-enter-from,
  .slide-up-leave-to {
    opacity: 0;
    transform: translateY(20px);
  }
  /* All CSS styles remain the same as in your code */
.seller-dashboard-layout {
    min-height: 100vh;
    background: #f8f9fa;
}

/* Dashboard Layout */
.dashboard-container {
    display: flex;
    min-height: calc(100vh - 76px);
    margin-top: 25px;
    /* Subtract navbar height */
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: 260px;
    position: sticky;
    background: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
    display: flex;
    flex-direction: column;
    z-index: 100;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
}

.profile-info h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.seller-badge {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    border-left: 3px solid transparent;
}

.menu-item:hover {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
    border-left-color: #007bff;
}

.menu-item.active {
    background: rgba(0, 123, 255, 0.15);
    color: #007bff;
    border-left-color: #007bff;
    font-weight: 500;
}

.menu-item i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 0.75rem;
}

.count-badge {
    margin-left: auto;
    background: #007bff;
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    min-width: 24px;
}

.menu-divider {
    height: 1px;
    background: #e9ecef;
    margin: 1rem 1.5rem;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #e9ecef;
}

/* Main Content */
.dashboard-main {
    flex: 1;
    overflow-y: auto;
}

.dashboard-header {
    background: white;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #007bff;
    font-weight: 500;
}

.header-actions .btn {
    padding: 0.5rem 1.5rem;
}

/* Dashboard Content */
.dashboard-content {
    padding: 2rem;
}

/* Form Styles */
.form-card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.form-section {
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #007bff;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.form-control,
.form-control-lg {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-control-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.invalid-feedback {
    display: block !important;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Image Upload Area */
.image-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
}

.image-upload-area:hover {
    border-color: #007bff;
    background: rgba(0, 123, 255, 0.05);
}

.image-upload-area.has-image {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
    padding: 1rem;
}

.upload-placeholder i {
    color: #adb5bd;
}

.preview-img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    object-fit: contain;
}

.remove-image {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Tips Card */
.tips-card,
.stats-card {
    border-radius: 12px;
    overflow: hidden;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.tip-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffc107;
    font-size: 1.2rem;
}

.tip-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.tip-text {
    color: #6c757d;
    line-height: 1.4;
}

/* Stats Card */
.stat-item {
    padding: 0.75rem;
    border-radius: 8px;
    background: #f8f9fa;
    margin-bottom: 0.75rem;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
}

/* Button Styles */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.btn-lg {
    padding: 0.75rem 2rem;
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
}

/* Radio Button Styles */
.btn-check:checked+.btn-outline-secondary {
    background: linear-gradient(135deg, #6c757d, #495057);
    border-color: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-secondary:hover {
    border-color: #6c757d;
}

/* Responsive Design */
@media (max-width: 1199.98px) {
    .dashboard-sidebar {
        width: 220px;
    }
}

@media (max-width: 991.98px) {
    .dashboard-container {
        flex-direction: column;
    }

    .dashboard-sidebar {
        width: 100%;
        position: static;
    }

    .sidebar-menu {
        display: flex;
        overflow-x: auto;
        padding: 0.5rem;
    }

    .menu-item {
        flex-direction: column;
        padding: 0.75rem;
        min-width: 80px;
        text-align: center;
        border-left: none;
        border-bottom: 3px solid transparent;
    }

    .menu-item:hover,
    .menu-item.active {
        border-left: none;
        border-bottom-color: #007bff;
    }

    .menu-item i {
        margin-right: 0;
        margin-bottom: 0.25rem;
        font-size: 1.2rem;
    }

    .menu-item span {
        font-size: 0.8rem;
    }

    .count-badge {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .user-profile {
        justify-content: center;
        text-align: center;
    }
}

@media (max-width: 767.98px) {
    .dashboard-content {
        padding: 1rem;
    }

    .dashboard-header {
        padding: 1rem;
        flex-direction: column;
        align-items: stretch;
    }

    .header-actions {
        margin-top: 1rem;
    }

    .form-section {
        padding: 1rem;
    }

    .image-upload-area {
        padding: 2rem;
    }

    .image-upload-area.has-image {
        padding: 1rem;
    }
}

@media (max-width: 575.98px) {
    .page-title {
        font-size: 1.5rem;
    }

    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
    }

    .form-control-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .d-flex.gap-2 {
        justify-content: stretch;
    }

    .d-flex.gap-2 .btn {
        flex: 1;
    }
}

.page-header {
    margin-top: 2rem;
}

.admin-controls {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    border: 1px solid #dee2e6;
}

.product-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.product-image {
    height: 200px;
    object-fit: cover;
    width: 100%;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.product-image:hover {
    transform: scale(1.05);
}

.discount-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ff4444, #ff6b6b);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

/* Responsive adjustments for the new layout */
@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .admin-controls .btn {
        margin-bottom: 0.5rem;
        width: 100%;
    }
}

@media (max-width: 576px) {
    .page-header h1 {
        font-size: 1.8rem;
    }

    .product-image {
        height: 180px;
    }
}
  </style>