// /**
//  * auth.js
//  * Handles authentication logic, session management, and access control.
//  */

// const Auth = {
//     login(email, password, role) {
//         const users = DataManager.getAll(DB_KEYS.USERS);
//         const user = users.find(u => u.email === email && u.password === password);

//         if (!user) return { success: false, message: 'Identifiants incorrects' };
//         if (!user.active) return { success: false, message: 'Compte désactivé contactez l\'admin' };

//         // Strict Role Check as per requirement
//         if (user.role !== role) return { success: false, message: `Vous n'êtes pas enregistré en tant que ${role}` };

//         // Save session
//         localStorage.setItem(DB_KEYS.CURRENT_USER, JSON.stringify(user));
//         return { success: true, user };
//     },

//     register(nom, prenom, email, password, role) {
//         const users = DataManager.getAll(DB_KEYS.USERS);
//         if (users.find(u => u.email === email)) {
//             return { success: false, message: 'Cet email est déjà utilisé' };
//         }

//         const newUser = {
//             id: DataManager.generateId(),
//             nom,
//             prenom,
//             name: `${nom} ${prenom}`,
//             email,
//             password,
//             role,
//             active: true // Auto-active for demo
//         };

//         DataManager.add(DB_KEYS.USERS, newUser);
//         // Auto-login after register
//         localStorage.setItem(DB_KEYS.CURRENT_USER, JSON.stringify(newUser));
//         return { success: true, user: newUser };
//     },

//     logout() {
//         localStorage.removeItem(DB_KEYS.CURRENT_USER);
//         window.location.href = 'login.html';
//     },

//     getCurrentUser() {
//         return JSON.parse(localStorage.getItem(DB_KEYS.CURRENT_USER));
//     },

//     checkSession() {
//         const user = this.getCurrentUser();
//         if (!user) {
//             window.location.href = 'login.html';
//             return null;
//         }
//         return user;
//     },

//     redirectBasedOnRole(role) {
//         switch (role) {
//             case 'client':
//                 window.location.href = 'dashboard-client.html';
//                 break;
//             case 'livreur':
//                 window.location.href = 'dashboard-livreur.html';
//                 break;
//             case 'admin':
//                 window.location.href = 'dashboard-admin.html';
//                 break;
//             default:
//                 this.logout();
//         }
//     }
// };
