
<style>    
    #tableRankingCorridas_filter{
        display: none !important;
    }

    #tableRankingCorridas thead, #tableRankingCorridas tfoot {
        display: none !important;
    }

</style>

<template>
    <button class="btn-primary mx-2" onclick="" id="btnFilterRankingCorridas">
        <i class="fa-solid fa-magnifying-glass-chart mr-1"></i> Filtro
    </button>
    <DataTable :columns="columns" :ajax="ajax" :options="options" ref="table" class="display responsive border border-transparent border-separate border-spacing-0 rounded-lg" id="tableRankingCorridas">
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
    import { dataTableButtons, dataTableLengthMenu } from '../../js/utils.js';
    import '../../css/dataTables.css';
    import '../../css/dataTablesLoader.css';
    
    DataTable.use(DataTablesCore);

    const table = ref()
  
    const columns = [
        {data: 'agent' ,className: 'text-start'},
        {data: 'total_trips'},
    ]
    
    const options = {
        language: {
            url: `../../../lang/${navigator.language ?? 'en'}/datatables.json`
        },
        buttons: [
            {
                text: '<i class="fas fa-sync-alt"></i>',
                action: function (e, dt, node, config) {
                    dt.ajax.reload();
                }
            }
        ],
        fixedColumns: true,
        responsive: true,
        serverSide: true,
        processing: true,
        responsive: true,
        stateSave: true,
        dom: "<'grid grid-cols-1 sm:grid-cols-12 mb-2'" +
            "<'col-span-8'<'toolbar mt-4'>>" +
            "<'col-span-4 flex items-center sm:justify-end sm:flex-nowrap flex-wrap justify-center'fB>" +
            ">" +
            "<'table-responsive'tr>" +
            "<'grid grid-cols-1 sm:grid-cols-12 gap-4 mt-2'" +
            "<'col-span-12 md:col-span-5 flex items-center justify-center md:justify-start mx-2'li>" +
            "<'col-span-12 md:col-span-7 flex items-center justify-center md:justify-end'p>" +
            ">",
        lengthMenu: dataTableLengthMenu,
        initComplete: function() {
            $("#tableRankingCorridas_wrapper").find('.toolbar').append($('#btnFilterRankingCorridas'));
        }
    };

    const ajax = {
        url: `/dashboard/rankingTrips`,
        data: (d) => {
            // d.rateFilter = document.getElementById('rateFilter').value,
            // d.initialDate = document.getElementById('initialDateFilter').value,
            // d.endDate = document.getElementById('endDateFilter').value
        }
    }

</script>