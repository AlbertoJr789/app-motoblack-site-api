
<template>
    <DataTable :data="data" :columns="columns" :ajax="ajax" :options="options" ref="table" class="display border border-transparent border-separate border-spacing-0 rounded-lg">
        <thead class="text-xs text text-amber-300 uppercase hover:cursor-pointer">
            <tr class="border">
                <th v-for="_ in columns" scope="col" class="px-6 py-3 first:rounded-tl-lg last:rounded-tr-lg bg-secondary ">
                </th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th v-for="_ in columns" class="first:rounded-bl-lg last:rounded-br-lg py-4 bg-secondary"></th>
            </tr>
        </tfoot>
    </DataTable>
</template>

<script setup>
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net';
    import '../../css/dataTables.css';
    import '../../css/dataTablesLoader.css';
    import { ref } from 'vue';
    
    DataTable.use(DataTablesCore);

    const table = ref()

    const props = defineProps({
        ajaxRoute: {
            type: String,
            required: true
        }
    })

    const columns = [
        {data: 'teste', title: 'Teste'},
        {data: 'created_at', title: 'Criação'},
        {data: 'updated_at', title: 'Atualização'}
    ]

    const options = {
        language: {
            url: `../../../lang/${navigator.language ?? 'en'}/datatables.json`
        },
        responsive: true,
        select: true,
        serverSide: true,
        processing: true,
        responsive: true,
        stateSave: true,
        dom: "<'grid grid-cols-1 sm:grid-cols-12 mb-2'" +
            "<'col-span-8'<'toolbar mt-4'>>" +
            "<'col-span-4 flex items-center justify-end'fB>" +
            ">" +
            "<'table-responsive'tr>" +

            "<'grid grid-cols-1 sm:grid-cols-12 gap-4 mt-2'" +
            "<'col-span-12 md:col-span-5 flex items-center justify-center md:justify-start mx-2'li>" +
            "<'col-span-12 md:col-span-7 flex items-center justify-center md:justify-end'p>" +
            ">",
        lengthMenu: [ [5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "∞"] ],
    };

    const ajax = {
        url: props.ajaxRoute
    }
</script>