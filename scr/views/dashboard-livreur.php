<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Livreur - Express Delivery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
    <aside class="w-64 bg-gray-900 border-r border-gray-200 flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="fas fa-motorcycle text-indigo-600 text-2xl mr-3"></i>
            <span class="font-bold text-white text-lg tracking-tight">Express<span
                    class="text-indigo-600">Driver</span></span>
        </div>

        <nav class="flex-1 py-6 space-y-1">
            <button onclick="switchView('market')" id="nav-market"
                class="sidebar-link w-full flex items-center px-6 py-3 text-white/50 active">
                <i class="fas fa-search-location w-6"></i>
                <span class="font-medium">Marché de colis</span>
            </button>
            <button onclick="switchView('active')" id="nav-active"
                class="sidebar-link w-full flex items-center px-6 py-3 text-white/50">
                <i class="fas fa-box-open w-6"></i>
                <span class="font-medium">Mes Livraisons</span>
            </button>
            <button onclick="switchView('profile')" id="nav-profile"
                class="sidebar-link w-full flex items-center px-6 py-3 text-white/50">
                <i class="fas fa-user-cog w-6"></i>
                <span class="font-medium">Mon Profil</span>
            </button>
            </div>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <button onclick="Auth.logout()"
                class="w-full flex items-center px-4 py-2 text-sm text-red-400 hover:bg-red-900/20 hover:text-red-300 rounded-lg transition-colors">
                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Header -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 id="page-title" class="text-xl font-bold text-gray-800">Marché des colis</h2>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative cursor-pointer" onclick="toggleNotifications()">
                    <div class="relative p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell text-gray-500 text-lg"></i>
                        <span id="notif-badge"
                            class="hidden absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">0</span>
                    </div>
                    <div id="notif-dropdown"
                        class="hidden absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 z-50 overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                            <span class="font-semibold text-gray-700 text-sm">Notifications</span>
                            <span class="text-xs text-indigo-600 cursor-pointer hover:underline">Tout marquer comme
                                lu</span>
                        </div>
                        <div id="notif-list" class="max-h-80 overflow-y-auto"></div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="flex items-center space-x-3 pl-6 border-l-2 border-gray-500">
                    <div class="text-right hidden sm:block">
                        <p id="user-name" class="text-sm font-semibold text-gray-900 leading-tight">Livreur</p>
                        <p class="text-xs text-gray-500 flex items-center justify-end"><span
                                class="w-2 h-2 rounded-full bg-green-500 mr-1"></span> En ligne</p>
                    </div>
                    <div
                        class="h-9 w-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold shadow-sm ring-2 ring-white">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto bg-gray-100 p-4 sm:p-8">

            <!-- Views -->

            <!-- MARKET VIEW -->
            <div id="view-market" class="fade-in max-w-6xl mx-auto">
                <div
                    class="bg-indigo-600 rounded-2xl p-6 mb-8 text-white shadow-lg flex justify-between items-center bg-gradient-to-r from-indigo-600 to-indigo-800">
                    <div>
                        <h3 class="text-lg font-bold mb-1">Espace Livreur</h3>
                        <p class="text-indigo-100 text-sm opacity-90">Trouvez des missions disponibles et augmentez vos
                            revenus.</p>
                    </div>
                    <i class="fas fa-map-marked-alt text-4xl text-indigo-300 opacity-50"></i>
                </div>

                <div id="market-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Orders Injected Logic -->
                </div>
            </div>

            <!-- ACTIVE VIEW -->
            <div id="view-active" class="hidden fade-in max-w-4xl mx-auto">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Missions en cours</h3>
                <div id="active-container" class="space-y-4">
                    <!-- Active Deliveries -->
                </div>
            </div>

            <!-- PROFILE VIEW -->
            <div id="view-profile" class="hidden  fade-in max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Mon Profil</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <form onsubmit="handleUpdateProfile(event)" class="space-y-6">
                            <div class="flex items-center space-x-6 mb-8">
                                <div
                                    class="h-20 w-20 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-3xl font-bold">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900" id="profile-display-name">Chargement...
                                    </h3>
                                    <p class="text-gray-500 text-sm">Livreur</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" name="nom" id="profile-nom" required
                                        class="w-full px-4 py-2 border bg-black/5 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
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
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition-all">
                                    Enregistrer les modifications
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Offer Modal -->
    <div id="offer-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Faire une offre</h3>
                    <form onsubmit="handleSubmitOffer(event)" class="space-y-4">
                        <input type="hidden" name="orderId" id="modal-order-id">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Votre Prix (DH)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">DH</span>
                                </div>
                                <input type="number" name="price" required min="1"
                                    class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all placeholder-gray-300"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durée estimée</label>
                            <input type="text" name="duration" required placeholder="ex: 30 min"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Véhicule</label>
                            <div class="grid grid-cols-4 gap-2">
                                <!-- Custom Radio Select -->
                                <label class="cursor-pointer">
                                    <input type="radio" name="vehicle" value="Moto" class="peer sr-only" checked>
                                    <div
                                        class="text-center p-2 border rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-500 hover:bg-gray-50 transition-all">
                                        <i class="fas fa-motorcycle block text-lg mb-1"></i> <span
                                            class="text-xs">Moto</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="vehicle" value="Voiture" class="peer sr-only">
                                    <div
                                        class="text-center p-2 border rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-500 hover:bg-gray-50 transition-all">
                                        <i class="fas fa-car block text-lg mb-1"></i> <span class="text-xs">Auto</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="vehicle" value="Camionnette" class="peer sr-only">
                                    <div
                                        class="text-center p-2 border rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-500 hover:bg-gray-50 transition-all">
                                        <i class="fas fa-truck block text-lg mb-1"></i> <span
                                            class="text-xs">Camion</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="vehicle" value="Vélo" class="peer sr-only">
                                    <div
                                        class="text-center p-2 border rounded-lg peer-checked:bg-indigo-50 peer-checked:border-indigo-500 hover:bg-gray-50 transition-all">
                                        <i class="fas fa-bicycle block text-lg mb-1"></i> <span
                                            class="text-xs">Vélo</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 text-gray-500 hover:text-gray-700 font-medium">Annuler</button>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold shadow-lg hover:bg-indigo-700 transition-all">Envoyer
                                l'offre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/data.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/notifications.js"></script>
    <script src="js/driver.js"></script>
    <script src="js/dashboard-driver-ui.js"></script>
</body>

</html>