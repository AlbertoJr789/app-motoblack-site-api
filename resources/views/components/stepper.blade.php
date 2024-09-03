<ol class="flex items-center w-full mb-4" wire:ignore>
    {{ $slot }}
</ol>

@push('scripts')
<script>
    let stepperFields = stepperItems = stepperIcons = [] 
    let previousStepper = 0
    
    document.addEventListener('DOMContentLoaded', function() {
        initStepper()
     
        Livewire.on('resetStepper',(e)=>{
            document.querySelector('[stepper-item]').click()
        })
        Livewire.hook('commit', ({component,commit,respond,succeed,fail}) => {                
            respond(() => {
                setTimeout(() => {
                    initFieldsValidation()
                }, 500);
            })
        })
    })

    function initStepper(){
        
        stepperFields = document.querySelector('[stepper-fields]')
        stepperItems = document.querySelectorAll('[stepper-item]') 
        initFieldsValidation()
        stepperItems.forEach((item)=>{
            item.addEventListener('click',(e)=>{
                let previous = document.querySelector('[active-stepper]')
                let previousPos = Array.from(stepperItems).indexOf(previous)
                
                if(previous == e.target) return
                
                let fields = false
                let targetPos = Array.from(stepperItems).indexOf(e.target)

                if(targetPos > previousPos) {
                    fields = fieldsValid(stepperFields.children[previousPos])
                }
                if(!fields){
                    for(let i=0;i < stepperItems.length;++i){
                        if(stepperItems[i] === e.target){
                            stepperFields.children[i].classList.remove('hidden')
                            stepperItems[i].setAttribute('active-stepper',true)
                            stepperItems[i].classList.remove('bg-secondary', 'text-primary', 'hover:text-secondary', 'hover:bg-amber-400','cursor-pointer')
                            stepperItems[i].classList.add('bg-amber-400','text-secondary')
                            stepperItems[i].classList.remove('fa-solid','fa-check')
                            stepperItems[i].classList.add(...stepperIcons[i].split(' '))
                            window.dispatchEvent(new CustomEvent('stepperChanged',{
                                detail: { activeStepper: i }
                            }))
                        }else{
                            stepperFields.children[i].classList.add('hidden')
                            stepperItems[i].classList.remove('bg-amber-400','text-secondary')
                            stepperItems[i].classList.add('bg-secondary','text-primary','hover:text-secondary','hover:bg-amber-400','cursor-pointer')
                            stepperItems[i].removeAttribute('active-stepper')
                            if(i < targetPos){
                                stepperItems[i].classList.remove(...stepperIcons[i].split(' '))
                                stepperItems[i].classList.add('fa-solid','fa-check')
                            }else{
                                stepperItems[i].classList.remove('fa-solid','fa-check')
                                stepperItems[i].classList.add(...stepperIcons[i].split(' '))
                            }
                        }
                    }
                    
                }else{
                    Swal.fire({
                        icon: 'warning',
                        title: "{{__('Invalid Fields')}}",
                        text: `{{__('Some fields are invalid or not filled, correct them before proceding: ')}}${fields}`
                    })
                }
                
            })
        }) 

    }

    function initFieldsValidation(){
        stepperItems.forEach((item,i)=>{
            stepperIcons.push(item.className.substr(0,item.className.indexOf('sm:text-xl')).trim())
            stepperFields.children[i].querySelectorAll('input[required], select[required]').forEach((node)=>{                
                node.addEventListener('input',()=>{
                    if(!fieldsValid(stepperFields.children[i])){
                        if(i < stepperItems.length){
                            stepperItems[i].parentNode.classList.add('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block') 
                            stepperItems[i+1].parentNode.classList.remove('hidden')
                            for(let j=i+1;j < stepperItems.length;j++){       
                                if(!fieldsValid(stepperFields.children[j])){
                                    stepperItems[j].parentNode.classList.add('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block') 
                                    stepperItems[j+1].parentNode.classList.remove('hidden')
                                }
                            }
                        }
                    }else{
                        if(i < stepperItems.length){
                            stepperItems[i].parentNode.classList.remove('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block')
                            for(let j=i+1;j < stepperItems.length;j++){                                
                                stepperItems[j].parentNode.classList.add('hidden')
                            }
                        }
                    }
                })
            })
        })
    }

    function fieldsValid(container){
        let inputs = container.querySelectorAll('input,select')
        let invalid = ''
        
        inputs.forEach((input)=>{
            if(input.hasAttribute('required')){
                if(input.value.trim() == "" || !input.value){
                    invalid += input.labels[0].innerHTML.trim().replace(':','') ?? input.getAttribute('name')
                    invalid += ',' 
                }
            }
        })
        return invalid.substr(0,invalid.length-1) //removing last comma
    }

   

      
</script>
@endpush