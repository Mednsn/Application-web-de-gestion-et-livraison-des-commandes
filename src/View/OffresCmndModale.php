<?php
session_start();
require_once __DIR__ . '/../Service/userService.php';
require_once __DIR__ . '/../Service/CommandeService.php';
require_once __DIR__ . '/../Service/OfferService.php';


$cmndServc = new CommandeService();
$offres = new OfferService();
$userser = new UserService();

$cmndId = $_POST['offreComnd'];

// $user = $userser->findUser($email);
// $cmnd = $cmndServc->selectAllCommndClient($user->id);


$arrayoffres = $offres->selectAllByOffre(7);

?>


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
    <aside class="w-64 bg-gray-900 border-r border-gray-200  flex-col hidden md:flex">
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
                        <p id="user-name" class="text-sm font-semibold text-gray-900 leading-tight">

                        </p>
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
                    <button onclick="switchView('create')" id="nouvelle"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-md transition-all flex items-center">
                        <i class="fas fa-plus mr-2"></i> Nouvelle
                    </button>
                </div>

                <div id="orders-container" class="space-y-4  ">


                    <div class="shadow-xl p-10 border border-t-2 ">
                        <div class="flex justify-between items-start mb-6 ">
                            <span class="px-4 py-1 rounded-full text-xs font-bold tracking-wide uppercase bg-blue-200">

                            </span>
                            <span class="text-gray-400  text-xs font-medium"></span>
                        </div>

                        <div class="relative pl-8 space-y-6 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100">
                            <div class="relative">
                                <div class="absolute -left-8 bg-white border-2 border-indigo-100 rounded-full w-6 h-6 flex items-center justify-center">
                                    <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                                </div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Ramassage</p>
                                <p class="text-gray-900 font-medium"></p>
                            </div>
                            <div class="relative">
                                <div class="absolute -left-8 bg-white border-2 border-pink-100 rounded-full w-6 h-6 flex items-center justify-center">
                                    <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                                </div>
                                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Livraison</p>
                                <p class="text-gray-900 font-medium"></p>
                            </div>
                        </div>

                        <div class="mt-6 bg-gray-50 rounded-xl p-4 text-sm text-gray-600 leading-relaxed">
                            <i class="fas fa-info-circle text-gray-400 mr-2"></i>
                        </div>

                        <div class="flex items-center space-x-3 mt-4 pt-4 border-t border-gray-50">


                            <button class="flex-1 w-full bg-indigo-200 hover:bg-indigo-500 text-indigo-800 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center">
                                <span class="bg-indigo-300 text-indigo-800 text-xs px-2 py-0.5 rounded-full mr-2">offers length</span> Voir les offres
                            </button>



                            <div class="flex-1 text-center py-2 text-sm text-gray-400 bg-gray-50 rounded-lg italic">Aucune offre pour le moment</div>


                            <form class="px-4 py-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Annuler la commande" method="POST" action="../Controler/CrudCommandController.php">
                                <input type="hidden" name="crud" value="delete">
                                <input type="hidden" name="id" value="">
                                <button type="submit"> <i class="fas fa-trash-alt"></i></button>

                            </form>
                        </div>
                    </div>


                    <!-- jhgjkjbjhbiuibjbjh trwuy -->

                    <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="bg-gray-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-box-open text-gray-300 text-3xl"></i>
                        </div>
                        <h3 class="text-gray-900 font-medium text-lg">Aucune expédition</h3>
                        <p class="text-gray-500 mb-6 max-w-sm mx-auto">Vous n'avez pas encore créé de demande de livraison. Lancez-vous dès maintenant !</p>
                        <button onclick="switchView('create')" class="text-indigo-600 font-semibold hover:text-indigo-800 transition-colors">
                            Commencer une expédition &rarr;
                        </button>
                        <!-- jhgjkjbjhbiuibjbjh trwuy -->

                    </div>

                </div>
            </div>

            <!-- CREATE VIEW -->


            <!-- PROFILE VIEW -->


        </main>
    </div>

    <!-- Modal for Offers -->
    <div id="offers-modal" class="block bg-black/75 fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

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
                                <div id="offers-list" class="space-y-3 max-h-80  overflow-y-auto">
                                    <!-- Dynamic content -->
                                    <?php if($arrayoffres) foreach ($arrayoffres as $offrs) : $userL=$offres->selectLivreurOffresByid($offrs->livreur_id); ?>
                                        <div class="group border border-gray-200 rounded-xl p-4 hover:border-indigo-300 hover:bg-indigo-50 transition-all cursor-pointer flex justify-between items-center">
                                            <div class="flex b items-center">
                                                <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-user-circle text-xl"></i>
                                                </div>
                                                <div>
                                                    <div class="flex items-baseline space-x-2">
                                                        <span class="font-bold text-gray-900 text-lg"><?php echo $userL->prix ?> DH</span>
                                                        <span class="text-xs text-gray-500 font-medium bg-white px-2 py-0.5 rounded-full border border-gray-200"><?php echo $userL->vehicule ?> </span>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <i class="far fa-clock mr-1"></i> <?php echo $userL->duree_estimee ?> • <span class="font-medium text-gray-700"><?php echo $userL->username ?> </span>
                                                    </p>
                                                </div>
                                            </div>
                                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all shadow-md hover:bg-indigo-700">
                                                Accepter
                                            </button>

                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a href="dashboard-client.php"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Fermer
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- <script src="../Authents/js/data.js"></script>
    <script src="../Authents/js/auth.js"></script>
    <script src="../Authents/js/notifications.js"></script>
    <script src="../Authents/js/client.js"></script>
    <script src="../Authents/js/dashboard-client.js"></script> -->
</body>

</html>