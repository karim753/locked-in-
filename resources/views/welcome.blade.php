<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Keuzedeel Systeem - Kies je keuzedeel voor de komende periode">

        <title>Keuzedeel Systeem - Techniek College Rotterdam</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            :root {
                --primary: #2ecc71;
                --primary-hover: #27ae60;
                --secondary: #16a085;
                --accent: #27ae60;
                --success: #2ecc71;
                --warning: #f39c12;
                --danger: #e74c3c;
            }
            body {
                font-family: 'Inter', sans-serif;
            }
            .gradient-bg {
                background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }
            .btn-primary {
                background: var(--primary);
                color: white;
                padding: 0.75rem 2rem;
                border-radius: 0.5rem;
                font-weight: 600;
                transition: all 0.2s ease;
                border: none;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                text-decoration: none;
            }
            .btn-primary:hover {
                background: var(--primary-hover);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(46, 204, 113, 0.3);
            }
            .btn-secondary {
                background: white;
                color: var(--primary);
                padding: 0.75rem 2rem;
                border-radius: 0.5rem;
                font-weight: 600;
                transition: all 0.2s ease;
                border: 2px solid var(--primary);
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                text-decoration: none;
            }
            .btn-secondary:hover {
                background: var(--primary);
                color: white;
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(46, 204, 113, 0.3);
            }
            .feature-icon {
                width: 4rem;
                height: 4rem;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
                box-shadow: 0 10px 25px -5px rgba(46, 204, 113, 0.2);
            }
            .nav-blur {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .float-animation {
                animation: float 6s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="nav-blur shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">TCR Keuzedeel Systeem</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-2" title="Uitloggen">
                                        <i class="fas fa-sign-out-alt text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn-primary">
                                <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
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

        <!-- Hero Section -->
        <div class="gradient-bg py-24 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <!-- Animated Background Elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full float-animation"></div>
            <div class="absolute top-32 right-20 w-16 h-16 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-20 left-32 w-12 h-12 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 4s;"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-6">
                        <i class="fas fa-graduation-cap text-white text-3xl"></i>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Techniek College Rotterdam</h1>
                    <p class="text-2xl text-white mb-8 font-light">Keuzedeel Systeem</p>
                    <p class="text-xl text-white mb-12 max-w-3xl mx-auto leading-relaxed">
                        Kies je keuzedeel voor de komende periode en verrijk je opleiding met interessante specialisaties
                    </p>
                    @auth
                        <a href="{{ route('keuzedelen.index') }}" class="btn-secondary">
                            <i class="fas fa-arrow-right mr-2"></i>Bekijk beschikbare keuzedelen
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="btn-secondary">
                                <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary">
                                <i class="fas fa-user-plus mr-2"></i>Account aanmaken
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Waarom keuzedelen bij TCR?</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                        Verbreed je kennis en ontwikkel specifieke vaardigheden die aansluiten bij jouw interesses en de arbeidsmarkt
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl shadow-xl p-8 card-hover border border-gray-100">
                        <div class="feature-icon">
                            <i class="fas fa-user-graduate text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Persoonlijke ontwikkeling</h3>
                        <p class="text-gray-600 leading-relaxed">Ontwikkel je talenten en interesses met keuzedelen die passen bij jouw persoonlijke doelen en ambities.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl p-8 card-hover border border-gray-100">
                        <div class="feature-icon">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Carrière voordeel</h3>
                        <p class="text-gray-600 leading-relaxed">Versterk je CV met speciale vaardigheden die werkgevers zoeken in de technische sector.</p>
                    </div>
                    <div class="bg-white rounded-2xl shadow-xl p-8 card-hover border border-gray-100">
                        <div class="feature-icon">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-4 text-gray-900">Expertise vergroten</h3>
                        <p class="text-gray-600 leading-relaxed">Word expert in jouw vakgebied met gespecialiseerde kennis en praktische ervaring.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">Cijfers in één oogopslag</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Ontdek de impact van ons keuzedeel systeem
                    </p>
                </div>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="text-5xl font-bold text-primary mb-2">50+</div>
                        <p class="text-gray-600 font-medium">Keuzedelen</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-secondary mb-2">1000+</div>
                        <p class="text-gray-600 font-medium">Studenten</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-accent mb-2">15+</div>
                        <p class="text-gray-600 font-medium">Opleidingen</p>
                    </div>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-success mb-2">95%</div>
                        <p class="text-gray-600 font-medium">Tevredenheid</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold">TCR Keuzedeel Systeem</h3>
                    </div>
                    <p class="text-gray-400 mb-4">Techniek College Rotterdam</p>
                    <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Alle rechten voorbehouden.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
