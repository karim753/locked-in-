<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registreren - TCR Keuzedeel Systeem">
    <title>Registreren - TCR Keuzedeel Systeem</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #2ecc71;
            --primary-hover: #27ae60;
            --secondary: #16a085;
            --accent: #27ae60;
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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
            width: 100%;
        }
        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(46, 204, 113, 0.3);
        }
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.1);
        }
        .input-field.error {
            border-color: #ef4444;
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
    <!-- Hero Section -->
    <div class="gradient-bg py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <!-- Animated Background Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-white opacity-10 rounded-full float-animation"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 left-32 w-12 h-12 bg-white opacity-10 rounded-full float-animation" style="animation-delay: 4s;"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-6">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">Techniek College Rotterdam</h1>
                <p class="text-2xl text-white mb-8 font-light">Keuzedeel Systeem</p>
                <p class="text-xl text-white mb-12 max-w-2xl mx-auto leading-relaxed">
                    Maak een account aan om keuzedelen te bekijken en in te schrijven
                </p>
            </div>
        </div>
    </div>

    <!-- Register Form -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                            <i class="fas fa-user-plus text-white text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Account Aanmaken</h2>
                        <p class="text-green-100">TCR Keuzedeel Systeem</p>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Volledige naam</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input id="name" type="text" 
                                       class="input-field pl-10 @error('name') error @enderror" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autocomplete="name" 
                                       autofocus
                                       placeholder="Jouw volledige naam">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mailadres</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input id="email" type="email" 
                                       class="input-field pl-10 @error('email') error @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email"
                                       placeholder="jouw.email@example.com">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                </div>
                                <select id="role" 
                                        name="role" 
                                        class="input-field pl-10 @error('role') error @enderror" 
                                        required>
                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="slber" {{ old('role') == 'slber' ? 'selected' : '' }}>SLBer</option>
                                </select>
                            </div>
                            @error('role')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(old('role') == 'student')
                            <div class="mb-6">
                                <label for="study_program" class="block text-sm font-medium text-gray-700 mb-2">Opleiding</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-graduation-cap text-gray-400"></i>
                                    </div>
                                    <input id="study_program" type="text" 
                                           class="input-field pl-10 @error('study_program') error @enderror" 
                                           name="study_program" 
                                           value="{{ old('study_program') }}" 
                                           placeholder="Bijv. Software Development">
                                </div>
                                @error('study_program')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="student_number" class="block text-sm font-medium text-gray-700 mb-2">Studentnummer</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input id="student_number" type="text" 
                                           class="input-field pl-10 @error('student_number') error @enderror" 
                                           name="student_number" 
                                           value="{{ old('student_number') }}" 
                                           placeholder="Bijv. 1234567">
                                </div>
                                @error('student_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Wachtwoord</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password" type="password" 
                                       class="input-field pl-10 @error('password') error @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="••••••••••">
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Bevestig wachtwoord</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input id="password_confirmation" type="password" 
                                       class="input-field pl-10" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password"
                                       placeholder="••••••••••">
                            </div>
                        </div>

                        <div class="mb-6">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-user-plus mr-2"></i>Account Aanmaken
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Al een account? 
                                <a href="{{ route('login') }}" class="font-medium text-primary hover:text-primary-hover">
                                    Inloggen
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 text-center">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hulp nodig?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope text-primary mr-2"></i>
                            <span>Neem contact op met de helpdesk</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-book text-primary mr-2"></i>
                            <span>Bekijk de handleiding</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone text-primary mr-2"></i>
                            <span>Bel 010 - 123 4567</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide student fields based on role selection
        const roleSelect = document.getElementById('role');
        const studyProgramField = document.getElementById('study_program')?.parentElement.parentElement;
        const studentNumberField = document.getElementById('student_number')?.parentElement.parentElement;

        function toggleStudentFields() {
            if (roleSelect.value === 'student') {
                if (studyProgramField) studyProgramField.style.display = 'block';
                if (studentNumberField) studentNumberField.style.display = 'block';
            } else {
                if (studyProgramField) studyProgramField.style.display = 'none';
                if (studentNumberField) studentNumberField.style.display = 'none';
            }
        }

        roleSelect.addEventListener('change', toggleStudentFields);
        toggleStudentFields();

        // Auto-hide error messages after 5 seconds
        setTimeout(() => {
            const errorDiv = document.querySelector('.bg-red-50');
            if (errorDiv) {
                errorDiv.style.transition = 'opacity 0.5s ease';
                errorDiv.style.opacity = '0';
                setTimeout(() => errorDiv.remove(), 500);
            }
        }, 5000);
    </script>
</body>
</html>
