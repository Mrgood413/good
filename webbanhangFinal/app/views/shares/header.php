<!DOCTYPE html>
<?php
require_once 'app/helpers/SessionHelper.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
            color: #fff;
            position: fixed;
            width: 250px;
            z-index: 100;
        }
        .sidebar .navbar-brand {
            padding-left: 15px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 12px 20px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,.1);
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,.1);
            color: #fff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        /* Toggle button for mobile */
        .sidebar-toggle {
            display: none;
        }
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
                transition: all 0.3s;
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle {
                display: block;
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="btn btn-dark sidebar-toggle d-md-none" type="button" onclick="toggleSidebar()">
        <span>☰</span>
    </button>

    <!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a class="navbar-brand d-flex align-items-center" href="/Product">
        <img src="/public/images/cart.png" alt="StockEase Logo" class="me-2" width="40">
        StockEase
    </a>
    <ul class="nav flex-column">
    <?php if (SessionHelper::isLoggedIn()): ?>
        <li class="nav-item">
            <a class="nav-link" href="/Product/">
            <i class="bi bi-box-seam me-2"></i> <!-- Cart icon -->
                Danh sách sản phẩm
            </a>
        </li>
    <?php endif; ?>
        
        <!-- Only show 'Add Product' link if the user is an Admin -->
        <?php if (SessionHelper::isAdmin()): ?>
            <li class="nav-item">
                <a class="nav-link" href="/Product/add">
                <i class="bi bi-plus-circle me-2"></i> <!-- Plus circle icon -->
                    Thêm sản phẩm
                </a>
            </li>
        <?php endif; ?>

        <?php if (SessionHelper::isAdmin()): ?>
            <li class="nav-item">
                <a class="nav-link" href="/Category/list">
                <i class="bi bi-folder-plus me-2"></i>
                    danh sách danh mục
                </a>
            </li>
        <?php endif; ?>

        <!-- Show logged-in user's name and role -->
        <li class="nav-item">
            <?php
            if (SessionHelper::isLoggedIn()) {
                echo "<a class='nav-link'> <i class='bi bi-person-circle me-2'></i>" . htmlspecialchars($_SESSION['username'])  . " (" . SessionHelper::getRole() . ") </a> ";
            } else {
                echo "<a class='nav-link' href=' /account/login'><i class='bi bi-box-arrow-in-right me-2'></i>Đăng nhập</a>";
            }
            ?>
        </li>

        <!-- Show logout link if logged in -->
        <li class="nav-item">
            <?php
            if (SessionHelper::isLoggedIn()) {
                echo "<a class='nav-link' href=' /account/logout'>
                <i class='bi bi-box-arrow-right me-2'></i>Đăng xuất
                </a>";
            }
            ?>
        </li>
    </ul>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-4">
            <!-- Content from other files will go here -->
