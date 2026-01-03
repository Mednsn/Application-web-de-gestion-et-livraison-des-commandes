/**
 * driver.js
 * Logic for Driver dashboard: View available orders, submit offers, delivery management.
 */

const Driver = {
    getAvailableOrders() {
        const orders = DataManager.getAll(DB_KEYS.ORDERS);
        // Open orders are 'Créée' or 'En attente d\'offres'
        // Actually Script 4 says "Commandes ouvertes".
        return orders.filter(o => ['Créée', 'En attente d\'offres'].includes(o.status) && o.active)
            .map(order => {
                // Enriched with offer info (Script 4)
                const offers = DataManager.getAll(DB_KEYS.OFFERS).filter(of => of.orderId === order.id);
                const driverIds = offers.map(of => of.driverId);
                const drivers = DataManager.getAll(DB_KEYS.USERS).filter(u => driverIds.includes(u.id));

                return {
                    ...order,
                    offerCount: offers.length,
                    competitors: drivers.map(d => d.name) // Just names, no prices
                };
            });
    },

    submitOffer(driverId, orderId, price, duration, vehicle) {
        // Check if already offered
        const existing = DataManager.getAll(DB_KEYS.OFFERS).find(o => o.orderId === orderId && o.driverId === driverId);
        if (existing) return { success: false, message: 'Vous avez déjà fait une offre pour cette commande.' };

        const offer = {
            id: DataManager.generateId(),
            orderId,
            driverId,
            price: parseFloat(price),
            duration,
            vehicle,
            status: 'pending',
            createdAt: new Date().toISOString()
        };
        DataManager.add(DB_KEYS.OFFERS, offer);

        // Update Order Status via "Client" logic side-effect or direct update
        // Script 5: "Statut commande = En attente d'offres"
        DataManager.update(DB_KEYS.ORDERS, orderId, { status: 'En attente d\'offres' });

        // Notify Client
        const order = DataManager.getAll(DB_KEYS.ORDERS).find(o => o.id === orderId);
        if (order) {
            Notifications.send(order.clientId, `Nouvelle offre reçue pour votre commande #${orderId}.`);
        }

        return { success: true };
    },

    getMyDeliveries(driverId) {
        // Orders where I have an accepted offer
        const myOffers = DataManager.getAll(DB_KEYS.OFFERS).filter(o => o.driverId === driverId && o.status === 'accepted');
        const orderIds = myOffers.map(o => o.orderId);
        const orders = DataManager.getAll(DB_KEYS.ORDERS).filter(o => orderIds.includes(o.id));
        return orders;
    },

    markAsShipped(orderId) {
        // Script 7
        const order = DataManager.getAll(DB_KEYS.ORDERS).find(o => o.id === orderId);
        if (order && order.status === 'En cours de traitement') {
            DataManager.update(DB_KEYS.ORDERS, orderId, { status: 'Expédiée' });
            // Notify Client
            Notifications.send(order.clientId, `Votre commande #${orderId} a été expédiée !`);
            Notifications.send(order.clientId, `Veuillez valider la réception une fois livrée.`);
            return { success: true };
        }
        return { success: false, message: 'Statut incorrect pour cette action.' };
    }
};
