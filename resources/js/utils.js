/**
 *  Populates a form matching data property value with form name
 *  @property HTMLFormControlsCollection container
 *  @property object data
 */
export function fillForms(container,data) {
    Array.from(container).forEach((input) => {
        let name = input.getAttribute('name');
        if(name && name != '_token'){
            document.querySelector(`input[name="${name}"]`).value = data[name]
        }
    });
}