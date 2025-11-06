<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Storage } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    storage: Storage;
}

const props = defineProps<Props>();

const form = useForm({
    name: props.storage.name,
    code: props.storage.code,
    description: props.storage.description,
});

function updateSupply() {
    form.patch(`/storages/${props.storage.id}`);
}
</script>

<template>
    <AppLayout>
        <Head :title="`Edit ${storage.name}`" />

        <Card>
            <CardHeader>
                <CardTitle>Edit {{ storage.name }}</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="updateSupply">
                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Name</Label>

                        <Input v-model="form.name" :default-value="storage.name" placeholder="e.g. Main Stockroom" />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Code</Label>

                        <Input type="text" v-model="form.code" :default-value="storage.code" placeholder="e.g. M-STK1" />

                        <InputError :message="form.errors.code" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Description</Label>

                        <Textarea v-model="form.description" :default-value="storage.description" placeholder="e.g. Room 110, West Wing" />

                        <InputError :message="form.errors.description" />
                    </FormField>

                    <Button :disabled="form.processing"> Update supply </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
