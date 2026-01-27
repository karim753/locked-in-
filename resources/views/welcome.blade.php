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
                --light-gray: #f5f5f5;
            }
            body {
                font-family: 'Inter', sans-serif;
            }
            .bg-primary {
                background-color: var(--primary);
            }
            .bg-secondary {
                background-color: var(--secondary);
            }
            .text-primary {
                color: var(--primary);
            }
            .text-secondary {
                color: var(--secondary);
            }
            .hover\:bg-primary:hover {
                background-color: var(--primary-hover);
            }
            .gradient-bg {
                background: linear-gradient(135deg, #2ecc71 0%, #16a085 100%);
            }
            .card-hover {
                transition: all 0.3s ease;
            }
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    </head>
    <body class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-primary text-2xl mr-3"></i>
                        <h1 class="text-xl font-bold text-gray-800">TCR Keuzedeel Systeem</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Uitloggen
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Hero Section -->
        <div class="gradient-bg py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-5xl font-bold text-white mb-6">Techniek College Rotterdam</h1>
                    <p class="text-xl text-white mb-4">Keuzedeel Systeem</p>
                    <p class="text-lg text-white mb-8 max-w-3xl mx-auto">
                        Kies je keuzedeel voor de komende periode en verrijk je opleiding met interessante specialisaties
                    </p>
                    @auth
                        <a href="{{ route('keuzedelen.index') }}" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                            <i class="fas fa-arrow-right mr-2"></i>Bekijk beschikbare keuzedelen
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('login') }}" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>Inloggen om keuzedelen te bekijken
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Waarom keuzedelen bij TCR?</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Verbreed je kennis en ontwikkel specifieke vaardigheden die aansluiten bij jouw interesses en de arbeidsmarkt
                    </p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-user-graduate text-primary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Persoonlijke ontwikkeling</h3>
                        <p class="text-gray-600">Kies keuzedelen die passen bij jouw interesses en carrièredoelen.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-briefcase text-primary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Betere baankansen</h3>
                        <p class="text-gray-600">Ontwikkel specifieke vaardigheden die werkgevers zoeken.</p>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 card-hover">
                        <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-certificate text-primary text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Extra certificaten</h3>
                        <p class="text-gray-600">Behaal erkende certificaten naast je diploma.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Section -->
        <div class="bg-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Hoe werkt het bij TCR?</h2>
                    <p class="text-lg text-gray-600">In 3 eenvoudige stappen naar jouw ideale keuzedeel</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white text-2xl font-bold">1</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Bekijk aanbod</h3>
                        <p class="text-gray-600">Ontdek alle beschikbare keuzedelen voor de komende periode</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white text-2xl font-bold">2</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Maak je keuze</h3>
                        <p class="text-gray-600">Lees de beschrijvingen en kies het keuzedeel dat bij je past</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-white text-2xl font-bold">3</span>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Schrijf je in</h3>
                        <p class="text-gray-600">Inschrijven is eenvoudig en snel via het online systeem</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-primary text-white py-16">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h2 class="text-3xl font-bold mb-6">Klaar om je keuzedeel te kiezen bij TCR?</h2>
                <p class="text-xl mb-8">Log nu in en bekijk alle beschikbare keuzedelen voor de komende periode</p>
                @auth
                    <a href="{{ route('keuzedelen.index') }}" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                        <i class="fas fa-arrow-right mr-2"></i>Bekijk keuzedelen
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-primary px-8 py-3 rounded-md font-medium hover:bg-gray-100 transition-colors inline-flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>Inloggen en starten
                    </a>
                @endauth
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} Techniek College Rotterdam. Alle rechten voorbehouden.</p>
                <div class="mt-4 text-sm text-gray-400">
                    Keuzedeel Systeem - Onderdeel van het onderwijsmanagementsysteem
                </div>
            </div>
        </footer>

        <script>
            // Auto-hide flash messages after 5 seconds
            setTimeout(() => {
                const messages = document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]');
                messages.forEach(msg => msg.style.display = 'none');
            }, 5000);
        </script>
    </body>
</html>