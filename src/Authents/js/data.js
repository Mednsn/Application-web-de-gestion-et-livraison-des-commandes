/**
 * data.js
 * Handles LocalStorage data persistence and mock data initialization.
 */

const DB_KEYS = {
  USERS: 'delivery_app_users',
  ORDERS: 'delivery_app_orders',
  OFFERS: 'delivery_app_offers',
  NOTIFICATIONS: 'delivery_app_notifications',
  CURRENT_USER: 'delivery_app_current_user'
};

// Initial Mock Data
const MOCK_USERS = [
  { id: 'u1', name: 'Client Alice', email: 'client@test.com', password: '123', role: 'client', active: true },
  { id: 'u2', name: 'Livreur Bob', email: 'livreur@test.com', password: '123', role: 'livreur', active: true },
  { id: 'u3', name: 'Admin Boss', email: 'admin@test.com', password: '123', role: 'admin', active: true },
  { id: 'u4', name: 'Livreur Charlie', email: 'livreur2@test.com', password: '123', role: 'livreur', active: true },
];

const DataManager = {
  init() {
    if (!localStorage.getItem(DB_KEYS.USERS)) {
      console.log('Initializing Mock Data...');
      this.save(DB_KEYS.USERS, MOCK_USERS);
      this.save(DB_KEYS.ORDERS, []);
      this.save(DB_KEYS.OFFERS, []);
      this.save(DB_KEYS.NOTIFICATIONS, []);
    }
  },

  getAll(key) {
    return JSON.parse(localStorage.getItem(key) || '[]');
  },

  save(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
  },

  add(key, item) {
    const data = this.getAll(key);
    data.push(item);
    this.save(key, data);
    return item;
  },

  update(key, id, updates) {
    const data = this.getAll(key);
    const index = data.findIndex(item => item.id === id);
    if (index !== -1) {
      data[index] = { ...data[index], ...updates };
      this.save(key, data);
      return data[index];
    }
    return null;
  },

  remove(key, id) {
    let data = this.getAll(key);
    data = data.filter(item => item.id !== id);
    this.save(key, data);
  },

  // Helper to generate IDs
  generateId() {
    return Math.random().toString(36).substr(2, 9);
  }
};

// Initialize immediately
DataManager.init();
