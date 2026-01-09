// kv: dashboard-admin-ui.js
// Init logic
const currentUser = Auth.checkSession();
if (currentUser) {
    renderStats();
    renderUsers();
}

let chartInstance = null;

function switchView(view) {
    document.getElementById('view-stats').classList.add('hidden');
    document.getElementById('view-users').classList.add('hidden');
    document.getElementById('view-profile').classList.add('hidden');

    // Sidebar active management
    document.querySelectorAll('.sidebar-link').forEach(el => el.classList.remove('active'));
    const navBtn = document.getElementById(`nav-${view}`);
    if (navBtn) navBtn.classList.add('active');

    document.getElementById(`view-${view}`).classList.remove('hidden');

    const titles = { 'stats': 'Vue d\'ensemble', 'users': 'Utilisateurs', 'profile': 'Mon Profil' };
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
        document.getElementById('profile-display-name').textContent = updates.name;
    } else {
        alert('Erreur: ' + result.message);
    }
}

function renderStats() {
    const stats = Admin.getStats();
    document.getElementById('stat-total').textContent = stats.totalOrders;
    document.getElementById('stat-done').textContent = stats.ordersCompleted;
    document.getElementById('stat-offers').textContent = stats.totalOffers;
    document.getElementById('stat-drivers').textContent = stats.activeDrivers;

    const ctx = document.getElementById('statusChart').getContext('2d');
    if (chartInstance) chartInstance.destroy();

    chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Créée', 'En attente', 'Traitement', 'Expédiée', 'Terminée', 'Annulée'],
            datasets: [{
                data: [
                    stats.ordersByStatus.created,
                    stats.ordersByStatus.pending,
                    stats.ordersByStatus.processing,
                    stats.ordersByStatus.shipped,
                    stats.ordersCompleted,
                    stats.ordersCancelled
                ],
                backgroundColor: [
                    '#93c5fd', // Blue
                    '#fde047', // Yellow
                    '#c4b5fd', // Purple
                    '#fb923c', // Orange
                    '#86efac', // Green
                    '#fca5a5'  // Red
                ],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { usePointStyle: true, font: { family: 'Inter', size: 11 } } }
            },
            cutout: '70%',
        }
    });
}

function renderUsers() {
    const users = Admin.getAllUsers();
    const tbody = document.getElementById('users-table');
    tbody.innerHTML = '';

    users.forEach(user => {
        const tr = document.createElement('tr');
        tr.className = "hover:bg-gray-50 transition-colors";
        tr.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="h-9 w-9 rounded-full bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center text-indigo-700 font-bold mr-3 shadow-sm text-sm">
                        ${user.name.charAt(0).toUpperCase()}
                    </div>
                    <div class="text-sm font-medium text-gray-900">${user.name}</div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                 <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wide">
                    ${user.role}
                 </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2.5 py-0.5 inline-flex text-xs font-semibold rounded-full ${user.active ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-red-50 text-red-700 border border-red-100'}">
                     <div class="w-1.5 h-1.5 rounded-full ${user.active ? 'bg-green-500' : 'bg-red-500'} mr-1.5 self-center"></div>
                    ${user.active ? 'Actif' : 'Bloqué'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                ${user.role !== 'admin' ? `
                    <button onclick="toggleUser('${user.id}')" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1 rounded-md transition-colors text-xs font-bold">
                        ${user.active ? 'Bloquer' : 'Activer'}
                    </button>
                ` : ''}
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function toggleUser(id) {
    Admin.toggleUserStatus(id);
    renderUsers();
}

function downloadCSV() {
    const csv = Admin.exportCSV();
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.setAttribute('hidden', '');
    a.setAttribute('href', url);
    a.setAttribute('download', 'export_commandes.csv');
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}
