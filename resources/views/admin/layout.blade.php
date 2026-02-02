<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Keuzedelen Systeem</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2ecc71;
            --primary-hover: #27ae60;
            --secondary: #16a085;
            --success: #2ecc71;
            --warning: #f39c12;
            --danger: #e74c3c;
            --dark: #1f2937;
            --light: #f3f4f6;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        
        .card-shadow:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }
        
        .nav-item {
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
        }
        
        .nav-item:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: var(--primary);
            color: white;
        }
        
        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            border-left: 4px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .badge-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }
        
        .badge-warning {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning);
        }
        
        .badge-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
        }
        
        .toggle-switch {
            position: relative;
            width: 2.75rem;
            height: 1.5rem;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: 0.4s;
            border-radius: 1.5rem;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 1.125rem;
            width: 1.125rem;
            left: 0.1875rem;
            bottom: 0.1875rem;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: var(--primary);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(1.25rem);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-xl">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Keuzedelen</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>
            
            <nav class="px-4 pb-6">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-chart-line mr-3"></i>
                        Dashboard
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Beheer</h3>
                    </div>
                    
                    <a href="{{ route('admin.keuzedelen.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.keuzedelen.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-book mr-3"></i>
                        Keuzedelen
                    </a>
                    
                    <a href="{{ route('admin.periods.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.periods.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-calendar mr-3"></i>
                        Periodes
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-users mr-3"></i>
                        Gebruikers
                    </a>
                    
                    <div class="pt-4 pb-2">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Analyse</h3>
                    </div>
                    
                    <a href="{{ route('admin.statistics') }}" 
                       class="nav-item flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.statistics') ? 'active' : 'text-gray-700 hover:text-gray-900' }}">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Statistieken
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500 mt-1">@yield('page-description', 'Beheer het keuzedelen systeem')</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        
                        <!-- User Menu -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                            </div>
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                        </div>
                        
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-gray-400 hover:text-red-600 transition-colors"
                                    title="Uitloggen">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-400 p-4 m-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-400 p-4 m-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="flex-1 p-6">
                @yield('admin-content')
            </main>
        </div>
    </div>

    <script>
        // Auto-hide notifications after 5 seconds
        setTimeout(() => {
            const notifications = document.querySelectorAll('.bg-green-50, .bg-red-50');
            notifications.forEach(notification => {
                notification.style.transition = 'opacity 0.5s ease';
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
