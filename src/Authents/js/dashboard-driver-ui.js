

function openOfferModal(orderId) {
    document.getElementById('modal-order-id').value = orderId;
    document.getElementById('offer-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('offer-modal').classList.add('hidden');
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
