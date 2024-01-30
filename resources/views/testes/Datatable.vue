

<template>
    <div class="sm:float-left sm:mb-0 sm:text-start text-center">
        <slot name="toolbar"></slot>
        <span v-if="checked.length">
            <button class="btn-danger" @click="deleteMultiple()">Delete</button>
            {{ checked.length }} elements checked
        </span>
    </div>
    <DataTable :columns="columns" :ajax="ajax" :options="options" ref="table" class="display border border-transparent border-separate border-spacing-0 rounded-lg" id="tableTestes">
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
    import { ref, toRaw } from 'vue';
    import { fillForms } from '../../js/utils.js'
    
    DataTable.use(DataTablesCore);

    const table = ref()
    const checked = ref([])

    const props = defineProps({
        ajaxRoute: {
            type: String,
            required: true
        }
    })
  
    const columns = [
        { responsivePriority: 2, data: 'select', name: 'select', title: `<div class="mx-0">
            <input class="input input-checkbox" type="checkbox" value="-1" id="testesHeaderCheckbox"/></div>`, 
            className:'text-center noVis', orderable: false, searchable: false, visible: true, width: '20px'},
        {data: 'id', title: 'id'},
        {data: 'teste', title: 'Teste'},
        {data: 'created_at', title: 'Criação'},
        {data: 'updated_at', title: 'Atualização'},
        {data: 'deleted_at', title: 'Exclusão'},
        { responsivePriority: 2, data: 'action', name: 'action', title: '', className:'text-center noVis', orderable: false, searchable: false, width: '50px'},

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
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                render: function ( val, type, row ) {
                    return `<div class="mx-0">
                                <input class="input input-checkbox border-black" type="checkbox" value="${row.id}"/>
                            </div>`;
                }
            },
        ],
        initComplete: () => {
            document.getElementById('tableTestes').addEventListener('change',(e)=>{
                if(e.target.type == 'checkbox'){
                    let value = e.target.getAttribute('value')
                    if(e.target.checked){
                        if(value == -1){ //table header marker
                            document.querySelectorAll('#tableTestes input[type="checkbox"]').forEach((checkbox)=>{
                                checkbox.checked = true
                                value = checkbox.getAttribute('value')
                                if(!checked.value.includes(value) && value != -1){
                                    checked.value.push(value)
                                }
                            })
                        }else{
                            checked.value.push(value)
                        }
                    } else {
                        if(e.target.getAttribute('value') == -1){ //table header marker
                            document.querySelectorAll('#tableTestes input[type="checkbox"]').forEach((checkbox)=>{
                                checkbox.checked = false
                                checked.value = []
                            })
                        }else{
                            checked.value = checked.value.filter((v) => v != value)
                        }
                    }
                }
            })
        },
        drawCallback: () => {
            document.getElementById('testesHeaderCheckbox').checked = false
            checked.value = []
        },
        lengthMenu: [ [5,10, 25, 50, 100, -1], [5,10, 25, 50, 100, "∞"] ],
    };

    const ajax = {
        url: props.ajaxRoute
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('alert',(e)=>{
            Swal.fire({
                icon: e[0].icon,
                title: e[0].title,
                text: e[0].text
            })
            table.value.dt.draw()
        })
        Livewire.on('loadInputs',(teste) => {
             fillForms(document.querySelector("#formTestes").elements,teste[0])
        })
    })

    function deleteMultiple(){
        deleteRegister(toRaw(checked.value))
    }

</script>