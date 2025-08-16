<template>
    <div class="flex items-center justify-center" :class="containerClass">
        <div 
            class="animate-spin rounded-full border-4 border-solid border-current border-r-transparent"
            :class="[sizeClass, colorClass]"
        >
            <span class="sr-only">Loading...</span>
        </div>
        <span v-if="text" class="ml-3 text-sm font-medium" :class="textColorClass">
            {{ text }}
        </span>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
    size?: 'sm' | 'md' | 'lg';
    color?: 'primary' | 'orange' | 'white' | 'gray';
    text?: string;
    class?: string;
}

const props = withDefaults(defineProps<Props>(), {
    size: 'md',
    color: 'primary'
});

const sizeClass = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'w-4 h-4';
        case 'lg':
            return 'w-8 h-8';
        default:
            return 'w-6 h-6';
    }
});

const colorClass = computed(() => {
    switch (props.color) {
        case 'orange':
            return 'text-orange-600';
        case 'white':
            return 'text-white';
        case 'gray':
            return 'text-gray-600';
        default:
            return 'text-orange-600';
    }
});

const textColorClass = computed(() => {
    switch (props.color) {
        case 'white':
            return 'text-white';
        case 'gray':
            return 'text-gray-600';
        default:
            return 'text-gray-700';
    }
});

const containerClass = computed(() => props.class || '');
</script>
