<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - BD Hospital' : 'BD Hospital'; ?></title>
    <link rel="stylesheet" href="../../assets/css/template_style.css">
    <link rel="stylesheet" href="../../assets/css/<?php echo $_COOKIE['user_type'] ?>.css">
    <script src="../../assets/js/sidebar.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="header-left">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div class="hospital-logo">
                <i class="fas fa-hospital"></i>
                <span>BD Hospital</span>
            </div>
        </div>
        
        <div class="header-center">
           
        </div>

        <div class="header-right">
            <div class="notifications" onclick="toggleNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
                <div class="notifications-dropdown" id="notificationsDropdown">
                    <div class="notification-header">
                        <h4>Notifications</h4>
                        <span class="mark-all-read">Mark all as read</span>
                    </div>
                    <div class="notification-list">
                        <div class="notification-item unread">
                            <i class="fas fa-calendar-check text-success"></i>
                            <div>
                                <p>Appointment confirmed for tomorrow</p>
                                <span class="time">2 min ago</span>
                            </div>
                        </div>
                        <div class="notification-item unread">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            <div>
                                <p>Lab results are ready</p>
                                <span class="time">1 hour ago</span>
                            </div>
                        </div>
                        <div class="notification-item">
                            <i class="fas fa-info-circle text-info"></i>
                            <div>
                                <p>Profile updated successfully</p>
                                <span class="time">3 hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="notification-footer">
                        <a href="#">View all notifications</a>
                    </div>
                </div>
            </div>

            <div class="user-profile" onclick="toggleUserMenu()">
                <img src="https://images.pexels.com/photos/5215024/pexels-photo-5215024.jpeg?auto=compress&cs=tinysrgb&w=50&h=50&fit=crop&crop=face" alt="Profile">
                <div class="user-dropdown" id="userDropdown">
                    <a href="profile.php"><i class="fas fa-user"></i> My Profile</a>
                    <a href="#"><i class="fas fa-cog"></i> Settings</a>
                    <a href="../../controllers/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </header>