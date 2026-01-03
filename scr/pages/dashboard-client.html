<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client - Express Delivery</title>
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

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
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
    <aside class="w-64 bg-gray-900 border-r border-gray-200 flex flex-col hidden md:flex">
        <div class="h-16 flex items-center px-6 border-b border-gray-100">
            <i class="fas fa-shipping-fast text-indigo-600 text-2xl mr-3"></i>
            <span class="font-bold text-white text-lg tracking-tight">Express<span
                    class="text-indigo-600">Deliv</span></span>
        </div>

        <nav class="flex-1 py-6 space-y-1">
            <button onclick="switchView('orders')" id="nav-orders"
                class="sidebar-link w-full flex items-center px-6 py-3 text-white/50 active">
                <i class="fas fa-box w-6"></i>
                <span class="font-medium ">Mes Commandes</span>
            </button>
            <button onclick="switchView('create')" id="nav-create"
                class="sidebar-link w-full flex items-center px-6 py-3 text-white/50">
                <i class="fas fa-plus-circle w-6"></i>
                <span class="font-medium">Nouvelle Expédition</span>
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
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden ">

        <!-- Header -->
        <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 hover:text-gray-700 mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 id="page-title" class="text-xl font-bold text-gray-800">Tableau de bord</h2>
            </div>

            <div class="flex items-center space-x-6">
                <!-- Notifications -->
                <div class="relative cursor-pointer" onclick="toggleNotifications()">
                    <div class="relative p-2 rounded-full hover:bg-gray-100 transition-colors">
                        <i class="fas fa-bell text-gray-500 text-lg"></i>
                        <span id="notif-badge"
                            class="hidden absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">0</span>
                    </div>
                    <!-- Dropdown -->
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
                <div class="flex items-center space-x-3 pl-6 border-l-2 border-gray-400">
                    <div class="text-right hidden sm:block">
                        <p id="user-name" class="text-sm font-semibold text-gray-900 leading-tight"></p>
                        <p class="text-xs text-gray-600">Client Premium</p>
                    </div>
                    <div
                        class="h-9 w-9 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-bold shadow-sm ring-2 ">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Scrollable Area -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-8">

            <!-- Views -->

            <!-- ORDERS VIEW -->
            <div id="view-orders" class="fade-in max-w-5xl mx-auto">

                <!-- Stats Row (Fake for visual pop) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600 mr-4">
                            <i class="fas fa-box text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Commandes Totales</p>
                            <h4 class="text-2xl font-bold text-gray-800" id="stat-total-orders">-</h4>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600 mr-4">
                            <i class="fas fa-spinner text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">En cours</p>
                            <h4 class="text-2xl font-bold text-gray-800" id="stat-active-orders">-</h4>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                        <div class="p-3 bg-green-50 rounded-xl text-green-600 mr-4">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Livrées</p>
                            <h4 class="text-2xl font-bold text-gray-800" id="stat-done-orders">-</h4>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Vos Expéditions</h3>
                    <button onclick="switchView('create')"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md transition-all flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nouvelle
                    </button>
                </div>

                <div id="orders-container" class="space-y-4">
                    <!-- Orders Injected JS -->
                </div>
            </div>

            <!-- CREATE VIEW -->
            <div id="view-create" class="hidden fade-in max-w-3xl mx-auto">
                <div class="mb-6 flex items-center">
                    <button onclick="switchView('orders')" class="text-gray-400 hover:text-gray-600 mr-4">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800">Nouvelle Expédition</h2>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-8">
                        <form onsubmit="handleCreateOrder(event)" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i> Lieu de ramassage
                                    </label>
                                    <input type="text" name="pickup" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-gray-400"
                                        placeholder="Ex: 12 Rue des Fleurs, Casa">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-flag-checkered text-gray-400 mr-2"></i> Lieu de livraison
                                    </label>
                                    <input type="text" name="dropoff" required
                                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-gray-400"
                                        placeholder="Ex: 45 Av. Hassan II, Rabat">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700">Description du colis</label>
                                <textarea name="description" required rows="4"
                                    class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all placeholder-gray-400"
                                    placeholder="Décrivez le contenu, poids estimé, instructions spéciales..."></textarea>
                            </div>

                            <div class="pt-4 border-t border-gray-100 flex justify-end space-x-4">
                                <button type="button" onclick="switchView('orders')"
                                    class="px-6 py-3 text-gray-600 font-medium hover:bg-gray-50 rounded-lg transition-colors">Annuler</button>
                                <button type="submit"
                                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                                    Publier l'annonce
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PROFILE VIEW -->
            <div id="view-profile" class="hidden fade-in max-w-2xl mx-auto">
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
                                    <p class="text-gray-500 text-sm">Client</p>
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

    <!-- Modal for Offers -->
    <div id="offers-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-tags text-indigo-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Offres reçues</h3>
                            <div class="mt-4">
                                <div id="offers-list" class="space-y-3 max-h-80 overflow-y-auto">
                                    <!-- Dynamic content -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/data.js"></script>
    <script src="js/auth.js"></script>
    <script src="js/notifications.js"></script>
    <script src="js/client.js"></script>
    <script src="js/dashboard-client-ui.js"></script>
</body>

</html>