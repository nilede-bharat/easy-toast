<template>
    <teleport to="body">
        <div aria-live="assertive"
             class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-[9999]">
            <div class="w-full flex flex-col items-center space-y-4 sm:items-end">

                <transition enter-active-class="transform ease-out duration-300 transition"
                            enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                            enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                            leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
                            leave-to-class="opacity-0">
                    <div v-if="open"
                         class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor"
                                         v-if="message.type === 'success'" class="h-6 w-6 text-green-400">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" v-if="message.type === 'error'"
                                         class="h-6 w-6 text-red-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" v-if="message.type === 'warning'"
                                         class="h-6 w-6 text-yellow-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                    </svg>

                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-900">{{ message.title }}</p>
                                    <p class="mt-1 text-sm text-gray-500">{{ message.message }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex">
                                    <button @click="open = false"
                                            class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 18 18 6M6 6l12 12"/>
                                        </svg>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </teleport>
</template>

<script setup>
import {ref, computed, watch} from 'vue'
import {usePage} from "@inertiajs/inertia-vue3";


const open = ref(false);
const props = computed(() => usePage().props.value);

// Create a reactive message object
const message = ref({
    open: false,
    message: '',
    title: '',
    type: '',
});

watch(props, (newProps) => {
    const {success = null, error = null, warning = null} = newProps;
    const _data = success ?? error ?? warning;

    // Reset message to default before each change
    message.value = {
        open: false,
        message: '',
        title: '',
        type: '',
    };

    // If no data is present, return early
    if (!_data) return;

    // Set message details
    message.value.open = true;
    if (success) {
        message.value.title = "Success!";
        message.value.type = "success";
    } else if (error) {
        message.value.title = "Error!";
        message.value.type = "error";
    } else if (warning) {
        message.value.title = "Warning!";
        message.value.type = "warning";
    }

    // Handle both object and string types for message
    if (typeof _data === 'object') {
        message.value.title = _data?.title ?? message.value.title;
        message.value.message = _data?.message ?? message.value.message;
    } else if (typeof _data === 'string') {
        message.value.message = _data;
    }

    // Automatically close the message after 5 seconds
    autoClose();
}, {immediate: true});

function autoClose() {
    open.value = true;
    setTimeout(() => {
        open.value = false;
    }, 5000);
}
</script>
