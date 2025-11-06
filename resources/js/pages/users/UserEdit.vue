<script lang="ts" setup>
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Form, FormField } from '@/components/ui/form';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/AppLayout.vue';
import { Department, User } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    user: User;
    departments: Department[];
}

const props = defineProps<Props>();

const form = useForm({
    department_id: props.user.department_id,
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
});

function updateUser() {
    form.transform((data: any) => {
        if (data.password === '') {
            delete data.password;
            delete data.password_confirmation;
        }
        return data;
    });

    form.patch(`/users/${props.user.id}`);
}
</script>

<template>
    <AppLayout>
        <Head title="Edit user" />

        <Card>
            <CardHeader>
                <CardTitle>Edit {{ user.name }}</CardTitle>
            </CardHeader>

            <CardContent>
                <Form @submit.prevent="updateUser">
                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label required>Department</Label>

                        <Select :default-value="user?.department">
                            <SelectTrigger>
                                <SelectValue placeholder="Select a department" />
                            </SelectTrigger>

                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem
                                        v-for="department in departments"
                                        :value="department"
                                        :key="department.id"
                                        @select="
                                            () => {
                                                form.department_id = department.id;
                                            }
                                        "
                                    >
                                        {{ department.name }} — {{ department.code }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>

                        <InputError :message="form.errors.department_id" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Name</Label>

                        <Input v-model="form.name" placeholder="Name" />

                        <InputError :message="form.errors.name" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Email</Label>

                        <Input v-model="form.email" type="email" placeholder="Email address" />

                        <InputError :message="form.errors.email" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Password</Label>

                        <Input type="password" v-model="form.password" placeholder="Password" />

                        <InputError :message="form.errors.password" />
                    </FormField>

                    <FormField class="mb-6 flex flex-col gap-2">
                        <Label>Confirm password</Label>

                        <Input type="password" v-model="form.password_confirmation" placeholder="Confirm password" />

                        <InputError :message="form.errors.password_confirmation" />
                    </FormField>

                    <Button :disabled="form.processing"> Update user </Button>
                </Form>
            </CardContent>
        </Card>
    </AppLayout>
</template>
