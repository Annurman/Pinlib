import './bootstrap';
import Alpine from 'alpinejs';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
});

// Ambil admin ID dari meta
const adminIdMeta = document.querySelector('meta[name="admin-id"]');
if (adminIdMeta) {
    const adminId = adminIdMeta.content;

    window.Echo.private(`admin.${adminId}`)
        .notification((notification) => {
            console.log('📢 Notifikasi baru:', notification);

            const notifBox = document.getElementById('admin-notification-box');
            if (notifBox) {
                const notifHtml = `
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-3 flex justify-between items-center rounded-lg shadow">
                        <div>
                            <p class="font-medium">${notification.message}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="${notification.link}" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">Pergi ke halaman</a>
                        </div>
                    </div>
                `;
                notifBox.insertAdjacentHTML('afterbegin', notifHtml);
            }
        });
}




