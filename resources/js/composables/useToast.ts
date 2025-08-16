import { ref, reactive } from 'vue';

export interface ToastOptions {
    type?: 'success' | 'error' | 'warning' | 'info';
    title: string;
    message?: string;
    duration?: number;
    autoClose?: boolean;
}

export interface Toast extends ToastOptions {
    id: string;
}

const toasts = ref<Toast[]>([]);

let toastIdCounter = 0;

export function useToast() {
    const addToast = (options: ToastOptions): string => {
        const id = `toast-${++toastIdCounter}`;
        const toast: Toast = {
            id,
            type: 'info',
            duration: 5000,
            autoClose: true,
            ...options
        };
        
        toasts.value.push(toast);
        return id;
    };

    const removeToast = (id: string) => {
        const index = toasts.value.findIndex(toast => toast.id === id);
        if (index > -1) {
            toasts.value.splice(index, 1);
        }
    };

    const success = (title: string, message?: string, duration = 3000) => {
        return addToast({ type: 'success', title, message, duration });
    };

    const error = (title: string, message?: string, duration = 5000) => {
        return addToast({ type: 'error', title, message, duration });
    };

    const warning = (title: string, message?: string, duration = 4000) => {
        return addToast({ type: 'warning', title, message, duration });
    };

    const info = (title: string, message?: string, duration = 4000) => {
        return addToast({ type: 'info', title, message, duration });
    };

    const clear = () => {
        toasts.value = [];
    };

    return {
        toasts: toasts,
        addToast,
        removeToast,
        success,
        error,
        warning,
        info,
        clear
    };
}
