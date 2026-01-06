/**
 * notifications.js
 * Handles creating and retrieving notifications.
 */

const Notifications = {
    send(userId, message) {
        const notif = {
            id: DataManager.generateId(),
            userId,
            message,
            date: new Date().toISOString(),
            read: false
        };
        DataManager.add(DB_KEYS.NOTIFICATIONS, notif);
    },

    getAll(userId) {
        const all = DataManager.getAll(DB_KEYS.NOTIFICATIONS);
        return all.filter(n => n.userId === userId).sort((a, b) => new Date(b.date) - new Date(a.date));
    },

    getUnreadCount(userId) {
        const all = this.getAll(userId);
        return all.filter(n => !n.read).length;
    },

    markAsRead(id) {
        DataManager.update(DB_KEYS.NOTIFICATIONS, id, { read: true });
    }
};
