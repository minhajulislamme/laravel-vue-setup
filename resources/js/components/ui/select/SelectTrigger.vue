<script setup lang="ts">
import { cn } from '@/lib/utils';
import { ChevronDown } from 'lucide-vue-next';
import { computed, type HTMLAttributes } from 'vue';

interface Props {
  class?: HTMLAttributes['class'];
  disabled?: boolean;
}

const props = defineProps<Props>();

const triggerClasses = computed(() => {
  return cn(
    'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-0 focus:border-primary disabled:cursor-not-allowed disabled:opacity-50 [&>span]:line-clamp-1',
    props.class,
  );
});
</script>

<template>
  <button
    type="button"
    :class="triggerClasses"
    :disabled="props.disabled"
  >
    <slot />
    <ChevronDown class="h-4 w-4 opacity-50" />
  </button>
</template>
