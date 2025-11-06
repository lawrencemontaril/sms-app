<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Department } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    department: Department;
}

const props = defineProps<Props>();

const form = useForm({
    user_id: props.department.user_id,
    name: props.department.name,
    code: props.department.code,
});

function updateDepartment() {
    form.patch(`/departments/${props.department.id}`);
}
</script>

<template>
    <AppLayout>
        <Head title="Edit department" />

        <Card>
            <CardHeader>
                <CardTitle>Edit '{{ department.name }}' department</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="updateDepartment">
                    <FormField>
                        <Label required>Name</Label>

                        <Input
                            v-model="form.name"
                            :default-value="department.name"
                            placeholder="Name"
                        />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField>
                        <Label required>Code</Label>

                        <Input
                            v-model="form.code"
                            :default-value="department.code"
                            type="text"
                            placeholder="Code"
                        />

                        <InputError :message="form.errors.code" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Department Head</Label>

                        <Select :default-value="department?.head">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a department head" />
                            </SelectTrigger>

                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem
                                        v-for="user in department?.members"
                                        :value="user"
                                        :key="user.id"
                                        @select="
                                            () => {
                                                form.user_id = user.id;
                                            }
                                        "
                                    >
                                        {{ user.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.user_id" />
                    </FormField>

                    <Button :disabled="form.processing"> Update department </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
