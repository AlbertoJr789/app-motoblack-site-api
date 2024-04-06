<template>
    <div class="lg:float-left lg:mb-0 lg:text-start text-center mt-6">
        <slot name="toolbar"></slot>
    </div>
    <DataTable :columns="columns" :ajax="ajax" :options="options" ref="table" class="display responsive border border-transparent border-separate border-spacing-0 rounded-lg" id="tableCorridas">
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
    import 'datatables.net-responsive';
    import 'datatables.net-fixedheader-dt';
    import 'datatables.net-buttons-dt';
    import 'datatables.net-buttons/js/buttons.colVis.js';
    import DataTablesCore from 'datatables.net';
    import { ref } from 'vue';
    import '../../css/dataTables.css';
    import '../../css/dataTablesLoader.css';
    
    DataTable.use(DataTablesCore);

    const table = ref()
    let deletedFilter = false

    const props = defineProps({
        ajaxRoute: {
            type: String,
            required: true
        },
    })
  
    const columns = [
        { responsivePriority: 0, data: 'select', name: 'select', className:'text-center noVis', orderable: false, searchable: false, visible: true},
        //  { responsivePriority: 2, data: 'select', name: 'select', title: `<div class="mx-0">
        //     <input class="input input-checkbox" type="checkbox" value="-1" id="testesHeaderCheckbox"/></div>`, 
        //     className:'text-center noVis', orderable: false, searchable: false, visible: true, width: '20px'},

        {data: 'id', title: window.trans('id')},
        {data: 'agente', name: "PA.nome", title: window.trans('Agent')},
        {data: 'passageiro', name:"PP.nome", title: window.trans('Passenger')},
        {data: 'cancelada', title: window.trans('Cancelled')},
        {data: 'data_finalizada', title: window.trans('Finish Date')},
        {data: 'nota_passageiro', title: window.trans('Passenger Evaluation')},
        {data: 'nota_agente', title: window.trans('Agent Evaluation')},
        {data: 'obs_agente', title: window.trans('Agent Report')},
        {data: 'obs_passageiro', title: window.trans('Passenger Report')},
        {data: 'justificativa_cancelamento', title: window.trans('Reason for Cancelling')},
        {data: 'veiculo', name: "V.modelo", title: window.trans('Vehicle Used')},
        {data: 'rota_gerada', title: window.trans('Route Taken')},
        
        {data: 'created_at', title: window.trans('Creation Date')},
        {data: 'updated_at', title: window.trans('Update Date')},

        // {data: 'active', title: window.trans('Active')},
        // {data: 'creator', name:'C.name', title: window.trans('Creator')},
        // {data: 'editor', name:'E.name', title: window.trans('Editor')},
        // {data: 'deleter', name:'D.name', title: window.trans('Deleter')},
        // {data: 'deleted_at', title: window.trans('Delete Date')},
        { responsivePriority: 2, data: 'action', name: 'action', title: '', className:'text-center noVis', orderable: false, searchable: false, width: '50px'},

    ]
    
    const options = {
        language: {
            url: `../../../lang/${navigator.language ?? 'en'}/datatables.json`
        },
        buttons: [{
            extend: 'colvis',
            columns: ':not(.noVis)',
        }],
        fixedHeader: true,
        fixedColumns: true,
        responsive: true,
        serverSide: true,
        processing: true,
        responsive: true,
        stateSave: true,
        order: [[1,'desc']],
        dom: "<'grid grid-cols-1 sm:grid-cols-12 mb-2'" +
            "<'col-span-8'<'toolbar mt-4'>>" +
            "<'col-span-4 flex items-center sm:justify-end sm:flex-nowrap flex-wrap justify-center'fB>" +
            ">" +
            "<'table-responsive'tr>" +
            "<'grid grid-cols-1 sm:grid-cols-12 gap-4 mt-2'" +
            "<'col-span-12 md:col-span-5 flex items-center justify-center md:justify-start mx-2'li>" +
            "<'col-span-12 md:col-span-7 flex items-center justify-center md:justify-end'p>" +
            ">",
        lengthMenu: [ [5,10 , 25, 50, 100, -1], [5,10, 25, 50, 100, "∞"] ]
    };

    const ajax = {
        url: props.ajaxRoute,
        data: (d) => {
            d.dateTypeFilter = document.getElementById('dateTypeFilter').value,
            d.initialDate = document.getElementById('initialDateFilter').value,
            d.endDate = document.getElementById('endDateFilter').value
        }
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('filter',() =>{
            deletedFilter = document.getElementById('dateTypeFilter').value == 'D' ? true : false
            table.value.dt.draw()
        })
    })

</script>