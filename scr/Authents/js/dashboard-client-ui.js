// kv: dashboard-client-ui.js
// Init
const currentUser = Auth.checkSession();
if (currentUser) {
    document.getElementById('user-name').textContent = currentUser.name;
    loadNotifications();
    renderOrders();
}

// --- Logic --- (Logic preserved but UI updated)

function switchView(view) {
    document.getElementById('view-orders').classList.add('hidden');
    document.getElementById('view-create').classList.add('hidden');
    document.getElementById('view-profile').classList.add('hidden');

    // Sidebar active state
    document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active', 'bg-indigo-50', 'text-indigo-600', 'border-r-4', 'border-indigo-600'));

    const navBtn = document.getElementById(`nav-${view}`);
    if (navBtn) {
        navBtn.classList.add('active'); // CSS class handles style
    }

    document.getElementById(`view-${view}`).classList.remove('hidden');

    // Update Title
    const titles = { 'orders': 'Mes Commandes', 'create': 'Nouvelle Expédition', 'profile': 'Mon Profil' };
    document.getElementById('page-title').textContent = titles[view];

    if (view === 'profile') renderProfile();
}

function renderProfile() {
    const user = Auth.getCurrentUser();
    if (!user) return;

    document.getElementById('profile-display-name').textContent = user.name;
    document.getElementById('profile-nom').value = user.nom || '';
    document.getElementById('profile-prenom').value = user.prenom || '';
    document.getElementById('profile-email').value = user.email || '';
}

function handleUpdateProfile(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const updates = {
        nom: formData.get('nom'),
        prenom: formData.get('prenom'),
        name: `${formData.get('nom')} ${formData.get('prenom')}`,
        email: formData.get('email')
    };

    const password = formData.get('password');
    if (password && password.trim() !== '') {
        updates.password = password;
    }

    const result = Auth.updateProfile(currentUser.id, updates);
    if (result.success) {
        alert('Profil mis à jour avec succès !');
        document.getElementById('user-name').textContent = updates.name;
        renderProfile();
    } else {
        alert('Erreur: ' + result.message);
    }
}

function handleCreateOrder(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    Client.createOrder(currentUser.id, data.pickup, data.dropoff, data.description);

    e.target.reset();
    switchView('orders');
    renderOrders();
}

function renderOrders() {
    const orders = Client.getMyOrders(currentUser.id);
    const container = document.getElementById('orders-container');

    // Update Stats (Fake logic for visualization)
    document.getElementById('stat-total-orders').textContent = orders.length;
    document.getElementById('stat-active-orders').textContent = orders.filter(o => !['Terminée', 'Annulée'].includes(o.status)).length;
    document.getElementById('stat-done-orders').textContent = orders.filter(o => o.status === 'Terminée').length;

    container.innerHTML = '';

    if (orders.length === 0) {
        container.innerHTML = `
            <div class="text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                <div class="bg-gray-50 rounded-full h-20 w-20 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-box-open text-gray-300 text-3xl"></i>
                </div>
                <h3 class="text-gray-900 font-medium text-lg">Aucune expédition</h3>
                <p class="text-gray-500 mb-6 max-w-sm mx-auto">Vous n'avez pas encore créé de demande de livraison. Lancez-vous dès maintenant !</p>
                <button onclick="switchView('create')" class="text-indigo-600 font-semibold hover:text-indigo-800 transition-colors">
                    Commencer une expédition &rarr;
                </button>
            </div>
        `;
        return;
    }

    orders.forEach(order => {
        const statusStyles = {
            'Créée': 'bg-blue-100 text-blue-700',
            'En attente d\'offres': 'bg-amber-100 text-amber-700',
            'En cours de traitement': 'bg-indigo-100 text-indigo-700',
            'Expédiée': 'bg-orange-100 text-orange-700',
            'Terminée': 'bg-emerald-100 text-emerald-700',
            'Annulée': 'bg-red-100 text-red-700'
        };

        const offers = Client.getOffersForOrder(order.id);
        const acceptedOffer = offers.find(o => o.status === 'accepted');

        let bottomSection = '';

        // Logic based on status
        if (['Créée', 'En attente d\'offres'].includes(order.status)) {
            bottomSection = `
                <div class="flex items-center space-x-3 mt-4 pt-4 border-t border-gray-50">
                    ${offers.length > 0
                    ? `<button onclick="showOffers('${order.id}')" class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center">
                             <span class="bg-indigo-200 text-indigo-800 text-xs px-2 py-0.5 rounded-full mr-2">${offers.length}</span> Voir les offres
                           </button>`
                    : `<div class="flex-1 text-center py-2 text-sm text-gray-400 bg-gray-50 rounded-lg italic">Aucune offre pour le moment</div>`
                }
                    <button onclick="handleCancel('${order.id}')" class="px-4 py-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Annuler la commande">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
             `;
        } else if (order.status === 'Expédiée') {
            bottomSection = `
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <button onclick="handleValidate('${order.id}')" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-green-200 transition-all flex items-center justify-center animate-pulse">
                        <i class="fas fa-check-circle mr-2"></i> Confirmer la réception
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-2">Le livreur a signalé le colis comme livré.</p>
                </div>
            `;
        } else if (acceptedOffer) {
            bottomSection = `
                <div class="mt-4 bg-indigo-50 rounded-xl p-4 flex items-center justify-between border border-indigo-100">
                     <div class="flex items-center">
                         <div class="h-8 w-8 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                             ${acceptedOffer.driverName.charAt(0)}
                         </div>
                         <div>
                             <p class="text-xs text-gray-500 uppercase font-bold">Livreur</p>
                             <p class="text-sm font-semibold text-indigo-900">${acceptedOffer.driverName}</p>
                         </div>
                     </div>
                     <div class="text-right">
                         <p class="text-lg font-bold text-indigo-700">${acceptedOffer.price} <span class="text-xs">DH</span></p>
                         <p class="text-xs text-indigo-400">${acceptedOffer.vehicle}</p>
                     </div>
                </div>
            `;
        }

        // Delete 'Soft' for History
        if (['Terminée', 'Annulée'].includes(order.status)) {
            // bottomSection += delete button logic if needed, or keeping history clean
            bottomSection += `
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-end">
                    <button onclick="handleDelete('${order.id}')" class="text-xs text-red-300 hover:text-red-500 transition-colors">Supprimer de l'historique</button>
                </div>
             `;
        }

        const card = document.createElement('div');
        card.className = "bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow group";
        card.innerHTML = `
            <div class="flex justify-between items-start mb-6">
                <span class="px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase ${statusStyles[order.status] || 'bg-gray-100'}">
                    ${order.status}
                </span>
                <span class="text-gray-400 text-xs font-medium">${new Date(order.createdAt).toLocaleDateString()}</span>
            </div>

            <div class="relative pl-8 space-y-6 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100">
                <div class="relative">
                    <div class="absolute -left-8 bg-white border-2 border-indigo-100 rounded-full w-6 h-6 flex items-center justify-center">
                        <div class="w-2 h-2 bg-indigo-500 rounded-full"></div>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Ramassage</p>
                    <p class="text-gray-900 font-medium">${order.pickup}</p>
                </div>
                <div class="relative">
                    <div class="absolute -left-8 bg-white border-2 border-pink-100 rounded-full w-6 h-6 flex items-center justify-center">
                        <div class="w-2 h-2 bg-pink-500 rounded-full"></div>
                    </div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Livraison</p>
                    <p class="text-gray-900 font-medium">${order.dropoff}</p>
                </div>
            </div>

            <div class="mt-6 bg-gray-50 rounded-xl p-4 text-sm text-gray-600 leading-relaxed">
                <i class="fas fa-info-circle text-gray-400 mr-2"></i> ${order.description}
            </div>
            
            ${bottomSection}
        `;
        container.appendChild(card);
    });
}

// --- Offer Management UI adaptation ---

function showOffers(orderId) {
    const offers = Client.getOffersForOrder(orderId);
    const list = document.getElementById('offers-list');
    list.innerHTML = '';

    offers.forEach(offer => {
        const el = document.createElement('div');
        el.className = "group border border-gray-200 rounded-xl p-4 hover:border-indigo-300 hover:bg-indigo-50 transition-all cursor-pointer flex justify-between items-center";
        el.innerHTML = `
            <div class="flex items-center">
                <div class="bg-indigo-100 text-indigo-600 w-10 h-10 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-user-circle text-xl"></i>
                </div>
                <div>
                    <div class="flex items-baseline space-x-2">
                        <span class="font-bold text-gray-900 text-lg">${offer.price} DH</span>
                        <span class="text-xs text-gray-500 font-medium bg-white px-2 py-0.5 rounded-full border border-gray-200">${offer.vehicle}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="far fa-clock mr-1"></i> ${offer.duration} • <span class="font-medium text-gray-700">${offer.driverName}</span>
                    </p>
                </div>
            </div>
            <button onclick="handleAcceptOffer('${orderId}', '${offer.id}')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all shadow-md hover:bg-indigo-700">
                Accepter
            </button>
        `;
        list.appendChild(el);
    });

    document.getElementById('offers-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('offers-modal').classList.add('hidden');
}

function handleAcceptOffer(orderId, offerId) {
    Client.acceptOffer(orderId, offerId);
    closeModal();
    renderOrders();
}

function handleCancel(orderId) {
    if (confirm('Annuler cette commande ? (Action irréversible)')) {
        Client.cancelOrder(orderId);
        renderOrders();
    }
}

function handleDelete(orderId) {
    Client.softDeleteOrder(orderId);
    renderOrders();
}

function handleValidate(orderId) {
    const res = Client.validateDelivery(orderId);
    if (res.success) {
        renderOrders();
        // success toast?
    } else {
        alert(res.message);
    }
}

// --- Notifications ---

function loadNotifications() {
    const notifs = Notifications.getAll(currentUser.id);
    const badge = document.getElementById('notif-badge');
    const list = document.getElementById('notif-list');

    const unread = notifs.filter(n => !n.read).length;
    if (unread > 0) {
        badge.textContent = unread;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }

    list.innerHTML = notifs.length ? '' : '<div class="p-4 text-center text-gray-400 text-sm">Rien à signaler.</div>';

    notifs.forEach(n => {
        const item = document.createElement('div');
        item.className = `p-4 border-b border-gray-50 hover:bg-gray-50 cursor-pointer flex items-start ${n.read ? 'opacity-50 grayscale' : ''}`;
        item.onclick = () => {
            Notifications.markAsRead(n.id);
            loadNotifications();
        };
        item.innerHTML = `
            <div class="flex-shrink-0 mr-3">
                <div class="h-2 w-2 rounded-full ${n.read ? 'bg-gray-300' : 'bg-blue-500 mt-1.5'}"></div>
            </div>
            <div>
                <p class="text-sm text-gray-800 leading-snug">${n.message}</p>
                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wide">${new Date(n.date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
            </div>
        `;
        list.appendChild(item);
    });
}

function toggleNotifications() {
    document.getElementById('notif-dropdown').classList.toggle('hidden');
}

setInterval(() => { renderOrders(); loadNotifications(); }, 5000);
