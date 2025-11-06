<script setup lang="ts">
defineOptions({ inheritAttrs: false });
</script>

<template>
    <form v-bind="$attrs">
        <slot />
    </form>
</template>
