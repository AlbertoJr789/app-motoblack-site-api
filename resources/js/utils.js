/**
 *  Populates a form matching data property value with form name
 *  @param {HTMLFormControlsCollection} container
 *  @param {Object} data
 */
export function fillForms(container,data) {
    Array.from(container).forEach((input) => {
        let name = input.getAttribute('name');
        if(name && name != '_token'){
            document.querySelector(`input[name="${name}"]`).value = data[name]
        }
    });
}

/**
 * 
 * @param {HTMLTableElement} targetTable 
 * @param {object} checked 
 */
export function handleCheckboxes(targetTable,checked){
    targetTable.addEventListener('change',(e)=>{
        if(e.target.type == 'checkbox'){
            let value = e.target.getAttribute('value')
            if(e.target.checked){
                if(value == -1){ //table header marker
                    targetTable.querySelectorAll('input[type="checkbox"]').forEach((checkbox)=>{
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
                    targetTable.querySelectorAll('input[type="checkbox"]').forEach((checkbox)=>{
                        checkbox.checked = false
                        checked.value = []
                    })
                }else{
                    checked.value = checked.value.filter((v) => v != value)
                }
            }
        }
    })
}

export const dataTableButtons = [
    {
        extend: 'colvis',
        columns: ':not(.noVis)',
    },
    {
        text: '<i class="fas fa-sync-alt"></i>',
        action: function (e, dt, node, config) {
            dt.ajax.reload();
        }
    }
]

export const dataTableLengthMenu = [ [5,10 , 25, 50, 100, -1], [5,10, 25, 50, 100, "∞"] ]
