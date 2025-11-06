<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { PaginationMetadata } from '@/types';
import { Icon } from '@iconify/vue';
import { router } from '@inertiajs/vue3';
import { useWindowSize } from '@vueuse/core';
import {
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
    PaginationRoot,
} from 'reka-ui';
import { computed } from 'vue';

interface Props {
    meta: PaginationMetadata;
}

const props = defineProps<Props>();
const { width } = useWindowSize();
const isSmallScreen = computed(() => width.value < 640);

const currentPage = computed(() => props.meta.current_page);
const itemsPerPage = computed(() => props.meta.per_page);
const totalItems = computed(() => props.meta.total);

const goToPage = (page: number) => {
    if (page !== currentPage.value) {
        router.get('', { page }, { preserveScroll: true });
    }
};
</script>

<template>
    <PaginationRoot
        @update:page="goToPage"
        :items-per-page="itemsPerPage"
        v-model:page="currentPage"
        :total="totalItems"
        :sibling-count="isSmallScreen ? 1 : 2"
        :show-edges="!isSmallScreen"
    >
        <PaginationList v-slot="{ items }" class="border-input flex items-center justify-between gap-2 border-t p-2">
            <div class="flex items-center gap-2">
                <PaginationFirst v-if="!isSmallScreen" as-child>
                    <Button>
                        First
                    </Button>
                </PaginationFirst>

                <PaginationPrev as-child>
                    <Button>
                        Prev
                    </Button>
                </PaginationPrev>
            </div>

            <div class="flex items-center gap-2">
                <template v-for="(page, index) in items">
                    <PaginationListItem v-if="page.type === 'page'" :key="index" :value="page.value" as-child>
                        <Button
                            size="icon"
                            class="bg-muted hover:text-primary-foreground text-muted-foreground dark:data-[selected]:bg-primary data-[selected]:bg-primary data-[selected]:text-primary-foreground"
                        >
                            {{ page.value }}
                        </Button>
                    </PaginationListItem>

                    <PaginationEllipsis v-else :key="page.type" :index="index" as-child>
                        <Button size="icon" variant="ghost" disabled> ... </Button>
                    </PaginationEllipsis>
                </template>
            </div>

            <div class="flex items-center gap-2">
                <PaginationNext as-child>
                    <Button>
                        Next
                    </Button>
                </PaginationNext>

                <PaginationLast v-if="!isSmallScreen" as-child>
                    <Button>
                        Last
                    </Button>
                </PaginationLast>
            </div>
        </PaginationList>
    </PaginationRoot>
</template>
