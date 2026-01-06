/**
 * client.js
 * Logic for Client dashboard: Create order, manage orders, handle offers.
 */

const Client = {
    createOrder(userId, pickup, dropoff, description) {
        const order = {
            id: DataManager.generateId(),
            clientId: userId,
            pickup,
            dropoff,
            description,
            status: 'Créée', // Initial status
            createdAt: new Date().toISOString(),
            active: true // For soft delete
        };
        DataManager.add(DB_KEYS.ORDERS, order);
        return order;
    },

    getMyOrders(userId) {
        const allOrders = DataManager.getAll(DB_KEYS.ORDERS);
        return allOrders.filter(o => o.clientId === userId && o.active).sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
    },

    cancelOrder(orderId) {
        // Only if 'Créée' or 'En attente d'offres'
        const order = DataManager.getAll(DB_KEYS.ORDERS).find(o => o.id === orderId);
        if (!order) return { success: false, message: 'Commande introuvable' };

        if (['Créée', 'En attente d\'offres'].includes(order.status)) {
            DataManager.update(DB_KEYS.ORDERS, orderId, { status: 'Annulée' });
            // Logic to cancel offers could be added here
            return { success: true };
        }
        return { success: false, message: 'Impossible d\'annuler une commande en cours' };
    },

    softDeleteOrder(orderId) {
        DataManager.update(DB_KEYS.ORDERS, orderId, { active: false });
    },

    getOffersForOrder(orderId) {
        const offers = DataManager.getAll(DB_KEYS.OFFERS);
        // Join with driver info if needed, but for now just the offer
        // We need driver name, so let's fetch it manually
        const drivers = DataManager.getAll(DB_KEYS.USERS);

        return offers
            .filter(o => o.orderId === orderId)
            .map(offer => {
                const driver = drivers.find(u => u.id === offer.driverId);
                return { ...offer, driverName: driver ? driver.name : 'Inconnu' };
            });
    },

    acceptOffer(orderId, offerId) {
        const order = DataManager.getAll(DB_KEYS.ORDERS).find(o => o.id === orderId);

        // 1. Update Order Status
        DataManager.update(DB_KEYS.ORDERS, orderId, { status: 'En cours de traitement' });

        // 2. Update Offers Status
        const offers = DataManager.getAll(DB_KEYS.OFFERS);
        offers.forEach(o => {
            if (o.orderId === orderId) {
                if (o.id === offerId) {
                    DataManager.update(DB_KEYS.OFFERS, o.id, { status: 'accepted' });
                    // Notify Driver
                    Notifications.send(o.driverId, `Votre offre pour la commande #${orderId} a été acceptée !`);
                } else {
                    DataManager.update(DB_KEYS.OFFERS, o.id, { status: 'rejected' });
                }
            }
        });
    },

    validateDelivery(orderId) {
        const order = DataManager.getAll(DB_KEYS.ORDERS).find(o => o.id === orderId);
        if (order.status === 'Expédiée') {
            DataManager.update(DB_KEYS.ORDERS, orderId, { status: 'Terminée' });
            // Notify driver? Maybe.
            // Find accepted offer to notify driver
            const offers = DataManager.getAll(DB_KEYS.OFFERS);
            const acceptedOffer = offers.find(o => o.orderId === orderId && o.status === 'accepted');
            if (acceptedOffer) {
                Notifications.send(acceptedOffer.driverId, `Le client a validé la livraison de la commande #${orderId}. Bon travail !`);
            }
            return { success: true };
        }
        return { success: false, message: 'La commande n\'est pas encore expédiée par le livreur.' };
    }
};
