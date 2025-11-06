<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { reactiveOmit } from '@vueuse/core'
import { SearchIcon, ChevronDown } from 'lucide-vue-next'
import { ComboboxInput, type ComboboxInputEmits, type ComboboxInputProps, useForwardPropsEmits } from 'reka-ui'
import ComboboxTrigger from './ComboboxTrigger.vue';
import { cn } from '@/lib/utils'

defineOptions({
  inheritAttrs: false,
})

const props = defineProps<ComboboxInputProps & {
  class?: HTMLAttributes['class']
}>()

const emits = defineEmits<ComboboxInputEmits>()

const delegatedProps = reactiveOmit(props, 'class')

const forwarded = useForwardPropsEmits(delegatedProps, emits)
</script>

<template>
  <div
    data-slot="command-input-wrapper"
    class="relative flex h-10 items-center gap-2 bg-background border rounded-md border-input shadow-xs ring-offset-background focus-within:outline-hidden focus-within:ring-2 focus-within:ring-ring focus-within:ring-offset-2"
  >
  <div class="p-2">
    <SearchIcon class="size-4 shrink-0 opacity-50" />
    </div>

    <ComboboxInput
      data-slot="command-input"
      :class="cn(
        'placeholder:text-muted-foreground disabled:bg-muted flex h-10 w-full rounded-md py-3 text-sm outline-hidden disabled:cursor-not-allowed disabled:opacity-50',
        props.class,
      )"
      v-bind="{ ...forwarded, ...$attrs }"
    />

    <!-- <ComboboxTrigger>
        <ChevronDown class="size-4 shrink-0 opacity-50" />
    </ComboboxTrigger> -->
  </div>
</template>
