(function () {
    'use strict';

    var activeModal = null;

    function getOpenModal() {
        return document.querySelector('.modal.show');
    }

    function removeBackdrop() {
        var backdrops = document.querySelectorAll('.modal-backdrop');

        backdrops.forEach(function (backdrop) {
            backdrop.parentNode.removeChild(backdrop);
        });
    }

    function createBackdrop() {
        removeBackdrop();

        var backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);

        backdrop.addEventListener('click', function () {
            hideModal(activeModal || getOpenModal());
        });
    }

    function showModalManually(modal) {
        activeModal = modal;
        modal.style.display = 'block';
        modal.removeAttribute('aria-hidden');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('role', 'dialog');
        modal.classList.add('show');

        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        createBackdrop();

        var focusTarget = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');

        if (focusTarget) {
            focusTarget.focus();
        }
    }

    function hideModalManually(modal) {
        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');
        modal.removeAttribute('role');

        activeModal = null;
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        removeBackdrop();
    }

    function findModal(trigger) {
        var selector = trigger.getAttribute('data-bs-target') ||
            trigger.getAttribute('data-target') ||
            trigger.getAttribute('href');

        if (!selector || selector.charAt(0) !== '#') {
            return null;
        }

        try {
            return document.querySelector(selector);
        } catch (error) {
            return null;
        }
    }

    function showModal(modal) {
        if (!modal) {
            return;
        }

        if (window.bootstrap && window.bootstrap.Modal) {
            window.bootstrap.Modal.getOrCreateInstance(modal).show();
            return;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modal).modal('show');
            return;
        }

        showModalManually(modal);
    }

    function hideModal(modal) {
        if (!modal) {
            return;
        }

        if (window.bootstrap && window.bootstrap.Modal) {
            window.bootstrap.Modal.getOrCreateInstance(modal).hide();
            return;
        }

        if (window.jQuery && typeof window.jQuery.fn.modal === 'function') {
            window.jQuery(modal).modal('hide');
            return;
        }

        hideModalManually(modal);
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-bs-toggle="modal"]');

        if (trigger) {
            event.preventDefault();
            showModal(findModal(trigger));
            return;
        }

        var dismiss = event.target.closest('[data-bs-dismiss="modal"]');

        if (dismiss) {
            event.preventDefault();
            hideModal(dismiss.closest('.modal'));
        }
    }, true);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            hideModal(activeModal || getOpenModal());
            return;
        }

        if (event.key !== 'Enter' && event.key !== ' ') {
            return;
        }

        var trigger = event.target.closest('[role="button"][data-bs-toggle="modal"]');

        if (!trigger) {
            return;
        }

        event.preventDefault();
        showModal(findModal(trigger));
    }, true);
})();
