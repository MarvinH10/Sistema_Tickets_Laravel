<script setup>
const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        required: false,
    },
    options: {
        type: Array,
        required: true,
    },
    placeholder: {
        type: String,
        default: "Por favor seleccione",
    },
    required: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const onChange = (event) => {
    emit("update:modelValue", event.target.value);
};
</script>

<template>
    <div>
        <select
            :id="id"
            :name="name"
            :value="modelValue"
            @change="onChange"
            class="block w-full px-3 py-2 mt-1 text-gray-900 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            :required="required"
        >
            <option value="" disabled>{{ placeholder }}</option>
            <option
                v-for="option in options"
                :key="option.value"
                :value="option.value"
                class="text-gray-900"
            >
                {{ option.text }}
            </option>
        </select>
    </div>
</template>
