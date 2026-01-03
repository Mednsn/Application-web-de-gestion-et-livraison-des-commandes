// kv: dashboard-driver-ui.js
const currentUser = Auth.checkSession();
if (currentUser) {
    document.getElementById('user-name').textContent = currentUser.name;
    loadNotifications();
    renderMarket();
}

function switchView(view) {
    document.getElementById('view-market').classList.add('hidden');
    document.getElementById('view-active').classList.add('hidden');
    document.getElementById('view-profile').classList.add('hidden');

    // Sidebar active state
    document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active', 'bg-indigo-50', 'text-indigo-600', 'border-r-4', 'border-indigo-600'));
    document.getElementById(`nav-${view}`).classList.add('active');

    document.getElementById(`view-${view}`).classList.remove('hidden');

    const titles = { 'market': 'Marché des colis', 'active': 'Mes Livraisons', 'profile': 'Mon Profil' };
    document.getElementById('page-title').textContent = titles[view];

    if (view === 'market') renderMarket();
    if (view === 'active') renderActive();
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

function renderMarket() {
    const orders = Driver.getAvailableOrders();
    const container = document.getElementById('market-container');
    container.innerHTML = '';

    if (orders.length === 0) {
        container.innerHTML = `
        <div class="col-span-full text-center py-12 bg-white rounded-2xl border-2 border-dashed border-gray-200">
            <div class="bg-gray-50 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-search text-gray-300 text-2xl"></i>
            </div>
            <p class="text-gray-500">Aucune commande disponible sur le marché pour le moment.</p>
        </div>`;
        return;
    }

    orders.forEach(order => {
        const card = document.createElement('div');
        card.className = "bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all p-0 overflow-hidden flex flex-col h-full";
        card.innerHTML = `
            <div class="p-6 flex flex-col flex-1">
                <div class="flex justify-between items-start mb-4">
                    <span class="bg-indigo-50 text-indigo-700 text-[10px] px-2 py-1 rounded-full font-bold uppercase tracking-wide">Course</span>
                    <span class="text-xs text-gray-400 font-medium"><i class="far fa-clock mr-1"></i> ${new Date(order.createdAt).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                </div>
                
                <div class="space-y-4 mb-4 flex-grow relative pl-4 border-l-2 border-gray-100 ml-1">
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-white border-2 border-indigo-500"></div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Départ</p>
                        <p class="text-sm font-semibold text-gray-800 leading-tight">${order.pickup}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-white border-2 border-pink-500"></div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Arrivée</p>
                        <p class="text-sm font-semibold text-gray-800 leading-tight">${order.dropoff}</p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600 mb-4 line-clamp-2">
                    ${order.description}
                </div>

                <div class="flex items-center justify-between text-xs text-gray-500 mt-auto pt-4 border-t border-gray-50">
                    <div class="flex items-center">
                        <i class="fas fa-users text-gray-400 mr-2"></i> ${order.competitors.length} concurrents
                    </div>
                    <div class="font-bold text-gray-900">Offre max: --</div>
                </div>
            </div>
            <button onclick="openOfferModal('${order.id}')" class="w-full bg-gray-50 hover:bg-indigo-600 hover:text-white text-indigo-600 font-bold py-3 text-sm transition-colors border-t border-gray-100">
                Faire une offre
            </button>
        `;
        container.appendChild(card);
    });
}

function renderActive() {
    const orders = Driver.getMyDeliveries(currentUser.id);
    const container = document.getElementById('active-container');
    container.innerHTML = '';

    if (orders.length === 0) {
        container.innerHTML = `<div class="p-8 text-center text-gray-500 bg-white rounded-xl shadow-sm">Vous n'avez aucune livraison active. Allez au marché pour en trouver !</div>`;
        return;
    }

    orders.forEach(order => {
        const isShipped = order.status === 'Expédiée';
        const isDone = order.status === 'Terminée';

        let actionBtn = '';
        if (order.status === 'En cours de traitement') {
            actionBtn = `<button onclick="handleShipped('${order.id}')" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-blue-200 transition-all flex items-center">
                <i class="fas fa-box-check mr-2"></i> Marquer comme Livré
            </button>`;
        } else if (isShipped) {
            actionBtn = `<div class="bg-orange-50 text-orange-600 font-bold px-4 py-3 rounded-xl border border-orange-100 flex items-center"><i class="fas fa-hourglass-half mr-2"></i> En attente client</div>`;
        } else if (isDone) {
            actionBtn = `<div class="bg-green-50 text-green-600 font-bold px-4 py-3 rounded-xl border border-green-100 flex items-center"><i class="fas fa-check-double mr-2"></i> Terminée</div>`;
        }

        const card = document.createElement('div');
        card.className = "bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-6 border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6";
        card.innerHTML = `
            <div class="flex-1 w-full">
                <div class="flex items-center space-x-3 mb-4">
                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-bold rounded-full">#${order.id.substring(0, 8)}</span>
                    ${isDone ? '<span class="text-green-500 text-xs font-bold uppercase">Terminé</span>' : '<span class="text-blue-500 text-xs font-bold uppercase animate-pulse">En cours</span>'}
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Ramassage</p>
                        <p class="font-semibold text-gray-800 text-lg">${order.pickup}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold mb-1">Livraison</p>
                        <p class="font-semibold text-gray-800 text-lg">${order.dropoff}</p>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100 inline-block">
                     Notes: ${order.description}
                </div>
            </div>
            <div class="w-full md:w-auto flex justify-center">
                ${actionBtn}
            </div>
        `;
        container.appendChild(card);
    });
}

// --- Offer Modal logic --- (Preserved)

function openOfferModal(orderId) {
    document.getElementById('modal-order-id').value = orderId;
    document.getElementById('offer-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('offer-modal').classList.add('hidden');
}

function handleSubmitOffer(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    const result = Driver.submitOffer(currentUser.id, data.orderId, data.price, data.duration, data.vehicle);

    if (result.success) {
        closeModal();
        e.target.reset();
        renderMarket();
        // Custom Toast could go here
        alert('Offre envoyée avec succès !');
    } else {
        alert(result.message);
    }
}

function handleShipped(orderId) {
    if (confirm('Confirmer que vous avez expédié/livré le colis ?')) {
        const res = Driver.markAsShipped(orderId);
        if (res.success) {
            renderActive();
        } else {
            alert(res.message);
        }
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

    list.innerHTML = notifs.length ? '' : '<div class="p-4 text-center text-gray-400 text-sm">Aucune notification</div>';

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

setInterval(() => {
    if (!document.getElementById('view-market').classList.contains('hidden')) renderMarket();
    loadNotifications();
}, 5000);
