/**
 * ========================================
 * DASHBOARD NOTIFICATION SYSTEM
 * Modern SaaS Style - Floating Cards
 * ========================================
 */

(function() {
    'use strict';

    const notificationTimeout = 6000;
    let activeNotifications = [];

    /**
     * Create notification card element
     */
    function createNotification(options) {
        const {
            title = 'Notification',
            message = '',
            avatar = null,
            avatarText = null,
            url = null,
            type = 'default',
            onClose = null
        } = options;

        const card = document.createElement('div');
        card.className = `dashboard-notification-card ${type}`;
        
        const avatarHtml = avatar 
            ? `<div class="dashboard-notification-avatar"><img src="${avatar}" alt=""></div>`
            : `<div class="dashboard-notification-avatar">${avatarText || '🔔'}</div>`;
        
        card.innerHTML = `
            ${avatarHtml}
            <div class="dashboard-notification-content">
                <h4 class="dashboard-notification-title">${title}</h4>
                <p class="dashboard-notification-message">${message}</p>
            </div>
            <button class="dashboard-notification-close" aria-label="Close notification">×</button>
        `;

        if (url) {
            card.dataset.url = url;
        }

        const closeButton = card.querySelector('.dashboard-notification-close');
        closeButton.addEventListener('click', (e) => {
            e.stopPropagation();
            closeNotification(card, onClose);
        });

        if (url) {
            card.style.cursor = 'pointer';
            card.addEventListener('click', (e) => {
                if (!e.target.closest('.dashboard-notification-close')) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    closeNotification(card, () => {
                        setTimeout(() => {
                            window.location.href = url;
                        }, 100);
                    });
                }
            });
        }

        return card;
    }

    /**
     * Show notification with animation
     */
    function showNotification(options) {
        const container = document.getElementById('dashboard-notification-container');
        if (!container) {
            console.error('Dashboard notification container not found');
            return null;
        }

        const card = createNotification(options);
        container.appendChild(card);

        requestAnimationFrame(() => {
            card.classList.add('show');
        });

        activeNotifications.push(card);

        autoHideNotification(card, options.onClose);

        return card;
    }

    /**
     * Close notification with animation
     */
    function closeNotification(card, callback) {
        if (!card || !card.parentElement) return;

        card.classList.remove('show');
        card.classList.add('hide');

        const index = activeNotifications.indexOf(card);
        if (index > -1) {
            activeNotifications.splice(index, 1);
        }

        setTimeout(() => {
            if (card.parentElement) {
                card.remove();
            }
            if (callback) {
                callback();
            }
        }, 300);
    }

    /**
     * Auto hide notification after timeout
     */
    function autoHideNotification(card, onClose) {
        setTimeout(() => {
            closeNotification(card, onClose);
        }, notificationTimeout);
    }

    /**
     * Close all active notifications
     */
    function closeAllNotifications() {
        activeNotifications.forEach(card => {
            closeNotification(card);
        });
        activeNotifications = [];
    }

    window.DashboardNotification = {
        show: showNotification,
        close: closeNotification,
        closeAll: closeAllNotifications,
        setTimeout: (ms) => {
            notificationTimeout = ms;
        }
    };

})();
