<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transform ease-out duration-300"
            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
            leave-active-class="transition ease-in duration-100"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="visible"
                class="fixed top-4 right-4 z-50 max-w-sm w-full bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden"
            >
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div 
                                class="w-8 h-8 rounded-full flex items-center justify-center"
                                :class="{
                                    'bg-green-100 text-green-600': type === 'success',
                                    'bg-red-100 text-red-600': type === 'error',
                                    'bg-orange-100 text-orange-600': type === 'warning',
                                    'bg-blue-100 text-blue-600': type === 'info'
                                }"
                            >
                                <CheckCircle v-if="type === 'success'" class="w-5 h-5" />
                                <XCircle v-else-if="type === 'error'" class="w-5 h-5" />
                                <AlertTriangle v-else-if="type === 'warning'" class="w-5 h-5" />
                                <Info v-else class="w-5 h-5" />
                            </div>
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                {{ title }}
                            </p>
                            <p v-if="message" class="mt-1 text-sm text-gray-500">
                                {{ message }}
                            </p>
                        </div>
                        <div class="ml-4 flex-shrink-0 flex">
                            <button
                                @click="close"
                                class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none"
                            >
                                <X class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Progress bar -->
                <div 
                    class="h-1 bg-gray-100 relative overflow-hidden"
                >
                    <div 
                        class="h-full transition-all duration-100 ease-linear"
                        :class="{
                            'bg-green-500': type === 'success',
                            'bg-red-500': type === 'error',
                            'bg-orange-500': type === 'warning',
                            'bg-blue-500': type === 'info'
                        }"
                        :style="{ width: `${progress}%` }"
                    ></div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { CheckCircle, XCircle, AlertTriangle, Info, X } from 'lucide-vue-next';

interface Props {
    type?: 'success' | 'error' | 'warning' | 'info';
    title: string;
    message?: string;
    duration?: number;
    autoClose?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    type: 'info',
    duration: 5000,
    autoClose: true
});

const emit = defineEmits<{
    close: [];
}>();

const visible = ref(true);
const progress = ref(100);

let progressInterval: number | null = null;
let autoCloseTimeout: number | null = null;

const close = () => {
    visible.value = false;
    if (progressInterval) clearInterval(progressInterval);
    if (autoCloseTimeout) clearTimeout(autoCloseTimeout);
    setTimeout(() => emit('close'), 300); // Wait for animation
};

onMounted(() => {
    if (props.autoClose) {
        // Start progress bar animation
        progressInterval = setInterval(() => {
            progress.value -= 100 / (props.duration / 100);
            if (progress.value <= 0) {
                progress.value = 0;
                if (progressInterval) clearInterval(progressInterval);
            }
        }, 100);

        // Auto close after duration
        autoCloseTimeout = setTimeout(() => {
            close();
        }, props.duration);
    }
});

onUnmounted(() => {
    if (progressInterval) clearInterval(progressInterval);
    if (autoCloseTimeout) clearTimeout(autoCloseTimeout);
});
</script>
