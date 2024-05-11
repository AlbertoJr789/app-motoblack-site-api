<div class="grid sm:grid-cols-2 sm:gap-6 grid-cols-1">
    <!-- Nome Field -->
    <div>
        {!! Form::label('nome', 'Nome:',['class' => "block mx-1"]) !!}
        {!! Form::text('nome', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'nome' ]) !!}
    </div>
    <!-- Tipo Field -->
    <div>
        {!! Form::label('tipo', 'Tipo:',['class' => "block mx-1"]) !!}
        {!! Form::select('tipo', [1 => 'Pessoa Física', 2 => 'Pessoa Jurídica'], null, ['class' => 'input w-full','required' => 'true','wire:model' => 'tipo','id' => 'tipo']) !!}
    </div>
</div>

<div class="grid sm:grid-cols-2 sm:gap-6 grid-cols-1">
    <!-- Documento Field -->
    <div>
        {!! Form::label('documento', 'Documento:',['class' => "block mx-1"]) !!}
        {!! Form::text('documento', null, ['class' => 'input w-full','required' => 'true', 'wire:model' => 'documento']) !!}
    </div>
    <!-- Rg Field -->
    <div>
        {!! Form::label('rg', 'Rg:',['class' => "block mx-1"]) !!}
        {!! Form::text('rg', null, ['class' => 'input w-full','required' => 'true','wire:model' => 'rg' ]) !!}
    </div>
</div>

@if($Pessoa)
    <div class="flex sm:justify-start justify-center mt-4">
        {!! Form::label('active', __('Active'),['class' => "block mx-1"]) !!}
        {!! Form::checkbox('active',null,$active, ['class' => 'checkbox-toggle-switch','wire:model' => 'active',]) !!}
    </div>
@endif
    
@push('scripts')
    <script>

        let documentoMask,documentoInput

        document.addEventListener('DOMContentLoaded', function() {
            documentoMask = IMask(document.querySelector('#documento'),{
                mask: '000.000.000-00'
            })                     
            documentoInput = document.querySelector('#documento')

            document.querySelector('#tipo').addEventListener('change',(e)=>{
                if(e.target.value == 1){
                    documentoMask.updateOptions({
                        mask: '000.000.000-00'
                    }) 
                }else if(e.target.value == 2){
                    documentoMask.updateOptions({
                        mask: '00.000.000/0000-00'
                    }) 
                }
            })
        })

    </script>
@endpush
