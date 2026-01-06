<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Express Delivery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sidebar-link {
            transition: all 0.2s;
        }

        .sidebar-link.active {
            background-color: #1f2937;
            color: white;
            border-left: 4px solid #6366f1;
        }

        .sidebar-link:hover:not(.active) {
            background-color: #111827;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50 h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-gray-400  flex-col hidden md:flex shadow-xl z-20">
        <div class="h-16 flex items-center px-6 border-b border-gray-800 bg-gray-900">
            <i class="fas fa-shield-alt text-indigo-500 text-xl mr-3"></i>
            <span class="font-bold text-white text-lg tracking-tight">Express<span
                    class="text-indigo-500">Admin</span></span>
        </div>

        <nav class="flex-1 py-6 space-y-1">
            <button onclick="switchView('stats')" id="nav-stats"
                class="sidebar-link w-full flex items-center px-6 py-3 active">
                <i class="fas fa-chart-pie w-6"></i>
                <span class="font-medium">Vue d'ensemble</span>
            </button>
            <button onclick="switchView('users')" id="nav-users"
                class="sidebar-link w-full flex items-center px-6 py-3">
                <i class="fas fa-users-cog w-6"></i>
                <span class="font-medium">Utilisateurs</span>
            </button>
            <button onclick="switchView('profile')" id="nav-profile"
                class="sidebar-link w-full flex items-center px-6 py-3">
                <i class="fas fa-user-circle w-6"></i>
                <span class="font-medium">Mon Profil</span>
            </button>
        </nav>

        <div class="p-4 border-t border-gray-800 bg-gray-900">
            <button onclick="Auth.logout()"
                class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header -->
        <header
            class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 id="page-title" class="text-xl font-bold text-gray-800">Vue d'ensemble</h2>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900 leading-tight">Administrateur</p>
                        <p class="text-xs text-gray-500">Super User</p>
                    </div>
                    <div
                        class="h-9 w-9 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold shadow-sm ring-2 ring-gray-100">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-8">

            <!-- STATS VIEW -->
            <div id="view-stats" class="fade-in max-w-7xl mx-auto">

                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Tableau de bord</h3>
                        <p class="text-sm text-gray-500">Aperçu en temps réel de l'activité.</p>
                    </div>
                    <button onclick="downloadCSV()"
                        class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-all flex items-center">
                        <i class="fas fa-download mr-2 text-gray-400"></i> Exporter CSV
                    </button>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-full w-1 bg-blue-500"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Commandes
                                </p>
                                <h4 class="text-3xl font-bold text-gray-900" id="stat-total">0</h4>
                            </div>
                            <div
                                class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <i class="fas fa-shopping-bag text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-full w-1 bg-green-500"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Livraisons
                                    Terminées</p>
                                <h4 class="text-3xl font-bold text-gray-900" id="stat-done">0</h4>
                            </div>
                            <div
                                class="p-3 bg-green-50 rounded-xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-full w-1 bg-indigo-500"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Offres Totales
                                </p>
                                <h4 class="text-3xl font-bold text-gray-900" id="stat-offers">0</h4>
                            </div>
                            <div
                                class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <i class="fas fa-hand-holding-usd text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 h-full w-1 bg-amber-500"></div>
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Livreurs Actifs
                                </p>
                                <h4 class="text-3xl font-bold text-gray-900" id="stat-drivers">0</h4>
                            </div>
                            <div
                                class="p-3 bg-amber-50 rounded-xl text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                                <i class="fas fa-motorcycle text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Area -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h4 class="text-lg font-bold text-gray-800 mb-4">Répartition des statuts</h4>
                        <div class="relative h-64 w-full">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                    <!-- Placeholder for another chart or recent activity -->
                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-center items-center text-center">
                        <div class="bg-gray-50 rounded-full p-4 mb-4">
                            <i class="fas fa-chart-line text-gray-300 text-3xl"></i>
                        </div>
                        <h4 class="text-gray-900 font-medium">Analyses avancées</h4>
                        <p class="text-gray-500 text-sm mt-2 max-w-xs">Bientôt disponible : revenus mensuels, temps
                            moyen de livraison et performance par zone.</p>
                    </div>
                </div>

            </div>

            <!-- USERS VIEW -->
            <div id="view-users" class="hidden fade-in max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Gestion Utilisateurs</h3>
                        <p class="text-sm text-gray-500">Gérez les accès et les permissions.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Utilisateur</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Contact</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Rôle</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Statut</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100" id="users-table">
                                <!-- JS Injection -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PROFILE VIEW -->
            <div id="view-profile" class="hidden fade-in max-w-3xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Mon Profil</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <form onsubmit="handleUpdateProfile(event)" class="space-y-6">
                            <div class="flex items-center space-x-6 mb-8">
                                <div
                                    class="h-20 w-20 bg-gray-900 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900" id="profile-display-name">Chargement...
                                    </h3>
                                    <p class="text-gray-500 text-sm">Administrateur</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="nom" id="profile-nom" required
                                        class="bg-black/5 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                                    <input type="text" name="prenom" id="profile-prenom" required
                                        class="bg-black/5 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" id="profile-email" required
                                    class="bg-black/5 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe
                                    (optionnel)</label>
                                <input type="password" name="password" placeholder="Laisser vide pour ne pas changer"
                                    class="bg-black/5 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                            </div>

                            <div class="pt-4 border-t border-gray-100 text-right">
                                <button type="submit"
                                    class="bg-gray-900 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-gray-800 transition-all">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script src="js/data.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/admin.js"></script>
    <script src="js/dashboard-admin-ui.js"></script>
</body>

</html>