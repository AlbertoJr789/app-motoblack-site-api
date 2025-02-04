<ol class="flex items-center w-full mb-4" wire:ignore>
    {{ $slot }}
</ol>

@push('scripts')
<script>
    let stepperFields = stepperItems = stepperIcons = [] 
    let previousStepper = 0
    
    document.addEventListener('DOMContentLoaded', function() {
        initStepper()
        evaluateSteppers(0)
        Livewire.on('resetStepper',(e)=>{
            document.querySelector('[stepper-item]').click()
            setTimeout(() => {
                evaluateSteppers(0)
            }, 500);
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
        
        stepperItems.forEach((item)=>{
            new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'style') {                        
                        let pos = Array.from(stepperItems).indexOf(mutation.target.children[0])
                        if(mutation.target.style.display == ''){
                            if(pos > 0){
                                stepperItems[pos-1].parentNode.classList.add('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block') 
                            }
                        }else{
                            if(pos > 0){
                                stepperItems[pos-1].parentNode.classList.remove('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block') 
                            }
                        }
                    }
                });
            }).observe(item.parentNode, { attributes: true, attributeFilter: ['style'] })
        })

        initFieldsValidation()
        stepperItems.forEach((item)=>{
            item.addEventListener('click',(e)=>{
                let previous = document.querySelector('[active-stepper]').children[0]
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
                            stepperItems[i].parentNode.setAttribute('active-stepper',true)
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
                            stepperItems[i].parentNode.removeAttribute('active-stepper')
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
                    evaluateSteppers(i)
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

   function evaluateSteppers(i){
        if(!fieldsValid(stepperFields.children[i]) && stepperItems.length > 1){
            if(i < stepperItems.length - 1){
                
                for(let j=i;j < stepperItems.length - 1;j++){    

                    if(!fieldsValid(stepperFields.children[j])){
                        stepperItems[j].parentNode.classList.add('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block') 
                        // stepperItems[j+1].parentNode.classList.remove('hidden')
                        stepperItems[j+1].parentNode.style.display = ''
                    }else{
                        return
                    }
                }
            
            }
        }else{
            if(i < stepperItems.length){
                stepperItems[i].parentNode.classList.remove('after:w-full','after:h-1','after:border-b','after:border-secondary','after:border-4', 'after:inline-block')
                for(let j=i+1;j < stepperItems.length;j++){                                
                    // stepperItems[j].parentNode.classList.add('hidden')
                    stepperItems[j].parentNode.style.display = 'none'
                }
            }
        }
   }

      
</script>
@endpush