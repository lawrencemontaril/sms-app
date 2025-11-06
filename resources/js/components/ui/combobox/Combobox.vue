<script setup lang="ts">
import { ComboboxRoot, type ComboboxRootEmits, type ComboboxRootProps, useForwardPropsEmits } from 'reka-ui'
import { cn } from '@/lib/utils'
import { computed,HTMLAttributes } from 'vue';

const props = defineProps<ComboboxRootProps & { class?: HTMLAttributes['class'] }>()
const emits = defineEmits<ComboboxRootEmits>()

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
  <ComboboxRoot
    data-slot="combobox"
    v-bind="forwarded"
    :class="cn('relative', props.class)"
  >
    <slot />
  </ComboboxRoot>
</template>
